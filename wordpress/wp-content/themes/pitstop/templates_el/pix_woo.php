<?php

namespace Elementor;

class PixTheme_EL_Pix_Woo extends Widget_Base {
	
	public function get_name() {
		return 'pix-woo';
	}
	
	public function get_title() {
		return 'Woocommerce Products';
	}
	
	public function get_icon() {
		return 'fas fa-archive';
	}
	
	public function get_categories() {
		return [ 'pixtheme' ];
	}
	
	protected function _register_controls() {
		
		$cats_woo = pixtheme_el_taxonomies('product_cat');
		
		$pix_banners = get_posts(['post_type' => 'pix-banner', 'posts_per_page' => -1]);
		$banners = [0 => esc_html__('No Banner', 'pitstop')];
		if(empty($pix_banners['errors'])){
			foreach($pix_banners as $banner){
				$banners[$banner->ID] = $banner->post_title;
			}
		}
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'pitstop' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'style',
			[
				'label' => esc_html__( 'Style', 'pitstop' ),
				'type' => 'radio_images',
                'default' => 'pix-product',
				'options' => [
					'pix-product' => 'woo_product.png',
                    'pix-product-long' => 'woo_product-long.png',
				]
			]
		);
		$this->add_control(
			'select_type',
			[
                'label' => esc_html__( 'Products by', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default'    =>  esc_html__( 'Label', 'pitstop' ),
					'ids'    =>  esc_html__( 'IDs', 'pitstop' ),
                ],
            ]
		);
		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'IDs', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Input products ID. example: 307,304,302,301,300', 'pitstop' ),
                'condition' => [
                    'select_type' => 'ids',
                ]
			]
		);
		$this->add_control(
			'labels',
			[
				'label' => esc_html__( 'Labels', 'pitstop' ),
				'type' => Controls_Manager::SELECT2,
                'description' => esc_html__( 'Select product labels to show', 'pitstop' ),
				'multiple' => true,
                'options' => [
                    'popular'   =>  esc_html__( 'Best Sellers', 'pitstop' ),
					'sale'      =>  esc_html__( 'Sales', 'pitstop' ),
	                'featured'  =>  esc_html__( 'Featured', 'pitstop' ),
					'new'       =>  esc_html__( 'New', 'pitstop' ),
                ],
				'default' => ['popular', 'sale', 'featured', 'new'],
                'condition' => [
                    'select_type' => 'default',
                ]
			]
		);
		$this->add_control(
			'cats',
			[
				'label' => esc_html__( 'Categories', 'pitstop' ),
				'type' => Controls_Manager::SELECT2,
                'description' => esc_html__( 'Select categories to show', 'pitstop' ),
				'multiple' => true,
				'options' => $cats_woo['options'],
				'default' => $cats_woo['default'],
                'condition' => [
                    'select_type' => 'default',
                ]
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'bg_color',
			[
                'label' => esc_html__( 'Background', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-white',
                'options' => [
                    'pix-white'    =>  esc_html__( 'White', 'pitstop' ),
					'pix-black'    =>  esc_html__( 'Black', 'pitstop' ),
                ],
            ]
		);
		$this->add_control(
			'navigation',
			[
                'label' => esc_html__( 'Navigation', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'nav',
                'options' => [
                    'nav'   =>  esc_html__( 'Arrows', 'pitstop' ),
					'no'    =>  esc_html__( 'Hide', 'pitstop' ),
                ],
            ]
		);
		$this->add_control(
			'count',
			[
				'label' => esc_html__( 'Items Count', 'pitstop' ),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__( 'Set to 0 to show all', 'pitstop' ),
                'min' => 0,
				'max' => 20,
				'step' => 1,
				'default' => 0,
                'condition' => [
                    'select_type' => 'default',
                ]
			]
		);
		$this->add_control(
			'banner_id',
			[
                'label' => esc_html__( 'Banner', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__( 'Select Banner to show', 'pitstop' ),
                'default' => 0,
                'options' => $banners,
            ]
		);
		$this->add_control(
			'banner_id_2',
			[
                'label' => esc_html__( 'Banner 2', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__( 'Select second Banner to show', 'pitstop' ),
                'default' => 0,
                'options' => $banners,
            ]
		);
		$this->add_control(
			'banner_position',
			[
                'label' => esc_html__( 'Banner Position', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left'   =>  esc_html__( 'Left', 'pitstop' ),
					'right'  =>  esc_html__( 'Right', 'pitstop' ),
                ],
            ]
		);
		$this->end_controls_section();
		
		
		$this->start_controls_section(
            'carousel_section',
            [
                'label' => esc_html__( 'Carousel', 'pitstop' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->end_controls_section();
        
	}
	
	protected function render() {

        $pix_el = $this->get_settings_for_display();
        
        $cats = $pix_el['cats'];
        $count = $pix_el['count'];
        
		$swiper_arr = pixtheme_vc_get_params_array($pix_el, 'swiper');
		
		$swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
		$data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
		$cols = isset($swiper_options_arr['slidesPerView']) != '' ? $swiper_options_arr['slidesPerView'] : 3;
		$swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($cols);
		$product_class = pixtheme_get_setting('pix-woo-hover-buttons', 'on') == 'off' ? 'pix-buttons-always-show' : '';
		
		
		$select_type = $pix_el['select_type'];
		$title = $pix_el['title'];
		$bg_color = $pix_el['bg_color'];
		$navigation = $pix_el['navigation'];
		$banner_out = $filter_class = '';
		$labels_arr = $pix_el['labels'];
		$banner_id = $pix_el['banner_id'];
		$banner_id_2 = $pix_el['banner_id_2'];
		$banner_position = $pix_el['banner_position'];
		
		$style = !isset($pix_el['style']) || $pix_el['style'] == '' ? 'pix-product' : $pix_el['style'];
		$style_wrapper = $style == 'pix-product-long' ? 'pix-products-long' : '';
		
		$labels_default = [
		    'popular' => esc_html__('Best Sellers', 'pitstop'),
		    'sale' => esc_html__('Sales', 'pitstop'),
		    'featured' => esc_html__('Featured', 'pitstop'),
		    'new' => esc_html__('New Products', 'pitstop'),
		];
		
		$out = '
		<section class="row pix-slider ' . esc_attr($style) . '-container">';
		
		
		if($select_type != 'ids'){
			$cats_arr = $cats;
			
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
		
		$wp_query = new \WP_Query( $args );
		
		if ($wp_query->have_posts()) {
		    
		    if($navigation == 'nav') {
		        $filter_labels = '';
		        $filter_class = 'pix-filter';
		        foreach ( $labels_default as $label => $name ) {
		            $active = $label == 'popular' ? 'active' : '';
		            if( empty($labels_arr) || (count($labels_arr) > 1 && in_array($label, $labels_arr)) ) {
		                $filter_labels .= '<a href="#" class="item ' . esc_attr($active) . '" data-ajax-filter="' . esc_attr($label) . '">' . $name . '</a>';
		            }
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
		                        <div class="pix-nav top-left">
		                            <div class="swiper-button-prev"></div>
		                            <div class="swiper-button-next"></div>
		                        </div>
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
			        <div class="pix-slider-items '.esc_attr($swiper_class).' '.esc_attr($filter_class).' '.esc_attr($product_class).'" '.($data_swiper).' data-style="'.esc_attr($style).'" data-cnt="'.esc_attr($count).'">
			            <div class="swiper-wrapper">';
		
		    $i = $offset = 0;
		    global $yith_woocompare;
		    $products_compare_list = isset($yith_woocompare->obj->products_list) ? $yith_woocompare->obj->products_list : [];
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
		        
		        $quick_view = $wishlist = $compare = '';
		        
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
		    </div>';
		}
		
		wp_reset_postdata();
		
		$out .= '
		    <div class="swiper-pagination"></div>
		</section>';
		
		
		pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}