<?php

/********** WOOCOMERCE **********/

/// Catalog

remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

add_action('pix_woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
add_action('pix_woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action('pix_woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 45);

/// Catalog Product

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);



add_filter( 'woocommerce_show_page_title' , 'pixtheme_woo_hide_page_title' );
function pixtheme_woo_hide_page_title() {
	return false;
}

add_filter('woocommerce_product_description_heading', '__return_empty_string');
add_filter('woocommerce_product_additional_information_heading', '__return_empty_string');
add_filter( 'yith_woocompare_compare_added_label', '__return_empty_string' );
add_filter( 'yith_wcwl_remove_from_wishlist_label', '__return_empty_string' );
add_filter( 'yith_wcwl_add_to_wishlist_icon_html', 'pix_wishlist_change_icon', 2 );
function pix_wishlist_change_icon($atts){
    if ( !isset($atts['exists']) || $atts['exists'] ) {
        $icon_html = '<i class="yith-wcwl-icon pix-flaticon-like"></i>';
    }
    return $icon_html;
}


add_action('pix_woocommerce_before_shop_loop', 'pix_header_wrap_start', 0);
function pix_header_wrap_start() {
	echo '<div class="pix-content-header">';
};
add_action('pix_woocommerce_before_shop_loop', 'pix_header_shop_title', 15);
function pix_header_shop_title() {
    $tab_position = pixtheme_get_option('tab_position', '');
	$tab_hide = pixtheme_get_option('tab_hide', '');
	
	$title_class = '';
	if( $tab_position != 'left_right' && $tab_position != 'right_left' ){
		$title_class = $breadcrumbs_class = 'text-'.$tab_position;
	}
	
	if(
	    $tab_hide != 'hide'
        && $tab_hide != 'hide_title'
        && ( pixtheme_get_option('tab_breadcrumbs_v_position', '') == 'over'
            && (is_shop()
                || is_product_category()
                || is_product_tag()
                )
            )
    ){
	   echo '<div class="pix-header-title '.esc_attr($title_class).'">
	            <h1 class="pix-h1-h6 h3-size">
	                '.woocommerce_page_title(false).'
	            </h1>
            </div>';
    }
};
add_action('pix_woocommerce_before_shop_loop', 'pix_header_wrap_end', 40);
function pix_header_wrap_end() {
	echo '</div>';
};
add_action('pix_woocommerce_before_shop_loop', 'pix_filter_select', 50);
function pix_filter_select() {
	if(is_shop() || is_product_category() || is_product_tag()){
	   echo '<div class="pix-filter-selected"></div>';
    }
};


add_action( 'woocommerce_before_shop_loop_item_title', 'pixtheme_woo_shop_loop_item_info_open', 3);
function pixtheme_woo_shop_loop_item_info_open() {
    $cats = wp_get_object_terms(get_the_ID(), 'product_cat');
    $cat_titles = array();
    $cat_titles_str = '';
    if ( ! empty($cats) ) {
        foreach ( $cats as $cat ) {
            $cat_titles[] = '<a href="'.get_term_link($cat).'" class="pix-product-category">'.$cat->name.'</a>';
        }
        $cat_titles_str = end( $cat_titles);
    }
    echo '
        <div class="pix-product-info">
            <div>
                '.wp_kses($cat_titles_str, 'post');
};
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 5);
add_action( 'woocommerce_before_shop_loop_item_title', 'pixtheme_woo_shop_loop_item_info_close', 7);
function pixtheme_woo_shop_loop_item_info_close() {
    global $product;
    $attributes = $product->get_attributes();
    $attr_out = '';
    if ( $attributes ) {
        $attr_out = '<ul class="pix-product_attr">';
        foreach ($attributes as $attr => $val) {
            $label = wc_attribute_label($attr);
            if ( isset( $attributes[ $attr ] ) || isset( $attributes[ 'pa_' . $attr ] ) ) {
                $attribute = isset( $attributes[ $attr ] ) ? $attributes[ $attr ] : $attributes[ 'pa_' . $attr ];
                if ( $attribute['is_taxonomy'] ) {
                    $attr_out .= '<li><label>'.$label.':</label> <span>'.implode( ', ', wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'names' ) ) ).'</span></li>';
                } else {
                    $attr_out .= '<li><label>'.$label.':</label> <span>'.$attribute['value'].'</span></li>';
                }
            }
        }
        $attr_out .= '</ul>';
    }
    echo '
            </div>
            <div class="h6"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></div>
            <p class="product-description">' . pixtheme_limit_words(get_the_excerpt(get_the_ID()), 15, '') . '</p>
        </div>
        <div class="pix-product-attr-container">'.wp_kses($attr_out, 'post').'</div>';
};
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
function woocommerce_template_loop_product_thumbnail() {
    global $product;
    $image = $out_image = '';
    $thumbnail = get_the_post_thumbnail($product->get_id(), 'shop_catalog', array('class' => 'active'));
    if(pixtheme_get_setting('pix-woo-hover-slider', 'off') == 'on' ) {
        $attach_ids = $product->get_gallery_image_ids();
        $attachment_count = count($product->get_gallery_image_ids());
        if ($attachment_count > 0) {
            $image_link = wp_get_attachment_url($attach_ids[0]);
            $default_attr = array('class' => "slider_img", 'alt' => get_the_title($product->get_id()),);
            $image = wp_get_attachment_image($attach_ids[0], 'shop_catalog', false, $default_attr);
        }
        $out_image = '
        <div class="pix-product-slider">
            <a href="'.get_the_permalink().'">
                <span class="pix-product-slider-box">
                    ' . $thumbnail . '
                    ' . $image . '
                </span>
                <span class="pix-product-slider-hover"></span>
                <span class="pix-product-slider-dots"></span>
            </a>
        </div>';
    } else {
        $out_image = '
        <a href="'.get_the_permalink().'">
            ' . $thumbnail . '
        </a>';
    }
	echo '
        <div class="pix-product-img">
            ' . $out_image . '
        </div>';
};

add_action( 'woocommerce_after_shop_loop_item', 'pixtheme_woo_shop_loop_item_icons_open', 5);
function pixtheme_woo_shop_loop_item_icons_open() {
    global $product, $yith_woocompare;
    $products_compare_list = class_exists( 'YITH_Woocompare' ) ? $yith_woocompare->obj->products_list : [];
    $compare_remove = '';
    if(in_array($product->get_id(), $products_compare_list)){
        $compare_remove = 'remove';
    }
    
    $quick_view = class_exists( 'PixThemeSettings' ) ? '<a class="pix__quickView pix-tooltip-show" href="#" data-fancybox="quick-view" data-product-id="'.esc_attr($product->get_id()).'" ><i class="pix-flaticon-magnifying-glass"></i>'.pixtheme_tooltip(esc_html__('Quick view', 'pitstop')).'</a>' : '';
    $wishlist = class_exists( 'YITH_WCWL' ) ? do_shortcode('[yith_wcwl_add_to_wishlist]') : '';
    $compare = class_exists( 'YITH_Woocompare' ) ? '<a href="#" class="pix-compare-btn pix-tooltip-show '.esc_attr($compare_remove).'" data-product_id="'.esc_attr($product->get_id()).'" ><i class="pix-flaticon-statistics"></i>'.pixtheme_tooltip(esc_html__('Compare', 'pitstop')).'</a>' : '';
    
    echo '
        <div class="pix-product-icons">
            '.wp_kses($quick_view.$wishlist.$compare, 'post').'
            <input type="number" min="1" value="1">';
};
add_action( 'woocommerce_after_shop_loop_item', 'pixtheme_woo_shop_loop_item_icons_close', 20);
function pixtheme_woo_shop_loop_item_icons_close() {
	echo '</div>';
};

add_action( 'woocommerce_after_shop_loop_item_title', 'pixtheme_woo_shop_loop_item_price', 3);
function pixtheme_woo_shop_loop_item_price() {
    global $product;
    $stock   = $product->get_stock_quantity();
    $rating  = $product->get_average_rating();
    $count   = $product->get_rating_count();
    $rating_html = $count > 0 ? wc_get_rating_html( $rating, $count ) : '<div class="star-rating"></div>';
    
	echo '<div class="pix-product-rc">'.wp_kses($rating_html, 'post');
};

add_action( 'woocommerce_after_shop_loop_item_title', 'pixtheme_woo_shop_loop_item_price_close', 20);
function pixtheme_woo_shop_loop_item_price_close() {
	echo '</div>';
};


add_filter( 'loop_shop_per_page', function( $cols ){ return pixtheme_get_option('pitstop_products_per_page','15'); }, 20 );


add_filter('loop_shop_columns', 'pixtheme_loop_columns');
if (!function_exists('pixtheme_loop_columns')) {
	function pixtheme_loop_columns() {
		return 3; // 3 products per row
	}
}

add_filter( 'woocommerce_add_to_cart_fragments', 'pixtheme_cart_count_fragments', 10, 1 );
function pixtheme_cart_count_fragments( $fragments ) {

    $icon = '<i class="pix-flaticon-shopping-bag-3"></i>';
    $fragments['div.pix-cart-items'] = '<div class="pix-cart-items">'.($icon).'<span class="pix-cart-count">'.WC()->cart->cart_contents_count.'</span></div>';

    return $fragments;

}

add_filter( 'woocommerce_variable_sale_price_html', 'pixtheme_variable_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'pixtheme_variable_price_format', 10, 2 );
function pixtheme_variable_price_format( $price, $product ) {

    $prefix = sprintf('<span class="pix-from-price">%s</span>', __('from', 'pitstop'));

    $min_price_regular = $product->get_variation_regular_price( 'min', true );
    $min_price_sale    = $product->get_variation_sale_price( 'min', true );
    $max_price = $product->get_variation_price( 'max', true );
    $min_price = $product->get_variation_price( 'min', true );
    
    $price = ( $min_price_sale == $min_price_regular ) ? wc_price( $min_price_regular ) : '<del>' . wc_price( $min_price_regular ) . '</del>' . '<ins>' . wc_price( $min_price_sale ) . '</ins>';

    return ( $min_price == $max_price ) ? $price : sprintf('%s%s', $prefix, $price);

}

add_filter( 'woocommerce_breadcrumb_defaults', 'pixtheme_woocommerce_breadcrumbs' );
function pixtheme_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => '&nbsp;&nbsp;<i class="pix-flaticon-arrow-angle-pointing-to-right"></i>&nbsp;&nbsp;',
        'wrap_before' => '<div class="pix-breadcrumbs-path">',
        'wrap_after'  => '</div>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Home', 'breadcrumb', 'pitstop' ),
    );
}

function pixtheme_woo_get_page_id(){
    global $post;

    if( is_shop() || is_product_category() || is_product_tag() )
        $id = get_option( 'woocommerce_shop_page_id' );
    elseif( is_product() || !empty($post->ID) )
        $id = $post->ID;
    else
        $id = 0;
    return $id;
}

function pixtheme_is_woo_page () {
    if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
        return true;
    }
    $woocommerce_keys   =   array (
        'woocommerce_shop_page_id' ,
        'woocommerce_terms_page_id' ,
        'woocommerce_cart_page_id' ,
        'woocommerce_checkout_page_id' ,
        'woocommerce_pay_page_id' ,
        'woocommerce_thanks_page_id' ,
        'woocommerce_myaccount_page_id' ,
        'woocommerce_edit_address_page_id' ,
        'woocommerce_view_order_page_id' ,
        'woocommerce_change_password_page_id' ,
        'woocommerce_logout_page_id' ,
        'woocommerce_lost_password_page_id'
    );
    foreach ( $woocommerce_keys as $wc_page_id ) {
        if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
            return true;
        }
    }
    return false;
}

