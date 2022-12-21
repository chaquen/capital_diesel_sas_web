<?php

	$swiper = array(
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Carousel', 'pitstop' ),
            'param_name' => 'swiper',
            'value' => 'on',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => '<i class="fas fa-desktop ultra"></i>',
            'param_name' => 'swiper_slides_per_view',
            'value' => array(1,2,3,4,5,6,7,8,9,10),
            'std' => '6',
            'edit_field_class' => 'vc_col-sm-2',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => '<i class="fas fa-desktop"></i>',
            'param_name' => 'swiper_items_desktop',
            'value' => array(1,2,3,4,5,6,7,8,9,10),
            'std' => '5',
            'edit_field_class' => 'vc_col-sm-2',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => '<i class="fas fa-laptop"></i>',
            'param_name' => 'swiper_items_laptop',
            'value' => array(1,2,3,4,5,6,7,8,9,10),
            'std' => '4',
            'description' => '',
            'edit_field_class' => 'vc_col-sm-2',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => '<i class="fas fa-tablet-alt landscape"></i>',
            'param_name' => 'swiper_items_tablet_land',
            'value' => array(1,2,3,4,5,6,7,8,9,10),
            'std' => '3',
            'description' => '',
            'edit_field_class' => 'vc_col-sm-2',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => '<i class="fas fa-tablet-alt"></i>',
            'param_name' => 'swiper_items_tablet',
            'value' => array(1,2,3,4,5,6,7,8,9,10),
            'std' => '2',
            'description' => '',
            'edit_field_class' => 'vc_col-sm-2',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => '<i class="fas fa-mobile-alt"></i>',
            'param_name' => 'swiper_items_mobile',
            'value' => array(1,2,3,4,5,6,7,8,9,10),
            'std' => '1',
            'description' => '',
            'edit_field_class' => 'vc_col-sm-2',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Pagination', 'pitstop' ),
            'param_name' => 'swiper_pagination',
            'value' => 'on',
            'description' => esc_html__( 'Pagination dots ...', 'pitstop' ),
            'dependency' => array(
                'element' => 'swiper',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Navigation', 'pitstop' ),
            'param_name' => 'swiper_navigation',
            'value' => 'off',
            'description' => esc_html__( 'Navigation arrows < >', 'pitstop' ),
            'dependency' => array(
                'element' => 'swiper',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Loop', 'pitstop' ),
            'param_name' => 'swiper_loop',
            'value' => 'off',
            'description' => esc_html__( 'Infinity loop', 'pitstop' ),
            'dependency' => array(
                'element' => 'swiper',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Space Between', 'pitstop' ),
            'param_name' => 'swiper_space_between',
            'value' => '',
            'std' => '50',
            'description' => esc_html__( 'space between items (px)', 'pitstop' ),
            'dependency' => array(
                'element' => 'swiper',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'on Tablet', 'pitstop' ),
            'param_name' => 'swiper_space_between_tablet',
            'value' => '',
            'std' => '30',
            'description' => '',
            'dependency' => array(
                'element' => 'swiper',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'on Mobile', 'pitstop' ),
            'param_name' => 'swiper_space_between_mobile',
            'value' => '',
            'std' => '20',
            'description' => '',
            'dependency' => array(
                'element' => 'swiper',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Rows', 'pitstop' ),
            'param_name' => 'swiper_slides_per_column',
            'value' => array(
                'default' => '1',
                esc_html__( '1', 'pitstop' ) => '1',
                esc_html__( '2', 'pitstop' ) => '2',
            ),
            'dependency' => array(
                'element' => 'swiper',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-6',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Scroll by', 'pitstop' ),
            'param_name' => 'swiper_slides_to_scroll',
            'value' => array(
                'default' => '1',
                esc_html__( 'Item', 'pitstop' ) => '1',
                esc_html__( 'Page', 'pitstop' ) => 'all',
            ),
            'dependency' => array(
                'element' => 'swiper',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-6',
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'range_slider',
            'heading' => esc_html__( 'Speed', 'pitstop' ),
            'param_name' => 'swiper_speed',
            'value' => array(
                'default' => '700',
                'min' => '0',
                'max' => '10000',
                'step' => '100',
                'unit' => 'ms',
            ),
            'dependency' => array(
                'element' => 'swiper',
                'value' => 'on'
            ),
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Autoplay', 'pitstop' ),
            'param_name' => 'swiper_autoplay',
            'value' => 'off',
            'dependency' => array(
                'element' => 'swiper',
                'value' => 'on'
            ),
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'range_slider',
            'heading' => esc_html__( 'Autoplay Delay', 'pitstop' ),
            'param_name' => 'swiper_autoplay_delay',
            'value' => array(
                'default' => '1000',
                'min' => '0',
                'max' => '10000',
                'step' => '100',
                'unit' => 'ms',
            ),
            'dependency' => array(
                'element' => 'swiper_autoplay',
                'value' => 'on'
            ),
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Variable Width', 'pitstop' ),
            'param_name' => 'swiper_variable_width',
            'value' => 'off',
            'dependency' => array(
                'element' => 'swiper',
                'value' => 'on'
            ),
            'group' => esc_html__( 'Carousel', 'pitstop' ),
        ),
    );

	vc_add_params( 'common_slider', $swiper );
	vc_add_params( 'common_special_offers', $swiper );
	vc_add_params( 'common_team', $swiper );
    vc_add_params( 'common_woocommerce', $swiper );
    vc_add_params( 'common_woo_categories', $swiper );
    vc_add_params( 'common_brands', $swiper );
    vc_add_params( 'common_reviews', $swiper );
    vc_add_params( 'common_posts_block', $swiper );

    function pixtheme_get_swiper($swiper_arr, $animation_func = ''){
        $options_arr = array();
        
        if( isset($swiper_arr['swiper']) && $swiper_arr['swiper'] == 'on' ) {
            unset($swiper_arr['swiper']);
            $items_scroll = $items_scroll_desktop = $items_scroll_laptop = $items_scroll_tablet_land = $items_scroll_tablet = $items_scroll_mobile = 1;
            $space_between_tablet = $space_between_mobile = 0;
            $items_mobile = 1;
            $items_tablet = 2;
            $items_tablet_land = 3;
            $items_laptop = 4;
            $items_desktop = 5;
            foreach ($swiper_arr as $key => $val) {
                $option = str_replace('swiper_', '', $key);
                $option_temp = explode('_', $option);
                if(count($option_temp) > 1) {
                    $option = '';
                    foreach ($option_temp as $k => $v) {
                        $option .= ucfirst($v);
                    }
                    $option = lcfirst($option);
                }
                if ($option == 'speed') {
                    $options_arr['speed'] = (int)$val;
                } elseif ($option == 'animation' && $val == 'on') {
                    $options_arr['onTranslate'] = $animation_func;
                } elseif ($option == 'slidesPerView') {
                    $options_arr[$option] = (int)$val;
                    $items_scroll = $swiper_arr['swiper_slides_to_scroll'];
                    $options_arr['slidesPerGroup'] = (int)$val;
                } elseif ($option == 'itemsDesktop') {
                    $items_desktop = (int)$val;
                } elseif ($option == 'itemsLaptop') {
                    $items_laptop = (int)$val;
                } elseif ($option == 'itemsTabletLand') {
                    $items_tablet_land = (int)$val;
                } elseif ($option == 'itemsTablet') {
                    $items_tablet = (int)$val;
                } elseif ($option == 'itemsMobile') {
                    $items_mobile = (int)$val;
                } elseif ($option == 'slidesPerColumn') {
                    $options_arr[$option] = (int)$val;
                } elseif ($option == 'spaceBetween') {
                    $options_arr[$option] = (int)$val;
                } elseif ($option == 'spaceBetweenTablet') {
                    $space_between_tablet = (int)$val;
                } elseif ($option == 'spaceBetweenMobile') {
                    $space_between_mobile = (int)$val;
                } elseif ( $val == 'on' || $val == 'off' ) {
                    $options_arr[$option] = $val == 'on' ? true : false;
                } elseif ($option != 'slidesPerGroup') {
                    $options_arr[$option] = $val;
                }
            }
            
            if($items_scroll == 'all'){
                $items_scroll_mobile = $items_mobile;
                $items_scroll_tablet = $items_tablet;
                $items_scroll_tablet_land = $items_tablet_land;
                $items_scroll_laptop = $items_laptop;
                $items_scroll_desktop = $items_desktop;
                $options_arr['slidesPerGroup'] = isset($options_arr['slidesPerView']) ? (int)$options_arr['slidesPerView'] : 6;
            } else {
                $options_arr['slidesPerGroup'] = 1;
            }
            $options_arr['breakpoints'] = array(
                0 => array(
                    'slidesPerView' => (int)$items_mobile,
                    'slidesPerGroup' => (int)$items_scroll_mobile,
	                'spaceBetween' => (int)$space_between_mobile,
	                'slidesPerColumn' => 1,
                ),
                575 => array(
                    'slidesPerView' => (int)$items_tablet,
                    'slidesPerGroup' => (int)$items_scroll_tablet,
	                'spaceBetween' => (int)$space_between_mobile,
	                'slidesPerColumn' => isset($options_arr['slidesPerColumn']) ? (int)$options_arr['slidesPerColumn'] : 1,
                ),
                1024 => array(
                    'slidesPerView' => (int)$items_tablet_land,
                    'slidesPerGroup' => (int)$items_scroll_tablet_land,
	                'spaceBetween' => (int)$space_between_tablet,
	                'slidesPerColumn' => isset($options_arr['slidesPerColumn']) ? (int)$options_arr['slidesPerColumn'] : 1,
                ),
                1360 => array(
                    'slidesPerView' => (int)$items_laptop,
                    'slidesPerGroup' => (int)$items_scroll_laptop,
	                'spaceBetween' => (int)$space_between_tablet,
	                'slidesPerColumn' => isset($options_arr['slidesPerColumn']) ? (int)$options_arr['slidesPerColumn'] : 1,
                ),
                1715 => array(
                    'slidesPerView' => (int)$items_desktop,
                    'slidesPerGroup' => (int)$items_scroll_desktop,
	                'spaceBetween' => isset($options_arr['spaceBetween']) ? (int)$options_arr['spaceBetween'] : 0,
	                'slidesPerColumn' => isset($options_arr['slidesPerColumn']) ? (int)$options_arr['slidesPerColumn'] : 1,
                ),
                2300 => array(
                    'slidesPerView' => (int)$options_arr['slidesPerView'],
                    'slidesPerGroup' => (int)$options_arr['slidesPerGroup'],
	                'spaceBetween' => isset($options_arr['spaceBetween']) ? (int)$options_arr['spaceBetween'] : 0,
	                'slidesPerColumn' => isset($options_arr['slidesPerColumn']) ? (int)$options_arr['slidesPerColumn'] : 1,
                )
            );
        } else {
            foreach ($swiper_arr as $key => $val) {
                $option = str_replace('swiper_', '', $key);
                $option = str_replace('_', '-', $option);
                if( $option == 'swiper'){
                    $options_arr[$option] = $val;
                } elseif (in_array($option, ['slides-per-view', 'items-desktop', 'items-laptop', 'items-tablet-land', 'items-tablet', 'items-mobile'])) {
                    $options_arr[$option] = (int)$val;
                }
            }
        }

        return $options_arr;
    }

?>