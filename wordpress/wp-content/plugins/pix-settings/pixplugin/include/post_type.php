<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


if( ! class_exists( 'PixTheme_Post_Types' ) ) {
	class PixTheme_Post_Types {
        
        private $permalinks = array();
	    
		public function __construct() {
			add_action( 'init', array( $this, 'post_type_init' ) );
			add_action( 'admin_init', array( $this, 'pix_permalinks_init' ) );
            add_action( 'admin_init', array( $this, 'pix_permalinks_save' ) );
            if(function_exists('wpcf7_init')) {
                add_action('plugins_loaded', array($this, 'pix_calculator_form'));
            }
            //if(class_exists('WooCommerce')) {
                add_action('edited_product_cat',  array( $this, 'pix_product_cat_fields_save' ));
                add_action('product_cat_edit_form_fields', array( $this, 'pix_product_cat_fields_form' ));
                add_action('product_cat_add_form_fields', array( $this, 'pix_product_cat_fields_add_form' ));
                add_action('create_product_cat', array( $this, 'pix_product_cat_fields_save' ));
            //}
		}
		
		
		public function pix_permalinks_init() {
    
            add_settings_field(
                'pix_product_cars_slug',
                esc_html__( 'Product Cars base', 'pixsettings' ),
                array( $this, 'pix_product_cars_slug_input' ),
                'permalink',
                'optional'
            );
            
            $this->permalinks = wp_parse_args( (array) get_option( 'pix_permalinks', array() ), array(
                'product_cars_base'         => '',
            ) );
            
        }
        
        public function pix_product_cars_slug_input() {
            ?>
            <input name="pix_product_cars_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['product_cars_base'] ); ?>" placeholder="<?php echo esc_attr_x( 'cars', 'slug', 'pixsettings' ); ?>" />
            <?php
        }
        
        public function pix_permalinks_save() {
            if ( ! is_admin() ) {
                return;
            }
            
            // We need to save the options ourselves; settings api does not trigger save for the permalinks page.
            if ( isset($_POST['permalink_structure'] ) ) {
                
                $permalinks                         = (array) get_option( 'pix_permalinks', array() );
                $permalinks['product_cars_base']   = trim( wp_unslash($_POST['pix_product_cars_slug']) );
                
                update_option( 'pix_permalinks', $permalinks );
                
            }
        }
		
		
		function post_type_init() {
            global $pix_settings;
            
            $permalinks = wp_parse_args( (array) get_option( 'pix_permalinks', array() ), array(
                'product_cars_base'         => '',
            ) );
            
            $product_cars_slug = !isset($permalinks['product_cars_base']) || empty($permalinks['product_cars_base']) ? 'cars' : $permalinks['product_cars_base'];
            
            register_taxonomy('pix-product-car',
                'product',
                array('hierarchical' => true,
                    'label' => __('Cars', 'pixsettings'),
                    'singular_label' => __('Car', 'pixsettings'),
                    'public' => true,
                    'show_tagcloud' => false,
                    'query_var' => true,
                    'rewrite' => array('slug' => $product_cars_slug, 'with_front' => false)
                )
            );
            
            if($pix_settings->settings->get_setting('pix-banner') == 'on') {
                register_post_type('pix-banner',
                    array(
                        'label' => __('Banners', 'pixsettings'),
                        'singular_label' => __('Banner', 'pixsettings'),
                        'exclude_from_search' => false,
                        'publicly_queryable' => true,
                        'menu_position' => null,
                        'show_ui' => true,
                        'public' => true,
                        'show_in_menu' => true,
                        'menu_icon' => 'dashicons-buddicons-activity',
                        'query_var' => true,
                        'rewrite' => array('slug' => 'banner'),
                        'capability_type' => 'page',
                        'has_archive' => true,
                        'hierarchical' => false,
                        'edit_item' => __('Edit', 'pixsettings'),
                        'supports' => array('title', 'thumbnail', 'page-attributes'),
                        'register_meta_box_cb'	=> 'pix_meta_boxes'
                    )
                );
    
                register_taxonomy('pix-banner-category',
                    'pix-banner',
                    array(
                        'hierarchical' => true,
                        'label' => __('Categories', 'pixsettings'),
                        'singular_label' => __('Category', 'pixsettings'),
                        'public' => true,
                        'show_tagcloud' => false,
                        'query_var' => true,
                        'rewrite' => array('slug' => 'banner-category', 'with_front' => false)
                    )
                );
                
                add_filter('manage_edit-pix-banner_columns', 'pixtheme_pixbanner_edit_columns');
                add_action('manage_pix-banner_posts_custom_column', 'pixtheme_pixbanner_custom_columns');

                function pixtheme_pixbanner_edit_columns($columns){
                    $columns = array(
                        'cb' => '<input type="checkbox" />',
                        'title' => __('Title', 'pixsettings'),
                        'image' => __('Featured Image', 'pixsettings'),
                        'id' => __('ID', 'pixsettings'),
                        'category' => __('Category', 'pixsettings'),
                    );

                    return $columns;
                }

                function pixtheme_pixbanner_custom_columns($column){
                    global $post;
                    switch ($column) {
                        case "category":
                            echo get_the_term_list($post->ID, 'pix-banner-category', '', ', ', '');
                            break;

                        case 'id':
                            echo $post->ID;
                            break;

                        case 'team_description':
                            the_excerpt();
                            break;

                        case 'image':
                            the_post_thumbnail(array(50,50));
                            break;
                    }
                }
            }
            
            if($pix_settings->settings->get_setting('pix-calculator') == 'on') {
                
                register_post_type('pix-calculator-field',
                    array(
                        'label' => __('Calculator Fields', 'pixsettings'),
                        'singular_label' => __('Calculator Field', 'pixsettings'),
                        'exclude_from_search' => false,
                        'publicly_queryable' => true,
                        'menu_position' => null,
                        'show_ui' => true,
                        'public' => true,
                        'show_in_menu' => true,
                        'menu_icon' => 'dashicons-editor-table',
                        'query_var' => true,
                        'rewrite' => array('slug' => 'calc-field'),
                        'capability_type' => 'page',
                        'has_archive' => true,
                        'hierarchical' => false,
                        'edit_item' => __('Edit', 'pixsettings'),
                        'supports' => array('title', 'excerpt', 'page-attributes'),
                        'register_meta_box_cb'	=> 'pix_meta_boxes'
                    )
                );
    
                register_taxonomy('pix-calculator',
                    'pix-calculator-field',
                    array(
                        'hierarchical' => true,
                        'label' => __('Calculators', 'pixsettings'),
                        'singular_label' => __('Calculator', 'pixsettings'),
                        'public' => true,
                        'show_tagcloud' => false,
                        'query_var' => true,
                        'rewrite' => array('slug' => 'calculator', 'with_front' => false)
                    )
                );
    
                add_filter('manage_edit-pix-calculator-field_columns', 'pixtheme_pixcalc_edit_columns');
                add_action('manage_pix-calculator-field_posts_custom_column', 'pixtheme_pixcalc_custom_columns');

                function pixtheme_pixcalc_edit_columns($columns){
                    $columns = array(
                        'cb' => '<input type="checkbox" />',
                        'title' => __('Title', 'pixsettings'),
                        'type' => __('Type', 'pixsettings'),
                        'id' => __('ID', 'pixsettings'),
                        'calculator' => __('Calculator', 'pixsettings'),
                    );
    
                    return $columns;
                }
    
                function pixtheme_pixcalc_custom_columns($column){
                    global $post;
                    switch ($column) {
                        case "calculator":
                            echo get_the_term_list($post->ID, 'pix-calculator', '', ', ', '');
                            break;
    
                        case 'id':
                            echo $post->ID;
                            break;
    
                        case 'type':
                            $type_arr = [
                                'select' => esc_html__('Select', 'pixsettings'),
                                'multiselect' => esc_html__('Multi Select', 'pixsettings'),
                                'check' => esc_html__('Checkbox', 'pixsettings'),
                                'radio' => esc_html__('Radiobutton', 'pixsettings'),
                            ];
                            echo $type_arr[get_post_meta( get_the_ID(), 'pix-field-type', true )];
                            break;
                    }
                }
            }

		}
		
		function pix_product_cat_fields_form($tag){
            $t_slug = $tag->slug;
            $pix_product_cat_thumb_url = get_option('pix_product_cat_thumb_' . $t_slug);
        ?>
            <tr class="form-field">
                <th scope="row" valign="top"><label for="tag-pixcar_body_thumb"><?php _e('Icon', 'pixsettings'); ?></label></th>
                <td>
                    <input type="text" name="pix_product_cat_thumb" id="tag-pix_product_cat_thumb" style="width:60%;" value="<?php echo isset($pix_product_cat_thumb_url) ? esc_url($pix_product_cat_thumb_url) : ''; ?>" />
                    <button data-input="tag-pix_product_cat_thumb" class="btn pix-image-upload pix-btn-icon"><i class="fas fa-image"></i><?php esc_html_e( 'Add', 'pixsettings') ?></button>
                    <button type="button" class="btn pix-reset pix-btn-icon"><i class="fas fa-trash-alt"></i><?php esc_html_e( 'Clear', 'pixsettings') ?></button>
                    <?php if(isset($pix_product_cat_thumb_url) && $pix_product_cat_thumb_url){ ?><p class="pix-bg"> <img src="<?php echo esc_url($pix_product_cat_thumb_url) ?>" alt="<?php esc_attr_e('Icon', 'pixsettings') ?>"> </p><?php } ?>
                </td>
            </tr>
        <?php
        }
    
        function pix_product_cat_fields_add_form($tag) {
        ?>
            <div class="form-field">
                <label for="tag-pix_product_cat_thumb"><?php _e('Image', 'pixsettings'); ?></label>
                <input type="text" name="pix_product_cat_thumb" id="tag-pix_product_cat_thumb" value="">
                <button data-input="tag-pix_product_cat_thumb" class="btn pix-image-upload pix-btn-icon"><i class="fas fa-image"></i><?php esc_html_e( 'Add', 'pixsettings') ?></button>
                <button type="button" class="btn pix-reset pix-btn-icon"><i class="fas fa-trash-alt"></i><?php esc_html_e( 'Clear', 'pixsettings') ?></button>
            </div>
        <?php
        }
    
        function pix_product_cat_fields_save($term_id) {
            if (isset($_POST['pix_product_cat_thumb'])) {
                $term = get_term_by( 'term_taxonomy_id', $term_id, 'product_cat' );
                $t_slug = $term->slug;
                if (isset($_POST['pix_product_cat_thumb'])) {
                    update_option('pix_product_cat_thumb_' . $t_slug, $_POST['pix_product_cat_thumb']);
                }
            }
        }
		
		public function pix_calculator_form(){
		    add_action( 'wpcf7_init', 'pixtheme_add_calculator_field' );
		    
            function pixtheme_add_calculator_field() {
                wpcf7_add_form_tag( 'calculator', 'pixtheme_add_calculator_field_handler', array( 'name-attr' => true ));
            }
            
            function pixtheme_add_calculator_field_handler( $tag ) {
                
                $tag = new WPCF7_FormTag( $tag );

                if ( empty( $tag->name ) ) {
                    return '';
                }
            
                $atts = array();
            
                $class = wpcf7_form_controls_class( $tag->type );
                $atts['class'] = 'pix-calculator-data '.$tag->get_class_option( $class );
                $atts['id'] = $tag->get_id_option();
            
                $atts['name'] = $tag->name;
                $atts = wpcf7_format_atts( $atts );
            
                $html = sprintf( '<textarea %s></textarea>', $atts );
                return $html;
            }
        }

	}
	new PixTheme_Post_Types;

}