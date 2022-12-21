<?php
if( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly
 

if ( $pix_query->have_posts() ) {
    
    if(pixtheme_retina()){
        $pix_size_img = array(760, 460);
    } else {
        $pix_size_img = array(380, 230);
    }
    
    
	$pix_out .= '
    <div class="pix-products">';
    
//    ob_start(); // start capturing output.
//    do_action( 'woocommerce_before_shop_loop' );
//    while ( $pix_query->have_posts() ) {
//        $pix_query->the_post();
//        do_action( 'woocommerce_shop_loop' );
//        wc_get_template_part( 'content', 'product' );
//    }
//    wp_reset_postdata();
//	do_action( 'woocommerce_after_shop_loop' );
//	$pix_out .= ob_get_contents(); // the actions output will now be stored in the variable as a string!
//	ob_end_clean();
 
	while ($pix_query->have_posts()) :
        $pix_query->the_post();

        ob_start(); // start capturing output.
        wc_get_template_part('content', 'product');
        $pix_out .= ob_get_contents(); // the actions output will now be stored in the variable as a string!
        ob_end_clean();
    endwhile;

    $pix_out .= '
    </div>';

//    $page = get_query_var('paged') == '' ? 1 : get_query_var('paged');
//    $paged_item = isset($_REQUEST['paged']) && $_REQUEST['paged'] != '' ? $_REQUEST['paged'] : $page;
//    $pix_out .= $pix_filter->pagenavi($pix_query->max_num_pages, $paged_item);
    
    $total   = $pix_query->max_num_pages;
    $page = get_query_var('paged') == '' ? 1 : get_query_var('paged');
    $current = isset($_REQUEST['paged']) && $_REQUEST['paged'] != '' ? $_REQUEST['paged'] : $page;
    if(isset($url)){
        $base = user_trailingslashit( wp_normalize_path( $url .'/page/%#%' ) );
    } else {
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
        $uri_parts = explode('/page/', $uri_parts[0], 2);
        $base    = user_trailingslashit( wp_normalize_path( $uri_parts[0] .'/page/%#%' ) );
    }
    
    $format  = '';
    
    if ( $total > 1 ) {
        
        $result_pagination = paginate_links(
            apply_filters(
                'woocommerce_pagination_args',
                array( // WPCS: XSS ok.
                    'base'      => $base,
                    'format'    => '',
                    'add_args'  => false,
                    'current'   => max( 1, $current ),
                    'total'     => $total,
                    'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
                    'next_text' => is_rtl() ? '&larr;' : '&rarr;',
                    'type'      => 'list',
                    'end_size'  => 3,
                    'mid_size'  => 3,
                )
            )
        );
        
        $pix_out .= '
        <nav class="woocommerce-pagination pix-paging">
            '.$result_pagination.'
        </nav>';
    }

}

?>
