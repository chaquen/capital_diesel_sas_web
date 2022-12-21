<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Team
 */
$swiper_arr = $shadows_arr = array();
$is_animate = $css_animation = $animate = $animate_data = '';
$title_size = 'pix-title-l';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$swiper_arr = pixtheme_vc_get_params_array($atts, 'swiper');
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );

$style = !isset($style) || $style == '' ? 'pix-team-long' : $style;
$shadow_class = pixtheme_get_shadow($shadows_arr);

$image_size = array(350, 350);
if( pixtheme_retina() ){
    $image_size = array(700, 700);
}

$members = vc_param_group_parse_atts( $atts['members'] );
$members_out = array();
$count = 1;
$cnt = count($members);
$i = $offset = 0;
foreach($members as $key => $item){
    $image = '';

    $href = isset($item['link']) ? vc_build_link( $item['link'] ) : '';
    $blank = empty($href['target']) ? '_self' : $href['target'];
    $href = empty($href['url']) ? '#' : $href['url'];

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

    if( isset($item['image']) && $item['image'] != ''){
        $img = wp_get_attachment_image_src( $item['image'], $image_size );
        $img_output = $img[0];
        $image =  '<img src="'.esc_url($img_output).'" alt="'.esc_attr($item['name']).'">';
    }
    $social_class =
    $position = isset($item['position']) && $item['position'] != '' ? $item['position'] : '';
    $phone = isset($item['phone']) && $item['phone'] != '' ? '<a href="tel:'.esc_attr($item['phone']).'" title="'.esc_attr($item['phone']).'"><i class="icon-phone"></i></a>' : '';
    $email = isset($item['email']) && $item['email'] != '' ? '<a href="mailto:'.esc_attr($item['email']).'" title="'.esc_attr($item['email']).'"><i class="icon-envelope"></i></a>' : '';
    $skype = isset($item['skype']) && $item['skype'] != '' ? '<a href="'.esc_url($item['skype']).'"><i class="icon-social-skype"></i></a>' : '';
    $facebook = isset($item['facebook']) && $item['facebook'] != '' ? '<a href="'.esc_url($item['facebook']).'"><i class="icon-social-facebook"></i></a>' : '';
    $twitter = isset($item['twitter']) && $item['twitter'] != '' ? '<a href="'.esc_url($item['twitter']).'"><i class="icon-social-twitter"></i></a>' : '';
    $instagram = isset($item['instagram']) && $item['instagram'] != '' ? '<a href="'.esc_url($item['instagram']).'"><i class="icon-social-instagram"></i></a>' : '';
    $linkedin = isset($item['linkedin']) && $item['linkedin'] != '' ? '<a href="'.esc_url($item['linkedin']).'"><i class="icon-social-linkedin"></i></a>' : '';
    
    $desc = isset($item['desc']) ? $item['desc'] : '';
    
    
    if($style == 'pix-team-square') {
        $class_red = $count % 2 == 0 ? 'pix-red-box' : '';
        $members_out[] = '
        <div class="pix-team-item swiper-slide ' . esc_attr($animate) . '" ' . ($animate_data) . '>
            <div class="pix-team-item-img">
                ' . wp_kses($image, 'post') . '
            </div>
            <div class="pix-team-item-bottom ' . esc_attr($class_red) . '">
                <div class="pix-team-item-info">
                    <div class="pix-team-item-name">' . wp_kses($item['name'], 'post') . '</div>
                    <div class="pix-team-item-job">' . wp_kses($position, 'post') . '</div>
                </div>
                <div class="pix-team-item-social">
                    ' . wp_kses($phone, 'post') . '
                    ' . wp_kses($email, 'post') . '
                    ' . wp_kses($skype, 'post') . '
                    ' . wp_kses($facebook, 'post') . '
                    ' . wp_kses($twitter, 'post') . '
                    ' . wp_kses($instagram, 'post') . '
                    ' . wp_kses($linkedin, 'post') . '
                </div>
            </div>
        </div>';
    } else {
        $phone = isset($item['phone']) && $item['phone'] != '' ? '<a class="btn btn-danger btn-sm btn-round" href="tel:'.esc_attr($item['phone']).'" title="'.esc_attr($item['phone']).'"><i class="fa fa-phone-alt"></i><span class="d-none d-xx-inline"> '.esc_html__('call', 'pitstop').'</span></a>' : '';
        $email = isset($item['email']) && $item['email'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="mailto:'.esc_attr($item['email']).'" title="'.esc_attr($item['email']).'"><i class="fa fa-envelope"></i></a>' : '';
        $skype = isset($item['skype']) && $item['skype'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($item['skype']).'"><i class="fab fa-skype"></i></a>' : '';
        $facebook = isset($item['facebook']) && $item['facebook'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($item['facebook']).'"><i class="fab fa-facebook-f"></i></a>' : '';
        $twitter = isset($item['twitter']) && $item['twitter'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($item['twitter']).'"><i class="fab fa-twitter"></i></a>' : '';
        $instagram = isset($item['instagram']) && $item['instagram'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($item['instagram']).'"><i class="fab fa-instagram"></i></a>' : '';
        $linkedin = isset($item['linkedin']) && $item['linkedin'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($item['linkedin']).'"><i class="fab fa-linkedin"></i></a>' : '';
        
        $members_out[] = '
        <div class="pix__teamItem swiper-slide">
              <div class="pix__teamItemInner">
                <div class="pix__teamItemImg">
                  <div class="pix__teamItemImgInner">' . wp_kses($image, 'post') . '</div>
                </div>
                <div class="pix__teamItemInfo">
                  <div class="pix__teamItemName">
                  		<div class="'.esc_attr($title_size).'">' . wp_kses($item['name'], 'post') . '</div>
                  		<span>' . wp_kses($position, 'post') . '</span>
                  </div>
                  <div class="pix__teamItemText pix-text-overflow">
                  	' . wp_kses($desc, 'post') . '
                  </div>
                  <div class="pix__teamItemContacts">
                    ' . wp_kses($phone, 'post') . '
                    ' . wp_kses($email, 'post') . '
                    ' . wp_kses($skype, 'post') . '
                    ' . wp_kses($facebook, 'post') . '
                    ' . wp_kses($twitter, 'post') . '
                    ' . wp_kses($instagram, 'post') . '
                    ' . wp_kses($linkedin, 'post') . '
                  </div>
                </div>
              </div>
            </div>';
    }

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
	<div class="pix-team-slider pix__teamList '.($swiper_class).' '.esc_attr($radius).' " '.($data_swiper).'>
		<div class="swiper-wrapper">
	    	'.implode( "\n", $members_out ).'
		</div>
	</div>
	<div class="pix-nav left-right pix-team-slider-nav '.esc_attr($nav_enable).'">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <div class="pix-swiper-pagination swiper-pagination pix-team-slider-paging '.esc_attr($page_enable).'"></div>
</div>';


pixtheme_out($out);
