<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $count
 * @var $cats
 * @var $carousel
 * @var $controls
 * @var $min_slides
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Woocommerce
 */

$args = array();
$swiper_arr = $carousel_arr = array();
$out = $style = $select_type = $title = $bg_color = $navigation = $css_animation = $animate = $animate_data = $banner_out = $filter_class = $labels = $nav_out = $nav_header_out = '';
$banner_id = $banner_id_2 = 0;
$banner_position = 'right';
$show_quick_view = $show_wishlist = $show_compare = $show_quantity = 'on';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$carousel_arr = pixtheme_vc_get_params_array($atts, 'slider');
$swiper_arr = pixtheme_vc_get_params_array($atts, 'swiper');
extract( $atts );

$style = $style != '' ? $style : 'pix-product';
$style_wrapper = $style == 'pix-product-long' ? 'pix-products-long' : '';

$swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
$data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
$cols = isset($swiper_options_arr['slidesPerView']) != '' ? $swiper_options_arr['slidesPerView'] : 3;
$swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($cols);
$product_class = pixtheme_get_setting('pix-woo-hover-buttons', 'on') == 'off' ? 'pix-buttons-always-show' : '';

$page_enable = isset($swiper_options_arr['pagination']) && !$swiper_options_arr['pagination'] ? 'disabled' : '';

$labels_default = [
    'popular' => esc_html__('Best Sellers', 'pitstop'),
    'sale' => esc_html__('Sales', 'pitstop'),
    'featured' => esc_html__('Featured', 'pitstop'),
    'new' => esc_html__('New Products', 'pitstop'),
];
$labels_arr = $labels == '' ? [] : explode(',', $labels);

$out = '
<section class="row pix-slider ' . esc_attr($style) . '-container">';


if($select_type != 'ids'){
	$cats_arr = explode(',', $cats);
	
	if(isset($labels_arr[0]) && $labels_arr[0] == 'sale'){
        $args = array(
            'no_found_rows'     => 1,
            'post_status'       => 'publish',
            'post_type'         => 'product',
            'meta_query'        => WC()->query->get_meta_query(),
            'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() ),
        );
    } elseif(isset($labels_arr[0]) && $labels_arr[0] == 'featured'){
        $args = array(
            'post_status'       => 'publish',
            'post_type'         => 'product',
            'orderby'           => 'date',
            'order'             => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                ),
            )
        );
    } elseif(isset($labels_arr[0]) && $labels_arr[0] == 'new'){
        $args = array(
            'post_status'       => 'publish',
            'post_type'         => 'product',
            'orderby'           => 'date',
            'order'             => 'DESC',
        );
    } else {
        $args = array(
            'post_type' => 'product',
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
        );
    }
	
	$args['tax_query'][] = [
        'taxonomy' => 'product_visibility',
        'field'    => 'name',
        'terms'    => 'exclude-from-catalog',
        'operator' => 'NOT IN',
    ];
	if( !empty($cats) ){
	    $args['tax_query'][] = [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $cats_arr,
        ];
    }
	
	if( is_numeric($count) ) {
        $args['showposts'] = $count;
    } else {
        $args['posts_per_page'] = -1;
    }
} else {
    $args = array(
        'post_type' => 'product',
        'post__in' => $items,
        'orderby' => 'post__in',
        'posts_per_page' => -1
    );
}

if($banner_id > 0 || $banner_id_2 > 0){
    
    $banner_1_out = $banner_2_out = '';
    
    if($banner_id > 0){
        $countdown = pixtheme_countdown('', get_post_meta( $banner_id, 'pix-banner-countdown', true )) != '' ? '<span class="pix-countdown" data-countdown="'.pixtheme_countdown('', get_post_meta( $banner_id, 'pix-banner-countdown', true )).'">00:00:00</span>' : '';
        $banner_1_out = '
                <div class="pix-promo-item '.get_post_meta( $banner_id, 'pix-banner-color', true ).'">
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
    }
    if($banner_id_2 > 0){
        $countdown = pixtheme_countdown('', get_post_meta( $banner_id_2, 'pix-banner-countdown', true )) != '' ? '<span class="pix-countdown" data-countdown="'.pixtheme_countdown('', get_post_meta( $banner_id_2, 'pix-banner-countdown', true )).'">00:00:00</span>' : '';
        $banner_2_out = '
                <div class="pix-promo-item '.get_post_meta( $banner_id, 'pix-banner-color', true ).'">
                	<div class="pix-promo-item-bg">
                		<img src="'.esc_url(get_the_post_thumbnail_url($banner_id_2, 'large')).'" alt="'.esc_attr__('Promo', 'pitstop').'">
					</div>
                    <div class="pix-promo-item-inner">
                        <div class="pix-promo-item-time">
                            <b>'.wp_kses(get_post_meta( $banner_id_2, 'pix-banner-subtext', true ), 'post').'</b>
                            '.$countdown.'
                        </div>
                        <div class="pix-promo-item-title">'.wp_kses(get_post_meta( $banner_id_2, 'pix-banner-title', true ), 'post').'</div>
                    </div>
                    <a class="pix-promo-item-link" href="'.esc_url(get_post_meta( $banner_id_2, 'pix-banner-link', true )).'"></a>
                </div>';
    }
    
    $style_wrapper .= ' col-xx-10 col-lg-9 col-md-8 col-sm-12 pl-0 pr-0';
    
    $banner_out = '
        <div class="pix-promo col-xx-2 col-lg-3 col-md-4 col-sm-12 pl-0 pr-0">
            <div class="pix-promo-items pix__autoParts2Banners">
                '.$banner_1_out.$banner_2_out.'
            </div>
        </div>';
} else {
    $style_wrapper .= ' col-12 pl-0 pr-0';
}

$wp_query = new WP_Query( $args );

if ($wp_query->have_posts()) {
	
    if($navigation != 'no') {
        $filter_labels = '';
        $filter_class = 'pix-filter';
        foreach ( $labels_default as $label => $name ) {
            $active = $label == 'popular' ? 'active' : '';
            if( empty($labels_arr) || (count($labels_arr) > 1 && in_array($label, $labels_arr)) ) {
                $filter_labels .= '<a href="#" class="item ' . esc_attr($active) . '" data-ajax-filter="' . esc_attr($label) . '">' . $name . '</a>';
            }
        }
        if($navigation == 'top-left') {
        	$nav_header_out = '
        	            <div class="pix-nav ' . esc_attr($navigation) . '">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>';
        } else {
        	$nav_out = '
        	            <div class="pix-nav ' . esc_attr($navigation) . '">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>';
        }
        $out .= '
    <div class="pix-slider-header ' . esc_attr($bg_color) . '">
        <div class="container-fluid">
            <div class="row align-items-center mr-0 ml-0">
                <div class="col-lg-5 pl-0">
                    <div class="d-flex align-items-center">
                        <div class="pix-section-title">
                            <h2 class="pix-title h3-size">' . ($title) . '</h2>
                        </div>
                        '.wp_kses($nav_header_out, 'post').'
                    </div>
                </div>
                <div class="col-lg-7 pr-0">
                    <div class="pix-slider-filter mt-40 mt-lg-0 justify-content-start justify-content-lg-end">
                        ' . ($filter_labels) . '
                    </div>
                </div>
            </div>
        </div>
    </div>';
    }
    
    
    $out .= '
    <div class="row pr-0 pl-0">';
    if($banner_position == 'left'){
        $out .= $banner_out;
    }
    $out .= '
	    <div class="pix-slider-container '.esc_attr($style_wrapper).'">
	        <div class="pix-slider-items '.esc_attr($swiper_class).' '.esc_attr($filter_class).' '.esc_attr($product_class).'" '.($data_swiper).' data-style="'.esc_attr($style).'" data-cnt="'.esc_attr($count).'" data-cats="'.esc_attr($cats).'">
	            <div class="swiper-wrapper">';

    $i = $offset = 0;
    global $yith_woocompare;
    $products_compare_list = class_exists( 'YITH_Woocompare' ) ? $yith_woocompare->obj->products_list : [];
    while ($wp_query->have_posts()) :
        $wp_query->the_post();
        global $product;
        
        $cats = wp_get_object_terms(get_the_ID(), 'product_cat');
        $cat_titles_str = $cat_titles_span = '';
        $cat_titles = $cat_slugs = array();
        if ( ! empty($cats) ) {
            foreach ( $cats as $cat ) {
                $cat_titles[] .= '<a href="'.get_term_link($cat).'" class="pix-product-category">'.$cat->name.'</a>';
                $cat_titles_span .= '<span>'.$cat->name.'</span>';
                
                $cat_slugs[] = $cat->slug;
            }
            $cat_titles_str = end( $cat_titles);
        }
        
        $sale = $sale_class = '';
        if ( $product->is_on_sale() ) {
            $percent = '';
            if($product->get_regular_price()>0){
                $percent = round(100 - $product->get_sale_price() / ( $product->get_regular_price()/100 ), 0 );
            }
            $sale_class = $style == 'pix-product-long' ? 'pix-product-long-badge' : 'pix-product-info-badge';
            $sale = '<div class="' . esc_attr($sale_class) . '">-'.esc_attr($percent).'%</div>';
            $sale_class = 'pix-sale';
        }
        $compare = '';
        if(in_array(get_the_ID(), $products_compare_list)){
            $compare = 'remove';
        }
        
        $link = get_the_permalink($product->get_id());
        $thumbnail = get_the_post_thumbnail(get_the_ID(), 'shop_catalog', array('class' => 'active'));
        $out_image = $image = '';
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
                <a href="' . esc_url($link) . '">
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
            <a href="' . esc_url($link) . '">
                ' . $thumbnail . '
            </a>';
        }
        
        $stock   = $product->get_stock_quantity();
        $rating  = $product->get_average_rating();
        $count   = $product->get_rating_count();
        $review_count = $product->get_review_count();
        
        if($count > 0){
            $rating_html = wc_get_rating_html( $rating, $count );
        } else {
            $rating_html = '<div class="star-rating"></div>';
        }
        
        $quick_view = $show_quick_view != 'off' ? '
        <a class="pix__quickView pix-tooltip-show" href="#" data-fancybox="quick-view" data-product-id="'.esc_attr($product->get_id()).'">
            <i class="pix-flaticon-magnifying-glass"></i>
            '.pixtheme_tooltip(esc_html__('Quick view', 'pitstop')).'
        </a>' : '';
        $wishlist = $show_wishlist != 'off' && class_exists( 'YITH_WCWL' ) ? do_shortcode('[yith_wcwl_add_to_wishlist]') : '';
        $compare = $show_compare != 'off' && class_exists( 'YITH_Woocompare' ) ? '
        <a href="#" class="pix-compare-btn pix-tooltip-show '.esc_attr($compare).'" data-product_id="'.esc_attr($product->get_id()).'">
            <i class="pix-flaticon-statistics"></i>
            '.pixtheme_tooltip(esc_html__('Compare', 'pitstop')).'
        </a>' : '';
        $quantity_input = $show_quantity != 'off' ? '<input type="number" min="1" value="1">' : '';
        
        
        if($css_animation != '') {
            $animate = 'animated';
            $animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
            $animate_data .= ' data-animation="'.esc_attr($css_animation).'"';
            $wow_group = !empty($wow_group) ? $wow_group : 1;
            $wow_group_delay = !empty($wow_group_delay) ? $wow_group_delay : 0;
            $animate_data .= !empty($wow_duration) ? ' data-wow-duration="'.esc_attr($wow_duration).'s"' : '';
            $animate_data .= !empty($wow_delay) ? ' data-wow-delay="'.esc_attr($wow_delay + $offset * $wow_group_delay).'s"' : '';
            $animate_data .= !empty($wow_offset) ? ' data-wow-offset="'.esc_attr($wow_offset).'"' : '';
            $animate_data .= !empty($wow_iteration) ? ' data-wow-iteration="'.esc_attr($wow_iteration).'"' : '';

            $offset = $i % $wow_group == 0 ? ++$offset : $offset;
        }
        
        if($style == 'pix-product-long') {
            
            $sales_price_from = get_post_meta( $product->get_id(), '_sale_price_dates_from', true );
            $sales_price_to   = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
            $countdown = pixtheme_countdown($sales_price_from, $sales_price_to, false) == '' ? '' : '
            <div class="pix-product-long-end">
                <b>'.esc_html__('Ends in:', 'pitstop').'</b><span class="pix-countdown" data-countdown="'.pixtheme_countdown($sales_price_from, $sales_price_to, false).'">00:00:00</span>
            </div>';
            $countdown = $countdown == '' && $product->get_stock_quantity() != '' ? '
            <div class="pix-product-long-end">
                <b>'.esc_html__('Left in Stock:', 'pitstop').'</b><span class="pix-countdown">'.$product->get_stock_quantity().'</span>
            </div>' : $countdown;
            
            $out .= '
            <div class="swiper-slide ' . esc_attr(implode(' ', $cat_slugs)) . '">
	            <div class="pix-slider-item ' . esc_attr($style) . '">
	                <div class="pix-product-long-inner">
	                    <div>
	                        <div class="pix-product-long-img">
	                            <div class="pix-product-slider">
                                    ' . $out_image . '
	                                ' . ($sale) . '
	                            </div>
	                        </div>
	                    </div>
	                    <div>
	                        <div class="pix-product-long-info">
	                            ' . ($cat_titles_str) . '
	                            <div class="h6"><a href="' . esc_url($link) . '" title="' . get_the_title($product->get_id()) . '">' . get_the_title($product->get_id()) . '</a></div>
	                            ' . pixtheme_limit_words(get_the_excerpt(get_the_ID()), 18, 'p') . '
	                            '.$countdown.'
	                        </div>
	                        <div class="pix-product-rc">
	                            '.$rating_html.'
	                            <div class="pix-product-long-coast '.esc_attr($sale_class).'">
	                                ' . ($product->get_price_html()) . '
	                            </div>
	                        </div>
	                        <div class="pix-product-icons">
	                            '.$quick_view.'
	                            '.$wishlist.'
	                            '.$compare.'
	                            '.$quantity_input;
	                        $out .= apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="pix-tooltip-show ajax_add_to_cart %s product_type_%s"><i class="pix-flaticon-shopping-bag-3"></i>'.pixtheme_tooltip(esc_html__('Add to cart', 'pitstop')).'</a>', esc_url($product->add_to_cart_url()), esc_attr($product->get_id()), esc_attr($product->get_sku()), esc_attr(isset($quantity) ? $quantity : 1), $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '', esc_attr($product->get_type())), $product);
	                        $out .= '
	                        </div>
	                    </div>
	                </div>
	            </div>
            </div>';
        } else {
            $out .= '
            <div class="swiper-slide">
	            <div class="pix-slider-item ' . esc_attr($style) . '">
	                <div class="pix-product-inner">
	                    <div class="pix-product-info">
	                        <div>
	                            ' . ($cat_titles_str) . '
	                            ' . ($sale) . '
	                        </div>
	                        <div class="h6"><a href="' . esc_url($link) . '" title="' . get_the_title($product->get_id()) . '">' . (get_the_title($product->get_id())) . '</a></div>
	                    </div>
	                    <div class="pix-product-img">
                            ' . $out_image . '
	                    </div>
	                    <div class="pix-product-rc">
	                        '.$rating_html.'
	                        <div class="pix-product-coast '.esc_attr($sale_class).'">
	                            ' . ($product->get_price_html()) . '
	                        </div>
	                    </div>
	                    <div class="pix-product-icons">
                            '.$quick_view.'
                            '.$wishlist.'
                            '.$compare.'
                            '.$quantity_input;
	                        $out .= apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="pix-tooltip-show ajax_add_to_cart %s product_type_%s"><i class="pix-flaticon-shopping-bag-3"></i>'.pixtheme_tooltip(esc_html__('Add to cart', 'pitstop')).'</a>',
	                            esc_url($product->add_to_cart_url()),
	                            esc_attr($product->get_id()),
	                            esc_attr($product->get_sku()),
	                            esc_attr(isset($quantity) ? $quantity : 1),
	                            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
	                            esc_attr($product->get_type())), $product);
	                        $out .= '
	                    </div>
	                </div>
	            </div>
            </div>';
        }
    
    endwhile;
    
    $out .= '
				</div>
	        </div>
	    </div>';
    if($banner_position == 'right'){
        $out .= $banner_out;
    }
    $out .= '
		'.wp_kses($nav_out, 'post').'
    </div>';
}

wp_reset_postdata();

$out .= '
    <div class="pix-swiper-pagination swiper-pagination pix-slider-items-paging '.esc_attr($page_enable).'"></div>
</section>';


pixtheme_out($out);