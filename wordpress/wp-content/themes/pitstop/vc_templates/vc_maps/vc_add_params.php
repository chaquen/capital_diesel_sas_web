<?php

    if(function_exists('pix_vc_add_param')){
        pix_vc_add_param( 'radio_images', 'pixtheme_radio_images_param_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_radio_images.js' );
        pix_vc_add_param( 'switch_button', 'pixtheme_switch_button_param_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_switch_button.js' );
        pix_vc_add_param( 'segmented_button', 'pixtheme_segmented_button_param_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_segmented_button.js' );
        pix_vc_add_param( 'range_slider', 'pixtheme_range_slider_param_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_range_slider.js' );
        pix_vc_add_param( 'cars_filter', 'pixtheme_cars_filter_param_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_cars_filter.js' );
        pix_vc_add_param( 'pix_filter', 'pixtheme_filter_param_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_filter.js' );
    }

	function pixtheme_radio_images_param_settings_field( $settings, $value ) {
		$output = array();
		$col = isset($settings['col']) ? $settings['col'] : 2;
		$values = isset( $settings['value'] ) && is_array( $settings['value'] ) ? $settings['value'] : array( esc_html__( 'Yes', 'pitstop' ) => 'true' );
		if ( ! empty( $values ) ) {
			foreach ( $values as $label => $v ) {
				$checked = $value == $v ? 'checked' : '';
				$label_arr = explode(';', $label);
				$label = isset($label_arr[0]) ? $label_arr[0] : '';
				$title = isset($label_arr[1]) ? '<span>'.($label_arr[1]).'</span>' : '';
				$output[] = '
				<div class="radio-image-item">
					<input id="pixid-' . $v . '" value="' . $v . '" type="radio" class="pix-radio-images-field" ' . $checked . '>
					<label class="vc_checkbox-label" for="pixid-' . $v . '"> <img src="'.esc_url(get_template_directory_uri() . '/images/elements/'.$label).'" >'.($title).'</label>
				</div>';
			}
		}
	    return '<div class="my_param_block pix-vc-radio-images pix-col-'.esc_attr($col).'">'.implode($output).'<input type="text" name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput pix-input-vc-radio-images hidden-field-value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" value="' . $value . '"/></div>';
	}


    function pixtheme_switch_button_param_settings_field( $settings, $value ) {
        if( (!isset($value) || $value == '') && isset( $settings['value'] ) && $settings['value'] != '' ){
            $value = $settings['value'];
        } elseif( (!isset($value) || $value == '') && (!isset( $settings['value'] ) || $settings['value'] == '') ) {
            $value = 'off';
        }
        $checked = $value == 'on' ? 'checked' : '';
        $output = '
            <label class="switch switch-green">
              <input type="checkbox" class="switch-input pix-switch-button-field" '.esc_attr($checked).'>
              <span class="switch-label" data-on="On" data-off="Off"></span>
              <span class="switch-handle"></span>
            </label>
        ';
        return '<div class="my_param_block pix-vc-switch-button">'.($output).'<input type="text" name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput pix-input-vc-switch-button hidden-field-value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" value="' . $value . '"/></div>';
    }


    function pixtheme_segmented_button_param_settings_field( $settings, $value ) {
        $output = array();
        $values = isset( $settings['value'] ) && is_array( $settings['value'] ) ? $settings['value'] : array( esc_html__( 'Yes', 'pitstop' ) => 'true' );
        if ( ! empty( $values ) ) {
            $i=0;
            $cnt = count($values)-1;
            $defalut = '';
            $pix_rand = 'pixid-'.rand().'-';
            foreach ( $values as $label => $v ) {
                if( $i == 0 ){
                    $defalut = $label == 'default' ? $v : 'undefined';
                }
                $class = '';
                if( $i == 1 ){
                    $class = 'first';
                } elseif ( $i == $cnt ){
                    $class = 'last';
                }
                $checked = '';
                if( (!isset($value) || empty($value)) && $value == $defalut ){
                    $checked = 'checked';
                } elseif( $value == $v ){
                    $checked = 'checked';
                }

                if($defalut != 'undefined' && $i > 0) {
                    $output[] = '<input id="' . $pix_rand . $v . '" value="' . $v . '" type="radio" class="pix-segmented-button-field" ' . $checked . '>
                    <label class="' . $class . '" for="' . $pix_rand . $v . '"> ' . $label . ' </label>';
                }
                $i++;
            }
        }
        return '<div class="my_param_block pix-vc-segmented-button">'.implode($output).'<input type="text" name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput pix-input-vc-segmented-button hidden-field-value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" value="' . $value . '"/></div>';
    }
    

    function pixtheme_range_slider_param_settings_field( $settings, $value ) {
        $values = isset( $settings['value'] ) && is_array( $settings['value'] ) ? $settings['value'] : array( esc_html__( 'Yes', 'pitstop' ) => 'true' );
        if ( ! empty( $values ) ) {
            $i=0;
            $defalut = $min = $max = '';
            $unit = 'px';
            $step = '1';
            foreach ( $values as $label => $v ) {

                if( $label == 'min' ){
                    $min = $v;
                } elseif ( $label == 'max' ){
                    $max = $v;
                } elseif( $label == 'default' ){
                    $defalut = $v;
                } elseif( $label == 'step' ){
                    $step = $v;
                } elseif( $label == 'unit' ){
                    $unit = $v;
                } else
                    $defalut = '0';

                if( !isset($value) || empty($value) ){
                    $value = $defalut;
                }
                $i++;
            }
        }
        $output = '
            <input type="text" class="pix-range-slider-field" data-unit="'.esc_attr($unit).'" data-min="'.esc_attr($min).'" data-max="'.esc_attr($max).'" data-step="'.esc_attr($step).'" value="'.esc_attr((int)$value).'">
            <div class="range-values range-single-input">
                <input data-type="number" class="range-value">
            </div>
        ';
        return '<div class="my_param_block pix-vc-range-slider">'.($output).'<input type="text" name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput pix-input-vc-range-slider hidden-field-value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" value="' . (int)$value . '"/></div>';
    }

    function pixtheme_cars_filter_param_settings_field( $settings, $value ){
        $title_arr = array(
            'makes' => array(
                'title' => esc_html__('Makes', 'pitstop'),
                'placeholder' => esc_html__('Select Car Make', 'pitstop'),
            ),
            'models' => array(
                'title' => esc_html__('Models', 'pitstop'),
                'placeholder' => esc_html__('Select Car Model', 'pitstop'),
            ),
            'years' => array(
                'title' => esc_html__('Year', 'pitstop'),
                'placeholder' => esc_html__('Years', 'pitstop'),
            ),
            'price' => array(
                'title' => esc_html__('Price', 'pitstop'),
                'placeholder' => esc_html__('Price', 'pitstop'),
            ),
            'body' => array(
                'title' => esc_html__('Body Type', 'pitstop'),
                'placeholder' => esc_html__('Select Body Type', 'pitstop'),
            ),
            'fuel' => array(
                'title' => esc_html__('Fuel', 'pitstop'),
                'placeholder' => esc_html__('Select Fuel', 'pitstop'),
            ),
            'transmission' => array(
                'title' => esc_html__('Transmission', 'pitstop'),
                'placeholder' => esc_html__('Select Transmission', 'pitstop'),
            ),
            'engine' => array(
                'title' => esc_html__('Engine Capacity', 'pitstop'),
                'placeholder' => esc_html__('Engine Capacity', 'pitstop'),
            ),
            'mileage' => array(
                'title' => esc_html__('Mileage', 'pitstop'),
                'placeholder' => esc_html__('Mileage', 'pitstop'),
            ),
        );

        if( !isset($value) || empty($value) ){
            $values = array(
                array(
                    'id' => 'makes',
                    'name' => $title_arr['makes']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'models',
                    'name' => $title_arr['models']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'years',
                    'name' => $title_arr['years']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'price',
                    'name' => $title_arr['price']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'body',
                    'name' => $title_arr['body']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'fuel',
                    'name' => $title_arr['fuel']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'transmission',
                    'name' => $title_arr['transmission']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'engine',
                    'name' => $title_arr['engine']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'mileage',
                    'name' => $title_arr['mileage']['placeholder'],
                    'show' => true,
                ),
            );
            $value = json_encode($values);
        } else {
            $values = json_decode(html_entity_decode($value), true);
        }
        
        $output = '<div class="pix-widget-sortable ' . esc_attr($settings['param_name']) . '">';

        foreach($values as $key => $val){
            $checked = $val['show'] ? 'checked' : '';
            $output .= '
            <div class="pix-widget-option" data-field="'.esc_attr($val['id']).'">
                
                <label>'.esc_attr($title_arr[ $val['id'] ]['title']).': <input type="text" placeholder="'.esc_attr( $title_arr[ $val['id'] ]['placeholder'] ).'" value="'.esc_attr( $val['name'] ).'" '.($checked == 'checked' ? '' : 'disabled').' /></label>

                <label class="switch switch-green">
                  <input type="checkbox" class="switch-input" '.esc_attr($checked).' />
                  <span class="switch-label" data-on="On" data-off="Off"></span>
                  <span class="switch-handle"></span>
                </label>
                
            </div>';
        }

        $output .= '</div>';

        return '<div class="my_param_block pix-vc-cars-filter">'.($output).'<input type="text" name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput pix-input-vc-cars-filter hidden-field-value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" value=\'' . ($value) . '\'/></div>';
    }
    
    
    function pixtheme_filter_param_settings_field( $settings, $value ){
    	
        $title_arr = array(
            'price' => array(
                'title' => esc_html__('Price', 'pitstop'),
                'placeholder' => esc_html__('Price', 'pitstop'),
            ),
            'cars' => array(
                'title' => esc_html__('Make', 'pitstop'),
                'placeholder' => esc_html__('Car Make', 'pitstop'),
            ),
            'models' => array(
                'title' => esc_html__('Model', 'pitstop'),
                'placeholder' => esc_html__('Car Model', 'pitstop'),
            ),
            'restyles' => array(
                'title' => esc_html__('Restyle', 'pitstop'),
                'placeholder' => esc_html__('Car Restyle', 'pitstop'),
            ),
            'versions' => array(
                'title' => esc_html__('Version', 'pitstop'),
                'placeholder' => esc_html__('Car Version', 'pitstop'),
            ),
        );
	
	    $woo_pa = wc_get_attribute_taxonomies();
	    $woo_pa_visible = array();
	    $woo_key = array();
	    
	    $attrs = get_option('cars');
		if($attrs['filter-visible'] != 'hide') {
		    $woo_key[] = 'cars';
			$woo_pa_visible[] = 'cars';
			$woo_key[] = 'models';
			$woo_pa_visible[] = 'models';
			$woo_key[] = 'restyles';
			$woo_pa_visible[] = 'restyles';
			$woo_key[] = 'versions';
			$woo_pa_visible[] = 'versions';
		}
	    $attrs = get_option('price');
		if($attrs['filter-visible'] != 'hide') {
		    $woo_key[] = 'price';
			$woo_pa_visible[] = 'price';
		}
	    
        foreach($woo_pa as $key => $val) {
            $attrs = get_option($val->attribute_name);
            if($attrs['filter-visible'] != 'hide'){
                $woo_key[] = $val->attribute_name;
	            $label = isset($attrs['filter-label']) && $attrs['filter-label'] != '' ? $attrs['filter-label'] : $val->attribute_label;
	            $title_arr[$val->attribute_name] = array(
		            'title' => $label,
		            'placeholder' => $label,
	            );
	            $woo_pa_visible[] = $val->attribute_name;
            }
            else {
	            unset($woo_pa[$key]);
            }
        }
        $cars = array(
            'attribute_name' => 'cars',
            'attribute_label' => esc_html__('Cars', 'pitstop'),
        );
        $models = array(
            'attribute_name' => 'models',
            'attribute_label' => esc_html__('Models', 'pitstop'),
        );
        $restyles = array(
            'attribute_name' => 'restyles',
            'attribute_label' => esc_html__('Restyles', 'pitstop'),
        );
        $versions = array(
            'attribute_name' => 'versions',
            'attribute_label' => esc_html__('Versions', 'pitstop'),
        );
        $price = array(
            'attribute_name' => 'price',
            'attribute_label' => esc_html__('Price', 'pitstop'),
        );
        
        array_unshift($woo_pa, (object)$cars);
        array_unshift($woo_pa, (object)$models);
        array_unshift($woo_pa, (object)$restyles);
        array_unshift($woo_pa, (object)$versions);
        array_unshift($woo_pa, (object)$price);
	    
        //return implode(';', $woo_pa_visible).'<br>'.implode(';', $woo_key);
        
        $values = array();
        $keys = '';
        if( !isset($value) || empty($value) ){
            foreach($woo_pa as $key => $val) {
                $values[] = array(
                    'id' => $val->attribute_name,
                    'name' => $val->attribute_label,
                    'row' => '1',
                    'show' => true,
                );
            }
            $value = json_encode($values);
        } else {
            $values_temp = [];
            $values = json_decode(html_entity_decode($value), true);
            foreach($values as $k => $v) {
                if(!in_array($v['id'], $values_temp)){
                    $values_temp[] = $v['id'];
                } else {
                    unset($values[$k]);
                }
            }
            foreach($woo_pa as $key => $val) {
                if( !in_array($val->attribute_name, $values_temp) ){
                    $values[] = array(
                        'id' => $val->attribute_name,
                        'name' => $val->attribute_label,
                        'row' => '1',
                        'show' => false,
                    );
                }
            }
            
        }
        
        
        
        $output = '<div class="pix-widget-sortable ' . esc_attr($settings['param_name']) . '">';
        
        foreach($values as $key => $val){
            $checked = $val['show'] ? 'checked' : '';
            $checked_row1 = $val['row'] == '1' ? 'checked' : '';
            $checked_row2 = $val['row'] == '2'? 'checked' : '';
            if(in_array($val['id'], $woo_pa_visible)) {
	            $output .= '
	            <div class="pix-widget-option" data-field="' . esc_attr($val['id']) . '">
	                
	                <label>' . esc_attr($title_arr[$val['id']]['title']) . ': <input type="text" placeholder="' . esc_attr($title_arr[$val['id']]['placeholder']) . '" value="' . esc_attr($val['name']) . '" ' . ($checked == 'checked' ? '' : 'disabled') . ' /></label>
	                
	                <span class="pix-vc-segmented-button">
	                    <input id="' . $val['id'] . '1" name="' . $val['id'] . '" value="1" type="radio" class="pix-segmented-button-field ' . esc_attr($checked_row1) . '" ' . esc_attr($checked_row1) . ' ' . ($checked == 'checked' ? '' : 'disabled') . '><label title="' . esc_html__('Row', 'pitstop') . '" class="first" for="' . $val['id'] . '1">1</label>
	                    <input id="' . $val['id'] . '2" name="' . $val['id'] . '" value="2" type="radio" class="pix-segmented-button-field ' . esc_attr($checked_row2) . '" ' . esc_attr($checked_row2) . ' ' . ($checked == 'checked' ? '' : 'disabled') . '><label title="' . esc_html__('Row', 'pitstop') . '" class="last" for="' . $val['id'] . '2">2</label>
	                </span>
	
	                <label class="switch switch-green">
	                    <input type="checkbox" class="switch-input" ' . esc_attr($checked) . ' />
	                    <span class="switch-label" data-on="On" data-off="Off"></span>
	                    <span class="switch-handle"></span>
	                </label>
	            </div>';
            }
        }

        $output .= '</div>';
        
        return '<div class="my_param_block pix-vc-filter">'.($output).'<input type="text" name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput pix-input-vc-filter hidden-field-value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" value=\'' . ($value) . '\'/></div>';
        
    }

?>
