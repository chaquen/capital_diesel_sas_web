<?php

namespace Elementor;

class PixTheme_EL_Pix_Filter extends Widget_Base {
	
	public function get_name() {
		return 'pix-filter';
	}
	
	public function get_title() {
		return esc_html__( 'Products Filter', 'pitstop' );
	}
	
	public function get_icon() {
		return 'fas fa-filter';
	}
	
	public function get_categories() {
		return [ 'pixtheme' ];
	}
	
	protected function _register_controls() {
		
		$args = [ 'post_type' => 'page', 'posts_per_page' => -1 ];
        $pages_arr = get_posts($args);
        $pages = [];
        if(empty($pages_arr['errors'])){
            foreach($pages_arr as $page){
                $pages[$page->ID] = $page->post_title;
            }
        }

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'pitstop' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
  
		$this->add_control(
			'filter',
			[
				'label' => esc_html__( 'Fields', 'pitstop' ),
				'type' => 'products_filter',
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'param_title',
			[
				'label' => esc_html__( 'Show Params Title', 'pitstop' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'off',
                'default' => 'off',
			]
		);
		$this->add_control(
			'page',
			[
                'label' => esc_html__( 'Page with Result', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__( 'Select page to redirect for result', 'pitstop' ),
                'options' => $pages,
            ]
		);
		$this->add_control(
			'btn_txt',
			[
				'label' => esc_html__( 'Button Text', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$this->end_controls_section();
		
	}
	
	protected function render() {
	    
	    global $pix_settings;

        $pix_el = $this->get_settings_for_display();
        
        $out = '';
        $filter = $pix_el['filter'];
        $btn_txt = $pix_el['btn_txt'];
        $param_title = $pix_el['param_title'];
        $page = $pix_el['page'];
        
        $filters = json_decode(html_entity_decode($filter), true);
        
        if ( $filters !== NULL && !empty($filters) ) {
        
            $filters_arr = $filters_arr_2 = array();
        
            foreach ($filters as $key => $val) {
             
                $attr_name = $val['id'];
                $label_out_id = $param_title == 'on' ? '<label for="'.esc_attr($attr_name).'">'.wp_kses($val['name'], 'post').'</label>' : '';
                $label_out = $param_title == 'on' ? '<label>'.wp_kses($val['name'], 'post').'</label>' : '';
                
                if($val['id'] == 'cars' && $val['show']) {
                    $args_tax = array(
                        'taxonomy' => array('pix-product-car'),
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'parent' => '0',
                        'hide_empty' => '0',
                    );
                    $cars_categories = get_categories($args_tax);
                    
                    $out_makes = '';
        
                    foreach ($cars_categories as $car_cat) {
                        $out_makes .= '<option value="' . esc_attr($car_cat->slug) . '">' . esc_html($car_cat->name) . '</option>';
                    }
                    $filter_out = '
                        <div class="pix-filter-select">
                            '.$label_out.'
                            <select id="ajax-make" class="pix-count" name="ajax-make" data-placeholder="'.esc_attr__('Select Make', 'pitstop').'" data-type="select" data-field="make">
                                '.($out_makes).'
                            </select>
                        </div>';
            
                    $filter_out_2 = '
                        <div class="pix-filter-select">
                            <select class="pix-filter pix-count" id="pix-model" name="pix-model" data-placeholder="'.esc_attr__('Select Model', 'pitstop').'" data-type="select" data-field="model">
                            </select>
                        </div>';
            
                    $filter_out_3 = '
                        <div class="pix-filter-select">
                            <select class="pix-filter pix-count" id="pix-restyle" name="pix-restyle" data-placeholder="'.esc_attr__('Select Restyle', 'pitstop').'" data-type="select" data-field="restyle">
                            </select>
                        </div>';
            
                    if($val['row'] == '2'){
                        $filters_arr_2[] = $filter_out;
                        $filters_arr_2[] = $filter_out_2;
                        //$filters_arr_2[] = $filter_out_3;
                    } else {
                        $filters_arr[] = $filter_out;
                        $filters_arr[] = $filter_out_2;
                        //$filters_arr[] = $filter_out_3;
                    }
        
                } elseif($val['id'] == 'price' && $val['show']) {
        
                    $filter_out = '
                        <div class="pix-range-box">
                            '.$label_out_id.'
                            <input id="'.esc_attr($val['id']).'" class="pix-range-slider" hidden type="text" value="" data-skin="pix" data-type="double" data-min="0" data-max="'.esc_attr($pix_settings->settings->get_setting('pix-woo-range-max')).'" data-from="0" data-to="'.esc_attr($pix_settings->settings->get_setting('pix-woo-range-max')).'" data-step="'.esc_attr($pix_settings->settings->get_setting('pix-woo-range-step')).'" data-prettify-separator="'.esc_attr(wc_get_price_thousand_separator()).'" data-grid="false" '.wp_kses(pixtheme_range_price_format(), 'post').'>
                            <input type="hidden" class="pix-min pix-filter pix-count" data-type="number" data-field="'.esc_attr($val['id']).'" value="">
                            <input type="hidden" class="pix-max pix-filter pix-count" data-type="number" data-field="'.esc_attr($val['id']).'" value="">
                        </div>';
            
                    if($val['row'] == '2'){
                        $filters_arr_2[] = $filter_out;
                    } else {
                        $filters_arr[] = $filter_out;
                    }
        
                } elseif($val['show']) {
                    $terms = get_terms([
                        'taxonomy' => 'pa_'.$val['id'],
                        'hide_empty' => false,
                    ]);
                    $attr_name = $val['id'];
                    
                    $attrs = get_option($val['id']);
                    $type_sel = 'select';
                    if(isset($attrs['filter-type'])){
                        $type_sel = $attrs['filter-type'];
                    }
        
                    switch ($type_sel) {
                        
                        case 'checkbox':
                            $filter_out = $label_out;
                            foreach ($terms as $term) {
                                $filter_out .= '
                                <div class="pix-product-box-checkbox">
                                    <label>
                                        <input class="pix-filter pix-count" data-type="check" data-field="'.esc_attr($attr_name).'"
                                           type="checkbox"
                                           name="pa_'.esc_attr($attr_name).'" id="'.esc_attr($term->slug).'"
                                           value="'.esc_attr($term->slug).'">
                                        <span class="pix-checkbox-icon"></span>
                                        <span class="pix-checkbox-text">'.wp_kses($term->name, 'post').'</span>
                                    </label>
                                </div>';
                            }
                            break;
                            
                        case 'toggle':
                            $filter_out = '
                            <div class="pixControl noborder">
                                <div class="pix-filter-toggle">
                                    <label for="'.esc_attr($attr_name).'">'.wp_kses($val['name'], 'post').'</label>
                                    <div class="pix-checkbox">
                                        <input id="'.esc_attr($attr_name).'" name="pa_'.esc_attr($attr_name).'"  type="checkbox" class="pix-filter pix-count" data-type="check" data-field="'.esc_attr($attr_name).'">
                                        <div></div>
                                    </div>
                                </div>
                            </div>';
                            break;
                            
                        case 'segmented':
                            $output = array();
                            if ( ! empty( $terms ) ) {
                                $i=0;
                                $cnt = count($terms)-1;
                                $pix_rand = 'pixid-'.rand().'-';
                                foreach ($terms as $term) {
                                    $class = '';
                                    if( $i == 0 ){
                                        $class = 'first';
                                    } elseif ( $i == $cnt ){
                                        $class = 'last';
                                    }
                    
                                    $output[] = '<input class="pix-filter pix-count pix-segmented-button-field" id="' . $pix_rand . $term->slug . '" name="pa_'.esc_attr($attr_name).'" value="' . $term->slug . '" type="radio" data-type="check" data-field="'.esc_attr($attr_name).'">
                                    <label class="' . $class . '" for="' . $pix_rand . $term->slug . '"> '.esc_attr($term->name).' </label>';
                                    
                                    $i++;
                                }
                            }
                            
                            $filter_out = '
                            <div class="pixControl noborder">
                                '.$label_out_id.'
                                <div id="'.esc_attr($attr_name).'" class="pix-filter-segmented-button">
                                '.implode($output).'
                                </div>
                            </div>';
                            break;
                            
                        case 'input':
                            $filter_out = '
                            <div class="pix-filter-input">
                                '.$label_out_id.'
                                <input id="'.esc_attr($attr_name).'" type="number" class="pix-filter pix-count" data-type="number" data-field="'.esc_attr($attr_name).'">
                            </div>';
                            break;
                            
                        case 'input-range':
                            $filter_out = '
                            <div class="pix-filter-input">
                                '.$label_out_id.'
                                <div id="'.esc_attr($attr_name).'" class="pix-double-control">
                                    <input type="number" class="pix-min pix-filter pix-count" data-type="number" data-field="'.esc_attr($attr_name).'">
                                    <span>&ndash;</span>
                                    <input type="number" class="pix-max pix-filter pix-count" data-type="number" data-field="'.esc_attr($attr_name).'">
                                </div>
                            </div>';
                            break;
                            
                        case 'range':
                            $filter_out = '
                            <div class="pix-range-box">
                                '.$label_out_id.'
                                <input id="'.esc_attr($attr_name).'" class="pix-range-slider" hidden type="text" value="" data-skin="pix" data-type="double" data-min="0" data-max="5000" data-step="10" data-from="'.(isset($get_values[0]) ? esc_attr($get_values[0]) : 0).'" data-to="'.(isset($get_values[1]) ? esc_attr($get_values[1]) : 5000).'" data-grid="false">
                                <input type="hidden" class="pix-min pix-filter pix-count" data-type="number" data-field="'.esc_attr($attr_name).'" value="'.(isset($get_values[0]) ? esc_attr($get_values[0]) : '').'">
                                <input type="hidden" class="pix-max pix-filter pix-count" data-type="number" data-field="'.esc_attr($attr_name).'" value="'.(isset($get_values[1]) ? esc_attr($get_values[1]) : '').'">
                            </div>';
                            break;
                            
                        case 'multi-select':
                            $terms_values = '';
                            foreach ( $terms as $term ) {
                                $terms_values .= '<option value="'.esc_attr($term->slug).'">' . $term->name . '</option>';
                            }
                            $filter_out = '
                            <div class="pix-filter-multi-select">
                                '.$label_out_id.'
                                <select id="'.esc_attr($attr_name).'" class="pix-filter pix-count" multiple data-placeholder="'.($val['name']).'" data-type="multi-select" data-field="'.esc_attr($attr_name).'">'.$terms_values.'</select>
                            </div>';
                            break;
                            
                        case 'select':
                            $terms_values = '';
                            foreach ( $terms as $term ) {
                                $terms_values .= '<option value="'.esc_attr($term->slug).'">' . $term->name . '</option>';
                            }
                            $filter_out = '
                            <div class="pix-filter-select">
                                '.$label_out_id.'
                                <select id="'.esc_attr($attr_name).'" class="pix-filter pix-count" data-placeholder="'.esc_html($val['name']).'" data-type="select" data-field="'.esc_attr($attr_name).'">
                                    '.$terms_values.'
                                </select>
                            </div>';
                            break;
                    }
            
                    if($val['row'] == '2'){
                        $filters_arr_2[] = $filter_out;
                    } else {
                        $filters_arr[] = $filter_out;
                    }
                    
                }
                
            }
            
            $final_title = empty( $title ) ? '' : '<h3 class="pix-filter-title pix-h1-h6 h3-size mt-0">'.$title.'</h3>';
            $show_btn = '<a href="'.get_permalink($page).'" class="pix-button pix-h-xl" data-page="'.get_permalink($page).'" data-href="">' . ($btn_txt) . ' <span></span></a>';
            
            $out = '
                <div class="pix__filterInner pix-filter-box">
                    <div class="pix__filterHeader">
                        <div class="row row-cols-sm-2 row-cols-lg-3 row-cols-xl-5 align-items-end">';
                if($final_title != ''){
                    $out .= '
                            <div class="col col-sm-12 col-lg-8 mb-40">
                                <div class="pix__sectionTitle mb-xl-10">
                                    '.$final_title.'
                                </div>
                            </div>';
                }
                foreach( $filters_arr as $val ) {
                    $out .= '
                             <div class="col mb-40">
                                ' . $val . '
                            </div>';
                }
                if(count($filters_arr_2) == 0){
                    $out .= '
                            <div class="w-100 d-sm-none"></div>
                            <div class="col col-sm-12 col-lg-8 mb-40">
                                <div class="text-center">
                                    <a href="' . get_permalink($page) . '" class="pix-button pix-h-xl" data-page="' . get_permalink($page) . '" data-href="">' . ($btn_txt) . ' <span></span></a>
                                </div>
                            </div>';
                }
                $out .= '
                        </div>
                    </div>';
            
            if(count($filters_arr_2) > 0) {
                $out .= '
                    <div class="pix__filterControls">
                        <div class="row row-cols-sm-2 row-cols-lg-3 row-cols-xl-5 align-items-end">';
                foreach( $filters_arr_2 as $val ) {
                    $out .= '
                             <div class="col mb-40">
                                ' . $val . '
                            </div>';
                }
                $out .= '
                            <div class="w-100 d-sm-none"></div>
                            <div class="col col-sm-12 col-lg-8 mb-40">
                                <div class="text-center">
                                    <a href="' . get_permalink($page) . '" class="pix-button pix-h-xl" data-page="' . get_permalink($page) . '" data-href="">' . ($btn_txt) . ' <span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            $out .= '
                </div>';
        
        }
        
        pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}