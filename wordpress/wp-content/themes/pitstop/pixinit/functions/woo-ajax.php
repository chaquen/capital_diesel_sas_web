<?php

/********** WOOCOMERCE AJAX **********/

/// Mini Cart

add_action('wp_footer','pixtheme_jquery_add_to_cart_script');
function pixtheme_jquery_add_to_cart_script(){
    if ( class_exists('WooCommerce') ): // Only for archives pages
        ?>
            <script type="text/javascript">
                // Ready state
                (function($){

                    $( document.body ).on( 'added_to_cart', function(){
                        if( $('#cart').hasClass('empty') ){
                            $('#cart').removeClass('empty');
                        }
                    });
                    
                    $( document.body ).on( 'removed_from_cart', function(){
                        console.log('cart is updated');
                    });

                })(jQuery); // "jQuery" Working with WP (added the $ alias as argument)
            </script>
        <?php
    endif;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'pixtheme_header_cart_badge_fragment' );
function pixtheme_header_cart_badge_fragment( $fragments ) {
    ob_start();
    ?>
    <span class="pix-cart badge"><?php echo WC()->cart->cart_contents_count; ?></span>
    <?php

    $fragments['span.pix-cart.badge'] = ob_get_clean();

    return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'pixtheme_header_cart_fragment' );
function pixtheme_header_cart_fragment( $fragments ) {
    ob_start();
    ?>
    <div class="pix-header-cart">
    <?php
        $items = WC()->cart->get_cart();
        if( count($items) > 0 ) :
    ?>
            <div class="pix-ajax-loader"><div class="loading"></div></div>
            <div class="pix-header-cart-header">
                <span><?php esc_html_e('Products in cart', 'pitstop'); ?></span>
                <b><?php echo WC()->cart->cart_contents_count; ?></b>
            </div>
            <div class="pix-header-cart-products pix-scrollbar">
                <div class="pix-header-cart-products-inner">
                    <ul>
    <?php
            foreach ($items as $key => $val) :
                $_product = wc_get_product($val['product_id']);
                $subtotal = WC()->cart->get_product_subtotal($_product, $val['quantity']);
    ?>
                        <li class="pix-header-cart-product">
                            <a href="<?php echo get_the_permalink($val['product_id']); ?>">
                                <?php echo wp_kses($_product->get_image(array(70,70)), 'post'); ?>
                            </a>
                            <div class="pix-header-cart-product-info">
                                <a href="<?php echo get_the_permalink($val['product_id']); ?>">
                                    <?php echo get_the_title($val['product_id']); ?>
                                </a>
                                <div class="form-group mb-0">
                                    <input type="number" min="1" data-val="<?php echo esc_attr($val['quantity']); ?>" value="<?php echo esc_attr($val['quantity']); ?>">
                                    <a href="#" class="pix-cart-apply hide" data-cart-id="<?php echo esc_attr($key); ?>"><i class="fas fa-check"></i></a>
                                    <a href="#" class="pix-cart-delete" data-cart-id="<?php echo esc_attr($key); ?>"><i class="fas fa-times"></i></a>
                                    <?php echo wp_kses($subtotal, 'post'); ?>
                                </div>
                            </div>
                        </li>
                        
    <?php   endforeach; ?>
    
                    </ul>
                </div>
            </div>
            <div class="pix-header-cart_subtotal">
                <span><?php esc_html_e('Subtotal:', 'pitstop'); ?></span>
                <span><?php echo WC()->cart->get_cart_total(); ?></span>
            </div>
            <div class="pix-header-cart_controls">
                <a class="btn pix-button pix-v-s" href="<?php echo wc_get_cart_url(); ?>"><?php esc_html_e('view cart', 'pitstop'); ?></a>
                <span></span>
                <a class="btn pix-button pix-v-s pix-dark" href="<?php echo wc_get_checkout_url(); ?>"><?php esc_html_e('checkout', 'pitstop'); ?></a>
            </div>
    <?php else : ?>
        <span class="pix-empty-cart">
            <?php esc_html_e('The cart is empty!', 'pitstop') ?>
        </span>
    <?php endif; ?>
    
    </div>
    
    <?php

    $fragments['div.pix-header-cart'] = ob_get_clean();

    return $fragments;
}


add_action('wp_ajax_pixtheme_cart_change', 'pixtheme_cart_change');
add_action('wp_ajax_nopriv_pixtheme_cart_change', 'pixtheme_cart_change');
function pixtheme_cart_change() {
    
    $data = array_map( 'esc_attr', $_POST );
    
    check_ajax_referer( 'pix_cart_nonce', 'cart_nonce' );
    
    if( true ){
        
        if(isset($data['cart_id']) && $data['cart_id'] != '' && isset($data['qnt'])){
            if($data['qnt'] == '0') {
                WC()->cart->remove_cart_item($data['cart_id']);
            } else {
                WC()->cart->set_quantity($data['cart_id'], $data['qnt']);
            }
        }
        
        $pix_out = '';
        $items = WC()->cart->get_cart();
        
        if( count($items) > 0 ) {
            $pix_out = '
        <div class="pix-ajax-loader"><div class="loading"></div></div>
        <div class="pix-header-cart-header">
            <span>'.esc_html__('Products in cart', 'pitstop').'</span>
            <b>'.WC()->cart->cart_contents_count.'</b>
        </div>
        <div class="pix-header-cart-products pix-scrollbar">
            <div class="pix-header-cart-products-inner">
                <ul data-count="'.esc_attr(WC()->cart->cart_contents_count).'">';
            foreach ($items as $key => $val) {
                $_product = wc_get_product($val['product_id']);
                $subtotal = WC()->cart->get_product_subtotal($_product, $val['quantity']);
                $pix_out .= '
                    <li class="pix-header-cart-product">
                        <a href="'.get_the_permalink($val['product_id']).'">
                            '.wp_kses($_product->get_image(array(70,70)), 'post').'
                        </a>
                        <div class="pix-header-cart-product-info">
                            <a href="'.get_the_permalink($val['product_id']).'">
                                '.get_the_title($val['product_id']).'
                            </a>
                            <div class="form-group mb-0">
                                <input type="number" min="1" data-val="'.esc_attr($val['quantity']).'" value="'.esc_attr($val['quantity']).'">
                                <a href="#" class="pix-cart-apply hide" data-cart-id="'.esc_attr($key).'"><i class="fas fa-check"></i></a>
                                <a href="#" class="pix-cart-delete" data-cart-id="'.esc_attr($key).'"><i class="fas fa-times"></i></a>
                                '.wp_kses($subtotal, 'post').'
                            </div>
                        </div>
                    </li>';
            }
            $pix_out .= '
                </ul>
            </div>
        </div>
        <div class="pix-header-cart_subtotal">
            <span>'.esc_html__('Subtotal:', 'pitstop').'</span>
            <span>'.WC()->cart->get_cart_total().'</span>
        </div>
        <div class="pix-header-cart_controls">
            <a class="btn pix-button pix-v-s" href="'.wc_get_cart_url().'">'.esc_html__('view cart', 'pitstop').'</a>
            <span></span>
            <a class="btn pix-button pix-v-s pix-dark" href="'.wc_get_checkout_url().'">'.esc_html__('checkout', 'pitstop').'</a>
        </div>';
        }

        wp_send_json_success($pix_out);

    } else {
        wp_send_json_error();
    }
}


add_action('wp_ajax_pixtheme_slider_filter', 'pixtheme_slider_filter_change');
add_action('wp_ajax_nopriv_pixtheme_slider_filter', 'pixtheme_slider_filter_change');
function pixtheme_slider_filter_change(){
    
    $data = array_map( 'esc_attr', $_POST );
    
    check_ajax_referer( 'pix_slider_nonce', 'slider_nonce' );
    
    if( true ){
        $cnt = isset($data['cnt']) ? $data['cnt'] : 12;
        if($data['label'] == 'sale'){
            $args = array(
                'posts_per_page'    => $cnt,
                'no_found_rows'     => 1,
                'post_status'       => 'publish',
                'post_type'         => 'product',
                'meta_query'        => WC()->query->get_meta_query(),
                'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() ),
            );
        } elseif($data['label'] == 'featured'){
            $args = array(
                'posts_per_page'    => $cnt,
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
        } elseif($data['label'] == 'new'){
            $args = array(
                'posts_per_page'    => $cnt,
                'post_status'       => 'publish',
                'post_type'         => 'product',
                'orderby'           => 'date',
                'order'             => 'DESC',
            );
        } else {
            $args = array(
                'posts_per_page'    => $cnt,
                'post_type' => 'product',
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
            );
        }
        
        $cats_arr = isset($data['cats']) && $data['cats'] != '' ? explode(',', $data['cats']) : [];
        $args['tax_query'][] = [
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'exclude-from-catalog',
            'operator' => 'NOT IN',
        ];
        if( isset($data['cats']) && $data['cats'] != '' ){
            $args['tax_query'][] = [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $cats_arr,
            ];
        }
        
        $pix_out = '';
        $wp_query = new WP_Query( $args );
        
        if ($wp_query->have_posts()) {
        
            $i = $offset = 0;
            global $yith_woocompare;
            $products_compare_list = $yith_woocompare->obj->products_list;
            $pix_out = '<div class="swiper-wrapper">';
            
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
            
            $sale = '';
            if ( $product->is_on_sale() ) {
                $percent = '';
                if($product->get_regular_price()>0){
                    $percent = round(100 - $product->get_sale_price() / ( $product->get_regular_price()/100 ), 0 );
                }
                $sale_class = $data['style'] == 'pix-product-long' ? 'pix-product-long-badge' : 'pix-product-info-badge';
                $sale = '<div class="' . esc_attr($sale_class) . '">-'.esc_attr($percent).'%</div>';
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
            
            if($data['style'] == 'pix-product-long') {
                $sales_price_from = get_post_meta( $product->get_id(), '_sale_price_dates_from', true );
                $sales_price_to   = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
                $countdown = pixtheme_countdown($sales_price_from, $sales_price_to, false) == '' ? '' : '
                <div class="pix-product-long-end">
                    <b>'.esc_html__('Ends in:', 'pitstop').'</b><span class="pix-countdown" data-countdown="'.pixtheme_countdown($sales_price_from, $sales_price_to, false).'">00:00:00</span>
                </div>';
                
                $pix_out .= '
                <div class="swiper-slide ' . esc_attr(implode(' ', $cat_slugs)) . '">
                <div class="pix-slider-item ' . esc_attr($data['style']) . '">
                    <div class="pix-product-long-inner">
                        <div>
                            <div class="pix-product-long-img">
                                <div class="pix-product-slider">
                                    <a href="' . esc_url($link) . '">
                                        ' . $out_image . '
                                    </a>
                                    ' . ($sale) . '
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="pix-product-long-info">
                                ' . ($cat_titles_str) . '
                                <div class="h5"><a href="' . esc_url($link) . '">' . get_the_title($product->get_id()) . '</a></div>
                                ' . pixtheme_limit_words(get_the_excerpt(get_the_ID()), 15, 'p') . '
                                '.$countdown.'
                            </div>
                            <div class="pix-product-rc">
                                '.$rating_html.'
                                <div class="pix-product-long-coast">
                                    ' . ($product->get_price_html()) . '
                                </div>
                            </div>
                            <div class="pix-product-icons">
                                <a class="pix__quickView pix-tooltip-show" href="#" data-fancybox="quick-view" data-product-id="'.esc_attr($product->get_id()).'">
                                    <i class="pix-flaticon-magnifying-glass"></i>
                                    '.pixtheme_tooltip(esc_html__('Quick view', 'pitstop')).'
                                </a>
                                '.do_shortcode('[yith_wcwl_add_to_wishlist]').'
                                <a href="#" class="pix-compare-btn pix-tooltip-show '.esc_attr($compare).'" data-product_id="'.esc_attr($product->get_id()).'">
                                    <i class="pix-flaticon-statistics"></i>
                                    '.pixtheme_tooltip(esc_html__('Compare', 'pitstop')).'
                                </a>
                                <input type="number" min="1" value="1">';
                            $pix_out .= apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="pix-tooltip-show ajax_add_to_cart %s product_type_%s"><i class="pix-flaticon-shopping-bag-3"></i>'.pixtheme_tooltip(esc_html__('Add to cart', 'pitstop')).'</a>', esc_url($product->add_to_cart_url()), esc_attr($product->get_id()), esc_attr($product->get_sku()), esc_attr(isset($quantity) ? $quantity : 1), $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '', esc_attr($product->get_type())), $product);
                            $pix_out .= '
                            </div>
                        </div>
                    </div>
                </div>
                </div>';
            } else {
                $pix_out .= '
                    <div class="swiper-slide ' . esc_attr(implode(' ', $cat_slugs)) . '">
                    <div class="pix-slider-item pix-product">
                        <div class="pix-product-inner">
                            <div class="pix-product-info">
                                <div>
                                    ' . ($cat_titles_str) . '
                                    ' . ($sale) . '
                                </div>
                                <div class="h6"><a href="' . esc_url($link) . '">' . (get_the_title($product->get_id())) . '</a></div>
                            </div>
                            <div class="pix-product-img">
                                ' . $out_image . '
                            </div>
                            <div class="pix-product-rc">
                                '.$rating_html.'
                                <div class="pix-product-coast">
                                    ' . ($product->get_price_html()) . '
                                </div>
                            </div>
                            <div class="pix-product-icons">
                                <a class="pix__quickView pix-tooltip-show" href="#" data-fancybox="quick-view" data-product-id="'.esc_attr($product->get_id()).'">
                                    <i class="pix-flaticon-magnifying-glass"></i>
                                    '.pixtheme_tooltip(esc_html__('Quick view', 'pitstop')).'
                                </a>
                                '.do_shortcode('[yith_wcwl_add_to_wishlist]').'
                                <a href="#" class="pix-compare-btn pix-tooltip-show '.esc_attr($compare).'" data-product_id="'.esc_attr($product->get_id()).'" >
                                    <i class="pix-flaticon-statistics"></i>
                                    '.pixtheme_tooltip(esc_html__('Compare', 'pitstop')).'
                                </a>
                                
                                <input type="number" min="1" value="1">';
                                $pix_out .= apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="pix-tooltip-show ajax_add_to_cart %s product_type_%s"><i class="pix-flaticon-shopping-bag-3"></i>'.pixtheme_tooltip(esc_html__('Add to cart', 'pitstop')).'</a>',
                                    esc_url($product->add_to_cart_url()),
                                    esc_attr($product->get_id()),
                                    esc_attr($product->get_sku()),
                                    esc_attr(isset($quantity) ? $quantity : 1),
                                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                    esc_attr($product->get_type())), $product);
                                $pix_out .= '
                            </div>
                        </div>
                    </div>
                    </div>';
            }
            endwhile;
            
            $pix_out .= '</div>';
        }

        wp_send_json_success($pix_out);

    } else {
        wp_send_json_error();
    }
}