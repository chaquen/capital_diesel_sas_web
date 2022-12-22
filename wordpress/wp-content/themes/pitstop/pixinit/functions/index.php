<?php 
	/**  Theme_index  **/
	
    include_once( get_template_directory() . '/pixinit/functions/styles_scripts.php' );
    include_once( get_template_directory() . '/pixinit/functions/functions.php' );
    include_once( get_template_directory() . '/pixinit/functions/comment_walker.php' );
    include_once( get_template_directory() . '/pixinit/functions/menu_walker.php' );
    include_once( get_template_directory() . '/pixinit/functions/product_cat_list_walker.php' );
    include_once( get_template_directory() . '/pixinit/functions/portfolio_walker.php' );
	include_once( get_template_directory() . '/pixinit/functions/sidebars.php');
    include_once( get_template_directory() . '/pixinit/functions/use.php' );
    include_once( get_template_directory() . '/pixinit/functions/woo.php' );
    include_once( get_template_directory() . '/pixinit/functions/woo_single.php' );
    include_once( get_template_directory() . '/pixinit/functions/woo-ajax.php' );
    include_once( get_template_directory() . '/pixinit/functions/defaults.php' );
    if ( did_action( 'elementor/loaded' ) ) {
        require_once(get_template_directory() . '/pixinit/functions/elementor.php');
    }


	function pixtheme_setup() {

	    // Language support
	    load_theme_textdomain('pitstop', get_template_directory() . '/languages');
	    $locale      = get_locale();
	    $locale_file = get_template_directory() . "/languages/$locale.php";
	    if (is_readable($locale_file)) {
	        require_once(get_template_directory() . "/languages/$locale.php");
	    }

	    // ADD SUPPORT FOR POST THUMBS
	    add_theme_support('post-thumbnails');
	    // Define various thumbnail sizes
     
		$img_size = ( ( pixtheme_get_setting('pix-img-base-size', '650') ) &&
					 is_numeric( pixtheme_get_setting('pix-img-base-size', '650') ) &&
					 pixtheme_get_setting('pix-img-base-size', '650') > 0
				 ) ? pixtheme_get_setting('pix-img-base-size', '650') : 650;
		$img_landscape_ratio = ( ( pixtheme_get_setting('pix-img-landscape-ratio', '1.618') ) &&
					 is_numeric( pixtheme_get_setting('pix-img-landscape-ratio', '1.618') ) &&
					 pixtheme_get_setting('pix-img-landscape-ratio', '1.618') > 0
				 ) ? pixtheme_get_setting('pix-img-landscape-ratio', '1.618') : 1.618;
		$img_portrait_ratio = ( ( pixtheme_get_setting('pix-img-portrait-ratio', '1.333') ) &&
					 is_numeric( pixtheme_get_setting('pix-img-portrait-ratio', '1.333') ) &&
					 pixtheme_get_setting('pix-img-portrait-ratio', '1.333') > 0
				 ) ? pixtheme_get_setting('pix-img-portrait-ratio', '1.333') : 1.333;
		$img_size_col_3 = $img_size;
        $img_size_col_4 = round($img_size/1.5 );
		add_image_size('pixtheme-square', $img_size, $img_size, true );
		add_image_size('pixtheme-landscape', ($img_size*$img_landscape_ratio), $img_size, true );
		add_image_size('pixtheme-portrait', $img_size, ($img_size*$img_portrait_ratio), true );
		add_image_size('pixtheme-original', $img_size, $img_size, false );
		
		add_image_size('pixtheme-thumb', 200, 110, true);
		add_image_size('pixtheme-medium', 950, 460, true);
		update_option( 'medium_size_w', 540 );
		update_option( 'medium_size_h', 540 );
		update_option( 'large_size_w', 950 );
		update_option( 'large_size_h', 950 );
		

	    add_theme_support('widgets');
	    add_theme_support('title-tag');
	    add_theme_support('automatic-feed-links');
	    add_theme_support('post-formats', array(
	        'gallery',
	        'video',
	        'quote',
	    ));
	    $args = array(
	        'flex-width' => true,
	        'width' => 350,
	        'flex-height' => true,
	        'height' => 'auto',
	        'default-image' => get_template_directory_uri() . '/images/logo.svg'
	    );
	    add_theme_support('custom-header', $args);
	    $args = array(
	        'default-color' => 'FFFFFF'
	    );
	    add_theme_support('custom-background', $args);

	    add_theme_support( 'woocommerce', array(
	        'single_image_width'            => 600,
            'thumbnail_image_width'         => 400,
            'gallery_thumbnail_image_width' => 300,
        ) );
		//add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

	}
	add_action('after_setup_theme', 'pixtheme_setup');
	
	
	/* Register 5 navi types */
	function pixtheme_custom_menus() {

	    /* Register Navigations */
        register_nav_menus(array(
            'primary_nav' => esc_html__('Primary Navigation', 'pitstop'),
            'primary_left_nav' => esc_html__('Primary Left Navigation', 'pitstop'),
            'primary_right_nav' => esc_html__('Primary Right Navigation', 'pitstop'),
            'top_nav' => esc_html__('Top Navigation', 'pitstop'),
            'account_nav' => esc_html__('Account Navigation', 'pitstop'),
            'footer_nav' => esc_html__('Footer Navigation', 'pitstop'),
		    'mobile_nav' => esc_html__('Mobile Navigation', 'pitstop'),
        ));
    }
	add_action('init', 'pixtheme_custom_menus');

	
	if ( ! isset( $content_width ) ) {
		$content_width = 1330;
	}

?>