<?php

/********** WOOCOMERCE **********/

/// Catalog

remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

add_action('pix_woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
add_action('pix_woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action('pix_woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 45);

/// Catalog Product

remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
add_action('pix_woocommerce_before_shop_loop', 'woocommerce_product_archive_description', 55);
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);



add_filter( 'woocommerce_show_page_title' , 'pixtheme_woo_hide_page_title' );
function pixtheme_woo_hide_page_title() {
	return false;
}

add_filter('woocommerce_product_description_heading', '__return_empty_string');
add_filter('woocommerce_product_additional_information_heading', '__return_empty_string');
add_filter( 'yith_woocompare_compare_added_label', '__return_empty_string' );
add_filter( 'yith_wcwl_remove_from_wishlist_label', '__return_empty_string' );
add_filter( 'yith_wcwl_add_to_wishlist_icon_html', 'pix_wishlist_change_icon', 2 );
function pix_wishlist_change_icon($atts){
    if ( !isset($atts['exists']) || $atts['exists'] ) {
        $icon_html = '<i class="yith-wcwl-icon pix-flaticon-like"></i>';
    }
    return $icon_html;
}


add_action('pix_woocommerce_before_shop_loop', 'pix_header_wrap_start', 0);
function pix_header_wrap_start() {
	echo '<div class="pix-content-header">';
};
add_action('pix_woocommerce_before_shop_loop', 'pix_header_shop_title', 15);
function pix_header_shop_title() {
    $tab_position = pixtheme_get_option('tab_position', '');
	$tab_hide = pixtheme_get_option('tab_hide', '');
	
	$title_class = '';
	if( $tab_position != 'left_right' && $tab_position != 'right_left' ){
		$title_class = $breadcrumbs_class = 'text-'.$tab_position;
	}
	
	if(
	    $tab_hide != 'hide'
        && $tab_hide != 'hide_title'
        && ( pixtheme_get_option('tab_breadcrumbs_v_position', '') == 'over'
            && (is_shop()
                || is_product_category()
                || is_product_tag()
                )
            )
    ){
	   echo '<div class="pix-header-title '.esc_attr($title_class).'">
	            <h1 class="pix-h1-h6 h3-size">
	                '.woocommerce_page_title(false).'
	            </h1>
            </div>';
    }
};
add_action('pix_woocommerce_before_shop_loop', 'pix_header_wrap_end', 40);
function pix_header_wrap_end() {
	echo '</div>';
};
add_action('pix_woocommerce_before_shop_loop', 'pix_filter_select', 50);
function pix_filter_select() {
	if( (is_shop() || is_product_category() || is_product_tag()) && get_post_meta(wc_get_page_id('shop'), 'pix_page_layout', true) == 4 ){
	    $pix_layout = pixtheme_get_layout('shop');
	    pixtheme_show_sidebar( 'top', 4, $pix_layout['sidebar'] );
	    echo '
        <div class="pix__filter">
          <div class="pix__filterInner">
            <div class="pix__filterHeader d-flex align-items-center justify-content-between">
              <div class="pix__sectionTitle">
                <h3>Search parts</h3>
              </div><a class="btn btn-sm btn-dark" href="#">Hide filter <i class="pit-top"></i></a>
            </div>
            <div class="pix__filterControls mt-40" style="">
              <form action="#">
                <div class="row align-items-end">
                  <div class="col-xl-3 col-lg-4 col-sm-6 mb-40">
                    <div class="pixSelect">
                      <div class="pixControl"><span>Categories</span></div>
                      <div class="pixSelect_list scrollable default-skin" data-scrollbar="" tabindex="-1"><div class="scroll-bar vertical" style="height: 122px; display: block;"><div class="thumb" style="top: 0px; height: 30px;"></div></div><div class="viewport" style="height: 122px;"><div class="overview" style="top: 0px;">
                        <ul>
                          <li><i class="pit-across"></i><a class="pixSelect_reset" href="#">No matter</a></li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check1" type="checkbox" checked="">
                              <label class="form-check-label" for="Check1">Autoparts &amp; analog</label>
                            </div>
                            <ul>
                              <li>
                                <div class="form-check">
                                  <input class="form-check-input" id="Check2" type="checkbox">
                                  <label class="form-check-label" for="Check2">Auto Electronics</label>
                                </div>
                              </li>
                              <li>
                                <div class="form-check">
                                  <input class="form-check-input" id="Check3" type="checkbox">
                                  <label class="form-check-label" for="Check3">Auto Electronics</label>
                                </div>
                              </li>
                              <li>
                                <div class="form-check">
                                  <input class="form-check-input" id="Check4" type="checkbox" checked="">
                                  <label class="form-check-label" for="Check4">Auto Electronics</label>
                                </div>
                                <ul>
                                  <li>
                                    <div class="form-check">
                                      <input class="form-check-input" id="Check5" type="checkbox" checked="">
                                      <label class="form-check-label" for="Check5">Voltmeters and charger</label>
                                    </div>
                                  </li>
                                </ul>
                              </li>
                            </ul>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check6" type="checkbox">
                              <label class="form-check-label" for="Check6">Auto Electronics</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check7" type="checkbox">
                              <label class="form-check-label" for="Check7">Gifts &amp; Merchandise</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check8" type="checkbox">
                              <label class="form-check-label" for="Check8">Tyres &amp; Oils</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check9" type="checkbox">
                              <label class="form-check-label" for="Check9">Autoparts &amp; analog</label>
                            </div>
                          </li>
                        </ul>
                      </div></div><div class="scroll-bar horizontal"><div class="thumb"></div></div></div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-sm-6 mb-40">
                    <div class="pixSelect">
                      <div class="pixControl"><span>Brand</span>
                        <div class="pixControl_selected"><img src="images/mercedes.png" alt=""><img src="images/bmw.png" alt=""></div>
                      </div>
                      <div class="pixSelect_list scrollable default-skin" data-scrollbar="" tabindex="-1"><div class="scroll-bar vertical" style="height: 122px; display: block;"><div class="thumb" style="top: 0px; height: 30px;"></div></div><div class="viewport" style="height: 122px;"><div class="overview" style="top: 0px;">
                        <ul>
                          <li><i class="pit-across"></i><a class="pixSelect_reset" href="#">No matter</a></li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check10" type="checkbox" checked="">
                              <label class="form-check-label" for="Check10">Audi <span>1946</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check11" type="checkbox">
                              <label class="form-check-label" for="Check11">BMW <span>2484</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check12" type="checkbox">
                              <label class="form-check-label" for="Check12">Chrysler <span>299</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check13" type="checkbox">
                              <label class="form-check-label" for="Check13">Citroen <span>1153</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check14" type="checkbox" checked="">
                              <label class="form-check-label" for="Check14">Dodge <span>224</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check15" type="checkbox" checked="">
                              <label class="form-check-label" for="Check15">Fiat <span>620</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check16" type="checkbox">
                              <label class="form-check-label" for="Check16">Ford <span>1924</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check17" type="checkbox">
                              <label class="form-check-label" for="Check17">Honda <span>635</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check18" type="checkbox">
                              <label class="form-check-label" for="Check18">Hyundai <span>847</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check19" type="checkbox">
                              <label class="form-check-label" for="Check19">Kia <span>719</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check20" type="checkbox">
                              <label class="form-check-label" for="Check20">Mazda <span>993</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check21" type="checkbox">
                              <label class="form-check-label" for="Check21">Mercedes <span>2155</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check22" type="checkbox">
                              <label class="form-check-label" for="Check22">Mitsubishi <span>645</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check23" type="checkbox">
                              <label class="form-check-label" for="Check23">Nissan <span>1140</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check24" type="checkbox" checked="">
                              <label class="form-check-label" for="Check24">Opel <span>1838</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check25" type="checkbox" checked="">
                              <label class="form-check-label" for="Check25">Peugeot <span>1390</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check26" type="checkbox">
                              <label class="form-check-label" for="Check26">Renault <span>1696</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check27" type="checkbox">
                              <label class="form-check-label" for="Check27">Rover <span>168</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check28" type="checkbox">
                              <label class="form-check-label" for="Check28">Seat <span>198</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check29" type="checkbox">
                              <label class="form-check-label" for="Check29">Skoda <span>555</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check30" type="checkbox">
                              <label class="form-check-label" for="Check30">Toyota <span>1043</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check31" type="checkbox">
                              <label class="form-check-label" for="Check31">Volvo <span>647</span></label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check32" type="checkbox">
                              <label class="form-check-label" for="Check32">Volkswagen <span>3060</span></label>
                            </div>
                          </li>
                        </ul>
                      </div></div><div class="scroll-bar horizontal"><div class="thumb"></div></div></div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-sm-6 mb-40">
                    <div class="pixSelect">
                      <div class="pixControl"><span>Model</span>
                        <div class="pixControl_selected">X6, ML 350</div>
                      </div>
                      <div class="pixSelect_list scrollable default-skin" data-scrollbar="" tabindex="-1"><div class="scroll-bar vertical" style="height: 122px; display: block;"><div class="thumb" style="top: 0px; height: 30px;"></div></div><div class="viewport" style="height: 122px;"><div class="overview" style="top: 0px;">
                        <ul>
                          <li><i class="pit-across"></i><a class="pixSelect_reset" href="#">No matter</a></li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check33" type="checkbox">
                              <label class="form-check-label" for="Check33">X6</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check34" type="checkbox" checked="">
                              <label class="form-check-label" for="Check34">ML 350</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check35" type="checkbox" checked="">
                              <label class="form-check-label" for="Check35">FX 200</label>
                            </div>
                          </li>
                        </ul>
                      </div></div><div class="scroll-bar horizontal"><div class="thumb"></div></div></div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-sm-6 mb-40">
                    <div class="pixSelect">
                      <div class="pixControl"><span>Select years</span></div>
                      <div class="pixSelect_list scrollable default-skin" data-scrollbar="" tabindex="-1"><div class="scroll-bar vertical" style="height: 122px; display: block;"><div class="thumb" style="top: 0px; height: 30px;"></div></div><div class="viewport" style="height: 122px;"><div class="overview" style="top: 0px;">
                        <ul>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check36" type="checkbox">
                              <label class="form-check-label" for="Check36">2005</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check37" type="checkbox">
                              <label class="form-check-label" for="Check37">2006</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check38" type="checkbox">
                              <label class="form-check-label" for="Check38">2007</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check39" type="checkbox">
                              <label class="form-check-label" for="Check39">2008</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check40" type="checkbox">
                              <label class="form-check-label" for="Check40">2009</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check41" type="checkbox">
                              <label class="form-check-label" for="Check41">2010</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check42" type="checkbox">
                              <label class="form-check-label" for="Check42">2011</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check43" type="checkbox">
                              <label class="form-check-label" for="Check43">2012</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check44" type="checkbox" checked="">
                              <label class="form-check-label" for="Check44">2013</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check45" type="checkbox" checked="">
                              <label class="form-check-label" for="Check45">2014</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check46" type="checkbox">
                              <label class="form-check-label" for="Check46">2015</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check47" type="checkbox">
                              <label class="form-check-label" for="Check47">2016</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check48" type="checkbox">
                              <label class="form-check-label" for="Check48">2017</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check49" type="checkbox">
                              <label class="form-check-label" for="Check49">2018</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check50" type="checkbox">
                              <label class="form-check-label" for="Check50">2019</label>
                            </div>
                          </li>
                        </ul>
                      </div></div><div class="scroll-bar horizontal"><div class="thumb"></div></div></div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-sm-6 mb-40">
                    <div class="pixGroup">
                      <div class="pixSelect">
                        <input class="pixControl" type="text" placeholder="Price on" value="">
                        <div class="pixSelect_list scrollable default-skin" data-scrollbar="" tabindex="-1"><div class="scroll-bar vertical" style="height: 122px; display: block;"><div class="thumb" style="top: 0px; height: 30px;"></div></div><div class="viewport" style="height: 122px;"><div class="overview" style="top: 0px;">
                          <ul>
                            <li><i class="pit-across"></i><a class="pixSelect_reset" href="#">No matter</a></li>
                            <li><span>150</span></li>
                            <li><span>350</span></li>
                            <li><span>500</span></li>
                          </ul>
                        </div></div><div class="scroll-bar horizontal"><div class="thumb"></div></div></div>
                      </div>
                      <div class="pixSelect">
                        <input class="pixControl" type="text" placeholder="Price to" value="">
                        <div class="pixSelect_list scrollable default-skin" data-scrollbar="" tabindex="-1"><div class="scroll-bar vertical" style="height: 122px; display: block;"><div class="thumb" style="top: 0px; height: 30px;"></div></div><div class="viewport" style="height: 122px;"><div class="overview" style="top: 0px;">
                          <ul>
                            <li><i class="pit-across"></i><a class="pixSelect_reset" href="#">No matter</a></li>
                            <li><span>150</span></li>
                            <li><span>350</span></li>
                            <li><span>500</span></li>
                          </ul>
                        </div></div><div class="scroll-bar horizontal"><div class="thumb"></div></div></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-sm-6 mb-40">
                    <div class="pixSelect">
                      <div class="pixControl"><span>Body type</span></div>
                      <div class="pixSelect_list scrollable default-skin" data-scrollbar="" tabindex="-1"><div class="scroll-bar vertical" style="height: 122px; display: block;"><div class="thumb" style="top: 0px; height: 30px;"></div></div><div class="viewport" style="height: 122px;"><div class="overview" style="top: 0px;">
                        <ul>
                          <li><i class="pit-across"></i><a class="pixSelect_reset" href="#">No matter</a></li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check51" type="checkbox">
                              <label class="form-check-label" for="Check51">SUV</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check52" type="checkbox">
                              <label class="form-check-label" for="Check52">Truck</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check53" type="checkbox">
                              <label class="form-check-label" for="Check53">Sedan</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check54" type="checkbox" checked="">
                              <label class="form-check-label" for="Check54">Van</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check55" type="checkbox" checked="">
                              <label class="form-check-label" for="Check55">Coupe</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check56" type="checkbox">
                              <label class="form-check-label" for="Check56">Wagon</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check57" type="checkbox">
                              <label class="form-check-label" for="Check57">Convertible</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check58" type="checkbox">
                              <label class="form-check-label" for="Check58">Sports Car</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check59" type="checkbox">
                              <label class="form-check-label" for="Check59">Diesel</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check60" type="checkbox">
                              <label class="form-check-label" for="Check60">Crossover</label>
                            </div>
                          </li>
                        </ul>
                      </div></div><div class="scroll-bar horizontal"><div class="thumb"></div></div></div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-sm-6 mb-40">
                    <div class="pixSelect">
                      <div class="pixControl"><span>Color</span>
                        <div class="pixControl_selected">
                          <div style="background-color: #009fe3;"></div>
                          <div style="background-color: #3aaa35;"></div>
                          <div style="background-color: #f29fc5;"></div>
                        </div>
                      </div>
                      <div class="pixSelect_list scrollable default-skin" data-scrollbar="" tabindex="-1"><div class="scroll-bar vertical" style="height: 122px; display: block;"><div class="thumb" style="top: 0px; height: 30px;"></div></div><div class="viewport" style="height: 122px;"><div class="overview" style="top: 0px;">
                        <ul>
                          <li><i class="pit-across"></i><a class="pixSelect_reset" href="#">No matter</a></li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check61" type="checkbox">
                              <label class="form-check-label" for="Check61">blue</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check62" type="checkbox">
                              <label class="form-check-label" for="Check62">indigo</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check63" type="checkbox">
                              <label class="form-check-label" for="Check63">purple</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check64" type="checkbox" checked="">
                              <label class="form-check-label" for="Check64">pink</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check65" type="checkbox" checked="">
                              <label class="form-check-label" for="Check65">red</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check66" type="checkbox">
                              <label class="form-check-label" for="Check66">orange</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check67" type="checkbox">
                              <label class="form-check-label" for="Check67">yellow</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check68" type="checkbox">
                              <label class="form-check-label" for="Check68">green</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check69" type="checkbox">
                              <label class="form-check-label" for="Check69">teal</label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" id="Check70" type="checkbox">
                              <label class="form-check-label" for="Check60">cyan</label>
                            </div>
                          </li>
                        </ul>
                      </div></div><div class="scroll-bar horizontal"><div class="thumb"></div></div></div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-sm-6 mb-40">
                    <div class="pixControl">
                      <label title="Dealer products">Dealer products</label>
                      <div class="pixCheckbox">
                        <input type="checkbox" checked="">
                        <div></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-sm-6 mb-40">
                    <div class="pixControl">
                      <label title="Product sertificate">Product sertificate</label>
                      <div class="pixCheckbox">
                        <input type="checkbox" checked="">
                        <div></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-sm-6 mb-40">
                    <div class="pixControl">
                      <label title="Only analogues">Only analogues</label>
                      <div class="pixCheckbox">
                        <input type="checkbox">
                        <div></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-8 mb-40">
                    <div class="pixRange">
                      <div class="pixRange_label">
                        <label>Price from:</label><span><span>$1 500</span><span>-</span><span>$50 000</span></span>
                      </div>
                      <span class="irs irs--pix js-irs-0"><span class="irs"><span class="irs-line" tabindex="0"></span><span class="irs-min" style="visibility: visible;">1 000</span><span class="irs-max" style="visibility: visible;">50 000</span><span class="irs-from" style="visibility: visible; left: 11.0825%;">7 300</span><span class="irs-to" style="visibility: visible; left: 50.0547%;">27 000</span><span class="irs-single" style="visibility: hidden; left: 27.4978%;">7 300 — 27 000</span></span><span class="irs-grid"></span><span class="irs-bar" style="left: 13.6066%; width: 39.3929%;"></span><span class="irs-shadow shadow-from" style="display: none;"></span><span class="irs-shadow shadow-to" style="display: none;"></span><span class="irs-handle from" style="left: 12.5977%;"><i></i><i></i><i></i></span><span class="irs-handle to type_last" style="left: 51.9906%;"><i></i><i></i><i></i></span></span><input class="pixRange_input irs-hidden-input" hidden="" type="text" value="" data-skin="pix" data-type="double" data-min="1000" data-max="50000" data-from="7300" data-to="27000" data-grid="false" tabindex="-1" readonly="">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="pix__filterSelected pix-filter-selected"><span>BMW <a href="#"></a></span> <span>Mercedes <a href="#"></a></span> <a href="#">Reset all</a>
          </div>
        </div>';
    }
};


add_action( 'woocommerce_before_shop_loop_item_title', 'pixtheme_woo_shop_loop_item_info_open', 3);
function pixtheme_woo_shop_loop_item_info_open() {
    $cats = wp_get_object_terms(get_the_ID(), 'product_cat');
    $cat_titles = array();
    $cat_titles_str = '';
    if ( ! empty($cats) ) {
        foreach ( $cats as $cat ) {
            $cat_titles[] = '<a href="'.get_term_link($cat).'" class="pix-product-category">'.$cat->name.'</a>';
        }
        $cat_titles_str = end( $cat_titles);
    }
    echo '
        <div class="pix-product-info">
            <div>
                '.wp_kses($cat_titles_str, 'post');
};
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 5);
add_action( 'woocommerce_before_shop_loop_item_title', 'pixtheme_woo_shop_loop_item_info_close', 7);
function pixtheme_woo_shop_loop_item_info_close() {
    global $product;
    $attributes = $product->get_attributes();
    $attr_out = '';
    if ( $attributes ) {
        $attr_out = '<ul class="pix-product_attr">';
        foreach ($attributes as $attr => $val) {
            $label = wc_attribute_label($attr);
            if ( isset( $attributes[ $attr ] ) || isset( $attributes[ 'pa_' . $attr ] ) ) {
                $attribute = isset( $attributes[ $attr ] ) ? $attributes[ $attr ] : $attributes[ 'pa_' . $attr ];
                if ( $attribute['is_taxonomy'] ) {
                    $attr_out .= '<li><label>'.$label.':</label> <span>'.implode( ', ', wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'names' ) ) ).'</span></li>';
                } else {
                    $attr_out .= '<li><label>'.$label.':</label> <span>'.$attribute['value'].'</span></li>';
                }
            }
        }
        $attr_out .= '</ul>';
    }
    echo '
            </div>
            <div class="h6"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></div>
            <p class="product-description">' . pixtheme_limit_words(get_the_excerpt(get_the_ID()), 15, '') . '</p>
        </div>
        <div class="pix-product-attr-container">'.wp_kses($attr_out, 'post').'</div>';
};
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
function woocommerce_template_loop_product_thumbnail() {
    global $product;
    $image = $out_image = '';
    $thumbnail = get_the_post_thumbnail($product->get_id(), 'shop_catalog', array('class' => 'active'));
    if(pixtheme_get_setting('pix-woo-hover-slider', 'off') == 'on' ) {
        $attach_ids = $product->get_gallery_image_ids();
        $attachment_count = count($product->get_gallery_image_ids());
        if ($attachment_count > 0) {
            $image_link = wp_get_attachment_url($attach_ids[0]);
            $default_attr = array('class' => "slider_img", 'alt' => get_the_title($product->get_id()),);
            $image = wp_get_attachment_image($attach_ids[0], 'shop_catalog', false, $default_attr);
        }
        $out_image = '
        <div class="pix-product-slider">
            <a href="'.get_the_permalink().'">
                <span class="pix-product-slider-box">
                    ' . $thumbnail . '
                    ' . $image . '
                </span>
                <span class="pix-product-slider-hover"></span>
                <span class="pix-product-slider-dots"></span>
            </a>
        </div>';
    } else {
        $out_image = '
        <a href="'.get_the_permalink().'">
            ' . $thumbnail . '
        </a>';
    }
	echo '
        <div class="pix-product-img">
            ' . $out_image . '
        </div>';
};

add_action( 'woocommerce_after_shop_loop_item', 'pixtheme_woo_shop_loop_item_icons_open', 5);
function pixtheme_woo_shop_loop_item_icons_open() {
    global $product, $yith_woocompare;
    $products_compare_list = class_exists( 'YITH_Woocompare' ) ? $yith_woocompare->obj->products_list : [];
    $compare_remove = '';
    if(in_array($product->get_id(), $products_compare_list)){
        $compare_remove = 'remove';
    }
    
    $quick_view = class_exists( 'PixThemeSettings' ) ? '<a class="pix__quickView pix-tooltip-show" href="#" data-fancybox="quick-view" data-product-id="'.esc_attr($product->get_id()).'" ><i class="pix-flaticon-magnifying-glass"></i>'.pixtheme_tooltip(esc_html__('Quick view', 'pitstop')).'</a>' : '';
    $wishlist = class_exists( 'YITH_WCWL' ) ? do_shortcode('[yith_wcwl_add_to_wishlist]') : '';
    $compare = class_exists( 'YITH_Woocompare' ) ? '<a href="#" class="pix-compare-btn pix-tooltip-show '.esc_attr($compare_remove).'" data-product_id="'.esc_attr($product->get_id()).'" ><i class="pix-flaticon-statistics"></i>'.pixtheme_tooltip(esc_html__('Compare', 'pitstop')).'</a>' : '';
    
    echo '
        <div class="pix-product-icons">
            '.wp_kses($quick_view.$wishlist.$compare, 'post').'
            <input type="number" min="1" value="1">';
};
add_action( 'woocommerce_after_shop_loop_item', 'pixtheme_woo_shop_loop_item_icons_close', 20);
function pixtheme_woo_shop_loop_item_icons_close() {
	echo '</div>';
};

add_action( 'woocommerce_after_shop_loop_item_title', 'pixtheme_woo_shop_loop_item_price', 3);
function pixtheme_woo_shop_loop_item_price() {
    global $product;
    $stock   = $product->get_stock_quantity();
    $rating  = $product->get_average_rating();
    $count   = $product->get_rating_count();
    $rating_html = $count > 0 ? wc_get_rating_html( $rating, $count ) : '<div class="star-rating"></div>';
    
	echo '<div class="pix-product-rc">'.wp_kses($rating_html, 'post');
};

add_action( 'woocommerce_after_shop_loop_item_title', 'pixtheme_woo_shop_loop_item_price_close', 20);
function pixtheme_woo_shop_loop_item_price_close() {
	echo '</div>';
};


add_filter( 'loop_shop_per_page', function( $cols ){ return class_exists( 'PixThemeSettings' ) ? pixtheme_get_setting('pix-woo-per-page','15') : '15'; }, 20 );


add_filter('loop_shop_columns', 'pixtheme_loop_columns');
if (!function_exists('pixtheme_loop_columns')) {
	function pixtheme_loop_columns() {
		return 3; // 3 products per row
	}
}

add_filter( 'woocommerce_add_to_cart_fragments', 'pixtheme_cart_count_fragments', 10, 1 );
function pixtheme_cart_count_fragments( $fragments ) {

    $icon = '<i class="pix-flaticon-shopping-bag-3"></i>';
    $fragments['div.pix-cart-items'] = '<div class="pix-cart-items">'.($icon).'<span class="pix-cart-count">'.WC()->cart->cart_contents_count.'</span></div>';

    return $fragments;

}

add_filter( 'woocommerce_variable_sale_price_html', 'pixtheme_variable_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'pixtheme_variable_price_format', 10, 2 );
function pixtheme_variable_price_format( $price, $product ) {

    $prefix = sprintf('<span class="pix-from-price">%s</span>', __('from', 'pitstop'));

    $min_price_regular = $product->get_variation_regular_price( 'min', true );
    $min_price_sale    = $product->get_variation_sale_price( 'min', true );
    $max_price = $product->get_variation_price( 'max', true );
    $min_price = $product->get_variation_price( 'min', true );
    
    $price = ( $min_price_sale == $min_price_regular ) ? wc_price( $min_price_regular ) : '<del>' . wc_price( $min_price_regular ) . '</del>' . '<ins>' . wc_price( $min_price_sale ) . '</ins>';

    return ( $min_price == $max_price ) ? $price : sprintf('%s%s', $prefix, $price);

}

add_filter( 'woocommerce_breadcrumb_defaults', 'pixtheme_woocommerce_breadcrumbs' );
function pixtheme_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => '&nbsp;&nbsp;<i class="pix-flaticon-arrow-angle-pointing-to-right"></i>&nbsp;&nbsp;',
        'wrap_before' => '<div class="pix-breadcrumbs-path">',
        'wrap_after'  => '</div>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Home', 'breadcrumb', 'pitstop' ),
    );
}

if ( ! function_exists( 'woocommerce_product_archive_description' ) ) {
	function woocommerce_product_archive_description() {
        // Don't display the description on search results page
        if ( is_search() ) {
            return;
        }
        
        if ( is_post_type_archive( 'product' ) && 0 === absint( get_query_var( 'paged' ) ) ) {
            $shop_page = get_post( wc_get_page_id( 'shop' ) );
            if ( $shop_page ) {
                $description = wc_format_content( $shop_page->post_content );
                
                if ( $description ) {
                    echo '<div class="page-description">' . $description . '</div>';
                }
            }
        }
    }
}

function pixtheme_woo_get_page_id(){
    global $post;

    if( is_shop() || is_product_category() || is_product_tag() )
        $id = get_option( 'woocommerce_shop_page_id' );
    elseif( is_product() || !empty($post->ID) )
        $id = $post->ID;
    else
        $id = 0;
    return $id;
}

function pixtheme_is_woo_page () {
    if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
        return true;
    }
    $woocommerce_keys   =   array (
        'woocommerce_shop_page_id' ,
        'woocommerce_terms_page_id' ,
        'woocommerce_cart_page_id' ,
        'woocommerce_checkout_page_id' ,
        'woocommerce_pay_page_id' ,
        'woocommerce_thanks_page_id' ,
        'woocommerce_myaccount_page_id' ,
        'woocommerce_edit_address_page_id' ,
        'woocommerce_view_order_page_id' ,
        'woocommerce_change_password_page_id' ,
        'woocommerce_logout_page_id' ,
        'woocommerce_lost_password_page_id'
    );
    foreach ( $woocommerce_keys as $wc_page_id ) {
        if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
            return true;
        }
    }
    return false;
}

