<?php


if ( !class_exists('Pix_Filter_Admin')) {
    class Pix_Filter_Admin {
        
        function __construct() {
            add_action( 'admin_menu', array( $this, 'pix_register_filter_submenu_page') );
        }
        
        public function pix_register_filter_submenu_page() {
            $hookname = add_submenu_page(
                'edit.php?post_type=product',
                'Filter',
                'Filter',
                'manage_options',
                'pix-filter-page',
                array($this, 'pix_filter_page_callback')
            );
            
            add_action( 'load-'.$hookname, array( $this, 'pix_save_options') );
        }
        
        public function pix_filter_page_callback() {
            echo '<div class="wrap">';
            echo '<h2>Pix Filter</h2>';
            echo '</div>';
            
            if( isset($_POST['submit']) ) { ?>
                <div id="message" class="updated">
                    <p><strong><?php _e('Settings saved.', 'pixsettings') ?></strong></p>
                </div>
            <?php }
            
            $args = array(
                'echo'       => 0,
                'hide_empty' => 0,
                'hierarchical'  => 1,
                'show_uncategorized' => 0,
                'value_field'        => 'slug',
                'taxonomy'           => 'product_cat',
                'name'               => 'product_cat',
                'class'              => 'pix-product-cat-select pix-multi-select',
            );
            $cats_select = wp_dropdown_categories($args);
            $cats_select = str_replace('pix-multi-select\'', 'pix-multi-select\' multiple data-placeholder="'.esc_html__('Select categories', 'pixsettings').'"', $cats_select);
            
            $woo_pa = wc_get_attribute_taxonomies();
            //print_r($woo_pa);
            
            echo '<form action="" method="post">';
            
            echo '<ul class="pix-attributes">';
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
            
            foreach($woo_pa as $key => $val){
                $values = get_option($val->attribute_name);
                //print_r($values);
                $attr_name = $val->attribute_name;
                $label = '';
                if(isset($values['filter-label'])){
                    $label = $values['filter-label'];
                }
                $cats_select_attr = str_replace('product_cat', $attr_name.'[filter-cat][]', $cats_select);
                if( isset($values['filter-cat']) ){
                    foreach($values['filter-cat'] as $k => $v){
                        $cats_select_attr = str_replace('"'.$v.'"', '"'.$v.'" selected', $cats_select_attr);
                    }
                }
                $type_sel = '';
                if(isset($values['filter-type'])){
                    $type_sel = $values['filter-type'];
                }
                $visible = '';
                if(isset($values['filter-visible'])){
                    $visible = $values['filter-visible'];
                }
                $exclude = '';
                if(isset($values['filter-exclude'])){
                    $exclude = $values['filter-exclude'];
                }
                echo '<li data-attr-name="'.esc_attr($attr_name).'">
                        <input type="text" name="'.esc_attr($attr_name.'[filter-label]').'" placeholder="'.wp_kses_post($val->attribute_label).'" value="'.wp_kses_post($label).'">
                        <select name="'.esc_attr($attr_name.'[filter-type]').'">
                            <option value="">Select filter type</option>
                            <option value="checkbox" '.selected($type_sel, 'checkbox', 0).'>Checkbox Group</option>
                            <option value="toggle" '.selected($type_sel, 'toggle', 0).'>Toggle</option>
                            <option value="segmented" '.selected($type_sel, 'segmented', 0).'>Segmented</option>
                            <option value="input" '.selected($type_sel, 'input', 0).'>Single Input</option>
                            <option value="input-range" '.selected($type_sel, 'input-range', 0).'>Range Input</option>
                            <option value="range" '.selected($type_sel, 'range', 0).'>Range Slider</option>
                            <option value="multi-select" '.selected($type_sel, 'multi-select', 0).'>Multi Select</option>
                            <option value="select" '.selected($type_sel, 'select', 0).'>Select</option>
                        </select>
                        <select name="'.esc_attr($attr_name.'[filter-visible]').'">
                            <option value="">Show</option>
                            <option value="advanced" '.selected($visible, 'advanced', 0).'>Advanced</option>
                            <option value="hide" '.selected($visible, 'hide', 0).'>Hide</option>
                        </select>
                        '.$cats_select_attr.'
                        <input type="text" name="'.esc_attr($attr_name.'[filter-exclude]').'" value="'.wp_kses_post($exclude).'">
                        <!--<span> <i class="fas fa-cog"></i> </span>-->
                      </li>';
            }
            echo '</ul>';
            
            submit_button( 'Save' );
            wp_nonce_field( 'pix-filter-page-save', 'pix-filter-page-save-nonce' );
            
            echo '</form>';
        }
        
        public function pix_save_options() {
            $action       = 'pix-filter-page-save';
            $nonce        = 'pix-filter-page-save-nonce';
            // If the user doesn't have permission to save, then display an error message
            
            if ( !isset( $_POST[ $nonce ] ) || ! wp_verify_nonce( $_POST[ $nonce ], $action ) ) {
                return;
            }
            
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
            foreach($woo_pa as $key => $val){
                if ( isset( $_POST[$val->attribute_name] ) ) {
                    update_option( $val->attribute_name, $_POST[$val->attribute_name] );
                } else {
                    delete_option( $val->attribute_name );
                }
            }
        }
        
    }
}
$pix_filter_admin = new Pix_Filter_Admin();
