<?php /* Header Mobile */
    $post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : get_the_ID();

    $pixtheme_header = apply_filters('pixtheme_header_settings', $post_ID);
    $pixtheme_logo_m = $pixtheme_header['logo_mobile'] == '' ? $pixtheme_header['logo'] : $pixtheme_header['logo_mobile'];
    $logo_src = $pixtheme_logo_m != '' ? $pixtheme_logo_m : get_template_directory_uri().'/images/logo-w.svg';
?>

		<header class="menu-mobile <?php echo esc_attr($pixtheme_header['header_sticky_mobile']) ?>">
			<div class="row">
				<div class="col-12">
                    <div class="menu-mobile__header pix-lvl pix-top-bar <?php echo esc_attr($pixtheme_header['header_background']) ?>">
                        
                        <div class="pix-header-mobile-col-right">
                            <?php if(class_exists('WOOCS')) : ?>
                            <div class="pix-header-currency">
                                <?php echo do_shortcode('[woocs]'); ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (class_exists( 'YITH_Woocompare' )) : ?>
                                <?php
                                    global $yith_woocompare;
                                    $compare_class = count($yith_woocompare->obj->products_list) > 0 ? '' : 'empty';
                                ?>
                            <div id="compare-mobile" class="pix-header-icon pix-compare product <?php echo esc_attr($compare_class)?>">
                                <span>
                                    <a href="/?action=yith-woocompare-view-table&iframe=yes" class="compare added"><i class="pix-flaticon-statistics"></i></a>
                                    <span class="badge"><?php echo count($yith_woocompare->obj->products_list) ?></span>
                                </span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (class_exists('YITH_WCWL')) : ?>
                                <?php
                                    $wish_class = yith_wcwl_count_products() > 0 ? '' : 'empty';
                                ?>
                            <div id="like-mobile" class="pix-header-icon <?php echo esc_attr($wish_class)?>">
                                <span>
                                    <a href="<?php echo get_permalink(get_option( 'yith_wcwl_wishlist_page_id' )) ?>"><i class="pix-flaticon-like"></i></a>
                                    <span class="badge"><?php echo yith_wcwl_count_products() ?></span>
                                </span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (class_exists('WooCommerce') && $pixtheme_header['header_minicart']) : ?>
                            <div class="cart-container">
                                <a href="<?php echo wc_get_cart_url(); ?>">
                                    <div class="pix-cart-items">
                                        <i class="fas fa-shopping-basket"></i>
                                        <span class="pix-cart-count"><?php echo WC()->cart->cart_contents_count; ?></span>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

					</div>
					<div class="menu-mobile__header pix-lvl <?php echo esc_attr($pixtheme_header['header_background']) ?>">

                        <a class="navbar-brand scroll" href="<?php echo esc_url(home_url('/')) ?>">
                            <img class="normal-logo" src="<?php echo esc_url($logo_src) ?>" alt="<?php esc_attr_e('Logo', 'pitstop') ?>"/>
                        </a>
                        
                        <div class="pix-header-mobile-col-right">
                            <div class="pix-header-mobile-icons">
                                <a href="#" class="pix-button pix-v-xs pix-h-s js-mobile-toggle"><?php echo pixtheme_get_option('header_mobile_cat_txt', esc_html__('Catalog', 'pitstop')) ?></a>
                            </div>
                            
                            <?php if ( $pixtheme_header['header_search'] ) : ?>
                            <i class="fas fa-search js-search-toggle"></i>
                            <div class="search-container">
                                <div class="input-container"></div>
                            </div>
                            <?php endif; ?>
                            
                            <button class="hamburger hamburger--spring js-mobile-toggle" type="button" onclick="this.classList.toggle('is-active');">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>

					</div>
					<div class="menu-mobile__list">
                        <div class="pix-mobile-menu-container">
                        <?php
                        if ( has_nav_menu( 'mobile_nav' ) ) {
                            wp_nav_menu(array(
                                'theme_location'  => 'mobile_nav',
                                'container'       => false,
                                'menu_id'		  => 'mobile-menu',
                                'menu_class'      => '',
                                'depth'           => 3,
                                'walker'          => new PixTheme_Walker_Mobile_Menu(),
                            ));
                        } elseif( has_nav_menu( 'primary_nav' ) ) {
                            wp_nav_menu(array(
                                'theme_location'  => 'primary_nav',
                                'container'       => false,
                                'menu_id'	      => 'mobile-menu',
                                'depth'           => 3,
                                'walker'          => new PixTheme_Walker_Mobile_Menu(),
                            ));
                        }
                        ?>
                        </div>
						
					</div>
					<div class="menu-mobile__list pix-catalog">
                        <div class="pix-mobile-menu-container">
                            <ul class="menu">
                            <?php
                            
                            $current_term_id = false;
                            $current_term_parents = array();
                            if ( is_tax( 'product_cat' ) ) {
                                $current_term = $wp_query->queried_object;
                                $current_term_id = $current_term->term_id;
                                $current_term_parents = get_ancestors( $current_term_id, 'product_cat' );
                            }
                    
                            echo pixtheme_category_tree(0, $current_term_id, $current_term_parents);
                            
                            ?>
                            </ul>
                        </div>
						
					</div>
                    <div class="overlay"></div>
				</div>
			</div>	
		</header>