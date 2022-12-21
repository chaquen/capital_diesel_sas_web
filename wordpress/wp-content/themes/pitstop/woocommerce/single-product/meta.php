<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

pixtheme_get_section_content(7119);

echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as"><span>' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'pitstop' ) . '</span> ', '</span>' );

if( shortcode_exists( 'share' ) ) {
    echo '
    <div class="pix-wrap-social-block tagged_in">
        '.do_shortcode('[share title="'.esc_html__('Share:', 'pitstop').'" post_type="product"]').'
    </div>';
}