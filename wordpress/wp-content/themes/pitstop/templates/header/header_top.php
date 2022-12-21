<?php /* Header Top */
$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : get_the_ID();
if( class_exists( 'WooCommerce' ) && pixtheme_is_woo_page() && pixtheme_get_option('woo_header_global','1') ){
    $post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
} elseif (!is_page_template('page-home.php') && get_option('page_for_posts') && pixtheme_get_option('header_like_blog','0')){
    $post_ID = get_option('page_for_posts') ? get_option('page_for_posts') : 0;
}

$pixtheme_header = apply_filters('pixtheme_header_settings', $post_ID);
$pixtheme_header['top_bar_background'] = $pixtheme_header['top_bar_background'] == '' ? 'black' : $pixtheme_header['top_bar_background'];
$pixtheme_top_bar_transparent = $pixtheme_header['top_bar_transparent'] < 100 ? 'transparent' : '';


?>

<div class="pix-top-bar <?php echo esc_attr($pixtheme_header['top_bar_background']) ?> <?php echo esc_attr( $pixtheme_top_bar_transparent ) ?>">
    <div class="<?php echo esc_attr($pixtheme_header['header_layout']) ?>">
        <div class="header-topbarbox-1">
            <ul>
                <?php if ($pixtheme_header['header_phone'] && 1==2) : ?>
                    <li><i class="fas fa-mobile-alt"></i><a href="tel:<?php echo esc_attr(str_replace(' ', '', pixtheme_get_option('header_phone', ''))) ?>"><?php echo wp_kses(pixtheme_get_option('header_phone', ''), 'post') ?></a></li>
                <?php endif; ?>
                <?php if ($pixtheme_header['header_email']) : ?>
                    <li><i class="far fa-envelope"></i><a href="mailto:<?php echo wp_kses(pixtheme_get_option('header_email', ''), 'post') ?>"><?php echo wp_kses(pixtheme_get_option('header_email', ''), 'post') ?></a></li>
                <?php endif; ?>
                <?php if ($pixtheme_header['header_address']) : ?>
                    <li><i class="fas fa-map-marker-alt"></i><?php echo wp_kses(pixtheme_get_option('header_address', ''), 'post') ?></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="header-topbarbox-2">
            <?php
            if ( has_nav_menu( 'top_nav' ) ) {
                wp_nav_menu(array(
                    'theme_location'  => 'top_nav',
                    'container'       => false,
                    'menu_id'		  => 'top-menu',
                    'menu_class'      => '',
                    'depth'           => 1
                ));
            }
            ?>
            <?php if ( $pixtheme_header['header_socials'] ) : ?>
                <ul class="header-socials">
                    <?php get_template_part('templates/header/header_socials'); ?>
                </ul>
            <?php endif; ?>
            
            <?php if ( $pixtheme_header['header_type'] == 'header2' && isset($pixtheme_header['header_button']) && $pixtheme_header['header_button'] ) : ?>
                <a class="pix-button pix-transparent pix-h-s pix-v-xs" href="<?php echo esc_url(pixtheme_get_option('header_button_link')) ?>"><?php echo wp_kses(pixtheme_get_option('header_button_text', esc_html__('Test Drive', 'pitstop')), 'post') ?></a>
            <?php endif; ?>
            
        </div>
    </div>
</div>