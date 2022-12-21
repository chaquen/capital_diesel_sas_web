<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $reviews_per_page
 * @var $disable_carousel
 * @var $skin
 * @var $autoplay
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Reviews
 */
$swiper_arr = $shadows_arr = array();
$color = 'pix-main-color';
$title_size = 'pix-title-l';
$is_animate = $css_animation = $animate = $animate_data = $nav_class = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$swiper_arr = pixtheme_vc_get_params_array($atts, 'swiper');
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );

$style = !isset($style) || $style == '' ? 'pix-testimonials' : $style;
$shadow_class = pixtheme_get_shadow($shadows_arr);

$image_size = array(200, 200);
if( pixtheme_retina() ){
    $image_size = array(400, 400);
}


$reviews = vc_param_group_parse_atts( $atts['reviews'] );
$reviews_out = array();
$count = 1;
$cnt = count($reviews);
$i = $offset = 0;
foreach($reviews as $key => $item){

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

    $class = $count == 1 ? 'active' : '';

    $href = isset($item['link']) ? vc_build_link( $item['link'] ) : '';
    $blank = empty($href['target']) ? '_self' : $href['target'];
    $href = empty($href['url']) ? '#' : $href['url'];


    if( isset($item['image']) && $item['image'] != ''){
        $img = wp_get_attachment_image_src( $item['image'], $image_size );
        $img_output = isset($img[0]) ? $img[0] : '';
        $image = $style == 'news-card-profile' ? '<img src="'.esc_url($img_output).'" alt="'.esc_attr($item['name']).'">' : '<div class="'.esc_attr($style).'__image"><img src="'.esc_url($img_output).'" alt="'.esc_attr($item['name']).'"></div>';
    }
    $position = isset($item['position']) && $item['position'] != '' ? $item['position'] : '';
    $facebook = isset($item['facebook']) && $item['facebook'] != '' ? '<a href="'.esc_url($item['facebook']).'" class="pix-socials"><i class="fab fa-facebook"></i></a>' : '';
    $twitter = isset($item['twitter']) && $item['twitter'] != '' ? '<a href="'.esc_url($item['twitter']).'" class="pix-socials"><i class="fab fa-twitter"></i></a>' : '';
    $instagram = isset($item['instagram']) && $item['instagram'] != '' ? '<a href="'.esc_url($item['instagram']).'" class="pix-socials"><i class="fab fa-instagram"></i></a>' : '';

    if ($style == 'news-card-people') {
        $reviews_out[] = '
            <div class="pix-equal-height pix-animation-container swiper-slide '.esc_attr($animate).'" '.($animate_data).'>
                <div class="news-card-people '.esc_attr($shadow_class).'">
                    <div class="pix-overlay '.esc_attr($color).'"></div>
                    '.($image).'
                    <div class="pix-block-content">    
                        <div class="pix-block-title '.esc_attr($title_size).'">'.($item['name']).' <span>'.($position).'</span></div>
                        <p>'.($item['content_d']).'</p>
                        '.($facebook).'
                        '.($twitter).'
                        '.($instagram).'
                    </div>
                </div>
            </div>
        ';
    } elseif ($style == 'pix-testimonials-people') {
        $reviews_out[] = '
            <div class="pix-animation-container swiper-slide '.esc_attr($animate).'" '.($animate_data).'>
                <div class="pix-testimonials-people news-card-people '.esc_attr($shadow_class).'">
                    '.($image).'
                    <div class="pix-block-content">
                        <div class="pix-block-title '.esc_attr($title_size).'">'.($item['name']).' <span>'.($position).'</span></div>
                        <p>'.($item['content_d']).'</p>
                        '.($facebook).'
                        '.($twitter).'
                        '.($instagram).'
                    </div>
                </div>
            </div>
        ';
    } elseif ($style == 'news-card-profile') {
        $reviews_out[] = '
            <div class="pix-animation-container swiper-slide '.esc_attr($animate).'" '.($animate_data).'>
                <div class="news-card-profile">
                    <div class="news-card-profile__header">
                        '.($image).'
                    </div>
                    <div class="pix-block-content">
                        <div class="pix-overlay '.esc_attr($color).'"></div>
                        <div class="news-card-profile__text '.esc_attr($shadow_class).'">
                            <h5><a target="'.esc_attr($blank).'" href="'.esc_url($href).'">'.($item['name']).'</a>'.pixtheme_echo_if_not_empty('<span>'.($position).'</span>', $position).'</h5>
                            <p>'.($item['content_d']).'</p>
                            <div class="news-card-profile__header-social">
                                '.($facebook).'
                                '.($twitter).'
                                '.($instagram).'
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
    } elseif ($style == 'news-card-message') {
        $reviews_out[] = '
            <div class="pix-animation-container swiper-slide '.esc_attr($animate).'" '.($animate_data).'>
                <div class="news-card-message">
                    <div class="news-card-message__text '.esc_attr($shadow_class).'">
                        <div class="pix-block-title '.esc_attr($title_size).'">'.($item['name']).'<span>'.($position).'</span></div>
                        <p>'.($item['content_d']).'</p>
                        <div class="pix-border-shadow-overlay"></div>
                    </div>
                    '.($image).'
                </div>
            </div>
        ';
    } elseif ($style == 'news-card-feedback') {
        $reviews_out[] = '
            <div class="news-card-feedback__user swiper-slide '.esc_attr($class).' '.esc_attr($animate).'" '.($animate_data).'>
                '.($image).'
                <div class="pix-block-title '.esc_attr($title_size).'">'.($item['name']).' <span>'.($position).'</span></div>
                <p>'.($item['content_d']).'</p>
                '.($facebook).'
                '.($twitter).'
                '.($instagram).'
            </div>
        ';
    } else {
        $class_red = $count % 2 == 0 ? 'pix-red-box' : '';
        $class_hover = isset($hover) ? $hover : 'pix-change-color';
        $reviews_out[] = '
            <div class="pix-testimonial swiper-slide '.esc_attr($class_hover).' '.esc_attr($class).' '.esc_attr($animate).'" '.($animate_data).'>
                <div class="pix-testimonial-img">
                    '.($image).'
                </div>
                <div class="pix-testimonial-job '.esc_attr($class_red).'">
                    <span>'.($position).'</span>
                </div>
                <div class="pix-testimonial-info">
                    <div class="pix-testimonial-name '.esc_attr($title_size).'">'.($item['name']).'</div>
                    <div class="pix-testimonial-text">
                        <p>'.($item['content_d']).'</p>
                    </div>
                </div>
            </div>
        ';
    }

    $count ++;
}


$swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
$data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
$nav_enable = isset($swiper_options_arr['navigation']) && !$swiper_options_arr['navigation'] ? 'disabled' : '';
$page_enable = isset($swiper_options_arr['pagination']) && !$swiper_options_arr['pagination'] ? 'disabled' : '';
$cols = isset($swiper_options_arr['slidesPerView']) != '' ? $swiper_options_arr['slidesPerView'] : 3;
$swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($cols);


if($style == 'news-card-feedback'){
    $out = '
    <div class="pix-swiper col-md-10 col-offset-1 offset-md-1 news-card-feedback-container '.esc_attr($radius).'">
        <div class="news-card-feedback '.esc_attr($swiper_class).' '.esc_attr($shadow_class).'" '.($data_swiper).'>
            <div class="feedback__users swiper-wrapper '.esc_attr($nav_enable).'">
                '.implode( "\n", $reviews_out ).'
            </div>
            <div class="pix-nav side-right vertical '.esc_attr($page_enable).'">
		        <div class="swiper-button-prev"></div>
		        <div class="swiper-button-next"></div>
		    </div>
        </div>
    </div>';
} else {
    $out = '
    <div class="pix-swiper">
	    <div class="'.esc_attr($style).'__carousel '.esc_attr($swiper_class).' '.esc_attr($nav_class).' '.esc_attr($radius).' " '.($data_swiper).'>
			<div class="swiper-wrapper">
	            '.implode( "\n", $reviews_out ).'
			</div>
	    </div>
	    <div class="pix-nav left-right '.esc_attr($style).'-nav '.esc_attr($nav_enable).'">
	        <div class="swiper-button-prev"></div>
	        <div class="swiper-button-next"></div>
	    </div>
	    <div class="pix-swiper-pagination swiper-pagination '.esc_attr($style).'-paging '.esc_attr($page_enable).'"></div>
    </div>';
}


pixtheme_out($out);
