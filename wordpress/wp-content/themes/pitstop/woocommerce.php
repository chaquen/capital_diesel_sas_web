<?php
/* Woocommerce template. */

$product_cat = 0;
$orderby = false;
if ( is_product() ) {
    $pix_layout = pixtheme_get_layout(get_post_type(), get_the_ID());
} elseif( is_shop() || is_archive() ){
    $pix_layout = pixtheme_get_layout('shop');
    
    global $PixFilterResult;
    $data = array_map( 'esc_attr', $_GET );
    
    $args_shop = array();
    foreach($data as $key=>$val){
        if( property_exists('Pix_Filter_Result', $key) && $key == 'per_page' ) {
            $this->$key = $val;
        } elseif( $key == 'orderby' && $val != '' ){
            $orderby = true;
        } elseif( strpos($key, 'filter') !== false ){
            $orderby = false;
        } elseif( $key == 'model' && $val != '' ){
            $args_shop['make'] = $val;
        } elseif( $key == 'href' ){
            $href = $val;
        } elseif( $key != 'currency' && $key != 'action' && $key != 'nonce' && $val != ''){
            $args_shop[$key] = $val;
        }
    }
    
} elseif( is_product_category() || is_product_tag() ) {
    $pix_layout = pixtheme_get_layout('product-cat');
    $product_cat = get_queried_object_id();
}
$pix_width_class = pixtheme_get_layout_width( get_post_type() );

get_header(); ?>


<section class="shop">
    <div class="<?php echo esc_attr($pix_width_class)?>">
        <?php do_action( 'pix_woocommerce_before_shop_loop' ); ?>
		<div class="row mr-0 mb-80 ml-0 pix-bg-white">
            <?php
                if(is_product() && pixtheme_get_setting('pix-woo-single-sticky', 'on') == 'on'){
                    do_action( 'pix_woocommerce_before_single_product' );
                }
            ?>
            <?php pixtheme_show_sidebar( 'left', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

            <div class="rtd <?php if ( $pix_layout['layout'] != 1 ) : ?>col-xx-10 col-xl-9 col-lg-8<?php endif; ?> col-12 <?php echo esc_attr($pix_layout['class'])?> pl-0 pr-0">
                <input type="hidden" id="pix-product-category" name="category" value="<?php echo esc_attr($product_cat) ?>">
                <?php
                    if( !is_search() && !$orderby && !is_customize_preview() && is_shop() && !empty($args_shop) && class_exists('PixThemeSettings')){
                        $pix_out = '';
                        $pix_query = new WP_Query( $PixFilterResult->pix_query( $args_shop ) );
                        $pix_filter = $PixFilterResult;
                        include( PIX_PLUGIN_DIR . '/pixplugin/templates/pix-listing-items.php' );
                        pixtheme_out('<div id="pix-filter-content" class="clearfix">'.$pix_out.'</div>');
                    } else {
                        woocommerce_content();
                    }
                ?>
            </div>

            <?php pixtheme_show_sidebar( 'right', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

		</div>
        <?php
            if(is_product()){
                do_action( 'pix_woocommerce_after_single_product_summary' );
            }
        ?>
	</div>
</section>

<?php get_footer();?>
