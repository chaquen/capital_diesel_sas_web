<?php /* Header Type 3 */
	$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : get_the_ID();
	if( class_exists( 'WooCommerce' ) && pixtheme_is_woo_page() && pixtheme_get_option('woo_header_global','1') ){
		$post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
	} elseif (!is_page_template('page-home.php') && get_option('page_for_posts') && pixtheme_get_option('header_like_blog','0')){
		$post_ID = get_option('page_for_posts') ? get_option('page_for_posts') : 0;
	}

	$pixtheme_header = apply_filters('pixtheme_header_settings', $post_ID);
	$pixtheme_header['header_background'] = $pixtheme_header['header_background'] == '' ? 'white' : $pixtheme_header['header_background'];
	$pixtheme_header_transparent = $pixtheme_header['header_transparent'] < 100 ? 'transparent' : '';
	$pixtheme_header['header_background_bottom'] = $pixtheme_header['header_background_bottom'] == '' ? 'white' : $pixtheme_header['header_background_bottom'];
    $pixtheme_header_transparent_bottom = pixtheme_get_option('header_transparent_bottom', '100') < 100 ? 'transparent' : '';
	$pixtheme_logo = isset($pixtheme_header['logo']) && $pixtheme_header['logo'] != '' ? $pixtheme_header['logo'] : get_template_directory_uri().'/images/logo.svg';
	$pixtheme_header['top_bar_background'] = $pixtheme_header['top_bar_background'] == '' ? 'black' : $pixtheme_header['top_bar_background'];
	$pixtheme_top_bar_transparent = $pixtheme_header['top_bar_transparent'] < 100 ? 'transparent' : '';

	$pixtheme_logo_stl = pixtheme_get_option('general_settings_logo_width', get_option('pixtheme_default_logo_width')) != '' ? 'width:'.esc_attr(pixtheme_get_option('general_settings_logo_width', get_option('pixtheme_default_logo_width'))).'px;' : '';
	$pixtheme_logo_stl = $pixtheme_logo_stl != '' ? 'style="'.($pixtheme_logo_stl).'"' : '';

	$pixtheme_logo_text = pixtheme_get_option('general_settings_logo_text') != '' ? '<div class="logo-text">'.pixtheme_get_option('general_settings_logo_text').'</div>' : '';
	

?>

	<header class="pix-header pix-levels pix-header-catalog <?php echo esc_attr($pixtheme_header['header_background']) ?> <?php echo esc_attr( $pixtheme_header_transparent ) ?> <?php echo esc_attr($pixtheme_header['header_sticky']) ?> <?php if ($pixtheme_header['header_bar']) : ?>header-topbar-view<?php endif; ?>">
    
    <?php
    if ($pixtheme_header['header_bar']) {
        get_template_part('templates/header/header_top');
    }
    ?>
    
        <div class="<?php echo esc_attr($pixtheme_header['header_layout']) ?>">

            <div class="menu-logo">
                <a class="navbar-brand scroll" href="<?php echo esc_url(home_url('/')) ?>" <?php echo wp_kses($pixtheme_logo_stl, 'post')?>>
                    <img class="pix-header-logo" src="<?php echo esc_url($pixtheme_logo) ?>" alt="<?php esc_attr_e('Logo', 'pitstop') ?>"/>
                </a>
                <?php echo wp_kses($pixtheme_logo_text, 'post'); ?>
            </div>

            <nav class="pix-main-menu <?php echo esc_attr($pixtheme_header['header_menu_pos']) ?>">
                <?php echo wp_kses(pixtheme_site_menu( 'nav navbar-nav ' ), 'post'); ?>
            </nav>
            
            <nav class="pix-header-icons">
                <ul class="main-menu-elements">
                <?php if(class_exists('WOOCS') && $pixtheme_header['header_currency']) : ?>
                    <li class="pix-header-currency">
                        <?php echo do_shortcode('[woocs]'); ?>
                    </li>
                <?php endif; ?>
                <?php if (class_exists('YITH_Woocompare') && $pixtheme_header['header_compare']) : ?>
                    <?php
                        global $yith_woocompare;
                        $compare_class = isset($yith_woocompare->obj) && count($yith_woocompare->obj->products_list) > 0 ? '' : 'empty';
                    ?>
                    <li id="compare" class="pix-compare product <?php echo esc_attr($compare_class)?>">
                        <span>
                            <a href="/?action=yith-woocompare-view-table&iframe=yes" class="compare added"><i class="pix-flaticon-statistics"></i></a>
                            <span class="badge"><?php echo count($yith_woocompare->obj->products_list) ?></span>
                        </span>
                    </li>
                <?php endif; ?>
                <?php if (class_exists('YITH_WCWL') && $pixtheme_header['header_wishlist']) : ?>
                    <?php
                        $wish_class = yith_wcwl_count_products() > 0 ? '' : 'empty';
                    ?>
                    <li id="like" class="<?php echo esc_attr($wish_class)?>">
                        <span>
                            <a href="<?php echo get_permalink(get_option( 'yith_wcwl_wishlist_page_id' )) ?>"><i class="pix-flaticon-like"></i></a>
                            <span class="badge"><?php echo yith_wcwl_count_products() ?></span>
                        </span>
                    </li>
                <?php endif; ?>
                <?php if (class_exists('WooCommerce') && $pixtheme_header['header_minicart']) : ?>
                    <?php
                        $cart_class = WC()->cart->cart_contents_count > 0 ? '' : 'empty';
                    ?>
                    <li id="cart" class="<?php echo esc_attr($cart_class)?>">
                        <span>
                            <a href="#pix4"><i class="pix-flaticon-shopping-bag-3"></i></a>
                            <span class="pix-cart badge"><?php echo WC()->cart->cart_contents_count; ?></span>
                        </span>
                        <div class="pix-header-cart">
                        
                        </div>
                    </li>
                <?php endif; ?>
                <?php if ($pixtheme_header['header_account']) : ?>
                    <li id="user" <?php if( is_user_logged_in() ) { echo 'class="logged-in"'; } ?>>
                        <span>
                            <?php if( !is_user_logged_in() || has_nav_menu( 'account_nav' ) ) : ?>
                            <a href="#pix5"><i class="pix-flaticon-user"></i></a>
                            <?php else: ?>
                            <a href="<?php echo esc_url(wc_get_page_permalink( 'myaccount' )) ?>" title="<?php esc_html_e('My Account', 'pitstop') ?>"><i class="pix-flaticon-user"></i></a>
                            <?php endif; ?>
                        </span>
                        <?php if( !is_user_logged_in() ) : ?>
                        <div class="pix-header-user">
                            <div class="pix-header-user-tabs"><a class="active" href="#pix-userLogin"><?php esc_html_e('Login', 'pitstop') ?></a><a
                                        href="#pix-userRegister"><?php esc_html_e('Register', 'pitstop') ?></a></div>
                            <div class="pix-header-user-panel active" id="pix-userLogin">
                                <?php
                                wp_login_form(
                                    array(
                                        'echo' => true,
                                        'label_username' => __( 'Your Username ' ),
                                        'label_password' => __( 'Your Password' ),
                                        'label_remember' => __( 'Remember Me' )
                                    )
                                );
                                ?>
                                <form name="loginform" id="loginform" action="<?php esc_url( home_url() ) ?>/wp-login.php" method="post">
                                    <div class="form-group mb-10">
                                        <label><?php esc_html_e('Username or email', 'pitstop') ?><span>*</span></label>
                                        <input class="form-control form-control-sm" type="text" name="log" id="user_login">
                                    </div>
                                    <div class="form-group mb-10">
                                        <label><?php esc_html_e('Password', 'pitstop') ?><span>*</span></label>
                                        <input class="form-control form-control-sm" type="password" name="pwd" id="user_pass">
                                    </div>
                                    <div class="form-group mb-10 form-check">
                                        <input class="form-check-input" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                                        <label class="form-check-label" for="rememberme"><?php esc_html_e('Remember me', 'pitstop') ?></label>
                                    </div>
                                    <button class="btn pix-button pix-v-s" type="submit" name="wp-submit" id="wp-submit"><?php esc_html_e('login', 'pitstop') ?></button>
                                    <input type="hidden" name="redirect_to" value="<?php esc_url( home_url() ) ?>/" />
                                    <input type="hidden" name="testcookie" value="1" />
                                    <small><a class="text-muted" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e('Lost your password?', 'pitstop') ?></a></small>
                                </form>
                            </div>
                            <div class="pix-header-user-panel" id="pix-userRegister">
                                <form>
                                    <div class="form-group mb-10">
                                        <label><?php esc_html_e('Email', 'pitstop') ?><span>*</span></label>
                                        <input class="form-control form-control-sm" type="email">
                                    </div>
                                    <div class="form-group mb-10">
                                        <label><?php esc_html_e('Username', 'pitstop') ?><span>*</span></label>
                                        <input class="form-control form-control-sm" type="text">
                                    </div>
                                    <div class="form-group mb-10">
                                        <label><?php esc_html_e('Password', 'pitstop') ?><span>*</span></label>
                                        <input class="form-control form-control-sm" type="password">
                                    </div>
                                    <div class="form-group mb-10 form-check">
                                        <input class="form-check-input" id="exampleCheck2" type="checkbox">
                                        <label class="form-check-label" for="exampleCheck2">
                                            <?php esc_html_e('I agree to the terms of the', 'pitstop') ?>
                                            <a class="text-muted" href="#"><?php esc_html_e('users agreement', 'pitstop') ?></a>
                                        </label>
                                    </div>
                                    <button class="btn pix-button pix-v-s" type="submit"><?php esc_html_e('register', 'pitstop') ?></button>
                                </form>
                            </div>
                        </div>
                        <?php elseif ( has_nav_menu( 'account_nav' ) ) :
                                wp_nav_menu(array(
                                    'theme_location'  => 'account_nav',
                                    'container'       => false,
                                    'menu_id'		  => 'account-menu',
                                    'menu_class'      => 'submenu',
                                    'depth'           => 1
                                ));
                              endif;
                        ?>
                    </li>
                <?php endif; ?>
				</ul>
			</nav>
   
		</div>
      <!-- second line header-->
      <div class="pix-header-bottom <?php echo esc_attr($pixtheme_header['header_background_bottom']) ?> <?php echo esc_attr( $pixtheme_header_transparent_bottom ) ?> <?php echo esc_attr( $pixtheme_header['header_catalog_height'] ) ?>">
        <div class="<?php echo esc_attr($pixtheme_header['header_layout_bottom']) ?>">
          <div class="row justify-content-between align-items-center">
            <div class="col-lg-3 col-sm-3">
              <div class="pix__secondMenu pix__secondMenuInverse mb-10 mb-sm-0">
                <a href="#"><i class="pit-burger"></i><span><?php esc_html_e('All products', 'pitstop') ?></span><i class="pit-bottom"></i></a>
            <?php if(pixtheme_get_setting('pix-catalog-section') != '') : ?>
                <div class="pix-section">
                <?php
                    $section_id = pixtheme_get_setting('pix-catalog-section');
                    if(function_exists('icl_object_id')) {
                        $section_id = icl_object_id ($section_id,'pix-section',true);
                    } elseif(function_exists('pll_get_post')){
                        $section_id = pll_get_post ($section_id);
                    }
                    pixtheme_get_section_content($section_id);
                ?>
                </div>
            <?php else : ?>
                <ul>
                <?php
                    
                    $cats = explode(',', substr(pixtheme_get_setting('pix-catalog-selector'), 0, -1));
                    $cats_id_arr = array();
                    foreach($cats as $slug ){
                        $term = get_term_by('slug', $slug, 'product_cat');
                        if(isset($term->term_id))
                            $cats_id_arr[] = $term->term_id;
                    }
                    $woo_args = array(
                         'taxonomy'     => 'product_cat',
                         'orderby'      => 'menu_order',
                         'include'      => $cats_id_arr,
                         'parent'       => 0,
                    );
                    $woo_categories = get_categories( $woo_args );
                    
                    $i = 0;
                    foreach ($woo_categories as $cat) {
                        $active = $i == 0 ? 'class="active"' : '';
                        $product_cat_icon = get_option('pix_product_cat_thumb_' . $cat->slug) != '' ? '<img class="pix-svg-fill" src="'.get_option('pix_product_cat_thumb_' . $cat->slug).'" alt="'.esc_attr($cat->name).'">' : '<i class="pit-star2"></i>';
                        ?>
                        <li <?php echo wp_kses($active, 'post')?>>
                            <a href="<?php echo get_category_link( $cat->term_id ) ?>"><?php echo wp_kses($product_cat_icon, 'post')?><span><?php echo esc_attr($cat->name) ?></span><i class="pit-right"></i></a>
                        </li>
                        <li>
                            <div class="row">
                                <div class="<?php echo pixtheme_get_setting('pix-catalog-banner') != '' ? 'col-xl-9 col-sm-6' : 'col-xl-12 col-sm-12' ?>">
                                    <div class="pix-masonry-catalog">
                        <?php
                        $woo_sub_args = array(
                             'taxonomy'     => 'product_cat',
                             'orderby'      => 'menu_order',
                             'parent'       => $cat->term_id,
                        );
                        $woo_subcategories = get_categories( $woo_sub_args );
                        
                        foreach ($woo_subcategories as $subcat) {
                            $sub_count = isset($subcat->count) && $subcat->count != '' ? ' <span> ('.$subcat->count.')</span>' : '';
                            // get the image URL
                            $thumbnail_id = get_term_meta( $subcat->term_id, 'thumbnail_id', true );
                            if( $thumbnail_id > 0 || (get_option('pix_product_cat_thumb_' . $subcat->slug) == '' && $thumbnail_id == 0) ){
                                $image_arr = wp_get_attachment_image_src( $thumbnail_id, 'medium', true );
                                $image_src = isset($image_arr[0]) ? $image_arr[0] : '';
                            } else {
                                $image_src = get_option('pix_product_cat_thumb_' . $subcat->slug);
                            }
                            
                            ?>
                            
                                        <div>
                                            <div class="pix__secondMenu-img"><img src="<?php echo esc_url($image_src) ?>" alt="<?php echo esc_attr($subcat->name) ?>"></div>
                                            <a href="<?php echo get_category_link( $subcat->term_id ) ?>"><b><?php echo esc_attr($subcat->name) ?></b></a>
                                            
                                            <?php
                                            $woo_sub_sub_args = array(
                                                 'taxonomy'     => 'product_cat',
                                                 'orderby'      => 'menu_order',
                                                 'parent'       => $subcat->term_id,
                                            );
                                            $woo_sub_subcategories = get_categories( $woo_sub_sub_args );
                                            
                                            if($woo_sub_subcategories){
                                                echo '<ul>';
                                                foreach ($woo_sub_subcategories as $sub_subcat) {
                                                    ?>
                                                        <li><a href="<?php echo get_category_link( $sub_subcat->term_id ) ?>"><?php echo esc_attr($sub_subcat->name) ?></a></li>
                                                    <?php
                                                }
                                                echo '</ul>';
                                            }
                                            ?>
                                        </div>
                            
                            <?php
                        }
                        ?>
                                    </div>
                                </div>
                                <?php if(pixtheme_get_setting('pix-catalog-banner') != '') : ?>
                                <div class="col-xl-3 col-sm-6">
                                <?php
                                    $banner_id = pixtheme_get_setting('pix-catalog-banner');
                                    echo '
                                    <div class="pix__secondMenuBanner pix-inverse" style="background-image: url('.esc_url(get_the_post_thumbnail_url($banner_id, 'large')).')">
                                        <p>'.wp_kses(get_post_meta( $banner_id, 'pix-banner-subtext', true ), 'post').'</p>
                                        <p>'.wp_kses(get_post_meta( $banner_id, 'pix-banner-title', true ), 'post').'</p>
                                        <a href="'.esc_url(get_post_meta( $banner_id, 'pix-banner-link', true )).'"></a>
                                    </div>';
                                ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </li>
                        <?php
                        
                        $i++;
                    }
                ?>
                
                </ul>
            
            <?php endif; ?>
            
              </div>
            </div>
            <div class="col-lg-9 col-sm-9 d-flex flex-row justify-content-between align-items-center">
                <?php if ($pixtheme_header['header_phone']) : ?>
                    <a class="pix-button pix__phone mr-10 mr-sm-40" href="tel:<?php echo esc_attr(str_replace(' ', '', pixtheme_get_option('header_phone', ''))) ?>">
                        <i class="pix-flaticon-phone-call mr-lg-2"></i><b class="d-none d-lg-inline"><?php echo wp_kses(pixtheme_get_option('header_phone', ''), 'post') ?></b>
                    </a>
                <?php endif; ?>
                <?php if ($pixtheme_header['header_email']) : ?>
                    <a class="pix-button pix__phone mr-10 mr-sm-40" href="mailto:<?php echo wp_kses(pixtheme_get_option('header_email', ''), 'post') ?>">
                        <i class="pix-flaticon-email mr-lg-2"></i><b class="d-none d-lg-inline"><?php echo wp_kses(pixtheme_get_option('header_email', ''), 'post') ?></b>
                    </a>
                <?php endif; ?>
              <form class="pix__search flex-fill" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="input-group">
                  <div class="flex-fill">
                    <input class="form-control" type="search" placeholder="<?php esc_html_e('Enter the name or part number', 'pitstop') ?>" value="<?php echo get_search_query(); ?>" name="s">
                    <div class="pix__searchAjax" data-scrollbar>
                        <div class="pix-ajax-loader">
                            <div class="pix-loading-m"></div>
                        </div>
                        <div class="pix__searchAjax_inner">
                        
                        </div>
                    </div>
                  </div>
                  <div class="input-group-append">
                      <button class="pix-button" type="submit"><i class="pix-flaticon-magnifying-glass d-sm-none"></i><span class="d-none d-sm-inline"><?php esc_html_e('Search', 'pitstop') ?></span></button>
                      <input type="hidden" name="post_type" value="product" />
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </header>
    
