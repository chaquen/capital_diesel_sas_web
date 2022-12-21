<?php

// prevent direct file access
if( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}


class PixThemeSettings_Product_Filter extends WP_Widget {

	// Widget setup.
	function __construct() {
		// Create the widget.
		parent::__construct('pixtheme_product_filter', esc_html__('Pix Product Filter', 'pixsettings') , array( 'description' => esc_html__('Display Product Filter', 'pixsettings'), ));
	}

	// Display the widget on the screen.
	function widget($args, $instance) {
		global $pix_settings, $post;
		extract($args);
		$title = apply_filters('widget_title', $instance['filter_title']);
		
		echo wp_kses_post($before_widget);
        if ($title) echo wp_kses_post($before_title . $title . $after_title);
        
        echo '<div class="pix-sidebar-block-filter">';
		
		$woo_pa = wc_get_attribute_taxonomies();
		$cars = array(
            'attribute_name' => 'cars',
            'attribute_label' => esc_html__('Cars', 'pixsettings'),
        );
		$price = array(
            'attribute_name' => 'price',
            'attribute_label' => esc_html__('Price', 'pixsettings'),
        );
        array_unshift($woo_pa, (object)$price);
		array_unshift($woo_pa, (object)$cars);
        
        $filter_select = array();
        
        if( !function_exists('cmp') ) {
	        function cmp( $a, $b ) {
		        return strcmp( $a->name, $b->name );
	        }
        }
        
        $cat = get_queried_object();
        $href_class = '';
        if( class_exists( 'WooCommerce' ) && ( is_shop() || is_product_category() ) ){
        
        } elseif( class_exists( 'WooCommerce' ) && is_product() ) {
            $href_class = 'pix-count';
        }
        
		foreach($woo_pa as $key => $val){
            $values = get_option($val->attribute_name);
            $attr_name = $val->attribute_name;
            $visible = true;
            $terms_values = '';
            $terms = get_terms([
                'taxonomy' => 'pa_'.$attr_name,
	            'hide_empty' => false,
            ]);
            
            if( isset($cat->slug) && isset($values['filter-cat']) && !in_array($cat->slug, $values['filter-cat']) ){
                $visible = false;
            }
            
//            $exclude = '';
//            if(isset($values['filter-exclude'])){
//                $exclude = $values['filter-exclude'];
//            }
            $type_sel = '';
            if(isset($values['filter-type'])){
                $type_sel = $values['filter-type'];
            }
            
            if( isset($_REQUEST[$attr_name]) ){
                $get_values = explode(',',$_REQUEST[$attr_name]);
                $filter_select[$attr_name] = array(
                    'value' => $_REQUEST[$attr_name],
                    'title' => $val->attribute_label,
                );
            } else {
                $get_values = array();
            }
            echo '<div class="pix-filter-control">';
            if($visible && $attr_name == 'cars') {
                $args_tax = array(
                    'taxonomy' => array('pix-product-car'),
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'parent' => '0',
                    'hide_empty' => '0',
                );
                $cars_categories = get_categories($args_tax);
                
                $makes = get_terms('pix-product-car', array('hide_empty' => false));
                $makes_tree = [];
                $lvl = pixtheme_terms_tree($makes, $makes_tree);
                
                $out_makes = $out_models = $out_restyles = $out_versions = '';
                $get_make = isset($_REQUEST['make']) ? explode(',', $_REQUEST['make']) : array();
                $get_model = isset($_REQUEST['model']) ? explode(',', $_REQUEST['model']) : array();
                $get_restyle = isset($_REQUEST['restyle']) ? explode(',', $_REQUEST['restyle']) : array();
                $get_version = isset($_REQUEST['version']) ? explode(',', $_REQUEST['version']) : array();
                
                usort($cars_categories, 'cmp');
                
                foreach ($cars_categories as $car_cat) {
                    if (in_array($car_cat->slug, $get_make)) {
                        $class_make = 'selected';
                    } else {
                        $class_make = '';
                    }
                    $out_makes .= '<option value="' . esc_attr($car_cat->slug) . '" ' . esc_attr($class_make) . '>' . esc_attr($car_cat->name) . '</option>';
                }
                
                echo '
                    <div class="pix-filter-select">
                        <select id="ajax-make" class="'.esc_attr($href_class).'" name="ajax-make" data-placeholder="'.esc_attr__('Select Cars Make', 'pitstop').'" data-type="select" data-field="make">
                            '.($out_makes).'
                        </select>
                    </div>';
                
                if ( ((isset($instance['makes_lvl']) && $instance['makes_lvl'] > 1) || !isset($instance['makes_lvl'])) && $lvl >= 2 ) {
	                if ( ! empty( $get_make ) ) {
		                $make_term = get_term_by( 'slug', $get_make[0], 'pix-product-car' );
		                $args      = array( 'taxonomy'   => 'pix-product-car',
		                                    'orderby'    => 'name',
		                                    'order'      => 'ASC',
		                                    'parent'     => $make_term->term_id,
		                                    'hide_empty' => false,
		                );
		                $terms_arr = get_terms( $args );
		                usort($terms_arr, 'cmp');
		                foreach ( $terms_arr as $k => $v ) {
			                if ( in_array( $v->slug, $get_model ) ) {
				                $class_model = 'selected';
			                } else {
				                $class_model = '';
			                }
			                $out_models .= '<option value="' . esc_attr( $v->slug ) . '" ' . esc_attr( $class_model ) . '>' . esc_attr( $v->name ) . '</option>';
		                }
	                }
	                echo '
                    <div class="pix-filter-select">
                        <select class="pix-filter ' . esc_attr( $href_class ) . '" id="pix-model" name="pix-model" data-placeholder="' . esc_attr__( 'Select Model', 'pitstop' ) . '" data-type="select" data-field="model">
                            ' . ( $out_models ) . '
                        </select>
                    </div>';
                }
                
                if( ((isset($instance['makes_lvl']) && $instance['makes_lvl'] > 2) || !isset($instance['makes_lvl'])) && $lvl >= 3) {
	                if ( ! empty( $get_model ) ) {
		                $make_term = get_term_by( 'slug', $get_model[0], 'pix-product-car' );
		                $args      = array( 'taxonomy'   => 'pix-product-car',
		                                    'orderby'    => 'name',
		                                    'order'      => 'ASC',
		                                    'parent'     => $make_term->term_id,
		                                    'hide_empty' => false,
		                );
		                $terms_arr = get_terms( $args );
		                usort( $terms_arr, 'cmp' );
		                foreach ( $terms_arr as $k => $v ) {
			                if ( in_array( $v->slug, $get_restyle ) ) {
				                $class_restyle = 'selected';
			                } else {
				                $class_restyle = '';
			                }
			                $out_restyles .= '<option value="' . esc_attr( $v->slug ) . '" ' . esc_attr( $class_restyle ) . '>' . esc_attr( $v->name ) . '</option>';
		                }
	                }
	                echo '
                    <div class="pix-filter-select">
                        <select class="pix-filter ' . esc_attr( $href_class ) . '" id="pix-restyle" name="pix-restyle" data-placeholder="' . esc_attr__( 'Select Restyle', 'pitstop' ) . '" data-type="select" data-field="restyle">
                            ' . ( $out_restyles ) . '
                        </select>
                    </div>';
                }
                
                if( ((isset($instance['makes_lvl']) && $instance['makes_lvl'] > 3) || !isset($instance['makes_lvl'])) && $lvl >= 4) {
	                if ( ! empty( $get_restyle ) ) {
		                $make_term = get_term_by( 'slug', $get_restyle[0], 'pix-product-car' );
		                $args      = array( 'taxonomy'   => 'pix-product-car',
		                                    'orderby'    => 'name',
		                                    'order'      => 'ASC',
		                                    'parent'     => $make_term->term_id,
		                                    'hide_empty' => false,
		                );
		                $terms_arr = get_terms( $args );
		                usort( $terms_arr, 'cmp' );
		                foreach ( $terms_arr as $k => $v ) {
			                if ( in_array( $v->slug, $get_version ) ) {
				                $class_version = 'selected';
			                } else {
				                $class_version = '';
			                }
			                $out_versions .= '<option value="' . esc_attr( $v->slug ) . '" ' . esc_attr( $class_version ) . '>' . esc_attr( $v->name ) . '</option>';
		                }
	                }
	                echo '
                    <div class="pix-filter-select">
                        <select class="pix-filter ' . esc_attr( $href_class ) . '" id="pix-version" name="pix-version" data-placeholder="' . esc_attr__( 'Select Version', 'pitstop' ) . '" data-type="select" data-field="version">
                            ' . ( $out_versions ) . '
                        </select>
                    </div>';
                }
    
            } elseif($visible) {
                $label = $instance['show_titles'] == 'on' ? '<label for="' . esc_attr($attr_name) . '">' . wp_kses($val->attribute_label, 'post') . '</label>' : '';
                switch ($type_sel) {
                    case 'checkbox':
                        echo $instance['show_titles'] == 'on' ? '<label>' . wp_kses_post($val->attribute_label) . '</label>' : '';
                        foreach ($terms as $term) {
                            $checked = in_array($term->slug, $get_values) ? 'checked' : '';
                            ?>
                            <div class="pix-product-box-checkbox">
                                <label>
                                    <input class="pix-filter '.esc_attr($href_class).'" data-type="check"
                                           data-field="<?php echo esc_attr($attr_name) ?>"
                                           type="checkbox" <?php echo esc_attr($checked) ?>
                                           name="pa_<?php echo esc_attr($attr_name) ?>"
                                           id="<?php echo esc_attr($term->slug) ?>"
                                           value="<?php echo esc_attr($term->slug) ?>">
                                    <span class="pix-checkbox-icon"></span>
                                    <span class="pix-checkbox-text"><?php echo wp_kses_post($term->name) ?></span>
                                </label>
                            </div>
                            <?php
                        }
                        break;
                    case 'toggle':
                        $checked = isset($get_values[0]) && $get_values[0] == 'on' ? 'checked' : '';
                        echo '
                        <div class="pix-filter-toggle">
                            '.$label.'
                            <div class="pix-checkbox">
                                <input id="' . esc_attr($attr_name) . '" name="pa_' . esc_attr($attr_name) . '" ' . esc_attr($checked) . ' type="checkbox" class="pix-filter '.esc_attr($href_class).'" data-type="check" data-field="' . esc_attr($attr_name) . '">
                                <div></div>
                            </div>
                        </div>';
                        break;
                    case 'segmented':
                        $output = array();
                        if ( ! empty( $terms ) ) {
                            $i=0;
                            $cnt = count($terms)-1;
                            $pix_rand = 'pixid-'.rand().'-';
                            foreach ($terms as $term) {
                                $checked = in_array($term->slug, $get_values) ? 'checked' : '';
                                $class = '';
                                if( $i == 0 ){
                                    $class = 'first';
                                } elseif ( $i == $cnt ){
                                    $class = 'last';
                                }
                
                                $output[] = '<input class="pix-filter '.esc_attr($href_class).' pix-segmented-button-field" id="' . $pix_rand . $term->slug . '" name="pa_'.esc_attr($attr_name).'" value="' . $term->slug . '" ' . esc_attr($checked) . ' type="radio" data-type="check" data-field="'.esc_attr($attr_name).'">
                                <label class="' . $class . '" for="' . $pix_rand . $term->slug . '"> '.esc_attr($term->name).' </label>';
                                
                                $i++;
                            }
                        }
                        
                        echo '
                        <div class="pix-filter-input">
                            '.$label.'
                            <div id="'.esc_attr($attr_name).'" class="pix-filter-segmented-button">
                            '.implode($output).'
                            </div>
                        </div>';
                    break;
                    case 'input':
                        echo '
                        <div class="pix-filter-input">
                            '.$label.'
                            <input id="' . esc_attr($attr_name) . '" type="number" class="pix-filter '.esc_attr($href_class).'" data-type="number" data-field="' . esc_attr($attr_name) . '">
                        </div>';
                        break;
                    case 'input-range':
                        echo '
                        <div class="pix-filter-input">
                            '.$label.'
                            <div id="' . esc_attr($attr_name) . '" class="pix-double-control">
                                <input type="number" class="pix-min pix-filter '.esc_attr($href_class).'" data-type="number" data-field="' . esc_attr($attr_name) . '">
                                <span>&ndash;</span>
                                <input type="number" class="pix-max pix-filter '.esc_attr($href_class).'" data-type="number" data-field="' . esc_attr($attr_name) . '">
                            </div>
                        </div>';
                        break;
                    case 'range':
                        ?>
                        <div class="pix-range-box">
                            <?php echo $label; ?>
                            <?php if($attr_name == 'price') : ?>
                            <input id="<?php echo esc_attr($attr_name) ?>" class="pix-range-slider" hidden type="text"
                                   value="" data-skin="pix" data-type="double" data-min="0" data-max="<?php echo esc_attr($pix_settings->settings->get_setting('pix-woo-range-max')) ?>" data-from="<?php echo isset($get_values[0]) ? esc_attr($get_values[0]) : 0; ?>" data-to="'<?php echo isset($get_values[1]) ? esc_attr($get_values[1]) : esc_attr($pix_settings->settings->get_setting('pix-woo-range-max')) ?>" data-step="<?php echo esc_attr($pix_settings->settings->get_setting('pix-woo-range-step')) ?>" data-prettify-separator="<?php echo esc_attr(wc_get_price_thousand_separator()) ?>" data-grid="false" <?php echo wp_kses(pixtheme_range_price_format(), 'post') ?> >
                            <?php else : ?>
                            <input id="<?php echo esc_attr($attr_name) ?>" class="pix-range-slider" hidden type="text"
                                   value="" data-skin="pix" data-type="double" data-min="0" data-max="5000" data-step="10"
                                   data-from="<?php echo isset($get_values[0]) ? esc_attr($get_values[0]) : 0; ?>"
                                   data-to="<?php echo isset($get_values[1]) ? esc_attr($get_values[1]) : 5000; ?>"
                                   data-grid="false">
                            <?php endif; ?>
                            <input type="hidden" class="pix-min pix-filter <?php echo esc_attr($href_class) ?>" data-type="number"
                                   data-field="<?php echo esc_attr($attr_name) ?>"
                                   value="<?php echo isset($get_values[0]) ? esc_attr($get_values[0]) : ''; ?>">
                            <input type="hidden" class="pix-max pix-filter <?php echo esc_attr($href_class) ?>" data-type="number"
                                   data-field="<?php echo esc_attr($attr_name) ?>"
                                   value="<?php echo isset($get_values[1]) ? esc_attr($get_values[1]) : ''; ?>">
                        </div>
                        <?php
                        break;
                    case 'multi-select':
                        $terms_values = '';
                        foreach ($terms as $term) {
                            $terms_values .= '<option value="' . esc_attr($term->slug) . '">' . $term->name . '</option>';
                        }
                        echo '
                        <div class="pix-filter-multi-select">
                            '.$label.'
                            <select id="' . esc_attr($attr_name) . '" class="pix-filter '.esc_attr($href_class).'" multiple data-placeholder="' . wp_kses_post($val->attribute_label) . '" data-type="multi-select" data-field="' . esc_attr($attr_name) . '">' . $terms_values . '</select>
                        </div>';
                        break;
        
                    case 'select':
                        $terms_values = '';
                        foreach ($terms as $term) {
                            $terms_values .= '<option value="' . esc_attr($term->slug) . '">' . $term->name . '</option>';
                        }
                        echo '
                        <div class="pix-filter-select">
                            '.$label.'
                            <select id="' . esc_attr($attr_name) . '" class="pix-filter '.esc_attr($href_class).'" data-placeholder="' . wp_kses_post($val->attribute_label) . '" data-type="select" data-field="' . esc_attr($attr_name) . '">
                                ' . $terms_values . '
                            </select>
                        </div>';
                        break;
                }
            }
            
            echo '</div>';
        }
        
        ?>
        
        <input type="hidden" class="pix-filter-select-value" value='<?php echo json_encode($filter_select) ?>'>
        
        <div class="row btn-filter">
            <div class="col-12 js-filter">

                <?php
                    $path = '';
                    if(substr_count($_SERVER['REQUEST_URI'], '/page/') > 0){
                        $path = preg_split('/\/page\//', $_SERVER['REQUEST_URI']);
                        $path = $path[0].'/';
                    }else{
                        $path = preg_split('/\?/', $_SERVER['REQUEST_URI']);
                        $path = $path[0];
                    }
                    
                    $btn = '<a href="'.esc_url($_SERVER['SERVER_NAME'] . $path).'" id="pix-reset-button" class="pix-button">'.esc_html__('Reset', 'pitstop').'</a>';
                    $filter_box_class = '';
                    if(isset($instance['href_page']) && $instance['href_page'] != ''){
                        $filter_box_class = 'pix-filter-box';
                        $btn = '<a href="'.get_permalink($instance['href_page']).'" class="pix-button" data-page="'.get_permalink($instance['href_page']).'" data-href="">'.wp_kses_post($instance['btn_title']).' <span></span></a>';
                    }
                ?>
                <div class="pix-sidebar-submit <?php echo esc_attr($filter_box_class); ?>">
                    <?php echo $btn; ?>
                </div>

            </div>
        </div>
        
        <?php
        
        echo '</div>';
		
		echo wp_kses_post($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['filter_title'] = strip_tags($new_instance['filter_title']);
		$instance['makes_lvl'] = ( ! empty( $new_instance['makes_lvl'] ) ) ? strip_tags( $new_instance['makes_lvl'] ) : '3';
		$instance['show_titles'] = $new_instance['show_titles'];
		return $instance;
	}

	function form($instance) {
		$defaults = array(
			'filter_title' => esc_html__('Filter', 'pixsettings'),
            'show_titles' => 'on',
		);
		$instance = wp_parse_args((array)$instance, $defaults);
		$makes_lvl = isset( $instance['makes_lvl'] ) ? $instance['makes_lvl'] : '3';
		$show_titles = isset( $instance['show_titles'] ) && $instance['show_titles'] == 'on' ? 'checked' : '';?>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('filter_title')); ?>"><?php esc_html_e('Title', 'pixsettings'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('filter_title')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('filter_title')); ?>" value="<?php echo esc_attr($instance['filter_title']); ?>" class="widefat" />
        </p>
        <p>
            <select class="widefat" id="<?php echo $this->get_field_id( 'makes_lvl' ); ?>" name="<?php echo $this->get_field_name( 'makes_lvl' ); ?>" >
                <option value="4" <?php selected( $makes_lvl, '4', true ); ?>><?php _e( 'Show All Cars Levels (4)', 'pixcars' ); ?></option>
                <option value="3" <?php selected( $makes_lvl, '3', true ); ?>><?php _e( 'Show Makes, Models & Restyle Levels (3)', 'pixcars' ); ?></option>
                <option value="2" <?php selected( $makes_lvl, '2', true ); ?>><?php _e( 'Show Makes & Models Levels (2)', 'pixcars' ); ?></option>
                <option value="1" <?php selected( $makes_lvl, '1', true ); ?>><?php _e( 'Show Makes Level (1)', 'pixcars' ); ?></option>
            </select>
        </p>
        <p>
            <div><?php esc_html_e('Show Fields Titles', 'pixsettings'); ?></div>
            <label class="switch switch-green">
                <input type="checkbox" class="switch-input pix-switch-button-field" id="<?php echo $this->get_field_id( 'show_titles' ); ?>" name="<?php echo $this->get_field_name( 'show_titles' ); ?>" <?php echo esc_attr($show_titles) ?> />
                <span class="switch-label" data-on="On" data-off="Off"></span>
                <span class="switch-handle"></span>
            </label>
        </p>

	<?php
	}
}