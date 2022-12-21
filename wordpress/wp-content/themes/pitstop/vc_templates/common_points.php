<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Price_Table
 */

$out = $unit = $radius = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$unit = $unit == '' ? 'px' : $unit;
$img_id = preg_replace( '/[^\d]/', '', $image );
$img_path = wp_get_attachment_image_src( $img_id, 'large' );
$image = '<img src="'.esc_url($img_path[0]).'" alt="'.esc_attr__('Points', 'pitstop').'">';

$points = vc_param_group_parse_atts( $atts['points'] );
$points_out = array();
foreach($points as $key => $item){

    $points_out[] = '
        <div class="pix-car-repair-point" style="top: '.esc_attr($item['top_pos'].$unit).'; left: '.esc_attr($item['left_pos'].$unit).';">
            <div class="pix-car-repair-point-text">
                <p>'.($item['content_d']).'</p>
            </div>
        </div>
    ';

}


$out = '
<div class="pix-car-repair-box '.esc_attr($radius).'">
    <div class="pix-car-repair-img">
        '.($image).'
    </div>
    <div class="pix-car-repair-points">
        '.implode( "\n", $points_out ).'
    </div>
</div>';


pixtheme_out($out);
