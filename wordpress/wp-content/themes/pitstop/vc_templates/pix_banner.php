<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $section_id
 * Shortcode class
 * @var $this WPBakeryShortCode_Pix_Banner
 */
$banner_id = $height = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$pix_banner_class = 'pix_banner_' . rand();
$height = is_numeric($height) ? $height.'px' : '100%';
$pix_banner_style = 'jQuery("head").append("<style> .pix-promo-item.'.esc_attr($pix_banner_class).'{height:'.esc_attr($height).'}</style>");';
wp_add_inline_script( 'pixtheme-common', $pix_banner_style );

$countdown = pixtheme_countdown('', get_post_meta( $banner_id, 'pix-banner-countdown', true )) != '' ? '<span class="pix-countdown" data-countdown="'.pixtheme_countdown('', get_post_meta( $banner_id, 'pix-banner-countdown', true )).'">00:00:00</span>' : '';
$out = '
<div class="pix-promo-item '.esc_attr($pix_banner_class).' '.get_post_meta( $banner_id, 'pix-banner-color', true ).'">
    <div class="pix-promo-item-bg">
        <img src="'.esc_url(get_the_post_thumbnail_url($banner_id, 'large')).'" alt="'.esc_attr__('Promo', 'pitstop').'">
    </div>
    <div class="pix-promo-item-inner">
        <div class="pix-promo-item-time">
            <b>'.wp_kses(get_post_meta( $banner_id, 'pix-banner-subtext', true ), 'post').'</b>
            '.$countdown.'
        </div>
        <div class="pix-promo-item-title">'.wp_kses(get_post_meta( $banner_id, 'pix-banner-title', true ), 'post').'</div>
    </div>
    <a class="pix-promo-item-link" href="'.esc_url(get_post_meta( $banner_id, 'pix-banner-link', true )).'"></a>
</div>';

pixtheme_out($out);
