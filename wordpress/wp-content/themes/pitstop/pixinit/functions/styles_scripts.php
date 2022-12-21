<?php
function pixtheme_fonts_url($post_id) {
 
	$fonts_url = '';
	$exclude = ['Jost'];
	$font_families = pixtheme_get_option('fonts_embed', get_option('pixtheme_default_fonts_embed'));
	
    if(!empty($font_families)) {
        
        $families = explode('&family=', html_entity_decode($font_families));
        foreach($families as $key => $val){
            $family = explode(':', $val);
            if(isset($family[0]) && in_array($family[0],$exclude)){
                unset($families[$key]);
            }
        }
        
        if(!empty($families)){
            $font_families = implode('&family=',$families);
            $query_args = array(
                'family' => str_replace('%2B', '+', urlencode($font_families)),
                'subset' => urlencode('latin,latin-ext'),
            );
            $fonts_url = add_query_arg($query_args, '//fonts.googleapis.com/css2');
        }
    }

	return esc_url_raw( $fonts_url );
}

add_filter('woocommerce_enqueue_styles', 'pixtheme_load_woo_styles');
function pixtheme_load_woo_styles($styles){
	if (isset($styles['woocommerce-general']) && isset($styles['woocommerce-general']['src'])){
		$styles['woocommerce-general']['src'] = get_template_directory_uri() . '/assets/woocommerce/css/woocommerce.css';
	}
	return $styles;
}


function pixtheme_load_styles_scripts(){
    
    wp_enqueue_style('style', get_stylesheet_uri());
    
    if(pixtheme_fonts_url(get_the_ID()) != '') {
        wp_enqueue_style('pixtheme-fonts', pixtheme_fonts_url(get_the_ID()), array(), null);
    }
    
    /* PRIMARY CSS */
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/bootstrap.min.css');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/bootstrap/bootstrap.min.js', array('jquery') , null, true);

    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/fonts/fontawesome/css/fontawesome.min.css');
    wp_enqueue_style('pitstop-icons', get_template_directory_uri() . '/css/fonts/pitstop-icons/flaticon.css');


    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // Placeholder
    wp_enqueue_script('placeholder', get_template_directory_uri() . '/js/jquery.placeholder.min.js', array('jquery') , null, true);
	
	// vanillaSelectBox
	wp_enqueue_style('vanillaSelectBox', get_template_directory_uri() . '/assets/vanillaSelectBox/vanillaSelectBox.css');
	wp_enqueue_style('pixVanillaSelectBox', get_template_directory_uri() . '/assets/vanillaSelectBox/pixVanillaSelectBox.css');
	wp_enqueue_script('vanillaSelectBox', get_template_directory_uri() . '/assets/vanillaSelectBox/vanillaSelectBox.js', array() , null, false);
	
	// Swiper
	wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/swiper/swiper-bundle.min.css');
	wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/swiper/swiper-bundle.min.js', array() , null, true);
	
	// SmoothScroll
    //wp_enqueue_script('smoothscroll', get_template_directory_uri() . '/assets/smoothscroll/SmoothScroll.js', array('jquery') , null, true);
	
	// CustomScroll
    wp_enqueue_script('customscroll', get_template_directory_uri() . '/assets/scrollbar.min.js', array('jquery') , null, true);
    wp_enqueue_script('rangeSlider', get_template_directory_uri() . '/assets/ion.rangeSlider.min.js', array('jquery') , null, true);
    wp_enqueue_script('countdown', get_template_directory_uri() . '/assets/countdown/jquery.countdown.js', array('jquery') , null, true);
    wp_enqueue_script('holder', get_template_directory_uri() . '/assets/holder.min.js', array('jquery') , null, true);

	// Isotope
	wp_enqueue_script('isotope', get_template_directory_uri() . '/assets/isotope/isotope.pkgd.min.js', array() , null, true);
    wp_enqueue_script('imagesloaded', get_template_directory_uri() . '/assets/isotope/imagesloaded.pkgd.min.js', array() , null, true);
    
    // Animate
    wp_enqueue_style('animate', get_template_directory_uri() . '/assets/animate/animate.css');
    
    if(class_exists("WooCommerce")) {
        if (current_theme_supports('wc-product-gallery-zoom')) {
            wp_enqueue_script('zoom');
        }
        if (current_theme_supports('wc-product-gallery-slider')) {
            wp_enqueue_script('flexslider');
        }
        if (current_theme_supports('wc-product-gallery-lightbox')) {
            wp_enqueue_script('photoswipe-ui-default');
            wp_enqueue_style('photoswipe-default-skin');
            add_action('wp_footer', 'woocommerce_photoswipe');
        }
        wp_enqueue_script('wc-single-product');
        wp_enqueue_script('wc-add-to-cart-variation');
    }
    
    // WOW
    wp_enqueue_script('wow', get_template_directory_uri() . '/assets/wow/wow.min.js', array('jquery') , null, true);

    // EasyPieChart
    wp_enqueue_script('easypiechart', get_template_directory_uri() . '/assets/easypiechart/jquery.easypiechart.min.js', array('jquery') , null, true);

    // Magnific-Popup
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/magnific-popup/magnific-popup.css');
    wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/assets/magnific-popup/jquery.magnific-popup.min.js', array('jquery') , null, true);
    
    // Fancybox
    wp_enqueue_style('fancybox', get_template_directory_uri() . '/assets/fancybox/jquery.fancybox.min.css');
    wp_enqueue_script('fancybox', get_template_directory_uri() . '/assets/fancybox/jquery.fancybox.min.js', array('jquery') , null, true);

    // Main CSS
    wp_enqueue_style('pixtheme-main', get_template_directory_uri() . '/css/main.css');
    if ( did_action( 'elementor/loaded' ) ) {
        wp_enqueue_style('pixtheme-elementor', get_template_directory_uri() . '/css/elementor.css');
    }
    
	wp_enqueue_style('pixtheme-responsive', get_template_directory_uri() . '/css/responsive.css');

    $api_key = pixtheme_get_setting('pix-google-api');
    if($api_key != '') {
        wp_enqueue_script('pixtheme-google-maps-api', "//maps.googleapis.com/maps/api/js?key=$api_key");
    }
    
    // CUSTOM SCRIPT
    wp_enqueue_style('pixtheme-dynamic-styles', admin_url('admin-ajax.php').'?action=dynamic_styles&pageID='.get_the_ID());
    wp_enqueue_script('pixtheme-common', get_template_directory_uri() . '/js/theme.js', array() , null, true);

    ob_start();
    get_template_part('searchform');
    $search_form = ob_get_contents();
    ob_end_clean();

    wp_localize_script( 'pixtheme-common', 'pix_js_vars',
        array(
            'search_form' => $search_form,
            'url'   => admin_url( 'admin-ajax.php' ),
            'wcajaxurl'   => class_exists( 'WooCommerce' ) && version_compare( WC()->version, '2.4', '>=' ) ? WC_AJAX::get_endpoint( "%%endpoint%%" ) : admin_url( 'admin-ajax.php', 'relative' ),
            'cart_nonce' => wp_create_nonce( 'pix_cart_nonce' ),
            'slider_nonce' => wp_create_nonce( 'pix_slider_nonce' ),
        )
    );

}
add_action('wp_enqueue_scripts', 'pixtheme_load_styles_scripts');


function pixtheme_dynamic_styles() {
	include( get_template_directory().'/pixinit/functions/dynamic-styles.php' );
	exit;
}
add_action('wp_ajax_dynamic_styles', 'pixtheme_dynamic_styles');
add_action('wp_ajax_nopriv_dynamic_styles', 'pixtheme_dynamic_styles');



add_filter('body_class','pixtheme_browser_body_class');
function pixtheme_browser_body_class($classes = '') {

    $classes[] = pixtheme_get_option('theme_boxes_shape', 'pix-rounded');
    $classes[] = pixtheme_get_option('buttons_shape', get_option('pixtheme_default_button_shape')).'-buttons';
    $classes[] = pixtheme_get_option('style_theme_tone', '');
    $classes[] = !in_array('woocommerce', $classes) && class_exists( 'WooCommerce' ) ? 'woocommerce' : '';
    $classes[] = !class_exists( 'PixThemeSettings' ) ? 'pix-no-settings' : '';
    $classes[] = 'pix-list';

    return $classes;
}



?>
