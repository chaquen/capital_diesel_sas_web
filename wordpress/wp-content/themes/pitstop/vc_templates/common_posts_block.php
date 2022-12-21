<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Posts_Block
 */
$swiper_arr = $shadows_arr = array();
$out = $out_news = $cats = $radius = $greyscale = $count = $col = $img_proportions = $hover_icon = '';
$title_size = 'pix-title-l';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$swiper_arr = pixtheme_vc_get_params_array($atts, 'swiper');
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );



$count = $count == '' ? '3' : $count;
$style = !isset($style) || $style == '' ? 'pix-news-slider' : $style;
$greyscale = ($greyscale == 'off') ? '' : 'pix-img-greyscale';
$shadow_class = pixtheme_get_shadow($shadows_arr);
$hover_icon = ( $hover_icon != '' ) ? 'pix-hover-icon-'.$hover_icon : '';

$col = 3;
$image_size = $img_proportions;
if($col == 3){
    $image_size .= '-col-3';
} elseif($col > 3) {
    $image_size .= '-col-4';
}
$image_size .= pixtheme_retina() ? '-retina' : '';

$args = array(
    'ignore_sticky_posts' => true,
    'showposts' => $count,
);
if($cats != '') {
    $cats = explode(",", $cats);

    $args = array(
        'ignore_sticky_posts' => true,
        'showposts' => $count,
        'post_type' => 'post',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $cats
            )
        ),
    );
}

$wp_query = new WP_Query( $args );
			 					
if ($wp_query->have_posts()):
    $i=0;
    $cnt = $wp_query->post_count;

    while ($wp_query->have_posts()) :
        $wp_query->the_post();
        $custom = get_post_custom(get_the_ID());
        $i++;
        
        $date = $author = $comments = '';
        
        $cat = array();
        if(pixtheme_get_option('blog_show_category', '1')){
            $categories = get_the_category(get_the_ID());
            if($categories){
                foreach($categories as $category) {
                    if($category->slug != 'uncategorized') {
                        if ($style == 'pix-news-slider') {
                            $cat[] = '<div class="pix-news-btn"><a href="' . esc_url(get_category_link($category->term_id)) . '" class="pix-button pix-cat-link">' . ($category->cat_name) . '</a></div>';
                        } elseif($style == 'news-card-gradient') {
                            $cat[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="pix-h-s pix-v-xs pix-font-s">' . ($category->cat_name) . '</a>';
                        } else {
                            $cat[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="pix-button pix-round pix-h-s pix-v-xs pix-font-s">' . ($category->cat_name) . '</a>';
                        }
                    }
                }
            }
        }
        if(pixtheme_get_option('blog_show_date', '1')){
            $date = '<a href="'.esc_url(get_the_permalink()).'">'.(get_the_date()).'</a>';
        }
        if(pixtheme_get_option('blog_show_author', '1')){
            $author = get_the_author_posts_link();
        }
        
        $num_comments = get_comments_number();
        if ( comments_open() ) {
            if ( $num_comments == 0 ) {
                $comments_text = esc_html__( 'No comments', 'pitstop' );
            } elseif ( $num_comments > 1 ) {
                $comments_text = $num_comments . esc_html__( ' comments', 'pitstop' );
            } else {
                $comments_text = esc_html__( '1 comment', 'pitstop' );
            }
            $comments = '<i class="fas fa-comments"></i> <a href="' . get_comments_link() .'">'. $comments_text.'</a>';
        }

        $thumbnail = get_the_post_thumbnail( get_the_ID() ) != '' ? get_the_post_thumbnail( get_the_ID(), 'medium' ) : '<img src="'.esc_url(get_template_directory_uri()).'/images/no_image.png">';

        if($style == 'pix-news-slider'){
        $out_news .= '
            <div class="pix-news-item swiper-slide '.esc_attr($shadow_class).' pix-overlay-container">
                <div class="pix-news-img">
                    '.($thumbnail).'
                </div>
                <div class="pix-news-info">
                    <div class="pix-news-author-date">'.($date).'</div>
                    <div class="pix-news-title '.esc_attr($title_size).'">
                        <a href="'.esc_url(get_the_permalink()).'" class="pix-title-link">'.(get_the_title()).'</a>
                    </div>
                    <div class="pix-news-text">
                        <p>'.pixtheme_limit_words(get_the_excerpt(), 50).'</p>
                    </div>
                    <div class="pix-overlay-item pix-bottom pix-left">
                        '.(implode($cat)).'
                    </div>
                </div>
            </div>';
        } else {
        $out_news .= '
            <div class="swiper-slide '.esc_attr($style).' '.esc_attr($shadow_class).' pix-overlay-container">';
            if($style == 'news-card-long') {
                $out_news .= '
                    <div class="news-card-long__image ">
                        <a class="icon-zoom" href="'.esc_url(get_the_permalink()).'"></a>
                        <div class="overlay"></div>
                        '.($thumbnail).'
                    </div>
                    <div class="news-card-long__text">
                        <div class="'.esc_attr($title_size).'"><a href="'.esc_url(get_the_permalink()).'" class="pix-title-link">'.(get_the_title()).'</a></div>
                        <span class="news-date">'.($date).'</span>
                        <p>'.pixtheme_limit_words(get_the_excerpt(), 50).'</p>
                    </div>';
            } elseif($style == 'pix-news-high') {
                $out_news .= '
                    <div class="pix-box-img">
                        <a href="'.esc_url(get_the_permalink()).'">
                            <div class="pix-overlay '.esc_attr($hover_icon).'"></div>
                            '.($thumbnail).'
                        </a>
                        
                        <div class="pix-hover-item pix-top pix-left pix-translate">'.(implode($cat)).'</div>
                        <div class="pix-hover-item pix-bottom pix-left pix-translate"><i class="far fa-user"></i> '.($author).'</div>
                    </div>
                    <div class="news-card-centered__text">
                        <div class="'.esc_attr($title_size).'"><a href="'.esc_url(get_the_permalink()).'" class="pix-main-color-hover-link">'.(get_the_title()).'</a></div>
                        <p>'.pixtheme_limit_words(get_the_excerpt(), 50).'</p>
                        <div class="pix-box-footer">
                            <div class="pix-categories"><i class="fas fa-clock"></i> '.($date).'</div>
                            <div class="pix-comments">'.( $comments ).'</div>
                        </div>
                    </div>';
            } elseif($style == 'news-card-centered') {
                $out_news .= '
                    <div class="news-card-centered__image">
                        <span class="news-date">'.($date).'</span>
                        <a href="'.esc_url(get_the_permalink()).'">'.pixtheme_limit_words(get_the_excerpt(), 50).'</a>
                        <div class="overlay"></div>
                        '.($thumbnail).'
                    </div>
                    <div class="news-card-centered__text">
                        <div class="mt-0 mb-0 '.esc_attr($title_size).'"><a href="'.esc_url(get_the_permalink()).'" >'.(get_the_title()).'</a></div>
                    </div>';
            } else {
                $out_news .= '
                    <div class="'.esc_attr($title_size).'"><a href="'.esc_url(get_the_permalink()).'" class="pix-title-link">'.(get_the_title()).'</a></div>
                    <div class="news-info">
                        <span class="news-info__category"><i class="far fa-folder"></i>'.(implode(', ', $cat)).'</span>
                        <span class="news-info__date"><i class="far fa-calendar-check"></i>'.($date).'</span>
                    </div>
                    '.($thumbnail).'
                    <div class="gradient-bg"></div>';
            }
        $out_news .= '            
            </div>';
        }

    endwhile;

endif;

wp_reset_postdata();

$swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
$data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
$nav_enable = isset($swiper_options_arr['navigation']) && !$swiper_options_arr['navigation'] ? 'disabled' : '';
$page_enable = isset($swiper_options_arr['pagination']) && !$swiper_options_arr['pagination'] ? 'disabled' : '';
$col = isset($swiper_options_arr['items']) ? $swiper_options_arr['items'] : 4;
$swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($col);

$class_container = $style == 'pix-news-slider' ? $style : ($style.'__carousel');

$out = '
<div class="pix-swiper">
	<div class="'.esc_attr($class_container).' '.esc_attr($swiper_class).' '.esc_attr($radius).' '.esc_attr($greyscale).'" '.($data_swiper).'>
		<div class="swiper-wrapper">
        	'.($out_news).'
        </div>
	</div>
	<div class="pix-nav left-right '.esc_attr($nav_enable).'">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <div class="pix-swiper-pagination swiper-pagination '.esc_attr($page_enable).'"></div>
</div>';

pixtheme_out($out);