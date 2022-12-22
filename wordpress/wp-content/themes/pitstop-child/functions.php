<?php
/************* LOAD REQUIRED SCRIPTS AND STYLES *************/
function pix_child_load_css(){
    wp_enqueue_style('style', get_stylesheet_uri() );
    wp_enqueue_style('pitstop', get_template_directory_uri() . '/style.css' );
}
add_action('wp_enqueue_scripts', 'pix_child_load_css'); //Load All Css