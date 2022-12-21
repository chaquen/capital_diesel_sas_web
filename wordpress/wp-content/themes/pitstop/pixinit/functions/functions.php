<?php

function pixtheme_site_menu($class = null) {
    if ( function_exists('wp_nav_menu') && has_nav_menu( 'primary_nav' ) && class_exists( 'PixThemeSettings' ) ) {
        wp_nav_menu(array(
            'theme_location' => 'primary_nav',
            'container' => false,
            'menu_class' => $class,
            'walker' => new Pix_Nav_Menu_Walker(),
        ));
    } elseif ( function_exists('wp_nav_menu') && has_nav_menu( 'primary_nav' ) ) {
        wp_nav_menu(array(
            'theme_location' => 'primary_nav',
            'container' => false,
            'menu_class' => $class,
            'walker' => new PixTheme_Walker_Menu(),
        ));
    } else {
        ?>
        <ul class="main-menu nav navbar-nav">
            <li>
                <a target="_blank" href="<?php echo esc_url( admin_url() . 'nav-menus.php#locations-primary_menu' ) ?>">
                    <?php esc_html_e( 'Please, set Primary Menu.', 'pitstop' ); ?>
                </a>
            </li>
        </ul>
        <?php
    }
}

function pixtheme_no_notice($var) {
    if (isset($var) && $var != '')
        return 1;
    else
        return 0;
}

function pixtheme_terms_tree(Array &$cats, Array &$into, $parentId = 0, $lvl=0, $max_lvl=0){
    
    $max_lvl = $lvl > $max_lvl ? $lvl : $max_lvl;
    
    foreach ($cats as $i => $cat) {
        if ($cat->parent == $parentId) {
            $cat->level = $lvl;
            $into[$cat->term_id] = $cat;
            unset($cats[$i]);
        }
    }

    foreach ($into as $topCat) {
        $topCat->children = [];
        $max_lvl = pixtheme_terms_tree($cats, $topCat->children, $topCat->term_id, $topCat->level+1, $max_lvl);
    }
    
    return $max_lvl;
}

function pixtheme_show_breadcrumbs(){
    if( class_exists('WooCommerce') && ( is_shop() || is_product_category() || is_product_tag() || is_product() ) ){
        woocommerce_breadcrumb();
    } elseif ( function_exists( 'pixtheme_breadcrumbs' ) && !is_page_template( 'page-home.php' ) ){
        pixtheme_breadcrumbs();
    }
}

function pixtheme_category_tree( $category = 0, $current_term_id = false, $current_term_parents = [] ) {
    
    $args = array(
        'parent' => $category,
    );

    $next = get_terms('product_cat', $args);
    
    if( $next ) {
        
        foreach ($next as $cat) {
            $has_children = get_term_children( $cat->term_id, 'product_cat' );
            $current_add_class_attr = ( $current_term_id === $cat->term_id ) ? 'class="active"' : '';
            echo '<li class="menu-item '.( in_array( $cat->term_id, $current_term_parents ) ? 'purple' : '').' '.( !empty($has_children) ? 'menu-item-has-children js-mobile-menu' : '' ).'"><a href="'.esc_url( get_category_link( $cat->term_id ) ).'" '. $current_add_class_attr.'>'.esc_html( $cat->name ).'</a>';
            if($cat->term_id !== 0 && !empty($has_children)){
                echo '<ul class="mobile-submenu">';
                pixtheme_category_tree($cat->term_id, $current_term_id, $current_term_parents);
                echo '</ul>';
                echo '<i class="fa fa-angle-down" aria-hidden="true"></i>';
            }
            echo '</li>';
        }
        
    }
    
    echo "\n";
}

// numbered pagination
function pixtheme_num_pagination( $pages = '', $range = 2 ) {
	 $showitems = ( $range * 2 ) + 1;

	 global $paged;
	 if ( empty( $paged ) )  { $paged = 1; }

	 if ( $pages == '' )
	 {
		 global $wp_query;
		 $pages = $wp_query->max_num_pages;
		 if ( ! $pages ) { $pages = 1; }
	 }

	 if ( 1 != $pages )
	 {
		 echo '<div class="navigation pagination text-center"><ul>';

		 if ( $paged > 1 && $showitems < $pages ) echo '<li><a href="' . esc_url( get_pagenum_link( esc_html( $paged ) - 1 ) ) . '"><i class="fa-chevron-left"></i></a></li>';

		 for ( $i = 1; $i <= $pages; $i++ )
		 {
			 if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) )
			 {
				if ( $paged == $i ) {
				    echo '<li class="page-current	"><a>' . $i . '</a></li>';
                } else {
				    echo '<li><a href="' . esc_url( get_pagenum_link($i) ) . '">' . esc_html( $i ) . '</a></li>';
                }
			 }
		 }

		 if ( $paged < $pages && $showitems < $pages ) echo '<li><a href="' . esc_url( get_pagenum_link( esc_html( $paged ) + 1 ) ) . '"><i class="fa-chevron-right"></i></a></li>';

		 echo '</ul></div>';
	 }
}

function pixtheme_wp_get_attachment( $attachment_id ) {
	$attachment = get_post( $attachment_id );
	return array(
		'alt' => is_object($attachment) ? get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) : '',
		'caption' => is_object($attachment) ? $attachment->post_excerpt : '',
		'description' => is_object($attachment) ? $attachment->post_content : '',
		'href' => is_object($attachment) ? get_permalink( $attachment->ID ) : '',
		'src' => is_object($attachment) ? $attachment->guid : '',
		'title' => is_object($attachment) ? $attachment->post_title : ''
	);
}

function pixtheme_post_read_more(){
    $btn_name = pixtheme_get_option('blog_settings_readmore');
    $name = ($btn_name) ? $btn_name : esc_html__('Read More','pitstop');
    return esc_attr($name);
}

function pixtheme_show_sidebar($type, $layout, $sidebar) {

	$layouts = array(
		1 => 'full',
		2 => 'right',
		3 => 'left',
	);
	
	$padding = pixtheme_get_setting('pix-blog-sidebar', 'no-padding');

	if ( isset($layouts[$layout]) && $type === $layouts[$layout] ) {
		echo '<div class="col-xx-2 col-xl-3 col-lg-4 col-md-4 d-xl-block pl-0 pr-0"><div class="pix-sidebar pix-'.esc_attr($padding).'">';
		if ( is_active_sidebar( $sidebar ) ) : dynamic_sidebar( $sidebar ); endif;
		echo '</div></div>';
	} else {
		echo '';
	}

}

function pixtheme_limit_words($string, $word_limit, $wrapper = '') {
    
    $wrapper_start = $wrapper_end = '';
    if(trim($wrapper) != '') {
        $wrapper_start = '<' . $wrapper . '>';
        $wrapper_end = '</' . $wrapper . '>';
    }
    
	// creates an array of words from $string (this will be our excerpt)
	// explode divides the excerpt up by using a space character

	$words = explode(' ', $string);

	// this next bit chops the $words array and sticks it back together
	// starting at the first word '0' and ending at the $word_limit
	// the $word_limit which is passed in the function will be the number
	// of words we want to use
	// implode glues the chopped up array back together using a space character
 	if(trim($string) == '') {
        return '';
    } else {
 	    $ellipsis = str_word_count(trim($string)) <= $word_limit ? '' : '...';
        return $wrapper_start . implode(' ', array_slice($words, 0, $word_limit)) . $ellipsis . $wrapper_end;
    }
}

function pixtheme_get_post_terms( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id'    => get_the_ID(),
		'taxonomy'   => 'category',
		'text'       => '%s',
		'before'     => '',
		'after'      => '',
		'items_wrap' => '<span>%s</span>',
		'sep'        => _x( ', ', 'taxonomy terms separator', 'pitstop' )
	);

	$args = wp_parse_args( $args, $defaults );

	$terms = get_the_term_list( $args['post_id'], $args['taxonomy'], '', $args['sep'], '' );

	if ( !empty( $terms ) ) {
		$html .= $args['before'];
		$html .= sprintf( $args['items_wrap'], sprintf( $args['text'], $terms ) );
		$html .= $args['after'];
	}

	return $html;
}

function pixtheme_countdown($from, $to, $is_str = true){
    
    $until = false;
    if($is_str){
        $from = strtotime($from);
        $to = strtotime($to);
    }
    
    if( $to > strtotime(date("Y-m-d H:i:s")) && ($from == '' || (strtotime(date("Y-m-d H:i:s")) >= $from) ) ){
        $until = date("m/d/Y", $to);
    }
    
    return $until;

}

function pixtheme_range_price_format(){
    
    $currency_pos = get_option( 'woocommerce_currency_pos' );
	$symbol       = get_woocommerce_currency_symbol();

	switch ( $currency_pos ) {
		case 'left':
			$data = 'data-prefix="'.$symbol.'"';
			break;
		case 'right':
			$data = '"data-postfix="'.$symbol.'""';
			break;
		case 'left_space':
			$data = 'data-prefix="'.$symbol.'&nbsp;';
			break;
		case 'right_space':
			$data = 'data-postfix="&nbsp;'.$symbol.'"';
			break;
        default:
            $data = 'data-prefix="'.$symbol.'"';
			break;
	}

	return $data;

}

function pixtheme_tooltip($text){
    $out = '<span class="pix-tooltip">
                <span class="pix-tooltip-inner">
                    <span class="pix-tooltip-text">'.$text.'</span>
                    <span class="pix-tooltip-arrow"></span>
                </span>
            </span>';
    
    return $out;
}

function pixtheme_hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    //return $rgb; // returns an array with the rgb values
    return implode(",", $rgb); // returns the rgb values separated by commas
}

function pixtheme_lighten_darken_color($hex, $amt) {
    
    $hex = str_replace("#", "", $hex, $count);
    $usePound = false;
    
    if ($count > 0) {
        $usePound = true;
    }
    
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    
    $r = $r + $amt;
    
    if ($r > 255) {
        $r = 255;
    } elseif($r < 0) {
        $r = 0;
    }
    
    $g = $g + $amt;
    
    if ($g > 255) {
        $g = 255;
    } elseif($g < 0) {
        $g = 0;
    }
    
    $b = $b + $amt;
    
    if ($b > 255) {
        $b = 255;
    } elseif($b < 0) {
        $b = 0;
    }
    
    return esc_attr( ($usePound ? "#" : "") . sprintf("%02X%02X%02X", $r, $g, $b) );
    //return esc_attr( ($usePound ? "#" : "") . dechex(($r<<16)|($g<<8)|$b ) );
    
}

function pixtheme_echo_if_not_empty($string, $value){
    if($value != ''){
        return $string;
    } else
        return '';
}


function pixtheme_get_tax_level($id, $tax){
    $ancestors = get_ancestors($id, $tax);
    return count($ancestors)+1;
}


function pixtheme_breadcrumbs() {
	global $delimiter;
	/* === Options === */

	$text['home'] = esc_html__('Home', 'pitstop');
	$text['category'] = esc_html__('Archive "%s"', 'pitstop');
	$text['search'] = esc_html__('Search results for "%s"', 'pitstop');
	$text['tag'] = esc_html__('Posts with tag "%s"', 'pitstop');
	$text['author'] = esc_html__('%s posts', 'pitstop');
	$text['404'] = esc_html__('Error 404', 'pitstop');
	$text['page'] = esc_html__('Page %s', 'pitstop');
	$text['cpage'] = esc_html__('Comments page %s', 'pitstop');

	$delimiter = '<i class="pix-flaticon-arrow-angle-pointing-to-right"></i>';
	$delim_before = '&nbsp;&nbsp;';
	$delim_after = '&nbsp;&nbsp;';
	$show_home_link = 1;
	$show_on_home = 1;
	$show_title = 1;
	$show_current = pixtheme_get_option('tab_breadcrumbs_current', 0);
	$before = '';
	$after = '';
	/* === End options === */
	
	global $post;
	$home_link = esc_url(home_url('/'));
	$link_before = '';
	$link_after = '';
	$link_attr = '';
	$link_in_before = '';
	$link_in_after = '';
	$link = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
	$frontpage_id = get_option('page_on_front');
	$parent_id = isset($post) ? $post->post_parent : '';
	$delimiter = $delim_before . $delimiter . $delim_after;
	
	function pix_show_current($title, $show_current = true){
	    global $delimiter, $before, $after;
	    if ($show_current) {
	        pixtheme_out($delimiter);
            pixtheme_out($before . $title . $after);
        }
    }
    
    function pix_get_breadcrumbs_children( $parent_id, $bc_items=array(), $lvl=0, $depth=true ) {
        $term = get_term($parent_id);
        $bc_items[$lvl] = $term;
        if( is_object($term) && $term->parent > 0 ){
            $bc_items = pix_get_breadcrumbs_children( $term->term_id, $bc_items, ($lvl+1) );
        }
        return $bc_items;
    }
	
	if ( is_home() || is_front_page() ) {

		if ($show_on_home == 1) echo '<div class="pix-breadcrumbs-path">' . sprintf($link, $home_link, $text['home']) . '</div>';

	} else {

		echo '<div class="pix-breadcrumbs-path">';
		if ( $show_home_link == 1 /*&& (!is_page() && !$parent_id) && !is_404()*/ ) echo sprintf($link, $home_link, $text['home']);

		if ( is_category() ) {
            $cat = get_category(get_query_var('cat'), false);
            if ($cat->parent != 0) {
                $cats = get_category_parents($cat->parent, TRUE, $delimiter);
                $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                if ($show_title == 0)
                    $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                if ($show_home_link == 1) pixtheme_out($delimiter);
                    pixtheme_out($cats);
            }
            if ( get_query_var('paged') ) {
                $cat = $cat->cat_ID;
                pixtheme_out($delimiter . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after);
            } else {
                pix_show_current(sprintf($text['category'], single_cat_title('', false)), $show_current);
            }

        } elseif ( is_search() ) {
            if ($show_home_link == 1) pixtheme_out($delimiter);
            pixtheme_out($before . sprintf($text['search'], get_search_query()) . $after);

        } elseif ( is_day() ) {
            if ($show_home_link == 1) pixtheme_out($delimiter);
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
            pixtheme_out($before . get_the_time('d') . $after);

        } elseif ( is_month() ) {
            if ($show_home_link == 1) pixtheme_out($delimiter);
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            pixtheme_out($before . get_the_time('F') . $after);

        } elseif ( is_year() ) {
            if ($show_home_link == 1) pixtheme_out($delimiter);
            pixtheme_out($before . get_the_time('Y') . $after);

        } elseif ( is_tax() ) {
		    
            if ($show_home_link == 1) pixtheme_out($delimiter);
            
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            
            $tax_arr = array( 'pix-service-cat', 'pix-portfolio-cat', 'pix-team-cat', 'pixcar-make' );
            
            $term_tax = isset($term->taxonomy) ? $term->taxonomy : '';
            if( in_array( $term_tax, $tax_arr ) ){
                
                if ( isset($term->parent) && $term->parent != 0) {
                    $cats = pix_get_breadcrumbs_children($term->parent);
                    foreach($cats as $cat){
                        echo sprintf($link, get_category_link($cat), $cat->name) . $delimiter;
                    }
                }
                if ( get_query_var('paged') ) {
                    $cat = $term->term_id;
                    pixtheme_out($delimiter . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after);
                } else {
                    pix_show_current($term->name, $show_current);
                }
            } else {
                $cat = get_the_category();
                if(!empty($cat)) {
					$cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, ',');
					$cats = preg_replace("#^(.+),$#", "$1", $cats);
					$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $cats);
					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					pixtheme_out($cats);
				} else {
					echo esc_html__('No Categories', 'pitstop');
				}
                if ( get_query_var('cpage') ) {
                    pixtheme_out($delimiter . sprintf($link, get_permalink(), get_the_title()) . $delimiter . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after);
                } else {
                    pix_show_current(get_the_title(), $show_current);
                }
            }

        // custom post type
        } elseif ( is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
		    
		    if ($show_home_link == 1) pixtheme_out($delimiter);

            $tax_arr = array(
                'pix-service' => 'pix-service-cat',
                'pix-portfolio' => 'pix-portfolio-cat',
                'pix-team' => 'pix-team-cat',
                'pixcar' => 'pixcar-make'
            );
            
            $tax_page_arr = array(
                'pix-service' => 'pix-service-page',
                'pix-portfolio' => 'pix-portfolio-page',
                'pix-team' => 'pix-team-page',
                'pixcar' => 'cars-page'
            );
            
            $post_type = get_post_type();
            if( array_key_exists( $post_type, $tax_arr ) ){
                
                $term_cats = wp_get_object_terms(get_the_ID(), 'pixcar-cat');
                
                if( !is_wp_error( $term_cats ) && !empty($term_cats) && isset($term_cats[0]->slug) ){
                    global $pixcars;
                    $pix_cat_slug = 'cars-page-'.$term_cats[0]->slug;
                    $pixtheme_all_page = $pixcars->settings->get_setting($pix_cat_slug);
                } elseif($post_type == 'pixcar') {
                    global $pixcars;
                    $pixtheme_all_page = $pixcars->settings->get_setting($tax_page_arr[$post_type]);
                } else {
                    $pixtheme_all_page = pixtheme_get_setting($tax_page_arr[$post_type], '0');
                }
                
                if ( $pixtheme_all_page != 0 ) {
                    echo sprintf($link, get_the_permalink($pixtheme_all_page), get_the_title($pixtheme_all_page)) . $delimiter;
                }
                
                $cats = wp_get_object_terms($post->ID, $tax_arr[$post_type]);
                
                $cats_lvls = array();
                if (!is_wp_error($cats)){
                    foreach( $cats as $cat ){
                        
                        $current_term_level = pixtheme_get_tax_level( $cat->term_id, $cat->taxonomy );
                        $cats_lvls[$current_term_level][] = $cat;
                        if ( isset($cat->parent) && $cat->parent != 0) {
                            $terms = pix_get_breadcrumbs_children($cat->parent);
                            foreach($terms as $term){
                                $current_term_level = pixtheme_get_tax_level( $term->term_id, $term->taxonomy );
                                $cats_lvls[$current_term_level][] = $term;
                            }
                        }
                        
                    }
                }
                
                $i=0;
                foreach( $cats_lvls as $lvl => $cats ){
                    $i++;
                    $j=0;
                    foreach( $cats as $cat ){
                        $j++;
                        echo sprintf($link, get_category_link($cat), $cat->name);
                        if(count($cats) > $j){
                            echo ', ';
                        }
                    }
                    if(count($cats_lvls) > $i){
                        echo wp_kses($delimiter, 'post');
                    }
                }
                
                pix_show_current(get_the_title(), $show_current);
                
            } else {
                $cat = get_the_category();
                if(!empty($cat)) {
					$cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, ',');
					$cats = preg_replace("#^(.+),$#", "$1", $cats);
					$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $cats);
					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					pixtheme_out($cats);
				} else {
					echo esc_html__('No Categories', 'pitstop');
				}
                if ( get_query_var('cpage') ) {
                    pixtheme_out($delimiter . sprintf($link, get_permalink(), get_the_title()) . $delimiter . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after);
                } else {
                    pix_show_current(get_the_title(), $show_current);
                }
            }

        } elseif ( is_attachment() ) {
            if ($show_home_link == 1) pixtheme_out($delimiter);
            $parent = get_post($parent_id);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            if ($cat) {
                $cats = get_category_parents($cat, TRUE, $delimiter);
                $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                pixtheme_out($cats);
            }
            printf($link, get_permalink($parent), $parent->post_title);
            pix_show_current(get_the_title(), $show_current);

        } elseif ( is_page() && !$parent_id ) {

            pix_show_current(get_the_title(), $show_current);

        } elseif ( is_page() && $parent_id ) {

            if ($show_home_link == 1) pixtheme_out($delimiter);
            if ($parent_id != $frontpage_id) {
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    if ($parent_id != $frontpage_id) {
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    }
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    pixtheme_out($breadcrumbs[$i]);
                    if ($i != count($breadcrumbs)-1) pixtheme_out($delimiter);
                }
            }
            pix_show_current(get_the_title(), $show_current);

        } elseif ( is_tag() ) {
		    pix_show_current(sprintf($text['tag'], single_tag_title('', false)), $show_current);

        } elseif ( is_author() ) {
            if ($show_home_link == 1) pixtheme_out($delimiter);
            global $author;
            $author = get_userdata($author);
            pixtheme_out($before . sprintf($text['author'], $author->display_name) . $after);

        } elseif ( is_404() ) {
            if ($show_current == 1){
                if ($show_home_link == 1) pixtheme_out($delimiter);
                pixtheme_out($before . $text['404'] . $after);
            }

        } elseif ( has_post_format() && !is_singular() ) {
            if ($show_home_link == 1) pixtheme_out($delimiter);
            echo get_post_format_string( get_post_format() );
        }

		echo '</div><!-- .breadcrumbs -->';

 	}
	
} // end pixtheme_breadcrumbs()