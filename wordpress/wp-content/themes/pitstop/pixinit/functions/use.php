<?php

function pixtheme_use_section() {
    return class_exists( 'Pix_Section' );
}

function pixtheme_use_woo() {
    return class_exists( 'WooCommerce' );
}

function pixtheme_use_wishlist() {
    return class_exists( 'YITH_WCWL' );
}

function pixtheme_use_compare() {
    return class_exists( 'YITH_Woocompare' );
}

function pixtheme_use_settings() {
    return class_exists( 'PixThemeSettings' );
}
