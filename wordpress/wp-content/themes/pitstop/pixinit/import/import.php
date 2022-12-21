<?php

function pixtheme_import_files() {
    return array(
        array(
            'import_file_name'           => esc_html__( 'Pitstop', 'pitstop' ),
            'import_file_url'            => esc_url('https://data.true-emotions.studio/themes/pitstop/pitstop.xml'),
            'import_widget_file_url'     => esc_url('https://data.true-emotions.studio/themes/pitstop/pitstop.json'),
            'import_customizer_file_url' => esc_url('https://data.true-emotions.studio/themes/pitstop/pitstop.dat'),
            'import_preview_image_url'   => esc_url('https://data.true-emotions.studio/themes/pitstop/pitstop.jpg'),
            'preview_url'                => esc_url('https://pitstop.true-emotions.studio/'),
        ),

    );
}
add_filter( 'pt-ocdi/import_files', 'pixtheme_import_files' );

function pixtheme_after_import( $selected_import ) {

    $menu_arr = array();
    $main_menu = get_term_by('name', 'Main', 'nav_menu');
    if(is_object($main_menu))
        $menu_arr['primary_nav'] = $main_menu->term_id;
    $left_menu = get_term_by('name', 'Left', 'nav_menu');
    if(is_object($left_menu))
        $menu_arr['primary_left_nav'] = $left_menu->term_id;
    $right_menu = get_term_by('name', 'Right', 'nav_menu');
    if(is_object($right_menu))
        $menu_arr['primary_right_nav'] = $right_menu->term_id;
    $footer_menu = get_term_by('name', 'Footer', 'nav_menu');
    if(is_object($footer_menu))
        $menu_arr['footer_nav'] = $footer_menu->term_id;
    set_theme_mod( 'nav_menu_locations', $menu_arr );

    if(function_exists('vc_set_default_editor_post_types')){
        $vc_list = array(
            'page',
            'post',
            'pix-team',
            'pix-portfolio',
            'pix-service',
            'pix-section',
        );
        vc_set_default_editor_post_types( $vc_list );
    }
    
    if ( 'Pitstop' === $selected_import['import_file_name'] ) {
        $slider_array = array(
            get_template_directory().'/pixinit/import/revslider/Home-1.zip',
            get_template_directory().'/pixinit/import/revslider/Home-2.zip',
            get_template_directory().'/pixinit/import/revslider/Home-3.zip',
            get_template_directory().'/pixinit/import/revslider/Home-4.zip',
            get_template_directory().'/pixinit/import/revslider/Home-5.zip',
            get_template_directory().'/pixinit/import/revslider/Home-8.zip',
        );
        $args = array(
            'post_type'        => 'pix-section',
            'post_status'      => 'publish',
        );
        $pix_sections = get_posts( $args );
        if( isset($pix_sections[0]) ){
            $pix_settings = get_option( 'pix-settings' );
            $pix_settings['pix-footer-section'] = $pix_sections[0]->ID;
            update_option( 'pix-settings', $pix_settings );
        }
    } else {
        $slider_array = array(
            get_template_directory().'/pixinit/import/revslider/Home-1.zip',
            get_template_directory().'/pixinit/import/revslider/Home-2.zip',
            get_template_directory().'/pixinit/import/revslider/Home-3.zip',
            get_template_directory().'/pixinit/import/revslider/Home-4.zip',
            get_template_directory().'/pixinit/import/revslider/Home-5.zip',
            get_template_directory().'/pixinit/import/revslider/Home-8.zip',
        );
        $args = array(
            'post_type'        => 'pix-section',
            'post_status'      => 'publish',
        );
        $pix_sections = get_posts( $args );
        if( isset($pix_sections[0]) ){
            $pix_settings = get_option( 'pix-settings' );
            $pix_settings['pix-footer-section'] = $pix_sections[0]->ID;
            update_option( 'pix-settings', $pix_settings );
        }
    }

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    
    if(class_exists('RevSlider')) {
    
        $absolute_path = __FILE__;
        $path_to_file = explode('wp-content', $absolute_path);
        $path_to_wp = $path_to_file[0];
    
        require_once($path_to_wp . '/wp-load.php');
        require_once($path_to_wp . '/wp-includes/functions.php');
    
        $slider = new RevSlider();
    
        foreach ($slider_array as $filepath) {
            $slider->importSliderFromPost(true, true, $filepath);
        }
    }

}
add_action( 'pt-ocdi/after_import', 'pixtheme_after_import' );

?>