<?php 
/**  Theme defaults values  **/

add_action('after_setup_theme', 'pixtheme_theme_defaults');
function pixtheme_theme_defaults(){

    update_option( 'pixtheme_default_content_width', 'full' );
    update_option( 'pixtheme_default_bg_color', '#f2f2f2' );
    
	// Logo
	update_option( 'pixtheme_default_logo_width', '140' );
	update_option( 'pixtheme_default_logo_height', '100' );

	// Header
    update_option( 'pixtheme_default_header_background_bottom', 'white' );

	// Colors and Fonts
	update_option( 'pixtheme_default_main_color', '#ff3737' );
	update_option( 'pixtheme_default_gradient_color', '#ffc02d' );
	update_option( 'pixtheme_default_gradient_direction', 'to right' );
	update_option( 'pixtheme_default_additional_color', '#f5f7f9' );
    update_option( 'pixtheme_default_black_color', '#212121' );

	update_option( 'pixtheme_default_fonts_embed', 'Jost:wght@400,600,700');
 
	$tags = array(
	    'p' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '400',
            'size'          => '16',
            'line_height'   => '1.8',
            'style'         => 'normal',
            'color'         => '#666666',
        )),
        'h1' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '700',
            'size'          => '34',
            'line_height'   => '1.2',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'h2' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '700',
            'size'          => '30',
            'line_height'   => '1.3',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'h3' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '600',
            'size'          => '26',
            'line_height'   => '1.3',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'h4' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '600',
            'size'          => '23',
            'line_height'   => '1.5',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'h5' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '600',
            'size'          => '20',
            'line_height'   => '1.8',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'h6' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '600',
            'size'          => '18',
            'line_height'   => '1.8',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'pre_title' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '600',
            'size'          => '16',
            'line_height'   => '1.8',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'title_s' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '600',
            'size'          => '16',
            'line_height'   => '1.8',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'title_m' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '600',
            'size'          => '18',
            'line_height'   => '1.8',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'title_l' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '600',
            'size'          => '20',
            'line_height'   => '1.8',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'title_xl' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '600',
            'size'          => '24',
            'line_height'   => '1.8',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'link' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '400',
            'size'          => '18',
            'line_height'   => '1.8',
            'style'         => 'normal',
            'color'         => '#000000',
        )),
        'button' => json_encode(array(
	        'family'        => 'Jost',
            'weight'        => '500',
            'size'          => '18',
            'line_height'   => '1.8',
            'style'         => 'normal',
            'color'         => '#ffffff',
        )),
    );
	
	foreach($tags as $tag => $val){
	    update_option( 'pixtheme_default_font_'.$tag, $val );
    }
    
    update_option( 'pixtheme_default_font_color_light', '#bbbbbb' );
    update_option( 'pixtheme_default_button_shape', 'pix-rounded' );
    update_option( 'pixtheme_default_button_color', 'main' );
    update_option( 'pixtheme_default_button_border', '0' );

	// Header Title and Breadcrumbs
	update_option( 'pixtheme_default_tab_tone', 'pix-tab-tone-dark' );
	update_option( 'pixtheme_default_tab_bg_color', '#050017' );
	update_option( 'pixtheme_default_tab_bg_color_gradient', '' );
	update_option( 'pixtheme_default_tab_gradient_direction', 'to top left' );
	update_option( 'pixtheme_default_tab_bg_opacity', '0' );
	update_option( 'pixtheme_default_tab_padding_top', '40' );
	update_option( 'pixtheme_default_tab_padding_bottom', '40' );
    update_option( 'pixtheme_default_tab_margin_bottom', '0' );

	update_option( 'pixtheme_default_decor', '0' );
	
	update_option( 'pixtheme_default_blog_icons', 'off' );

}

add_filter( 'pixtheme_header_settings', 'pixtheme_header_settings_var' );
function pixtheme_header_settings_var( $post_ID=0 ){

	/// Header global parameters
    $pitstop['header_type'] = pixtheme_get_option('header_type', 'header1');
    $pitstop['header_type_mobile'] = pixtheme_get_option('header_type_mobile', 'mobile');
    $pitstop['header_background'] = pixtheme_get_option('header_background', 'main-color');
    $pitstop['header_transparent'] = pixtheme_get_option('header_transparent', '100');
    $pitstop['header_background_bottom'] = pixtheme_get_option('header_background_bottom', 'white');
    $pitstop['header_transparent_bottom'] = pixtheme_get_option('header_transparent_bottom', '100');
    $pitstop['header_bar'] = pixtheme_get_option('header_bar', '0');
    $pitstop['top_bar_background'] = pixtheme_get_option('top_bar_background', 'black');
    $pitstop['top_bar_transparent'] = pixtheme_get_option('top_bar_transparent', '100');
    $pitstop['header_layout'] = pixtheme_get_option('header_layout', 'container-fluid');
    $pitstop['header_layout_bottom'] = pixtheme_get_option('header_layout_bottom', 'container');
    $pitstop['header_sticky'] = pixtheme_get_option('header_sticky', '');
    $pitstop['header_sticky_width'] = pixtheme_get_option('header_sticky_width', '');
    $pitstop['header_sticky_mobile'] = pixtheme_get_option('header_sticky_mobile', '');
    $pitstop['header_menu_pos'] = pixtheme_get_option('header_menu_pos', 'pix-text-center');


    /// Header menu settings
    $pitstop['header_menu'] = pixtheme_get_option('header_menu', '1');

    /// Header widgets
    $pitstop['header_minicart'] = pixtheme_get_option('header_minicart', '0');
    $pitstop['header_search'] = pixtheme_get_option('header_search', '1');
    $pitstop['header_socials'] = pixtheme_get_option('header_socials', '1');
    $pitstop['header_button'] = pixtheme_get_option('header_button', '0');

    $pitstop['header_phone'] = pixtheme_get_option('header_phone', '');
    $pitstop['header_email'] = pixtheme_get_option('header_email', '');
    $pitstop['header_address'] = pixtheme_get_option('header_address', '');

    /// Responsive
    $pitstop['mobile_sticky'] = pixtheme_get_option('mobile_sticky', '');
    $pitstop['mobile_topbar'] = pixtheme_get_option('mobile_topbar', '');
    $pitstop['tablet_minicart'] = pixtheme_get_option('tablet_minicart', '');
    $pitstop['tablet_search'] = pixtheme_get_option('tablet_search', '');
    $pitstop['tablet_phone'] = pixtheme_get_option('tablet_phone', '');
    $pitstop['tablet_socials'] = pixtheme_get_option('tablet_socials', '');


    /// Logo
    $pitstop['logo'] = pixtheme_get_option('general_settings_logo', '');
    $pitstop['logo_mobile'] = pixtheme_get_option('general_settings_logo_mobile', '');


	return $pitstop;
	
}