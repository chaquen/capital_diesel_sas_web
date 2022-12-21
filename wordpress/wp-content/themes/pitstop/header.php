<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>  data-scrolling-animations="true">
    <?php
        wp_body_open();
        $post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : get_the_ID();
        $pixtheme_page_layout = get_post_meta($post_ID, 'page_layout', 1) != '' ? get_post_meta($post_ID, 'page_layout', 1) : pixtheme_get_option('style_general_settings_layout', 'normal');
        if( class_exists( 'WooCommerce' ) ){
            $post_ID = $post_ID ? $post_ID : get_option( 'woocommerce_shop_page_id' );
        }
        $pixtheme_woo_layout = get_post_meta($post_ID, 'pix_woo_layout', 1) != '' ? get_post_meta($post_ID, 'pix_woo_layout', 1) : pixtheme_get_option('woo_layout', 'default');
    
        $pixtheme_header = apply_filters('pixtheme_header_settings', $post_ID);
    ?>
    
    <?php if( (pixtheme_get_option('general_settings_loader','useall') == 'usemain' && is_front_page()) || pixtheme_get_option('general_settings_loader','useall') == 'useall' ) : ?>
        <?php
            $main_color = pixtheme_get_option('style_settings_main_color', get_option('pixtheme_default_main_color'));
            $gradient_color = pixtheme_get_option('style_settings_gradient_color', get_option('pixtheme_default_gradient_color'));
        ?>
    <!-- Loader -->
        <div id="page-preloader">
            <?php if(pixtheme_get_option('loader_img', '') != '') : ?>
            <div class="pix-pulse"></div>
            <?php else : ?>
            <div class="pix-loading"></div>
            <?php endif; ?>
        </div>
    <!-- Loader end -->
    <?php endif; ?>
    
        <div class="pix page-layout-<?php echo esc_attr($pixtheme_page_layout); ?> woo-layout-<?php echo esc_attr($pixtheme_woo_layout); ?>" >
    
        <?php
            
            if(get_post_meta($post_ID, 'pix_header_switch', 1) != 'off') {
                get_template_part( 'templates/header/' . $pixtheme_header['header_type_mobile'] );
                if($pixtheme_header['header_sticky'] != ''){
                    echo '<div class="pix-header-placeholder"></div>';
                }
                get_template_part('templates/header/' . $pixtheme_header['header_type']);
            }
        
            if (!is_page_template('page-home.php')) {
                get_template_part( 'templates/header/bg_image' );
            }
        
        ?>

