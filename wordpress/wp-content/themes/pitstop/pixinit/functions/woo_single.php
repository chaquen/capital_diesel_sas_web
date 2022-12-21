<?php

/********** WOOCOMERCE **********/

/// Single Product

//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action('woocommerce_single_product_summary', 'woocommerce_single_product_summary_col_1', 1);
//add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 25);
add_action('woocommerce_single_product_summary', 'woocommerce_single_product_summary_col_2', 51);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_params', 53);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price_meta', 54);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price_custom', 55);
//add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 55);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 57);
add_action('woocommerce_single_product_summary', 'woocommerce_single_product_summary_col_end', 59);


/// Single Tabs UpSell Related

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

add_action('pix_woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
add_action('pix_woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
add_action('pix_woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);




/// Single Product

add_action('woocommerce_before_single_product_summary', 'pixtheme_single_product_wrapper_begin', 1);
function pixtheme_single_product_wrapper_begin() {
	echo '<div class="row mr-0 ml-0">';
};
add_action('woocommerce_before_single_product_summary', 'pixtheme_single_product_img_wrapper_begin', 3);
function pixtheme_single_product_img_wrapper_begin() {
	$pix_layout = pixtheme_get_layout(get_post_type(), get_the_ID());
	$class = isset($pix_layout['layout']) && $pix_layout['layout'] == 2 ? 'col-xx-5 col-xl-6 col-lg-7' : 'col-xx-6 col-xl-5 col-lg-4';
	echo '    <div class="'.esc_attr($class).'">
                  <div class="pix-single-img-wrapper">';
};
add_action('woocommerce_before_single_product_summary', 'pixtheme_single_product_img_wrapper_end', 30);
function pixtheme_single_product_img_wrapper_end() {
	$pix_layout = pixtheme_get_layout(get_post_type(), get_the_ID());
	$class = isset($pix_layout['layout']) && $pix_layout['layout'] == 2 ? 'col-xx-7 col-xl-6 col-lg-5' : 'col-xx-6 col-xl-7 col-lg-8';
	echo '        </div>
              </div>
              <div class="'.esc_attr($class).'">';
};

function woocommerce_single_product_summary_col_1() {
	echo '		<div class="pix-col-info">';
};
function woocommerce_single_product_summary_col_2() {
    global $product;
    $availability = $product->get_availability();
    $class = ! empty( $availability['availability'] ) ? 'available' : '';
	echo '		</div>
				<div class="pix-col-info">
					<div class="pix-col-info-block pix-single-product-price-panel product_meta '.esc_attr($class).'">';
};
function woocommerce_template_single_params() {
	global $product;
    $attributes = $product->get_attributes();
    $attr_out = '';
    if ( $attributes ) {
        $attr_out = '<ul class="pix-single-product_attr">';
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
	
};

function woocommerce_template_single_price_meta() {
	global $product, $yith_woocompare;
	$products_compare_list = class_exists( 'YITH_Woocompare' ) ? $yith_woocompare->obj->products_list : [];
	$compare_remove = $wishlist_compare = '';
    if(in_array(get_the_ID(), $products_compare_list)){
        $compare_remove = 'remove';
    }
    
    $wishlist = class_exists( 'YITH_WCWL' ) ? do_shortcode('[yith_wcwl_add_to_wishlist]') : '';
    $compare = class_exists( 'YITH_Woocompare' ) ? '<a href="#" class="pix-compare-btn pix-tooltip-show '.esc_attr($compare_remove).'" data-product_id="'.esc_attr($product->get_id()).'"><i class="pix-flaticon-statistics"></i>'.pixtheme_tooltip(esc_html__('Compare', 'pitstop')).'</a>' : '';
	
	$wishlist_compare = $wishlist != '' || $compare != '' ? '
	            <div class="wish-compare">
					'.$wishlist.$compare.'
                </div>' : '';
	
	$stock = $product->get_stock_quantity();
	$availability = $product->get_availability();
	if ( ! empty( $availability['availability'] ) ) {
		echo '<div>
				<span class="stock '.esc_attr( $availability['class'] ).'">'.wp_kses( $availability['availability'], 'post' ).'</span>
				'.wp_kses($wishlist_compare, 'post').'
			  </div>';
	}
 
	if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
		$sku = $product->get_sku() != '' ? $product->get_sku() : esc_html__( 'N/A', 'pitstop' );
		echo '<div class="sku_wrapper">
				<label>'.esc_html__( 'SKU', 'pitstop' ).'</label>
				<span class="sku">'.wp_kses($sku, 'post').'</span>
			  </div>';
	}
	
    $rating  = $product->get_average_rating();
    $count   = $product->get_rating_count();
    $review_count = $product->get_review_count();
    
    if($count > 0){
        $rating_html = wc_get_rating_html( $rating, $count );
    } else {
        $rating_html = '<div class="star-rating"></div>';
    }
    if ( comments_open() ) {
		$rating_html =	'<div class="pix-rating-container">'.$rating_html.'<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<span class="count">' . esc_html( $review_count ) . '</span>)</a></div>';
	}
    
    echo '<div><label>'.esc_html__( 'Rating', 'pitstop' ).'</label>'.wp_kses($rating_html, 'post').'</div>';
	
};

function woocommerce_template_single_price_custom() {
	global $product;
    
    echo '<p class="'.esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ).'">
			<label>'.esc_html__( 'Price', 'pitstop' ).'</label>
			'.$product->get_price_html().'
		  </p>';
	
};

function woocommerce_single_product_summary_col_end() {
	echo    '
		        	</div>';
	
	if ( is_active_sidebar( 'product-price-sidebar' ) ) {
	    echo '<div class="pix-col-info-block pix-price-sidebar">';
        dynamic_sidebar( 'product-price-sidebar' );
        echo '</div>';
    }
    
	echo '		</div>';
};

add_action('woocommerce_after_single_product_summary', 'pixtheme_single_product_wrapper_end', 50);
function pixtheme_single_product_wrapper_end() {
	echo '    </div>
          </div>';
};


add_action('pix_woocommerce_after_single_product_summary', 'pixtheme_after_single_product_summary_wrapper_begin', 1);
function pixtheme_after_single_product_summary_wrapper_begin() {
	echo '<div class="row mr-0 ml-0 product">';
};
add_action('pix_woocommerce_after_single_product_summary', 'pixtheme_after_single_product_summary_wrapper_end', 40);
function pixtheme_after_single_product_summary_wrapper_end() {
	echo '</div>';
};


add_filter( 'woocommerce_output_related_products_args', 'pixtheme_related_products_args' );
function pixtheme_related_products_args( $args ) {
	$args['posts_per_page'] = 5; // 3 related products
	$args['columns'] = 5; // arranged in 3 columns
	return $args;
}
