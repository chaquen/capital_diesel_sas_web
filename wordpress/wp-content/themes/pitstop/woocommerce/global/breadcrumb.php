<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	echo wp_kses($wrap_before, 'post');

	foreach ( $breadcrumb as $key => $crumb ) {

		echo wp_kses($before, 'post');

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== ($key + 1) ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} elseif(pixtheme_get_option('tab_breadcrumbs_current', 0)) {
		    if ( sizeof( $breadcrumb ) == 2 ) {
                echo wp_kses($delimiter, 'post');
            }
			echo esc_html( $crumb[0] );
		} else {
		    echo '';
        }

		echo wp_kses($after, 'post');
  
		if ( sizeof( $breadcrumb ) > $key + 2 ) {
			echo wp_kses($delimiter, 'post');
		}
	}

	echo wp_kses($wrap_after, 'post');

}
