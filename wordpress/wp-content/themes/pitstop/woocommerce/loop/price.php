<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$sale_class = $group_class = '';
if ( $product->is_on_sale() ) {
    $sale_class = 'pix-sale';
}
if ( $product->is_type( 'grouped' ) ) {
    $group_class = 'pix-grouped-product';
}
?>

<?php if ( $price_html = $product->get_price_html() ) : ?>
	<div class="pix-product-coast <?php echo esc_attr($sale_class); ?> <?php echo esc_attr($group_class); ?>"><?php echo wp_kses($price_html, 'post'); ?></div>
<?php endif; ?>
