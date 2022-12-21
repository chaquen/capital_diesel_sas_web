<?php


if ( !class_exists('Pix_Nav_Menu')) {
    class Pix_Nav_Menu {
        
        function __construct() {
            
            // add custom menu fields to menu
            add_filter( 'wp_setup_nav_menu_item', array( $this, 'pix_add_custom_nav_fields' ) );
    
            // save menu custom fields
            add_action( 'wp_update_nav_menu_item', array( $this, 'pix_update_custom_nav_fields'), 10, 3 );
            
            // edit menu walker
            add_filter( 'wp_edit_nav_menu_walker', array( $this, 'pix_edit_walker'), 10, 2 );
    
        }
        
        function pix_add_custom_nav_fields( $menu_item ) {
        
            $menu_item->mega_menu = get_post_meta( $menu_item->ID, '_menu_item_mega_menu', true );
            $menu_item->catalog = get_post_meta( $menu_item->ID, '_menu_item_catalog', true );
            return $menu_item;
        
        }
        
        function pix_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
	
            // Check if element is properly sent
            if ( isset($_REQUEST['menu-item-mega-menu'][$menu_item_db_id]) ) {
                //$mega_menu_value = $_REQUEST['menu-item-mega-menu'][$menu_item_db_id];
                update_post_meta( $menu_item_db_id, '_menu_item_mega_menu', 1 );
            } else {
                update_post_meta( $menu_item_db_id, '_menu_item_mega_menu', 0 );
            }
            
            if ( isset($_REQUEST['menu-item-catalog'][$menu_item_db_id]) ) {
                update_post_meta( $menu_item_db_id, '_menu_item_catalog', 1 );
            } else {
                update_post_meta( $menu_item_db_id, '_menu_item_catalog', 0 );
            }
            
        }
        
        function pix_edit_walker($walker,$menu_id) {
	
            return 'Pix_Nav_Menu_Walker_Edit';
            
        }
        
    }
}
$pix_nav_menu = new Pix_Nav_Menu();

include_once( 'class.PixNavMenu.Walker.Edit.php' );
include_once( 'class.PixNavMenu.Walker.php' );