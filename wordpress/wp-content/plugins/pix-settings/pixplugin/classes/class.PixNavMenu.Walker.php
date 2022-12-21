<?php
/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
class Pix_Nav_Menu_Walker extends Walker_Nav_Menu{
    
    // add classes to ul sub-menus
	public function start_lvl( &$output, $depth = 0, $args = array() ) {

		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"submenu\">\n";
	}
    
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0){
        global $wp_query;
        
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		if( isset( $item->mega_menu ) && $item->mega_menu == 1 ) {
            $classes[] = 'pix-mega-menu';
        }
        
        if($depth == 0) {
		    $menu = wp_get_nav_menu_object( $args->menu );
		    if ( $menu && ! is_wp_error($menu) && !isset($menu_items) ) {
		        $menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );
		        $children = pixtheme_get_nav_menu_item_children($item->ID, $menu_items);
		        if( isset($children['lvl']) && $children['lvl'] > 2 ){
		            $classes[] = 'pix-submenu-vertical';
                }
            }
        }
        
		if(in_array('menu-item-has-children', $classes)) {
            $classes[] = 'arrow';
        }

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		if ( '_blank' === $item->target && empty( $item->xfn ) ) {
			$atts['rel'] = 'noopener noreferrer';
		} else {
			$atts['rel'] = $item->xfn;
		}
		$atts['href']         = ! empty( $item->url ) ? $item->url : '';
		$atts['aria-current'] = $item->current ? 'page' : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title        Title attribute.
		 *     @type string $target       Target attribute.
		 *     @type string $rel          The rel attribute.
		 *     @type string $href         The href attribute.
		 *     @type string $aria_current The aria-current attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		
		
		$item_output = '';
		
        if ($item->object != 'pix-section'){
            
            if(is_object($args)){
                $item_output  = $args->before;
                $item_output .= '<a' . $attributes . '>';
                $item_output .= $args->link_before . $title . $args->link_after;
                $item_output .= '</a>';
                $item_output .= $args->after;
                
                
                
                if( isset( $item->catalog ) && $item->catalog == 1 ) {
                    
                    $cats = explode(',', substr(pixtheme_get_setting('pix-catalog-selector'), 0, -1));
                    $cats_id_arr = array();
                    foreach($cats as $slug ){
                        $term = get_term_by('slug', $slug, 'product_cat');
                        $cats_id_arr[] = $term->term_id;
                    }
                    $woo_args = array(
                         'taxonomy'     => 'product_cat',
                         'orderby'      => 'menu_order',
                         'include'      => $cats_id_arr,
                         'parent'       => 0,
                    );
                    $woo_categories = get_categories( $woo_args );

                    $item_output  .= '
                    <div class="row">
                        <div class="pix-masonry-catalog">';
                    foreach ($woo_categories as $cat) {

                        $cat_count = isset($cat->count) && $cat->count != '' ? ' <span> ('.$cat->count.')</span>' : '';
                        $item_output  .= '
                            <div>
                                <a href="'.get_category_link( $cat->term_id ).'"><b>'.esc_attr( $cat->name ).'</b></a>';

                        $woo_sub_args = array(
                             'taxonomy'     => 'product_cat',
                             'orderby'      => 'menu_order',
                             'parent'       => $cat->term_id,
                        );
                        $woo_subcategories = get_categories( $woo_sub_args );

                        if($woo_subcategories){
                            $item_output  .= '<ul>';
                            foreach ($woo_subcategories as $subcat) {
                                $item_output  .= '<li><a href="'.get_category_link( $subcat->term_id ).'">'.esc_attr($subcat->name).'</a></li>';
                            }
                            $item_output  .= '</ul>';
                            $item_output  .= count($woo_subcategories) > 4 ? '<p><a class="pix-more-open" href="#">'.esc_html('show more', 'pixsettings').'</a><a class="pix-more-close hide" href="#">'.esc_html('close', 'pixsettings').'</a></p>' : '';
                        }
                        $item_output  .= '
                            </div>';
                    }
                    $item_output  .= '
                        </div>
                    </div>';

                }
            }else{
                $item_output = '<a'. $attributes .'>';
                $item_output .= $title ;
                $item_output .= '</a>';
            }

        }else{

            $post = get_post($item->object_id);

            $shortcodes_custom_css = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
            if ( ! empty( $shortcodes_custom_css ) ) {
                $item_output .= '<style scoped type="text/css" data-type="vc_shortcodes-custom-css">';
                $item_output .= esc_html($shortcodes_custom_css);
                $item_output .= '</style>';
            }

            $item_output .= $post->post_content;

        }

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter .pix-masonry-catalog {
    column-count: 4;
    column-gap: 10px;
    padding: 20px 10px;
    align-self: start;
}for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		if ($item->object == 'pix-section'){
            $output .= $item_output;
        }else{
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    
    }
}