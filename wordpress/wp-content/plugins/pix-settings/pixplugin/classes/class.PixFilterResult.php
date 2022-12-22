<?php


class Pix_Filter_Result {

	public $per_page;
	
	public $href;

	public $order;

	public $orderby;

	public $metakey;

	protected static $orderby_arr = array('date', 'title');
	/**
	 * Class Constructor
	 * =================
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'init_plugin' ) );
		add_action( 'wp_ajax_pix_quick_view', array( $this, 'pix_quick_view' ) );
        add_action( 'wp_ajax_nopriv_pix_quick_view', array( $this, 'pix_quick_view' ) );
		add_action( 'wp_ajax_pix_search_ajax', array( $this, 'pix_search_ajax' ) );
        add_action( 'wp_ajax_nopriv_pix_search_ajax', array( $this, 'pix_search_ajax' ) );
        add_action( 'wp_ajax_pix_filter', array( $this, 'pix_filter' ) );
        add_action( 'wp_ajax_nopriv_pix_filter', array( $this, 'pix_filter' ) );
	}


	public function init_plugin() {
		global $pix_settings;
		
		$search = $pix_settings->settings->get_setting('pix-woo-select-search') == 'on' ? true : false;
		
        wp_enqueue_script( 'pix-filter', PIX_PLUGIN_URL . '/assets/js/pix-filter.js', array('jquery'), null, true );
        wp_localize_script(
            'pix-filter',
            'pixAjax',
            array(
                'url'   => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'pix_filter_nonce' ),
                'nonce_view' => wp_create_nonce( 'pix_view_nonce' ),
	            'select_search' => $search,
            )
        );
    }
    
    
    public function pix_quick_view() {
	    global $wpdb, $product;
	    
        check_ajax_referer( 'pix_view_nonce', 'nonce_view' );
        
        if( true ){
        
        
//            $sql = $wpdb->prepare("
//                    SELECT      p.*,
//                                MAX(CASE WHEN pm.meta_key = '_sku' then pm.meta_value ELSE NULL END) as sku
//                    FROM        $wpdb->posts p
//                    LEFT JOIN   $wpdb->postmeta pm
//                                ON p.ID = pm.post_id
//                    WHERE       p.ID = %d
//                                AND p.post_type IN ('product', 'product_variation')
//                                AND p.post_status = 'publish'
//                    GROUP BY    p.ID
//                    ORDER BY    p.post_title ASC",
//		                        $product_id);
//
//            $pix_out = '';
//            $pix_result = $wpdb->get_results($sql);

//            $args = array(
//                'post_type' => 'product',
//                'p' => $product_id,
//            );
//            $pix_result = new WP_Query( $args );

//            include( PIX_PLUGIN_DIR . '/pixplugin/templates/pix-quick-view.php' );
//
//            $product = wc_get_product( esc_attr( $_POST['product_id'] ) );
//            ob_start();
//            wc_get_template_part( 'content', 'single-product' );
//            $pix_out = ob_get_contents();
//            ob_end_clean();
//
//			wp_send_json_success($pix_out);


//            $nonce = $_POST['nonce'];
//            if ( ! wp_verify_nonce( $nonce, 'woo_nonce' ) ) {
//                die();
//            }
            WPBMap::addAllMappedShortcodes();
            echo '<div class="pix-popup-wrapper">
                    <div class="single single-product woocommerce woocommerce-page woocommerce-js">';
            // You can remove unwanted in popup preview section by remove_action call
            // remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
            // remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
            // remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
            global $post;
            $post = get_post($_POST['product_id']);
            setup_postdata($post);
            wc_get_template_part( 'content', 'single-product' );
            echo '</div>
                </div>';
            wp_reset_postdata();
            exit;

        } else {
            wp_send_json_error(array('error' => $custom_error));
        }
    }
    
    
    public function pix_search_ajax() {
		global $wpdb, $pix_settings;

	    $search_str = '%'.esc_attr( $_POST['search'] ).'%';
	    
        check_ajax_referer( 'pix_filter_nonce', 'nonce' );
        
        if( true ){
            
            $sql = $wpdb->prepare("
                    SELECT      p.*,
                                MAX(CASE WHEN pm.meta_key = '_sku' then pm.meta_value ELSE NULL END) as sku
                    FROM        $wpdb->posts p
                    LEFT JOIN   $wpdb->postmeta pm
                                ON p.ID = pm.post_id
                    WHERE       ( p.post_title LIKE '%s'
                                  OR p.post_name LIKE '%s'
                                  OR ( pm.meta_key = '_sku' AND pm.meta_value LIKE '%s')
                                )
                                AND p.post_type IN ('product', 'product_variation')
                                AND p.post_status = 'publish'
                    GROUP BY    p.ID
                    ORDER BY    p.post_title ASC",
		                        $search_str, $search_str, $search_str);
            
            $pix_out = '';
            $pix_result = $wpdb->get_results($sql);
            
            include( PIX_PLUGIN_DIR . '/pixplugin/templates/pix-ajax-search-items.php' );

			wp_send_json_success($pix_out);

        } else {
            wp_send_json_error(array('error' => $custom_error));
        }
    }
    
    
    public function pix_filter() {
		global $wpdb, $pix_settings;

	    $data = array_map( 'esc_attr', $_GET );

        check_ajax_referer( 'pix_filter_nonce', 'nonce' );
		$keys = array_keys($data);
        
        if( true && !in_array('make_model', $keys) && !in_array('model_restyle', $keys) && !in_array('restyle_version', $keys) ){
            $args = array();
            $href = 'false';
            $this->href = false;
            foreach($data as $key=>$val){
                if( property_exists('Pix_Filter_Result', $key) && $key == 'per_page' ) {
	                $this->$key = $val;
                } elseif( $key == 'model' && $val != '' ){
	                $args['make'] = $val;
                } elseif( $key == 'href' ){
	                $href = $val;
	                $this->href = true;
                } elseif(  !in_array($key, ['url', 'action', 'nonce', 'step', 'next_id', 'next_type', 'step_order']) && $val != '' ){
                    $args[$key] = $val;
                }
            }
            
            $pix_out = '';
            $pix_query = new WP_Query($this->pix_query($args));
            
            if( $href != 'false' ){
            	if( $data['step'] == 'on' && isset($data['next_type']) && in_array($data['next_type'], ['select', 'multi-select']) ) {
		            $pix_out          = [];
		            $pix_out['count'] = $pix_query->post_count;
		            $products_id_arr  = wp_list_pluck( $pix_query->posts, 'ID' );
		            $attribute        = isset( $data['next_id'] ) ? 'pa_' . $data['next_id'] : '';
		            $sql              = $wpdb->prepare( "
						SELECT 		t.*
					    FROM 		$wpdb->term_relationships as tr
					    INNER JOIN 	$wpdb->term_taxonomy as tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
					    INNER JOIN 	$wpdb->terms as t ON tt.term_id = t.term_id
					    WHERE 		tr.object_id IN (%1s)
					    AND 		tt.taxonomy LIKE '%s'
					    GROUP BY 	t.term_id
					    ORDER BY 	t.name ASC",
			            implode( ',', $products_id_arr ), $attribute );
		
		            $pix_result      = $wpdb->get_results( $sql );
		            $pix_out['content'] = '';
		
		            foreach ( $pix_result as $item ) {
						$pix_out['content'] .= '<option value="'.esc_attr($item->slug).'">' . $item->name . '</option>';
		            }
	            } else {
            		$pix_out = $pix_query->post_count;
	            }
            } else {
                if(isset($data['url'])){
                    $url = explode('?', $data['url']);
                    $url = isset($url[0]) ? $url[0] : '';
                } else {
                    $url = get_permalink();
                }
                $pix_filter = $this;
                include( PIX_PLUGIN_DIR . '/pixplugin/templates/pix-listing-items.php' );
            }

			wp_send_json_success($pix_out);

        } elseif( true && ( in_array('make_model', $keys) || in_array('model_restyle', $keys) || in_array('restyle_version', $keys) ) ){
            foreach($data as $key=>$val) {
                if( in_array($key, array('make_model', 'model_restyle', 'restyle_version')) ) {
                    $html = '';

	                $make_term = get_term_by('slug', $val, 'pix-product-car');
					$terms = get_terms([
						'taxonomy' => 'pix-product-car',
						'orderby'       => 'slug',
						'order'         => 'ASC',
						'parent'       => $make_term->term_id,
						'hide_empty' => false,
					]);
	                if (!empty($terms) && !is_wp_error($terms)) {
		                foreach ($terms as $k => $v) {
			                //$make_child_term = get_term_by('id', $key_child, 'pixcar-make');
			                $html .= '<option value="'.esc_attr($v->slug).'">'.wp_kses_post($v->name).'</option>';
		                }
	                }
	                wp_send_json_success($html);
	                break;
                }
            }
        } else {
            wp_send_json_error(array('error' => $custom_error));
        }
    }
    
    
    
    public function pix_query( $query_args ) {
		global $pix_settings;
		
		$tax_query = array();
		
		if( is_array( $query_args ) ){
		    foreach( $query_args as $var => $data ){
		        if( !in_array($var, array('price', 'paged', 'order')) ){
		            if( in_array($var, array('make', 'model', 'restyle', 'version')) ){
		                $tax_query[] = array(
                            'taxonomy'        => 'pix-product-car',
                            'field'           => 'slug',
                            'terms'           =>  explode(',', $data),
                            'operator'        => 'IN',
                        );
                    } elseif( in_array($var, array('category')) ) {
		                if($data != '0'){
                            $tax_query[] = array(
                                'taxonomy'        => 'product_cat',
                                'field'           => 'id',
                                'terms'           =>  $data,
                                'operator'        => 'IN',
                            );
                        }
                    } else {
                        $tax_query[] = array(
                            'taxonomy'        => 'pa_'.$var,
                            'field'           => 'slug',
                            'terms'           =>  explode(',', $data),
                            'operator'        => 'IN',
                        );
                    }
		        }
            }
        }
	    $tax_query[] =  array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'exclude-from-catalog',
            'operator' => 'NOT IN',
        );
		
        
		if( is_array( $query_args ) )
			 extract( $query_args );

		if( empty( $category ) ) 	    $category	    = 'all';
		if( empty( $price ) ) 		    $price		    = 'all';
		if( empty( $car_make ) ) 	    $car_make	    = 'all';
        if( empty( $car_model ) ) 	    $car_model	    = 'all';
        if( empty( $car_restyle ) ) 	$car_restyle	= 'all';
        if( empty( $car_version ) ) 	$car_version	= 'all';
		if( empty( $per_page ) ) 	    $per_page	    = $this->href ? -1 : 15;
		if( empty( $order ) )           $order          = '_price-asc';


//        $temp = explode('-', $order);
//        if(isset($temp[0]) && $temp[0] == 'car_brand' ){
//            $this->orderby = 'title';
//            $this->order = strtoupper($temp[1]);
//            $this->metakey = '';
//        } elseif(isset($temp[0]) && in_array($temp[0], self::$orderby_arr)){
//            $this->orderby = $temp[0];
//            $this->order = strtoupper($temp[1]);
//            $this->metakey = '';
//        } elseif(isset($temp[0]) && !in_array($temp[0], self::$orderby_arr)){
//            $this->orderby = !in_array($temp[0], self::$orderby_num) ? 'meta_value' : 'meta_value_num';
//            $this->order = strtoupper($temp[1]);
//            $this->metakey = $temp[0];
//        }
//        if( isset($temp[0]) ){
//            $this->orderby = array(
//                'pixcars_featured' => 'ASC',
//                $this->orderby => $this->order,
//            );
//        }


		if( empty( $paged ) && get_query_var('paged') ) {
			$paged = get_query_var('paged');
		}elseif( empty( $paged ) && get_query_var('page') ) {
			$paged = get_query_var('page');
		}elseif ( empty( $paged ) ) {
			$paged = 1;
		}


		$per_page = $this->per_page ? $this->per_pagde : $per_page;

	    
	    
//	    if( $category !== 'all' ) {
//
//            // Remove blank space from condition
//            if( preg_match( '/ /', $category ) )
//                $category = str_replace( ' ', '', $category );
//
//            // If multiple conditions added
//            if( preg_match( '/,/', $category ) )
//                $category = explode( ',', $category );
//
//            // Convert string to lowercase
//            if( is_array( $category ) ) {
//                $category = array_map( 'strtolower', $category );
//            }else{
//                $category = strtolower( $category );
//            }
//
//            // Format meta query
//            $tax_query[] = array(
//                'taxonomy'	=> 'product_cat',
//                'field'		=> 'id',
//                'terms'		=> $category,
//                'operator'  => 'IN',
//            );
//
//        }
        
        
        if( $price !== 'all' ) {

            // Remove blank space from price
            if( preg_match( '/ /', $price ) )
                $price = str_replace( ' ', '', $price );

            // Remove dot from price
            if( preg_match( '/./', $price ) )
                $price = str_replace( '.', '', $price );

            // If multiple prices added
            if( preg_match( '/,/', $price ) )
                $price = explode( ',', $price );

            if(is_array($price) && $price[1] >= 5000 && $price[0] <= $price[1]){
                // Format meta query
                $pixPrice = array(
                    'key'     => '_price',
                    'value'   => $price[0],
                    'type'    => 'numeric',
                    'compare' => '>='
                );
            }elseif(is_array($price) && $price[1] < 5000 && $price[0] <= $price[1]) {
                // Format meta query
                $pixPrice = array(
                        'key' => '_price',
                        'value' => $price,
                        'type' => 'numeric',
                        'compare' => 'BETWEEN'
                );
            }else{
                $pixPrice = array(
                    'key'     => '_price',
                    'value'   => $price[0],
                    'type'    => 'numeric',
                    'compare' => '>='
                );
            }
        }
        
        $pixPrice		= isset( $pixPrice ) ? $pixPrice : '';
        
        // Format query to output all cars
        $this->Query = array(
            'post_type' 		=> 'product',
            'posts_per_page' 	=> $per_page,
//            'orderby' 			=> $this->orderby,
//            'order' 			=> $this->order,
//            'meta_key' 			=> $this->metakey,
            'tax_query'      => $tax_query,
            'meta_query'		=> array(
                $pixPrice
            ),
            'paged' 			=> $paged
        );

		return $this->Query;
	}
	
	
	
	function pagenavi($max_page, $paged = 1) {
	    $pagenavi_options = array(
	        'pages_text' => '',
	        'current_text' => '%PAGE_NUMBER%',
	        'page_text' => '%PAGE_NUMBER%',
	        'first_text' => wp_kses_post(__('<i class="fa fa-angle-left"></i>','pixcars')),
	        'last_text' => wp_kses_post(__('<i class="fa fa-angle-right"></i>','pixcars')),
	        'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
            'next_text' => is_rtl() ? '&larr;' : '&rarr;',
	        'dotright_text' => esc_html__('...','pixcars'),
	        'dotleft_text' => esc_html__('...','pixcars'),
	        'style' => 1,
	        'num_pages' => 5,
	        'always_show' => 0,
	        'num_larger_page_numbers' => 3,
	        'larger_page_numbers_multiple' => 10,
	        'use_pagenavi_css' => 1,
            //'base'    => esc_url_raw( add_query_arg( 'product-page', '%#%', false ) ),
            'base' => user_trailingslashit( wp_normalize_path( get_permalink() .'/%#%/' ) ),
	    );

     
	    $pages_to_show = intval($pagenavi_options['num_pages']);
	    $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
	    $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
	    $pages_to_show_minus_1 = $pages_to_show - 1;
	    $half_page_start = floor($pages_to_show_minus_1/2);
	    $half_page_end = ceil($pages_to_show_minus_1/2);
	    $start_page = $paged - $half_page_start;

	    if ($start_page <= 0)
	        $start_page = 1;

	    $end_page = $paged + $half_page_end;
	    if (($end_page - $start_page) != $pages_to_show_minus_1) {
	        $end_page = $start_page + $pages_to_show_minus_1;
	    }

	    if ($end_page > $max_page) {
	        $start_page = $max_page - $pages_to_show_minus_1;
	        $end_page = $max_page;
	    }

	    if ($start_page <= 0)
	        $start_page = 1;

	    $larger_pages_array = array();
	    if ( $larger_page_multiple )
	        for ( $i = $larger_page_multiple; $i <= $max_page; $i += $larger_page_multiple )
	            $larger_pages_array[] = $i;

		$out = '';
		
	    if ($max_page > 1 || intval($pagenavi_options['always_show'])) {
	        $base = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	        $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), esc_html__('Page %CURRENT_PAGE% of %TOTAL_PAGES%','pixcars'));
	        $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
	        $out .= '<nav class="pix-pagination woocommerce-pagination"><ul class="page-numbers">'."\n";
	        switch(intval($pagenavi_options['style'])) {
	            // Normal
	            case 1:
	                if (!empty($pages_text)) {
	                    //echo '<li><span class="pages">'.$pages_text.'</span></li>';
	                }
	                if ($start_page >= 2 && $pages_to_show < $max_page) {
	                    $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
	                    $out .= '<li><a href="'.$pagenavi_options['base'].'" data-page="'.$max_page.'" class="first page-numbers pix-ajax-page" title="">'.$first_page_text.'</a></li>';
	                    if (!empty($pagenavi_options['dotleft_text'])) {
	                        $out .= '<li><span class="extend">'.$pagenavi_options['dotleft_text'].'</span></li>';
	                    }
	                }
	                $larger_page_start = 0;
	                foreach($larger_pages_array as $larger_page) {
	                    if ($larger_page < $start_page && $larger_page_start < $larger_page_to_show) {
	                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
	                        $out .= '<li><a href="'.$pagenavi_options['base'].'" data-page="'.$larger_page.'" class="page page-numbers pix-ajax-page" title="'.$page_text.'">'.$page_text.'</a></li>';
	                        $larger_page_start++;
	                    }
	                }
	                if($paged > 1)
	                    $out .= '<li class="arrow"><a href="javascript:void(0);" data-page="'.($paged-1).'" class="previouspostslink page-numbers pix-ajax-page">'.$pagenavi_options['prev_text'].'</a></li>';
	                for($i = $start_page; $i  <= $end_page; $i++) {
	                    if ($i == $paged) {
	                        $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
	                        $out .= '<li><span class="current">'.$current_page_text.'</span></li>';
	                    } else {
	                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
	                        $out .= '<li><a href="'.$pagenavi_options['base'].'" data-page="'.$i.'" class="page page-numbers pix-ajax-page" title="'.$page_text.'">'.$page_text.'</a></li>';
	                    }
	                }
					if($paged < $max_page)
	                $out .= '<li class="arrow"><a href="javascript:void(0);" data-page="'.($paged+1).'" class="nextpostslink pix-ajax-page">'.$pagenavi_options['next_text'].'</a></li>';
	                $larger_page_end = 0;
	                foreach($larger_pages_array as $larger_page) {
	                    if ($larger_page > $end_page && $larger_page_end < $larger_page_to_show) {
	                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
	                        $out .= '<li><a href="javascript:void(0);" data-page="'.$larger_page.'" class="page page-numbers pix-ajax-page" title="'.$page_text.'">'.$page_text.'</a></li>';
	                        $larger_page_end++;
	                    }
	                }
	                if ($end_page < $max_page) {
	                    if (!empty($pagenavi_options['dotright_text'])) {
	                        $out .= '<li><span class="extend">'.$pagenavi_options['dotright_text'].'</span></li>';
	                    }
	                    $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
	                    $out .= '<li><a href="javascript:void(0);" data-page="'.$max_page.'" class="last page-numbers pix-ajax-page" title="">'.$last_page_text.'</a></li>';
	                }
	                break;

	        }
	        $out .= '</ul></nav>'."\n";

	    }
	    return $out;
	}
    
    

    public function pixcustom() {
	    $data = array_map( 'esc_attr', $_POST );

        check_ajax_referer( 'pixcustom_nonce', 'nonce' );

        if( true && isset($data['department']) ){
            $out = '<option value="">'.esc_html__( 'Select Doctor', 'pixsettings' ).'</option>';
            $pix_portfolio = get_objects_in_term( $data['department'], 'pix-portfolio-cat' );
            $args_port = array(
                'post_type' => 'portfolio',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'post__in' => $pix_portfolio,
                'order' => 'ASC'
            );
            $portfolio = get_posts($args_port);
            if(empty($portfolio['errors'])){
                foreach($portfolio as $port_card){
                    $calendar_id = get_post_meta($port_card->ID, 'pix_portfolio_calendar', true);
                    if($calendar_id != '') {
                        $out .= '<option class="level-0" value="' . esc_attr($calendar_id) . '">' . wp_kses_post($port_card->post_title) . '</option>';
                    }
                }
            }
			wp_send_json_success($out);

        } else {
            wp_send_json_error(array('error' => $custom_error));
        }
    }

}
global $PixFilterResult;
$PixFilterResult = new Pix_Filter_Result();
?>