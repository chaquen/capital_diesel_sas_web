<?php /* Header Background Image tamplate */ ?>

<?php
	$title_class = $breadcrumbs_class = $term = $image = '';
	
	$pix_width_class = pixtheme_get_layout_width( get_post_type() );

	$bg_image = pixtheme_get_option('tab_bg_image', '');
	$tab_tone = pixtheme_get_option('tab_tone', get_option('pixtheme_default_tab_tone')) == '' ? 'text-white-color' : pixtheme_get_option('tab_tone', get_option('pixtheme_default_tab_tone'));
	$tab_position = pixtheme_get_option('tab_position', '') == '' ? 'center' : pixtheme_get_option('tab_position', '');
	$tab_hide = pixtheme_get_option('tab_hide', '');
	
	if( $tab_position != 'left_right' && $tab_position != 'right_left' ){
		$title_class = $breadcrumbs_class = 'text-'.$tab_position;
	} else {
	    if( $tab_position == 'left_right' ){
	        $title_class = 'pull-left';
	        $breadcrumbs_class = 'pull-right';
        } elseif( $tab_position == 'right_left' ){
	        $title_class = 'pull-right';
	        $breadcrumbs_class = 'pull-left';
        }
	}

	if ( class_exists( 'WooCommerce' ) && is_shop() ) {
        $thumbnail_id = get_post_thumbnail_id(wc_get_page_id('shop'));
        $image = wp_get_attachment_url( $thumbnail_id );
        $image = $image == '' ? $bg_image : $image;
	}elseif ( class_exists( 'WooCommerce' ) && is_product_category() ) {
        $image = '';
        $image = $bg_image;
	}elseif ( class_exists( 'WooCommerce' ) && is_product() && !empty($post->ID)) {
        $image = '';
        $image = $image == '' ? $bg_image : $image;
	}elseif ( is_home() || is_archive() || is_page_template('blog-template.php') ) {
        $term = isset ($wp_query) ? $wp_query->get_queried_object() : '';
        $image = '';
        if(isset($term->taxonomy) && $term->taxonomy == 'category') {
            $post_thumbnail_id = get_post_thumbnail_id($term->term_id);
            $image = wp_get_attachment_url( $post_thumbnail_id );
        }
        elseif(isset($term->term_id)){
            $image = get_option("pixtheme_tax_thumb".$term->term_id);
        }
        $image = $image == '' ? $bg_image : $image;
	}elseif ( is_single() && get_post_type($post->ID) == 'post' ) {
        $categories = get_the_category($post->ID);
        $image = '';
        if($categories){
            foreach($categories as $category) {
                $image = get_option('pixtheme_tax_thumb' . $category->term_id);
                if($image != '')
                    break;
            }
        }
        $image = $image == '' ? $bg_image : $image;
	}elseif( get_post_type() == 'page' ) {
        if( has_post_thumbnail() ){
            $post_thumbnail_id = get_post_thumbnail_id($post->ID);
            $post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
            $image = $post_thumbnail_url;

        } else {
            $image = $bg_image;
        }
	}else{
	    $image = $bg_image;
	}

	$image = $image == '' ? '' : 'style="background-image:url('.esc_url($image).');"';
?>
<!-- ========================== -->
<!-- Top header -->
<!-- ========================== -->
<div class="custom-header <?php echo esc_attr(pixtheme_get_option('tab_bg_image_fixed', '')) ?>" <?php echo wp_kses($image, 'post') ?> >
	<span class="vc_row-overlay"></span>
	<div class="<?php echo esc_attr($pix_width_class)?>">
	    <div class="row">
	        <div class="col-md-12">
		        <div class="pix-header-tab-box <?php echo esc_attr($tab_tone) ?>">

                    <?php if( $tab_hide != 'hide' && $tab_hide != 'hide_breadcrumbs' && pixtheme_get_option('tab_breadcrumbs_v_position', '') == 'over' ) : ?>
		            <div class="pix-header-breadcrumbs <?php echo esc_attr($breadcrumbs_class) ?>">
		                <?php pixtheme_show_breadcrumbs()?>
		            </div>
		            <?php endif ?>

		            <?php if( $tab_hide != 'hide'
                            && $tab_hide != 'hide_title'
                            && ( (pixtheme_get_option('tab_breadcrumbs_v_position', '') == 'over'
                                && class_exists('WooCommerce')
                                && !is_shop()
                                && !is_product_category()
                                && !is_product_tag() )
                                || !class_exists('WooCommerce')
                                || pixtheme_get_option('tab_breadcrumbs_v_position', '') == ''
                               )
                            ): ?>
		            <div class="pix-header-title <?php echo esc_attr($title_class) ?>">
		                <h1 class="pix-h1 pix-h1-h6 h2-size">
						<?php
						    $pixtheme_postpage_id = get_option('page_for_posts');
							$pixtheme_frontpage_id = get_option('page_on_front');
							$pixtheme_page_id = isset ($wp_query) ? $wp_query->get_queried_object_id() : '';
						
							if(is_single() && ! is_attachment()) {
                                echo get_the_title();
                            } elseif( class_exists( 'WooCommerce' ) && (is_shop() || is_product_category() || is_product_tag()) ) {
                                woocommerce_page_title();
                            } elseif( is_author() ) {
                                echo get_the_author();
                            } elseif( is_archive() && get_post_type() != 'post') {
							    if( !isset($term->label) )
							        echo esc_html($term->name);
							    else
                                    echo esc_html($term->label);
                            } elseif( is_404() ) {
							    esc_html_e('404', 'pitstop');
                            }elseif( $pixtheme_page_id == $pixtheme_frontpage_id  && $pixtheme_postpage_id == 0 ) {
							    esc_html_e('Latest Posts', 'pitstop');
                            } elseif( is_home() ) {
                                echo get_the_title($pixtheme_postpage_id);
                            } elseif( is_page_template( 'blog-template.php' ) ) {
                                echo get_the_title($pixtheme_page_id);
                            } elseif( is_search() ) {
                                echo get_search_query();
                            } elseif( is_category() ) {
                                echo single_cat_title();
                            } elseif( is_tag() ) {
                                echo single_tag_title();
                            } elseif( $pixtheme_page_id > 0 ) {
                                echo get_the_title($pixtheme_page_id);
                            } else {
                                echo get_the_title();
                            }
                        ?>
				        </h1>

				    </div>
				    <?php endif ?>

				    <?php if( $tab_hide != 'hide' && $tab_hide != 'hide_breadcrumbs' && pixtheme_get_option('tab_breadcrumbs_v_position', '') != 'over' && get_post_type() != 'post' ) : ?>
		            <div class="pix-header-breadcrumbs <?php echo esc_attr($breadcrumbs_class) ?>">
		                <?php pixtheme_show_breadcrumbs()?>
		            </div>
		            <?php endif ?>
                    
                    <?php if( is_single() && get_post_type() == 'post' ) : ?>
                    <div class="pix-header-breadcrumbs <?php echo esc_attr($breadcrumbs_class) ?>">
                        <?php if ( pixtheme_get_setting('pix-blog-author', 'on') == 'on-off' ) : ?>
                            <span class="author">
                                
                                <?php if ( pixtheme_get_setting('pix-blog-icons', get_option('pixtheme_default_blog_icons')) == 'on' ) : ?><i class="far fa-user"></i><?php endif; ?>
                                <a href="<?php echo esc_url(get_author_posts_url( $post->post_author )); ?>"><?php echo get_the_author_meta( 'user_nicename' , $post->post_author ); ?></a>
                            </span>
                        <?php endif; ?>
                        
                        <?php if ( pixtheme_get_setting('pix-blog-date', 'on') == 'on' ) : ?>
                            <?php if ( pixtheme_get_setting('pix-blog-author', 'on') == 'on-off' ) : ?>
                            <span class="dash">&mdash;</span>
                            <?php endif; ?>
                            <span>
                                <?php if ( pixtheme_get_setting('pix-blog-icons', get_option('pixtheme_default_blog_icons')) == 'on' ) : ?><i class="far fa-calendar-check"></i><?php endif; ?>
                                <?php echo sprintf( '<span>%s</span>', esc_attr( get_the_date() ) ); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php endif ?>
                    
	            </div>
	        </div>
	    </div>
	</div>

</div><!--./top header -->
