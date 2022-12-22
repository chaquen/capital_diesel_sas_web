<?php
 
	$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : (get_the_ID()>0 ? get_the_ID() : '');
	$pix_width_class = pixtheme_get_layout_width( get_post_type() );

    if( class_exists( 'WooCommerce' ) && pixtheme_is_woo_page() && pixtheme_get_option('woo_header_global','1') ){
		$post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
	}
    
    $elementor_page = get_post_meta( $post_ID, '_elementor_edit_mode', true );

	$logo = pixtheme_get_option('general_settings_logo');
	$logo_text = pixtheme_get_option('general_settings_logo_text');

	$footer_section_id = false;
	$footer_section_id = in_array(get_post_meta($post_ID, 'pix_page_footer', true), array('global', '')) || $post_ID == '' ? pixtheme_get_setting('pix-footer-section') : get_post_meta($post_ID, 'pix_page_footer', true);
	if(function_exists('icl_object_id')) {
		$footer_section_id = icl_object_id ($footer_section_id,'pix-section',true);
	} elseif(function_exists('pll_get_post')){
	    $footer_section_id = pll_get_post ($footer_section_id);
    }

	$year = date('Y');
	
?>

<?php if ( ($footer_section_id != 'nofooter') && get_post_type() != 'pix-section' ) : ?>

    <!-- Footer section -->
    <footer class="pix-footer">
        <div class="<?php echo esc_attr($pix_width_class)?>">

            <?php if ( $footer_section_id && !$elementor_page )  { pixtheme_get_section_content($footer_section_id); } ?>
            
            <?php if ( $footer_section_id && $elementor_page )  { pixtheme_get_el_section_content($footer_section_id); } ?>

            <?php if ( !$footer_section_id ):?>
                <div class="pix-footer__bottom">
                <?php if(pixtheme_get_setting('pix-footer-copyright', '')) : ?>
                    <div class="footer-copyright"><?php echo wp_kses(pixtheme_get_setting('pix-footer-copyright'), 'post')?></div>
                <?php else : ?>
                    <div class="footer-copyright"><?php printf('%s%s ', '&copy; ', $year)?><span><?php esc_html_e('All Rights Reserved', 'pitstop')?></span></div>
                <?php endif; ?>
                    <div class="footer-created_by"><a target="_blank" href="<?php echo esc_url('https://true-emotions.studio')?>"><span><?php esc_html_e('By PixTheme', 'pitstop')?></span><?php esc_html_e(' Studio', 'pitstop')?></a></div>
                </div>
            <?php endif; ?>

        </div>
    </footer>

<?php endif; ?>


</div>

<!-- popup-->
<div class="pix__popup single single-product woocommerce woocommerce-page woocommerce-js" id="pixPopup">
    <div class="pix__popupCloser"></div>
    <div class="pix__popupWindow">
        <div class="pix__popupClose"></div>
        <div class="pix__popupInner">
        
        </div>
    </div>
</div>
<!-- ./ popup-->

<?php
    wp_footer();
?>

</body></html>