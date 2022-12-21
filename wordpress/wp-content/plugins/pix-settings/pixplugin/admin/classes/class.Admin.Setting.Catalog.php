<?php

/**
 * Register, display and save a selection with a drop-down list of any taxonomy
 *
 * This setting accepts the following arguments in its constructor function.
 *
 * $args = array(
 *		'id'			=> 'setting_id', 	// Unique id
 *		'title'			=> 'My Setting', 	// Title or label for the setting
 *		'description'	=> 'Description', 	// Help text description
 *		'taxonomies'	=> array();			// Array of taxonomies to fetch (required)
 *		'blank_option'	=> true, 			// Whether or not to show a blank option
 *		'args'			=> array();			// Arguments to pass to WordPress's get_terms() function
 * );
 * type
 *
 * @since 1.0
 * @package Simple Admin Pages
 */

function pix_load_catalog($slugs, $max_lvl=4, $pid = 0, $html_res = "", $lvl=0){
    $lvl++;
    
    $args = array(
        'orderby'   => 'none',
        'parent'    => $pid,
    );
    $terms = get_terms( 'product_cat', $args );
    
    foreach( $terms as $term ){
        
        $checked = $slugs != '' && in_array( $term->slug, $slugs ) ? 'checked' : '';
        $children = get_term_children($term->term_id, 'product_cat');
        if( $children && $lvl <= $max_lvl){

            if($lvl==1)
                $html_res .= '<li><input type="checkbox" '.esc_attr($checked).' id="'.esc_attr($term->slug).'" name="'.esc_attr($term->slug).'"><label for="'.esc_attr($term->slug).'">'.esc_attr($term->name).'</label>';
            else
                $html_res .= '<li class="pix-sub"><input type="checkbox" '.esc_attr($checked).' id="'.esc_attr($term->slug).'" name="'.esc_attr($term->slug).'"><label for="'.esc_attr($term->slug).'">'.esc_attr($term->name).'</label>';

                $html_res .= '<ul  class="pix-subcategory">';
                $html_res = pix_load_catalog($slugs, $max_lvl, $term->term_id, $html_res, $lvl);
                $html_res .= '</ul>';

            $html_res .= '</li>';
        } elseif( $children && $lvl==1 ){

            $html_res .= '<li><input type="checkbox" '.esc_attr($checked).' id="'.esc_attr($term->slug).'" name="'.esc_attr($term->slug).'"><label for="'.esc_attr($term->slug).'">'.esc_attr($term->name).'</label>';
            $html_res .= '<ul class="pix-subcategory">';
            $html_res = pix_load_catalog($slugs, $max_lvl, $term->term_id, $html_res, $lvl);
            $html_res .= '</ul>';
            $html_res .= '</li>';
        } elseif($lvl<4) {
            if($children && $lvl>1)
                $html_res .= '<li class="pix-sub"><input type="checkbox" '.esc_attr($checked).' id="'.esc_attr($term->slug).'" name="'.esc_attr($term->slug).'"><label for="'.esc_attr($term->slug).'">'.esc_attr($term->name).'</label>';
            else
                $html_res .= '<li><input type="checkbox" '.esc_attr($checked).' id="'.esc_attr($term->slug).'" name="'.esc_attr($term->slug).'"><label for="'.esc_attr($term->slug).'">'.esc_attr($term->name).'</label></li>';
        }
    }
    
    $lvl--;
    return $html_res;
}

class PixAdminSettingCatalog extends PixAdminSetting {

	public $sanitize_callback = 'sanitize_text_field';

	// Arrays of taxonomies to fetch (required)
	public $taxonomy;
	
    public $scripts = array(
		'pix-catalog' => array(
			'path'			=> 'js/catalog.js',
			'dependencies'	=> array( 'jquery' ),
			'version'		=> '1.0.0',
			'footer'		=> true,
		),
	);
	/**
	 * Display this setting
	 * @since 1.0
	 */
	
	
	
	public function display_setting() {
     
	    $input_name = $this->get_input_name();
	    
	    $values_arr = !isset($this->value) || $this->value == '' ? '' : explode(',', substr($this->value, 0, -1));
		
		?>
            <div class="pix-catalog">
                <ul>
                    <?php echo pix_load_catalog($values_arr, 1); ?>
                </ul>
                <input type="hidden" class="pix-hidden-text" name="<?php echo $input_name; ?>" value="<?php echo $this->value; ?>"/>
            </div>

		<?php

		$this->display_description();

	}

}
