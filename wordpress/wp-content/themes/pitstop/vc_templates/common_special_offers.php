<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Special_Offers
 */
$href_before = $href_after = $is_animate = $css_animation = $animate = $animate_data = '';
$title_size = 'pix-title-l';
$swiper_arr = $shadows_arr = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$swiper_arr = pixtheme_vc_get_params_array($atts, 'swiper');
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );

$shadow_class = pixtheme_get_shadow($shadows_arr);

$image_size = 'pixtheme-original-col-3';
//$image_size .= pixtheme_retina() ? '-retina' : '';

$offers = vc_param_group_parse_atts( $atts['offers'] );
$offers_out = array();
$count = 1;
$cnt = count($offers);
$i = $offset = 0;
foreach($offers as $key => $item){

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

    $image = '';
    $href = isset($item['link']) ? vc_build_link( $item['link'] ) : '';
    $target = empty($href['target']) ? '_self' : $href['target'];

    if( isset($item['image']) && $item['image'] != ''){
        $img = wp_get_attachment_image_src( $item['image'], $image_size );
        $img_output = $img[0];
        $image =  '<img src="'.esc_url($img_output).'" alt="'.esc_attr($item['title']).'">';
    }
    if(!empty( $href['url'] )){
        $href_before = '<a target="' . ($target) . '" href="' . esc_url($href['url']) . '" class="pix-shadow-link">';
        $href_after = '</a>';
    }
    $subtitle = isset($item['subtitle']) && $item['subtitle'] != '' ? $item['subtitle'] : '';

    $class_red = $count % 2 == 0 ? 'pix-offer-slider-item-red' : '';
    $offers_out[] = '
        <div class="pix-offer-item swiper-slide '.esc_attr($animate).'" '.($animate_data).'>
        	'.($href_before).'
            <div class="pix-offer-item-inner">
                <div class="pix-offer-item-img">
                    '.($image).'
                </div>
                <div class="pix-offer-item-info">
                    <div class="pix-offer-item-title">
                        <div class="'.esc_attr($title_size).' pix-text-overflow">'.($item['title']).'</div>
                        <span class="pix-text-overflow">'.($subtitle).'</span>
                    </div>
                    <div class="pix-offer-item-text">
                        <p class="pix-text-overflow">'.($item['content_d']).'</p>
                    </div>
                </div>
            </div>
            '.($href_after).'
        </div>';

    $count ++;
}

$swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
$data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
$nav_enable = isset($swiper_options_arr['navigation']) && !$swiper_options_arr['navigation'] ? 'disabled' : '';
$page_enable = isset($swiper_options_arr['pagination']) && !$swiper_options_arr['pagination'] ? 'disabled' : '';
$col = isset($swiper_options_arr['items']) ? $swiper_options_arr['items'] : 4;
$swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($col);


$out = '
<div class="pix-swiper">
	<div class="pix-offer-list '.esc_attr($swiper_class).' '.esc_attr($radius).' " '.($data_swiper).'>
	    <div class="swiper-wrapper">
	    	'.implode( "\n", $offers_out ).'
		</div>
	</div>
	<div class="pix-nav left-right pix-offer-list-nav '.esc_attr($nav_enable).'">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <div class="pix-swiper-pagination swiper-pagination pix-offer-list-paging '.esc_attr($page_enable).'"></div>
</div>';


pixtheme_out($out);
