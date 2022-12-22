<?php
/**
 * @var $atts
 * @var $this WPBakeryShortCode_Common_Woo_Categories
 */

$show_image = $prod_number = 'on';
$count = '0';
$swiper_arr = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$swiper_arr = pixtheme_vc_get_params_array($atts, 'swiper');
extract( $atts );


$count = $count == '' ? '0' : $count;

$swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
$data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
$col = isset($swiper_options_arr['items']) != '' ? $swiper_options_arr['items'] : 3;
$swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($col);


if( $cats == '' ):
	$out = '<p>'.esc_html__('No categories selected. To fix this, please login to your WP Admin area and set the categories you want to show by editing this shortcode and setting one or more categories in the multi checkbox field "Categories".', 'pitstop');
else:

$out = '
<div class="pix-slider-container pix-nav-outside-left-right">
 
	<div class="pix-categories-list '.esc_attr($swiper_class).'" '.($data_swiper).'>
	    <div class="swiper-wrapper">';
    
    $cats_id_arr = array();
    foreach(explode( ",", $cats ) as $slug ){
        $term = get_term_by('slug', $slug, 'product_cat');
        if($term){
            $cats_id_arr[] = $term->term_id;
        }
        
    }
    $woo_args = array(
        'taxonomy'          => 'product_cat',
        'orderby'           => 'menu_order',
        'include'           => $cats_id_arr,
        'hide_empty'        => false,
        'parent'            => 0,
        'posts_per_page' 	=> -1,
    );
    $woo_categories = get_categories( $woo_args );
    
    foreach ($woo_categories as $cat) {

        $link = get_category_link( $cat->term_id );
        $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
        // get the image URL
        $image = '';
        if($show_image != 'off') {
            $image_arr = wp_get_attachment_image_src($thumbnail_id, 'medium', true);
            $image_src = isset($image_arr[0]) ? $image_arr[0] : '';
            $image = '<div class="pix-categories-item-img"><a href="'.esc_url($link).'"><img src="'.esc_url($image_src).'" alt="'.esc_attr($cat->name).'"></a></div>';
        }
        
        $out .= '
            <div class="pix-categories-item swiper-slide">
                <div class="pix-categories-item-inner">
                    '.wp_kses($image, 'post').'
                    <h5 class="pix-categories-item-title"><a href="'.esc_url($link).'">'.esc_attr($cat->name).'</a></h5>
                    <div class="pix-categories-item-links">
                        <ul>';
        
        $woo_sub_args = array(
            'taxonomy'     => 'product_cat',
            'orderby'      => 'menu_order',
            'parent'       => $cat->term_id
        );
        $woo_subcategories = get_categories( $woo_sub_args );
        $more_btn = $count > 0 && count($woo_subcategories) > $count ? '<a href="'.esc_url($link).'"><i class="fas fa-ellipsis-h"></i></a>' : '';
        
        $i=0;
        foreach ($woo_subcategories as $subcat) {
            $sub_count = $prod_number == 'on' && isset($subcat->count) && $subcat->count != '' ? ' <span>'.$subcat->count.'</span>' : '';
            if($i == $count){
                break;
            }
            $out .= '
                            <li><a href="'.get_category_link( $subcat->term_id ).'">'.esc_attr($subcat->name).' '.wp_kses($sub_count, 'post').'</a></li>
            ';
            $i++;
        }
	       
        $out .= '
                        </ul>
                        '.($more_btn).'
                    </div>
                </div>
            </div>';
    
    }

$out .= '
        </div>
	</div>
	<div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="pix-nav left-right high">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>';

endif;

pixtheme_out($out);