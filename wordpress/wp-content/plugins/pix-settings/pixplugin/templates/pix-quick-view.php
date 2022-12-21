<?php
if( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly
 

if ( !empty($pix_result) ) {

    $pix_size_img = array(100, 100);
    
	$pix_out .= '
    <ul class="pix__searchAjax_products">
    ';

    foreach ($pix_result as $item) :
        $_product = wc_get_product( $item->ID );

        $cats = wp_get_object_terms($item->ID, 'product_cat');
        $cat_titles_str = '';
        $cat_titles = array();
        if ( ! empty($cats) ) {
            foreach ( $cats as $cat ) {
                $cat_titles[] = '<a href="'.get_term_link($cat).'" class="pix-product-info-category">'.$cat->name.'</a>';
            }
            $cat_titles_str = '<span>'.implode(', ', $cat_titles).'</span>';
        }

        $thumbnail = get_the_post_thumbnail($item->ID, $pix_size_img);

        $defaults = array(
			'quantity'   => 1,
			'class'      => implode(
				' ',
				array_filter(
					array(
						'button',
						'product_type_' . $_product->get_type(),
						$_product->is_purchasable() && $_product->is_in_stock() ? 'add_to_cart_button' : '',
						$_product->supports( 'ajax_add_to_cart' ) && $_product->is_purchasable() && $_product->is_in_stock() ? 'ajax_add_to_cart' : '',
					)
				)
			),
			'attributes' => array(
				'data-product_id'  => $_product->get_id(),
				'data-product_sku' => $_product->get_sku(),
				'aria-label'       => $_product->add_to_cart_description(),
				'rel'              => 'nofollow',
			),
		);

		$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $_product );
		$args['class'] .= ' pix-cart-icon';

        $pix_out .= '
        <li class="pix__searchAjax_product">
            <a class="pix__searchAjax_product-img" href="'.get_the_permalink($item->ID).'">
                '.$thumbnail.'
            </a>
            <div class="pix__searchAjax_product-info">
                '.$cat_titles_str.'
                <div class="h6"><a href="'.get_the_permalink($item->ID).'">'.get_the_title($item->ID).'</a></div>
                <div>
                    <div class="pix__searchAjax_product-price">
                        '.$_product->get_price_html().'
                    </div>
                    '.apply_filters( 'woocommerce_loop_add_to_cart_link',
                        sprintf( '<a href="%s" data-quantity="%s" class="%s btn btn-sm btn-danger" title="%s" %s><i class="pit-cartbig"></i></a>',
                            esc_url( $_product->add_to_cart_url() ),
                            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                            esc_attr( isset( $args['class'] ) ? $args['class'] : '' ),
                            esc_html( $_product->add_to_cart_text() ),
                            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : ''
                        ),
                        $_product, $args ).'
                </div>
            </div>
        </li>';

    endforeach;

    $pix_out .= '
    </ul>
    ';

}

?>
