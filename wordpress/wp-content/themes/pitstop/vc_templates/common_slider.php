<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Slider
 */
$is_animate = $css_animation = $animate = $animate_data = $swiper_class = $data_swiper = '';
$swiper_arr = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$swiper_arr = pixtheme_vc_get_params_array($atts, 'swiper');
extract( $atts );


$swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
if(!isset($swiper_options_arr['swiper'])) {
    $data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\'' . json_encode($swiper_options_arr) . '\'';
    $nav_enable = isset($swiper_options_arr['navigation']) && !$swiper_options_arr['navigation'] ? 'disabled' : '';
    $page_enable = isset($swiper_options_arr['pagination']) && !$swiper_options_arr['pagination'] ? 'disabled' : '';
    $swiper_class = 'swiper-container';
} elseif( $swiper_options_arr['swiper'] == 'off' ){
    $col = isset($swiper_options_arr['items']) ? $swiper_options_arr['items'] : 4;
    foreach($swiper_options_arr as $key => $val){
        if( $key == 'slides-per-view'){
            $swiper_class .= 'pix-col-'.$val.' ';
        } else {
            $swiper_class .= str_replace('items-','pix-col-', $key).'-'.$val.' ';
        }
    }
    $nav_enable = $page_enable = 'disabled';
}

$i = $offset = 0;
if($css_animation != '' && $is_animate == 'on') {
    $animate = 'animated';
    $animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
    $animate_data = ' data-animation="'.esc_attr($css_animation).'"';
    $wow_group = !empty($wow_group) ? $wow_group : 1;
    $wow_group_delay = !empty($wow_group_delay) ? $wow_group_delay : 0;
    $wow_delay = !empty($wow_delay) ? $wow_delay : 0;
    $animate_data .= !empty($wow_duration) ? ' data-wow-duration="'.esc_attr($wow_duration).'s"' : '';
    $animate_data .= !empty($wow_delay) || $wow_group_delay > 0 ? ' data-wow-delay="'.esc_attr($wow_delay + $offset * $wow_group_delay).'s"' : '';
    $animate_data .= !empty($wow_offset) ? ' data-wow-offset="'.esc_attr($wow_offset).'"' : '';
    $animate_data .= !empty($wow_iteration) ? ' data-wow-iteration="'.esc_attr($wow_iteration).'"' : '';

    $offset = $i % $wow_group == 0 ? ++$offset : $offset;
}

$search = [ 'pix-box ' ];
$replace = [ 'pix-box swiper-slide ' ];

$out = '
<div class="pix-swiper">
	<div class="'.esc_attr($swiper_class).'" '.($data_swiper).'>
		<div class="swiper-wrapper">
	    	'.str_replace($search, $replace, do_shortcode($content)).'
	    </div>
	</div>
	<div class="pix-nav left-right '.esc_attr($nav_enable).'">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <div class="pix-swiper-pagination swiper-pagination '.esc_attr($page_enable).'"></div>
</div>';


pixtheme_out($out);
