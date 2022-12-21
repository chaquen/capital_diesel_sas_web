<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Wrapper
 */
$position = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$out = '
<div class="pix-wrap '.esc_attr($position).'">

    '.do_shortcode($content).'

</div>';


pixtheme_out($out);
