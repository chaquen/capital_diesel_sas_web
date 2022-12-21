<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Brands
 */
$css_animation = $title = $popup = $greyscale = '';
$navigation = 'side-left';
$swiper_arr = $carousel_arr = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$swiper_arr = pixtheme_vc_get_params_array($atts, 'swiper');
//$carousel_arr = pixtheme_vc_get_params_array($atts, 'slider');
extract( $atts );

$brands_per_page = is_numeric($brands_per_page) ? $brands_per_page : 5;
$gallery_class = $popup == 'on' ? 'pix-popup-gallery' : '';
$greyscale = ($greyscale == 'off') ? '' : 'pix-img-greyscale';

$image_size = array(150, 150);
if( pixtheme_retina() ){
    $image_size = array(300, 300);
}

$animate = '';
if($css_animation != '') {
	$animate = 'class="';
	$animate .= 'animated';
	$animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
	$animate .= '"';
	$animate .= ' data-animation="'.esc_attr($css_animation).'"';
	$animate .= !empty($wow_duration) ? ' data-wow-duration="'.esc_attr($wow_duration).'s"' : '';
	$animate .= !empty($wow_delay) ? ' data-wow-delay="'.esc_attr($wow_delay).'s"' : '';
	$animate .= !empty($wow_offset) ? ' data-wow-offset="'.esc_attr($wow_offset).'"' : '';
	$animate .= !empty($wow_iteration) ? ' data-wow-iteration="'.esc_attr($wow_iteration).'"' : '';
}

$brands = vc_param_group_parse_atts( $atts['brands'] );
$brands_out = array();
foreach($brands as $key => $item){

    $href = isset($item['link']) ? vc_build_link( $item['link'] ) : '';
    $url = empty($href['url']) ? '#' : $href['url'];
    $target = empty($href['target']) ? '' : 'target="'.esc_attr($href['target']).'"';
    if(isset($item['image']) && $item['image'] != ''){
        $img_id = preg_replace( '/[^\d]/', '', $item['image'] );
        $img_path = wp_get_attachment_image_src( $img_id, $image_size );
        $img_full = wp_get_attachment_image_src( $img_id, 'full' );
        $url = $popup == 'on' && isset($img_full[0]) ? $img_full[0] : $url;
        $item_title = isset($item['title']) ? $item['title'] : '';
        if(isset($img_path[0])) {
            $brands_out[] = '
        <div class="pix__clientsItem swiper-slide">
            <a ' . ($target) . ' href="' . esc_url($url) . '"><img class="pix-no-lazy-load" src="' . esc_url($img_path[0]) . '" alt="' . esc_attr($item_title) . '"></a>
        </div>';
        }
    }

}

//$options_arr = pixtheme_get_slider($carousel_arr, '');
//$data_carousel = empty($options_arr) ? '' : 'data-slick-options=\''.json_encode($options_arr).'\'';
//$carousel_class = !empty($options_arr) ? '' : 'disable-owl-carousel pix-col-'.esc_attr($brands_per_page);

$swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
$data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
$nav_enable = $navigation == 'no' || (isset($swiper_options_arr['navigation']) && !$swiper_options_arr['navigation']) ? 'disabled' : '';
$page_enable = isset($swiper_options_arr['pagination']) && !$swiper_options_arr['pagination'] ? 'disabled' : '';
$col = isset($swiper_options_arr['items']) != '' ? $swiper_options_arr['items'] : $brands_per_page;
$swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($col);

$title_out = $title == '' ? '' : '<div class="pix-carousel-title pix-title h3 mt-0 mb-0 pl-0 pr-20">'.($title).'</div>';

$out = '

<div class="pix-images-slider">
    '.wp_kses($title_out, 'post').'
    <div class="pix-nav boxed '.esc_attr($navigation).' '.esc_attr($nav_enable).'">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <div class="pix__clientsList '.esc_attr($gallery_class).' '.esc_attr($swiper_class).' '.esc_attr($greyscale).'" '.($data_swiper).'>
        <div class="swiper-wrapper">
        '.implode( "\n", $brands_out ).'
        </div>
    </div>
    <div class="pix-swiper-pagination swiper-pagination '.esc_attr($page_enable).'"></div>
</div>';

pixtheme_out($out);