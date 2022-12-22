<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $section_id
 * Shortcode class
 * @var $this WPBakeryShortCode_Pix_Section
 */
$section_id = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

pixtheme_get_staticblock_content($section_id);
