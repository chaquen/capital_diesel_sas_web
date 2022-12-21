<?php

	$vc_icons_data = pixtheme_init_vc_icons();

	$args = array( 'hide_empty' => false, 'hierarchical' => false, 'parent' => 0 );
	$categories = get_terms( $args );
	$cats = $cats_team = $cats_post = $cats_woo = $cats_serv = $calendars = $calculators = array();
	$calendars[esc_html__('Default Calendar', 'pitstop')] = 0;
	$calculators[esc_html__('Default', 'pitstop')] = 0;
	
	foreach($categories as $category){
		if( is_object($category) ){
			if( $category->taxonomy == 'pix-portfolio-cat' ){
				$cats[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'pix-team-cat' ) {
				$cats_team[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'category' ) {
				$cats_post[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'product_cat' ) {
				$cats_woo[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'pix-service-cat' ) {
				$cats_serv[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'pix-calculator' ) {
				$calculators[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'booked_custom_calendars' ) {
				$calendars[$category->name] = $category->term_id;
			}
		}
	}
	
	$args = array( 'post_type' => 'page', 'posts_per_page' => -1);
	$pages_arr = get_posts($args);
	$pages = array();
	if(empty($pages_arr['errors'])){
		foreach($pages_arr as $page){
			$pages[$page->post_title] = $page->ID;
		}
	}

	$pix_banners = get_posts(['post_type' => 'pix-banner', 'posts_per_page' => -1]);
	$banners = [esc_html__('No Banner', 'pitstop') => 0];
	if(empty($pix_banners['errors'])){
		foreach($pix_banners as $banner){
			$banners[$banner->post_title] = $banner->ID;
		}
	}

	$args = array( 'post_type' => 'pix-service');
	$services = get_posts($args);
	$serv = array();
	if(empty($services['errors'])){
		foreach($services as $service){
			$serv[$service->post_title] = $service->ID;
		}
	}
	
	$args = array( 'post_type' => 'wpcf7_contact_form');
	$forms = get_posts($args);
	$cform7 = array();
	if(empty($forms['errors'])){
		foreach($forms as $form){		
			$cform7[$form->post_title] = $form->ID;
		}
	}
	
	$args = array( 'post_type' => 'pix-section', 'post_status' => 'publish' );
	$pix_sections = get_posts($args);
	$sections = array();
	if(empty($pix_sections['errors'])){
		foreach($pix_sections as $pix_section){
			$sections[$pix_section->post_title] = $pix_section->ID;
		}
	}
    
    $post_types_control = array();
	$post_types = array(
	    'default' => 'pix-portfolio',
    );
	if(pixtheme_get_setting('pix-portfolio', 'off') == 'on'){
	    $post_types[esc_html__('Portfolio', 'pitstop')] = 'pix-portfolio';
        $post_types_control[] = array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Portfolio Categories', 'pitstop' ),
            'param_name' => 'portfolio_cat',
            'value' => $cats,
            'description' => esc_html__( 'Select categories to show', 'pitstop' ),
            'dependency' => array(
                'element' => 'post_type',
                'value' => array('pix-portfolio'),
            )
        );
	}
	if(pixtheme_get_setting('pix-service', 'off') == 'on'){
	    $post_types[esc_html__('Services', 'pitstop')] = 'pix-service';
        $post_types_control[] = array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Departments', 'pitstop' ),
            'param_name' => 'service_cat',
            'value' => $cats_serv,
            'description' => esc_html__( 'Select categories to show', 'pitstop' ),
            'dependency' => array(
                'element' => 'post_type',
                'value' => array('pix-service'),
            )
        );
	}
	if(pixtheme_get_setting('pix-team', 'off') == 'on'){
	    $post_types[esc_html__('Team', 'pitstop')] = 'pix-team';
        $post_types_control[] = array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Team Categories', 'pitstop' ),
            'param_name' => 'team_cat',
            'value' => $cats_team,
            'description' => esc_html__( 'Select categories to show', 'pitstop' ),
            'dependency' => array(
                'element' => 'post_type',
                'value' => array('pix-team'),
            )
        );
	}
	if ( class_exists( 'WooCommerce' ) ) {
        $post_types[esc_html__('Products', 'pitstop')] = 'product';
        $post_types_control[] = array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Products Categories', 'pitstop' ),
            'param_name' => 'product_cat',
            'value' => $cats_woo,
            'description' => esc_html__( 'Select categories to show', 'pitstop' ),
            'dependency' => array(
                'element' => 'post_type',
                'value' => array('product'),
            )
        );
    }
    
    function pix_vc_control($control, $field_class = '', $dep_element = '', $dep_arr = array(), $title = '', $default = ''){
	    
	    $control_arr = array();
	    
	    switch ($control) {
	        case 'radius' :
	            $title = empty($title) ? esc_html__( 'Shape', 'pitstop' ) : $title;
	            $default = empty($default) ? 'pix-global' : $default;
	            $control_arr = array(
	                'type' => 'segmented_button',
                    'heading' => $title,
                    'param_name' => 'radius',
                    'value' => array(
                        'default' => $default,
                        esc_html__( 'Global', 'pitstop' ) => 'pix-global',
                        esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                        esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                        esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                    ),
                );
                break;
                
            case 'box_gap' :
	            $title = empty($title) ? esc_html__( 'Boxes Gap', 'pitstop' ) : $title;
	            $default = empty($default) ? '0' : $default;
	            $control_arr = array(
                    'type' => 'dropdown',
                    'heading' => $title,
                    'param_name' => 'box_gap',
                    'value' => array(0,1,2,5,10,15,20,30,50),
                );
                break;
        }
        
        if( !empty($dep_element) && !empty($dep_arr) ){
            $control_arr['dependancy'] = array(
                'element' => $dep_element,
                'value' => $dep_arr
            );
        }
        
        if( !empty($field_class) ){
            $control_arr['edit_field_class'] = $field_class;
        }
        
        return $control_arr;
        
    }




	/// common_title
	vc_map(
		array(
			'name' => esc_html__( 'Title', 'pitstop' ),
			'base' => 'common_title',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop'),
			'params' => array(
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'heading' => esc_html__( 'Title', 'pitstop' ),
					'param_name' => 'title',
					'value' => esc_html__( 'I am Title', 'pitstop' ),
					'description' => esc_html__( 'Main title.', 'pitstop' )
				),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Tag', 'pitstop' ),
                    'param_name' => 'tag',
                    'value' => array(
                        'default' => 'h2',
                        esc_html__( 'H1', 'pitstop' ) => 'h1',
                        esc_html__( 'H2', 'pitstop' ) => 'h2',
                        esc_html__( 'H3', 'pitstop' ) => 'h3',
                        esc_html__( 'H4', 'pitstop' ) => 'h4',
                        esc_html__( 'H5', 'pitstop' ) => 'h5',
                        esc_html__( 'H6', 'pitstop' ) => 'h6',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Size', 'pitstop' ),
                    'param_name' => 'size',
                    'value' => array(
                        'default' => 'h2',
                        esc_html__( 'H1', 'pitstop' ) => 'h1',
                        esc_html__( 'H2', 'pitstop' ) => 'h2',
                        esc_html__( 'H3', 'pitstop' ) => 'h3',
                        esc_html__( 'H4', 'pitstop' ) => 'h4',
                        esc_html__( 'H5', 'pitstop' ) => 'h5',
                        esc_html__( 'H6', 'pitstop' ) => 'h6',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Position', 'pitstop' ),
                    'param_name' => 'position',
                    'value' => array(
                        'default' => 'text-center',
                        esc_html__( 'Left', 'pitstop' ) => 'text-left',
                        esc_html__( 'Center', 'pitstop' ) => 'text-center',
                        esc_html__( 'Right', 'pitstop' ) => 'text-right',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Uppercase', 'pitstop' ),
                    'param_name' => 'uppercase',
                    'value' => 'off',
                    'edit_field_class' => 'vc_col-sm-3',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Decor', 'pitstop' ),
                    'param_name' => 'show_decor',
                    'value' => 'on',
                    'edit_field_class' => 'vc_col-sm-3',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Bottom Padding', 'pitstop' ),
                    'param_name' => 'padding',
                    'value' => 'on',
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'No Wrap', 'pitstop' ),
                    'param_name' => 'no_wrap',
                    'value' => 'off',
                    'description' => esc_html__( 'The overflowing text won\'t be moved to a new line.', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Pre title', 'pitstop' ),
					'param_name' => 'subtitle',
					'value' => '',
					'description' => esc_html__( 'Text before title', 'pitstop' )
				),
                array(
                    'type' => 'textarea_html',
                    'heading' => esc_html__( 'Content', 'pitstop' ),
                    'param_name' => 'content',
                    'value' => '',
                    'description' => ''
                ),
				array(
					'type' => 'segmented_button',
					'heading' => esc_html__( 'Text Tone', 'pitstop' ),
					'param_name' => 'color',
					'value' => array(
                        'default' => 'default',
						esc_html__( 'Dark', 'pitstop' ) => 'default',
						esc_html__( 'Light', 'pitstop' ) => 'white-heading',
					),
				),
                array(
                    'type' => 'css_editor',
                    'heading' => esc_html__( 'Css', 'pitstop' ),
                    'param_name' => 'css',
                    'group' => esc_html__( 'Design options', 'pitstop' ),
                ),
			)
		)
	);



	/// common_button
	vc_map(
		array(
			'name' => esc_html__( 'Button', 'pitstop' ),
			'base' => 'common_button',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop'),
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__( 'Text', 'pitstop' ),
					'param_name' => 'text',
					'value' => esc_html__( 'Go', 'pitstop' ),
					'description' => esc_html__( 'Button text.', 'pitstop' )
				),
				array(
                    'type' => 'vc_link',
                    'heading' => esc_html__( 'Link', 'pitstop' ),
                    'param_name' => 'link',
                    'value' => '',
                    'description' => esc_html__( 'Button link', 'pitstop' )
                ),
				array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'As Link', 'pitstop' ),
                    'param_name' => 'button_type',
                    'value' => 'off',
                    'description' => esc_html__( 'Use as simple link with hover underline', 'pitstop' )
                ),
				array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Shape', 'pitstop' ),
                    'param_name' => 'radius',
                    'value' => array(
                        'default' => 'pix-global',
                        esc_html__( 'Global', 'pitstop' ) => 'pix-global',
                        esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                        esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                        esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                    ),
                    'dependency' => array(
                        'element' => 'button_type',
                        'value' => array('off')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Transparent', 'pitstop' ),
                    'param_name' => 'transparent',
                    'value' => 'off',
                    'dependency' => array(
                        'element' => 'button_type',
                        'value' => array('off')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Top/Bottom Paddings', 'pitstop' ),
                    'param_name' => 'size_v',
                    'value' => array(
                        'default' => 'pix-v-s',
                        esc_html__( 'S', 'pitstop' ) => 'pix-v-s',
                        esc_html__( 'M', 'pitstop' ) => 'pix-v-m',
                        esc_html__( 'L', 'pitstop' ) => 'pix-v-l',
                        esc_html__( 'XL', 'pitstop' ) => 'pix-v-xl',
                    ),
                    'dependency' => array(
                        'element' => 'button_type',
                        'value' => array('off')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Left/Right Paddings', 'pitstop' ),
                    'param_name' => 'size_h',
                    'value' => array(
                        'default' => 'pix-h-l',
                        esc_html__( 'S', 'pitstop' ) => 'pix-h-s',
                        esc_html__( 'M', 'pitstop' ) => 'pix-h-m',
                        esc_html__( 'L', 'pitstop' ) => 'pix-h-l',
                        esc_html__( 'XL', 'pitstop' ) => 'pix-h-xl',
                    ),
                    'dependency' => array(
                        'element' => 'button_type',
                        'value' => array('off')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Font Size', 'pitstop' ),
                    'param_name' => 'font_size',
                    'value' => array(
                        'default' => 'pix-font-m',
                        esc_html__( 'S', 'pitstop' ) => 'pix-font-s',
                        esc_html__( 'M', 'pitstop' ) => 'pix-font-m',
                        esc_html__( 'L', 'pitstop' ) => 'pix-font-l',
                        esc_html__( 'XL', 'pitstop' ) => 'pix-font-xl',
                    ),
                ),
				array(
					'type' => 'segmented_button',
					'heading' => esc_html__( 'Color', 'pitstop' ),
					'param_name' => 'color',
					'value' => array(
                        'default' => 'pix-colored',
						esc_html__( 'Colored', 'pitstop' ) => 'pix-colored',
						esc_html__( 'Dark', 'pitstop' ) => 'pix-dark',
						esc_html__( 'Light', 'pitstop' ) => 'pix-light',
					),
                    'edit_field_class' => 'vc_col-sm-6',
				),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Alignment', 'pitstop' ),
                    'param_name' => 'position',
                    'value' => array(
                        'default' => 'pix-text-left',
                        esc_html__( 'Left', 'pitstop' ) => 'pix-text-left',
                        esc_html__( 'Center', 'pitstop' ) => 'pix-text-center',
                        esc_html__( 'Right', 'pitstop' ) => 'pix-text-right',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => esc_html__( 'Css', 'pitstop' ),
                    'param_name' => 'css',
                    'group' => esc_html__( 'Design options', 'pitstop' ),
                ),
			)
		)
	);



	/// common_box_icon
	vc_map(
		array(
			'name' => esc_html__( 'Icon Box', 'pitstop' ),
			'base' => 'common_icon_box',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop'),
			'params' => array_merge(
				array(
					array(
						'type' => 'radio_images',
						'heading' => esc_html__( 'Style', 'pitstop' ),
						'param_name' => 'style',
						'value' => array(
                            'icon_box-side.png' => 'pix-ibox-side',
							'icon_box-title-side.png' => 'pix-ibox-title-side',
							'icon_box-top.png' => 'pix-ibox-top',
                            'services_cat_flip.png' => 'pix-ibox-flip',
						),
						'col' => 4,
						'description' => '',
					),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'Background Image', 'pitstop' ),
                        'param_name' => 'bg_image',
                        'description' => esc_html__( 'Select image.', 'pitstop' ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-flip')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Flip Box', 'pitstop' ),
                        'param_name' => 'flip',
                        'value' => 'on',
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-flip'),
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Box Shape', 'pitstop' ),
                        'param_name' => 'radius',
                        'value' => array(
                            'default' => 'pix-global',
                            esc_html__( 'Global', 'pitstop' ) => 'pix-global',
                            esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                            esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                            esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Alignment', 'pitstop' ),
                        'param_name' => 'position_with_center',
                        'value' => array(
                            'default' => 'pix-text-left',
                            esc_html__( 'Left', 'pitstop' ) => 'pix-text-left',
                            esc_html__( 'Center', 'pitstop' ) => 'pix-text-center',
                            esc_html__( 'Right', 'pitstop' ) => 'pix-text-right',
                        ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-top')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Alignment', 'pitstop' ),
                        'param_name' => 'position_no_center',
                        'value' => array(
                            'default' => 'pix-text-review-left',
                            esc_html__( 'Left', 'pitstop' ) => 'pix-text-review-left',
                            esc_html__( 'Right', 'pitstop' ) => 'pix-text-review-right',
                        ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-side', 'pix-ibox-title-side')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Border', 'pitstop' ),
                        'param_name' => 'border',
                        'value' => 'off',
                        'description' => esc_html__( 'Show border around the box', 'pitstop' ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-top')
                        ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Fill on Hover', 'pitstop' ),
                        'param_name' => 'filled',
                        'value' => 'off',
                        'description' => esc_html__( 'Fill the background with the main color on hover', 'pitstop' ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-top')
                        ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'No Padding', 'pitstop' ),
                        'param_name' => 'no_padding',
                        'value' => 'off',
                        'description' => esc_html__( 'Set default padding to 0', 'pitstop' ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-top')
                        ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Fill Color', 'pitstop' ),
                        'param_name' => 'fill_color',
                        'value' => array(
                            'default' => 'pix-main-color',
                            esc_html__( 'Main', 'pitstop' ) => 'pix-main-color',
                            esc_html__( 'Additional', 'pitstop' ) => 'pix-additional-color',
                            esc_html__( 'Gradient', 'pitstop' ) => 'pix-gradient-color',
                            esc_html__( 'Black', 'pitstop' ) => 'pix-black-color',
                        ),
                        'dependency' => array(
                            'element' => 'filled',
                            'value' => array('on')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Type', 'pitstop' ),
                        'param_name' => 'icon_type',
                        'value' => array(
                            'default' => 'image',
                            esc_html__( 'Image/SVG', 'pitstop' ) => 'image',
                            esc_html__( 'Font', 'pitstop' ) => 'font',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
					array(
						'type' => 'attach_image',
						'heading' => esc_html__( 'Image/SVG', 'pitstop' ),
						'param_name' => 'image',
						'description' => esc_html__( 'Select image.', 'pitstop' ),
                        'dependency' => array(
                            'element' => 'icon_type',
                            'value' => array('image')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
					),
					
				),
				pixtheme_get_vc_icons($vc_icons_data, 'icon_type', 'font'),
				array(
				    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Size', 'pitstop' ),
                        'param_name' => 'icon_size',
                        'value' => array(
                            'default' => 'pix-icon-l',
                            esc_html__( 'S', 'pitstop' ) => 'pix-icon-s',
                            esc_html__( 'M', 'pitstop' ) => 'pix-icon-m',
                            esc_html__( 'L', 'pitstop' ) => 'pix-icon-l',
                            esc_html__( 'XL', 'pitstop' ) => 'pix-icon-xl',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Background', 'pitstop' ),
                        'param_name' => 'icon_shape',
                        'value' => array(
                            'default' => 'transparent',
                            esc_html__( 'Transparent', 'pitstop' ) => 'transparent',
                            esc_html__( 'Round', 'pitstop' ) => 'round',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
				    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Color', 'pitstop' ),
                        'param_name' => 'icon_color',
                        'value' => array(
                            'default' => 'pix-icon-color',
                            esc_html__( 'Color', 'pitstop' ) => 'pix-icon-color',
                            esc_html__( 'Gradient', 'pitstop' ) => 'pix-icon-gradient',
                            esc_html__( 'Monochrome', 'pitstop' ) => 'pix-icon-default',
                        ),
                        'dependency' => array(
                            'element' => 'icon_type',
                            'value' => array('font')
                        ),
                    ),
				    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Background Color', 'pitstop' ),
                        'param_name' => 'icon_bg_color',
                        'value' => array(
                            'default' => 'pix-icon-bg-main-color',
                            esc_html__( 'Main', 'pitstop' ) => 'pix-icon-bg-main-color',
                            esc_html__( 'Additional', 'pitstop' ) => 'pix-icon-bg-additional-color',
                            esc_html__( 'Gradient', 'pitstop' ) => 'pix-icon-bg-gradient-color',
                            esc_html__( 'Black', 'pitstop' ) => 'pix-icon-bg-black-color',
                            esc_html__( 'White', 'pitstop' ) => 'pix-icon-bg-white-color',
                        ),
                        'dependency' => array(
                            'element' => 'icon_shape',
                            'value' => array('round')
                        ),
                    ),
				    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title', 'pitstop' ),
                        'param_name' => 'title',
                        'description' => esc_html__( 'Enter text used as title of icon.', 'pitstop' ),
                        'admin_label' => true,
                    ),
					array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Title Size', 'pitstop' ),
                        'param_name' => 'title_size',
                        'value' => array(
                            'default' => 'pix-title-l',
                            esc_html__( 'Title S', 'pitstop' ) => 'pix-title-s',
                            esc_html__( 'Title M', 'pitstop' ) => 'pix-title-m',
                            esc_html__( 'Title L', 'pitstop' ) => 'pix-title-l',
                            esc_html__( 'Title XL', 'pitstop' ) => 'pix-title-xl',
                        ),
                    ),
					array(
						'type' => 'vc_link',
						'heading' => esc_html__( 'Link', 'pitstop' ),
						'param_name' => 'link',
						'value' => '',
						'description' => esc_html__( 'Button link', 'pitstop' )
					),
					array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Link Type', 'pitstop' ),
                        'param_name' => 'link_type',
                        'value' => array(
                            'default' => 'overlay',
                            esc_html__( 'Overlay', 'pitstop' ) => 'overlay',
                            esc_html__( 'Button', 'pitstop' ) => 'button',
                            esc_html__( 'Text Link', 'pitstop' ) => 'href',
                        ),
                        'description' => esc_html__( 'If Overlay the whole box is a link. Don\'t use links in content', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button/Link Text', 'pitstop' ),
						'param_name' => 'btn_link_txt',
                        'dependency' => array(
                            'element' => 'link_type',
                            'value' => array('button', 'href')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
					),
					array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Content Position', 'pitstop' ),
                        'param_name' => 'content_position',
                        'value' => array(
                            'default' => 'pix-top',
                            esc_html__( 'Top', 'pitstop' ) => 'pix-top',
                            esc_html__( 'Middle', 'pitstop' ) => 'pix-middle',
                            esc_html__( 'Bottom', 'pitstop' ) => 'pix-bottom',
                        ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-side')
                        ),
                    ),
					array(
						'type' => 'textarea_html',
						'holder' => 'div',
						'heading' => esc_html__( 'Content', 'pitstop' ),
						'param_name' => 'content',
						'value' => '',
						'description' => esc_html__( 'Enter information.', 'pitstop' )
					),
                    array(
                        'type' => 'css_editor',
                        'heading' => esc_html__( 'Css', 'pitstop' ),
                        'param_name' => 'css',
                        'group' => esc_html__( 'Design options', 'pitstop' ),
                    ),
				)
			),
		)
	);




	/// common_amount_box
	vc_map(
		array(
			'name' => esc_html__( 'Amount Box', 'pitstop' ),
			'base' => 'common_amount_box',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop'),
			'params' => array_merge(
			    array(
			        array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Type', 'pitstop' ),
                        'param_name' => 'icon_type',
                        'value' => array(
                            'default' => 'image',
                            esc_html__( 'Image/SVG', 'pitstop' ) => 'image',
                            esc_html__( 'Font', 'pitstop' ) => 'font',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
					array(
						'type' => 'attach_image',
						'heading' => esc_html__( 'Image/SVG', 'pitstop' ),
						'param_name' => 'image',
						'description' => esc_html__( 'Select image.', 'pitstop' ),
                        'dependency' => array(
                            'element' => 'icon_type',
                            'value' => array('image')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
					),
                ),
                pixtheme_get_vc_icons($vc_icons_data, 'icon_type', 'font'),
                array(
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Size', 'pitstop' ),
                        'param_name' => 'icon_size',
                        'value' => array(
                            'default' => 'pix-icon-l',
                            esc_html__( 'S', 'pitstop' ) => 'pix-icon-s',
                            esc_html__( 'M', 'pitstop' ) => 'pix-icon-m',
                            esc_html__( 'L', 'pitstop' ) => 'pix-icon-l',
                            esc_html__( 'XL', 'pitstop' ) => 'pix-icon-xl',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Position', 'pitstop' ),
                        'param_name' => 'position',
                        'value' => array(
                            'default' => 'pix-text-center',
                            esc_html__( 'Left', 'pitstop' ) => 'pix-text-left',
                            esc_html__( 'Top', 'pitstop' ) => 'pix-text-center',
                            esc_html__( 'Right', 'pitstop' ) => 'pix-text-right',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Color', 'pitstop' ),
                        'param_name' => 'icon_color',
                        'value' => array(
                            'default' => 'pix-icon-color',
                            esc_html__( 'Color', 'pitstop' ) => 'pix-icon-color',
                            esc_html__( 'Monochrome', 'pitstop' ) => 'pix-icon-default',
                        ),
                        'dependency' => array(
                            'element' => 'icon_type',
                            'value' => array('font')
                        ),
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Fill on Hover', 'pitstop' ),
                        'param_name' => 'border',
                        'value' => 'off',
                        'description' => esc_html__( 'Fill the background with the main color on hover', 'pitstop' ),
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__( 'Title', 'pitstop' ),
                        'param_name' => 'title',
                        'value' => '',
                        'description' => esc_html__( 'Title.', 'pitstop' )
                    ),
					array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Title Style', 'pitstop' ),
                        'param_name' => 'title_size',
                        'value' => array(
                            'default' => 'pix-title-l',
                            esc_html__( 'Title S', 'pitstop' ) => 'pix-title-s',
                            esc_html__( 'Title M', 'pitstop' ) => 'pix-title-m',
                            esc_html__( 'Title L', 'pitstop' ) => 'pix-title-l',
                            esc_html__( 'Title XL', 'pitstop' ) => 'pix-title-xl',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__( 'Amount', 'pitstop' ),
                        'param_name' => 'amount',
                        'value' => '',
                        'description' => esc_html__( 'Amount.', 'pitstop' )
                    ),
                    array(
						'type' => 'textarea_html',
						'holder' => 'div',
						'heading' => esc_html__( 'Content', 'pitstop' ),
						'param_name' => 'content',
						'value' => '',
						'description' => esc_html__( 'Enter information.', 'pitstop' )
					),
                    array(
                        'type' => 'css_editor',
                        'heading' => esc_html__( 'Css', 'pitstop' ),
                        'param_name' => 'css',
                        'group' => esc_html__( 'Design options', 'pitstop' ),
                    ),
			    ),
                $add_animation
            )
		)
	);

	/// common_mailchimp
	vc_map(
		array(
			'name' => esc_html__( 'Mailchimp Box', 'pitstop' ),
			'base' => 'common_mailchimp',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop'),
			'show_settings_on_create' => false,
			'content_element' => true,
			'params' => array(),
		)
	);
	//////////////////////////////////////////////////////////////////////
    
    
    
    /// pix_calculator
    
    $cf7_calculator = array();
    $cf7_calculator = array_merge(array(esc_html__('Without Contact Form', 'pitstop') => 0), $cform7);
    
    if(pixtheme_get_setting('pix-calculator', 'on') == 'on'){
        vc_map(
            array(
                'name' => esc_html__( 'Calculator', 'pitstop' ),
                'base' => 'pix_calculator',
                'class' => 'pix-theme-icon-common',
                'category' => esc_html__( 'Pitstop', 'pitstop'),
                'params' => array(
    
                    array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Calculator', 'pitstop' ),
						'param_name' => 'calc_id',
						'value' => $calculators,
						'description' => esc_html__( 'Select calculator to show', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-6',
					),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Contact Form', 'pitstop' ),
                        'param_name' => 'form_id',
                        'value' => $cf7_calculator,
                        'description' => esc_html__( 'Select contact form to show', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                )
            )
        );
    }
    
    
    

    /// common_cform7
    vc_map(
        array(
            'name' => esc_html__( 'Contact Form 7', 'pitstop' ),
            'base' => 'common_cform7',
            'class' => 'pix-theme-icon-common',
            'category' => esc_html__( 'Pitstop', 'pitstop'),
            'params' => array(

                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Contact Form', 'pitstop' ),
                    'param_name' => 'form_id',
                    'value' => $cform7,
                    'description' => esc_html__( 'Select contact form to show', 'pitstop' )
                ),
                pix_vc_control('radius', 'vc_col-sm-8'),
                pix_vc_control('box_gap', 'vc_col-sm-4'),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Send Button Position', 'pitstop' ),
                    'param_name' => 'btn_position',
                    'value' => array(
                        'default' => 'pix-text-left',
                        esc_html__( 'Left', 'pitstop' ) => 'pix-text-left',
                        esc_html__( 'Center', 'pitstop' ) => 'pix-text-center',
                        esc_html__( 'Right', 'pitstop' ) => 'pix-text-right',
                        esc_html__( 'Full Width', 'pitstop' ) => 'pix-text-full-width',
                    ),
                ),
            )
        )
    );




    /// common_special_offers
    vc_map( array(
        'name' => esc_html__( 'Special Offers', 'pitstop' ),
        'base' => 'common_special_offers',
        'class' => 'pix-theme-icon-common',
        'category' => esc_html__( 'Pitstop', 'pitstop'),
        'params' => array(
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Shape', 'pitstop' ),
                'param_name' => 'radius',
                'value' => array(
                    'default' => 'pix-global',
                    esc_html__( 'Global', 'pitstop' ) => 'pix-global',
                    esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                    esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                    esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                ),
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Offers', 'pitstop' ),
                'param_name' => 'offers',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'Image', 'pitstop' ),
                        'param_name' => 'image',
                        'description' => esc_html__( 'Select image.', 'pitstop' )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title', 'pitstop' ),
                        'param_name' => 'title',
                        'description' => '',
                    ),
					array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Title Style', 'pitstop' ),
                        'param_name' => 'title_size',
                        'value' => array(
                            'default' => 'pix-title-l',
                            esc_html__( 'Title S', 'pitstop' ) => 'pix-title-s',
                            esc_html__( 'Title M', 'pitstop' ) => 'pix-title-m',
                            esc_html__( 'Title L', 'pitstop' ) => 'pix-title-l',
                            esc_html__( 'Title XL', 'pitstop' ) => 'pix-title-xl',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Subtitle', 'pitstop' ),
                        'param_name' => 'subtitle',
                        'description' => '',
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__( 'Text', 'pitstop' ),
                        'param_name' => 'content_d',
                        'value' => wp_kses(__( 'I am test text block. Click edit button to change this text.', 'pitstop' ), 'post'),
                        'description' => esc_html__( 'Enter text.', 'pitstop' )
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__( 'Link', 'pitstop' ),
                        'param_name' => 'link',
                    ),
                ),
            ),
        ),


    ) );



    /// common_tab_acc
    $tabs_acc_content = 'Metus quam cras vehicula ante, potenti eget. Vel est integer, vivamus proin torquent, sodales aliquam tincidunt laoreet est, at in sollicitudin laoreet etiam sit suspendisse, ligula ut vestibulum dapibus et neque. Nibh et risus ipsum amet pede, eros arcu non, velit ridiculus elit, mauris cursus et. Vel cursus sagittis sem nullam odio pede.';
    vc_map(
        array(
            'name' => esc_html__( 'Tabs/Accordion', 'pitstop' ),
            'base' => 'common_tab_acc',
            'class' => 'pix-theme-icon-common',
            'category' => esc_html__( 'Pitstop', 'pitstop'),
            'params' => array(
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Toggle Type', 'pitstop' ),
                    'param_name' => 'toggle_type',
                    'value' => array(
                        'default' => 'tabs',
                        esc_html__( 'Tabs', 'pitstop' ) => 'tabs',
                        esc_html__( 'Accordion', 'pitstop' ) => 'accordion',
                    ),
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Collapse', 'pitstop' ),
                    'param_name' => 'collapse',
                    'value' => 'off',
                    'dependency' => array(
                        'element' => 'toggle_type',
                        'value' => array('accordion')
                    ),
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__( 'Tabs', 'pitstop' ),
                    'param_name' => 'tabs',
                    'description' => esc_html__( 'Enter values for graph - title and value.', 'pitstop' ),
                    'value' => urlencode( json_encode( array(
                        array(
                            'label' => esc_html__( 'Concept', 'pitstop' ),
                            'content_t' => $tabs_acc_content,
                            'link' => '/',
                            'tab_id' => rand(),
                        ),
                        array(
                            'label' => esc_html__( 'Design', 'pitstop' ),
                            'content_t' => $tabs_acc_content,
                            'link' => '/',
                            'tab_id' => rand(),
                        ),
                        array(
                            'label' => esc_html__( 'Deployment', 'pitstop' ),
                            'content_t' => $tabs_acc_content,
                            'link' => '/',
                            'tab_id' => rand(),
                        ),
                        array(
                            'label' => esc_html__( 'Support', 'pitstop' ),
                            'content_t' => $tabs_acc_content,
                            'link' => '/',
                            'tab_id' => rand(),
                        ),
                    ) ) ),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Label', 'pitstop' ),
                            'param_name' => 'label',
                            'description' => esc_html__( 'Enter text used as title of bar.', 'pitstop' ),
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => esc_html__( 'Content', 'pitstop' ),
                            'param_name' => 'content_t',
                            'value' => wp_kses(__( 'I am test text block. Click edit button to change this text.', 'pitstop' ), 'post'),
                            'description' => esc_html__( 'Enter text.', 'pitstop' )
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__( 'Link', 'pitstop' ),
                            'param_name' => 'link',
                            'value' => '',
                            'description' => esc_html__( 'Button link', 'pitstop' )
                        ),
                        array(
                            'type' => 'tab_id',
                            'heading' => esc_html__( 'ID', 'pitstop' ),
                            'param_name' => 'tab_id',
                        ),

                    ),
                    'dependency' => array(
                        'element' => 'toggle_type',
                        'value' => array('tabs')
                    ),
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Link Type', 'pitstop' ),
                    'param_name' => 'link_type',
                    'value' => array(
                        'default' => 'button',
                        esc_html__( 'Button', 'pitstop' ) => 'button',
                        esc_html__( 'Text Link', 'pitstop' ) => 'href',
                    ),
                    'dependency' => array(
                        'element' => 'toggle_type',
                        'value' => array('tabs')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Button/Link Text', 'pitstop' ),
                    'param_name' => 'btn_link_txt',
                    'dependency' => array(
                        'element' => 'toggle_type',
                        'value' => array('tabs')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__( 'Accordion', 'pitstop' ),
                    'param_name' => 'accordion',
                    'description' => esc_html__( 'Enter values for graph - title and value.', 'pitstop' ),
                    'value' => urlencode( json_encode( array(
                        array(
                            'label_a' => esc_html__( 'Mus imperdiet, consectetuer adipiscing?', 'pitstop' ),
                            'content_a' => $tabs_acc_content,
                            'tab_id_a' => rand(),
                        ),
                        array(
                            'label_a' => esc_html__( 'Dictum interdum aenean magna vestibulum lectus?', 'pitstop' ),
                            'content_a' => $tabs_acc_content,
                            'tab_id_a' => rand(),
                        ),
                        array(
                            'label_a' => esc_html__( 'Urna auctor, turpis eu, curabitur maecenas vitae?', 'pitstop' ),
                            'content_a' => $tabs_acc_content,
                            'tab_id_a' => rand(),
                        ),
                        array(
                            'label_a' => esc_html__( 'Vel cursus sagittis sem nullam odio pede?', 'pitstop' ),
                            'content_a' => $tabs_acc_content,
                            'tab_id_a' => rand(),
                        ),
                    ) ) ),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Label', 'pitstop' ),
                            'param_name' => 'label_a',
                            'description' => esc_html__( 'Enter text used as title of bar.', 'pitstop' ),
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => esc_html__( 'Content', 'pitstop' ),
                            'param_name' => 'content_a',
                            'value' => wp_kses(__( 'I am test text block. Click edit button to change this text.', 'pitstop' ), 'post'),
                            'description' => esc_html__( 'Enter text.', 'pitstop' )
                        ),
                        array(
                            'type' => 'tab_id',
                            'heading' => esc_html__( 'ID', 'pitstop' ),
                            'param_name' => 'tab_id_a',
                        ),
                    ),
                    'dependency' => array(
                        'element' => 'toggle_type',
                        'value' => array('accordion')
                    ),
                ),
            ),
        )
    );



    /// common_progress
    vc_map(
        array(
            'name' => esc_html__( 'Progress Bar', 'pitstop' ),
            'base' => 'common_progress',
            'class' => 'pix-theme-icon-common',
            'category' => esc_html__( 'Pitstop', 'pitstop'),
            'params' => array(
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__( 'Values', 'pitstop' ),
                    'param_name' => 'values',
                    'description' => esc_html__( 'Enter values for graph - title and value.', 'pitstop' ),
                    'value' => urlencode( json_encode( array(
                        array(
                            'label' => esc_html__( 'Hosting providers', 'pitstop' ),
                            'value' => '70',
                        ),
                        array(
                            'label' => esc_html__( 'Security companies', 'pitstop' ),
                            'value' => '50',
                        ),
                        array(
                            'label' => esc_html__( 'Private companies and clients', 'pitstop' ),
                            'value' => '60',
                        ),
                        array(
                            'label' => esc_html__( 'Software development companies', 'pitstop' ),
                            'value' => '90',
                        ),
                    ) ) ),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Label', 'pitstop' ),
                            'param_name' => 'label',
                            'description' => esc_html__( 'Enter text used as title of bar.', 'pitstop' ),
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Value', 'pitstop' ),
                            'param_name' => 'value',
                            'description' => esc_html__( 'Enter value of bar.', 'pitstop' ),
                            'admin_label' => true,
                        ),
                    ),
                ),
            ),
        )
    );



	/// common_posts_block
	vc_map(
		array(
			'name' => esc_html__( 'Posts Block', 'pitstop' ),
			'base' => 'common_posts_block',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop'),
			'params' => array(
			    array(
                    'type' => 'radio_images',
                    'heading' => esc_html__( 'Style', 'pitstop' ),
                    'param_name' => 'style',
                    'value' => array(
                        'posts_block-news.png' => 'pix-news-slider',
                        'posts_block-long.png' => 'news-card-long',
                        'posts_block-centered.png' => 'news-card-centered',
                        'posts_block-gradient.png' => 'news-card-gradient',
                        'posts_block-high.png' => 'pix-news-high',
                    ),
                    'col' => 3,
                    'description' => '',
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Boxes Shape', 'pitstop' ),
                    'param_name' => 'radius',
                    'value' => array(
                        'default' => 'pix-global-shape',
                        esc_html__( 'Global', 'pitstop' ) => 'pix-global-shape',
                        esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                        esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                        esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Greyscale Images', 'pitstop' ),
                    'param_name' => 'greyscale',
                    'value' => 'off',
                    'description' => esc_html__( 'Show greyscale image with colored hover', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Categories', 'pitstop' ),
					'param_name' => 'cats',
					'value' => $cats_post,
					'description' => esc_html__( 'Select categories to show. If empty, display last posts.', 'pitstop' )
				),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Items Count', 'pitstop' ),
                    'param_name' => 'count',
                    'description' => esc_html__( 'Select number posts to show. Default 3.', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Hover Icon', 'pitstop' ),
                    'param_name' => 'hover_icon',
                    'value' => array(
                        esc_html__( 'No', 'pitstop' ) => '',
                        esc_html__( 'Plus', 'pitstop' ) => 'plus',
                        esc_html__( 'Eye', 'pitstop' ) => 'eye',
                        esc_html__( 'Search', 'pitstop' ) => 'search',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Title Size', 'pitstop' ),
                    'param_name' => 'title_size',
                    'value' => array(
                        'default' => 'pix-title-l',
                        esc_html__( 'Title S', 'pitstop' ) => 'pix-title-s',
                        esc_html__( 'Title M', 'pitstop' ) => 'pix-title-m',
                        esc_html__( 'Title L', 'pitstop' ) => 'pix-title-l',
                        esc_html__( 'Title XL', 'pitstop' ) => 'pix-title-xl',
                    ),
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Image Proportions', 'pitstop' ),
                    'param_name' => 'img_proportions',
                    'value' => array(
                        'default' => 'pixtheme-square',
                        esc_html__( 'Original', 'pitstop' ) => 'pixtheme-original',
                        esc_html__( 'Landscape', 'pitstop' ) => 'pixtheme-landscape',
                        esc_html__( 'Portrait', 'pitstop' ) => 'pixtheme-portrait',
                        esc_html__( 'Square', 'pitstop' ) => 'pixtheme-square',
                    ),
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => esc_html__( 'Css', 'pitstop' ),
                    'param_name' => 'css',
                    'group' => esc_html__( 'Design options', 'pitstop' ),
                ),

			)
		)
	);


	/// common_team
    vc_map( array(
        'name' => esc_html__( 'Team', 'pitstop' ),
        'base' => 'common_team',
        'class' => 'pix-theme-icon-common',
        'category' => esc_html__( 'Pitstop', 'pitstop'),
        'params' => array(
            array(
                'type' => 'radio_images',
                'heading' => esc_html__( 'Style', 'pitstop' ),
                'param_name' => 'style',
                'value' => array(
                    'team_long.png' => 'pix-team-long',
                    'team_square.png' => 'pix-team-square',
                ),
                'col' => 2,
                'description' => '',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Shape', 'pitstop' ),
                'param_name' => 'radius',
                'value' => array(
                    'default' => 'pix-global-shape',
                    esc_html__( 'Global', 'pitstop' ) => 'pix-global-shape',
                    esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                    esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                    esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                ),
            ),
			array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Title Style', 'pitstop' ),
                'param_name' => 'title_size',
                'value' => array(
                    'default' => 'pix-title-l',
                    esc_html__( 'Title S', 'pitstop' ) => 'pix-title-s',
                    esc_html__( 'Title M', 'pitstop' ) => 'pix-title-m',
                    esc_html__( 'Title L', 'pitstop' ) => 'pix-title-l',
                    esc_html__( 'Title XL', 'pitstop' ) => 'pix-title-xl',
                ),
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Members', 'pitstop' ),
                'param_name' => 'members',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'Image', 'pitstop' ),
                        'param_name' => 'image',
                        'description' => esc_html__( 'Select image.', 'pitstop' )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Name', 'pitstop' ),
                        'param_name' => 'name',
                        'description' => '',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Position', 'pitstop' ),
                        'param_name' => 'position',
                        'description' => '',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__( 'Content', 'pitstop' ),
                        'param_name' => 'desc',
                        'description' => '',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Phone', 'pitstop' ),
                        'param_name' => 'phone',
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Email', 'pitstop' ),
                        'param_name' => 'email',
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Skype', 'pitstop' ),
                        'param_name' => 'skype',
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Facebook', 'pitstop' ),
                        'param_name' => 'facebook',
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Twitter', 'pitstop' ),
                        'param_name' => 'twitter',
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Instagram', 'pitstop' ),
                        'param_name' => 'instagram',
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Linkedin', 'pitstop' ),
                        'param_name' => 'linkedin',
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__( 'Link', 'pitstop' ),
                        'param_name' => 'link',
                        'description' => esc_html__( 'to the profile page', 'pitstop' )
                    ),
                ),
            ),
        ),


    ) );


    /// common_reviews
    vc_map( array(
        'name' => esc_html__( 'Reviews', 'pitstop' ),
        'base' => 'common_reviews',
        'class' => 'pix-theme-icon-common',
        'category' => esc_html__( 'Pitstop', 'pitstop'),
        'params' => array(
            array(
                'type' => 'radio_images',
                'heading' => esc_html__( 'Style', 'pitstop' ),
                'param_name' => 'style',
                'value' => array(
                    'reviews_testimonials.png' => 'pix-testimonials',
                    'reviews_people.png' => 'news-card-people',
                    'reviews_feedback.png' => 'news-card-feedback',
                    'reviews_message.png' => 'news-card-message',
                    'reviews_profile.png' => 'news-card-profile',
                    'reviews_people_2.png' => 'pix-testimonials-people',
                ),
                'col' => 3,
                'description' => '',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Shape', 'pitstop' ),
                'param_name' => 'radius',
                'value' => array(
                    'default' => 'pix-global-shape',
                    esc_html__( 'Global', 'pitstop' ) => 'pix-global-shape',
                    esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                    esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                    esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Hover Color', 'pitstop' ),
                'param_name' => 'color',
                'value' => array(
                    'default' => 'pix-main-color',
                    esc_html__( 'Main', 'pitstop' ) => 'pix-main-color',
                    esc_html__( 'Additional', 'pitstop' ) => 'pix-additional-color',
                    esc_html__( 'Gradient', 'pitstop' ) => 'pix-gradient-color',
                    esc_html__( 'Black', 'pitstop' ) => 'pix-black-color',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('news-card-people', 'news-card-profile'),
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Hover Effect', 'pitstop' ),
                'param_name' => 'hover',
                'value' => array(
                    'default' => 'pix-change-color',
                    esc_html__( 'Change Color', 'pitstop' ) => 'pix-change-color',
                    esc_html__( 'Transform', 'pitstop' ) => 'pix-transform',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-testimonials'),
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Name Style', 'pitstop' ),
                'param_name' => 'title_size',
                'value' => array(
                    'default' => 'pix-title-l',
                    esc_html__( 'Title S', 'pitstop' ) => 'pix-title-s',
                    esc_html__( 'Title M', 'pitstop' ) => 'pix-title-m',
                    esc_html__( 'Title L', 'pitstop' ) => 'pix-title-l',
                    esc_html__( 'Title XL', 'pitstop' ) => 'pix-title-xl',
                ),
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Reviews', 'pitstop' ),
                'param_name' => 'reviews',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'Image', 'pitstop' ),
                        'param_name' => 'image',
                        'description' => esc_html__( 'Select image.', 'pitstop' )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Name', 'pitstop' ),
                        'param_name' => 'name',
                        'description' => '',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Position', 'pitstop' ),
                        'param_name' => 'position',
                        'description' => '',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Facebook', 'pitstop' ),
                        'param_name' => 'facebook',
                        'description' => esc_html__( 'Profile link', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Twitter', 'pitstop' ),
                        'param_name' => 'twitter',
                        'description' => esc_html__( 'Profile link', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Instagram', 'pitstop' ),
                        'param_name' => 'instagram',
                        'description' => esc_html__( 'Profile link', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__( 'Review Text', 'pitstop' ),
                        'param_name' => 'content_d',
                        'value' => wp_kses(__( 'I am test text block. Click edit button to change this text.', 'pitstop' ), 'post'),
                        'description' => esc_html__( 'Enter text.', 'pitstop' )
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__( 'Link', 'pitstop' ),
                        'param_name' => 'link',
                        'description' => esc_html__( 'Author link', 'pitstop' )
                    ),
                ),
            ),
        ),
    
    
    ) );

    
    
    /// common_video
    vc_map(
		array(
			'name' => esc_html__( 'Video', 'pitstop' ),
			'base' => 'common_video',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'YouTube or Vimeo Link', 'pitstop' ),
					'param_name' => 'url',
					'value' => 'https://www.youtube.com/watch?v=PssMYGPiyl0',
				),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Display Type', 'pitstop' ),
                    'param_name' => 'display',
                    'value' => array(
                        'default' => 'popup',
                        esc_html__( 'Popup Window', 'pitstop' ) => 'popup',
                        esc_html__( 'Embedded Video', 'pitstop' ) => 'embed',
                        esc_html__( 'Button with Popup', 'pitstop' ) => 'button',
                    ),
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Alignment', 'pitstop' ),
                    'param_name' => 'position',
                    'value' => array(
                        'default' => 'pix-text-left',
                        esc_html__( 'Left', 'pitstop' ) => 'pix-text-left',
                        esc_html__( 'Center', 'pitstop' ) => 'pix-text-center',
                        esc_html__( 'Right', 'pitstop' ) => 'pix-text-right',
                    ),
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('button'),
                    ),
                ),
				array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Image', 'pitstop' ),
                    'param_name' => 'image',
                    'description' => esc_html__( 'Select image.', 'pitstop' ),
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('popup', 'embed'),
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Boxes Shape', 'pitstop' ),
                    'param_name' => 'radius',
                    'value' => array(
                        'default' => 'pix-global-shape',
                        esc_html__( 'Global', 'pitstop' ) => 'pix-global-shape',
                        esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                        esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                        esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__( 'Height', 'pitstop' ),
					'param_name' => 'height',
                    'description' => esc_html__( 'Default 500px', 'pitstop' ),
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('popup', 'embed'),
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
				),
				array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Overlay Color', 'pitstop' ),
                    'param_name' => 'color',
                    'value' => '#000',
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('popup', 'embed'),
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Title', 'pitstop' ),
                    'param_name' => 'title',
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('popup', 'embed'),
                    ),
                ),
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'heading' => esc_html__( 'Content', 'pitstop' ),
					'param_name' => 'content',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('popup', 'embed'),
                    ),
				),
			)
		)
	);


    

    /// common_google_map
    vc_map(
        array(
            'name' => esc_html__( 'Google Map', 'pitstop' ),
            'base' => 'common_google_map',
            'class' => 'pix-theme-icon-common',
            'category' => esc_html__( 'Pitstop', 'pitstop'),
            'params' => array(
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Map Type', 'pitstop' ),
                    'param_name' => 'map_type',
                    'value' => array(
                        'default' => 'google',
                        esc_html__( 'Google Map', 'pitstop' ) => 'google',
                        esc_html__( 'Image with Link', 'pitstop' ) => 'img',
                    ),
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Map Image', 'pitstop' ),
                    'param_name' => 'map_image',
                    'value' => '',
                    'description' => esc_html__( 'Select image from media library.', 'pitstop' ),
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'img',
                    )
                ),array(
                    'type' => 'vc_link',
                    'heading' => esc_html__( 'Link', 'pitstop' ),
                    'param_name' => 'map_link',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'img',
                    )
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Marker Image', 'pitstop' ),
                    'param_name' => 'image',
                    'value' => '',
                    'description' => esc_html__( 'Select image from media library.', 'pitstop' ),
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'google',
                    )
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__( 'Locations', 'pitstop' ),
                    'param_name' => 'locations',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'heading' => esc_html__( 'LatLng', 'pitstop' ),
                            'param_name' => 'latlng',
                            'value' => '40.6700,-73.9400',
                            'description' => esc_html__( 'Latitude, Longtitude (Example: 40.6700,-73.9400)', 'pitstop' )
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Description', 'pitstop' ),
                            'param_name' => 'description',
                            'value' => '',
                            'description' => '',
                        ),
                    ),
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'google',
                    )
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'heading' => esc_html__( 'Map Width', 'pitstop' ),
                    'param_name' => 'width',
                    'value' => '',
                    'description' => esc_html__( 'Default 100%', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'heading' => esc_html__( 'Map Height', 'pitstop' ),
                    'param_name' => 'height',
                    'value' => '',
                    'description' => esc_html__( 'Default 500px', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'heading' => esc_html__( 'Zoom', 'pitstop' ),
                    'param_name' => 'zoom',
                    'value' => '',
                    'description' => esc_html__( 'Zoom 0-20. Default 9.', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-6',
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'google',
                    )
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Scroll Wheel', 'pitstop' ),
                    'param_name' => 'scrollwheel',
                    'value' => 'off',
                    'description' => esc_html__( 'Zoom map with scroll', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-6',
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'google',
                    )
                ),
            )
        )
    );






    /// common_points
	vc_map( array(
		'name' => esc_html__( 'Image Points', 'pitstop' ),
		'base' => 'common_points',
		'class' => 'pix-theme-icon-common',
		'category' => esc_html__( 'Pitstop', 'pitstop'),
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'pitstop' ),
				'param_name' => 'image',
				'description' => esc_html__( 'Select image.', 'pitstop' ),
			),
			array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Shape', 'pitstop' ),
                'param_name' => 'radius',
                'value' => array(
                    'default' => 'pix-global',
                    esc_html__( 'Global', 'pitstop' ) => 'pix-global',
                    esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                    esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                    esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
			array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Point Units', 'pitstop' ),
                'param_name' => 'unit',
                'value' => array(
                    'default' => '%',
                    esc_html__( 'Percent', 'pitstop' ) => '%',
                    esc_html__( 'Pixels', 'pitstop' ) => 'px',

                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Points', 'pitstop' ),
                'param_name' => 'points',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Top Position', 'pitstop' ),
                        'param_name' => 'top_pos',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Left Position', 'pitstop' ),
                        'param_name' => 'left_pos',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__( 'Popup Text', 'pitstop' ),
                        'param_name' => 'content_d',
                        'value' => wp_kses(__( 'I am test text block. Click edit button to change this text.', 'pitstop' ), 'post'),
                    ),
                )
            ),
		),

	) );


    vc_map(
		array(
			'name' => esc_html__( 'Slider/Grid', 'pitstop' ),
			'base' => 'common_slider',
			'class' => 'wpb_vc_tta_tabs pix-theme-icon-common',
			'as_parent' => array('only' => 'common_icon_box'),
			'content_element' => true,
			'show_settings_on_create' => true,
			'is_container' => true,
			'category' => esc_html__( 'Pitstop', 'pitstop' ),
			'params' => array(),
            'admin_enqueue_js' => get_template_directory_uri().'/vc_templates/js/custom-vc-admin.js',
		    'js_view' => 'VcPixContainerView',
		)
	);
    
    vc_map(
		array(
			'name' => esc_html__( 'Wrapper', 'pitstop' ),
			'base' => 'common_wrapper',
			'class' => 'wpb_vc_tta_tabs pix-theme-icon-common',
			'as_parent' => array('only' => 'vc_icon'),
			'content_element' => true,
			'show_settings_on_create' => false,
			'is_container' => false,
			'category' => esc_html__( 'Pitstop', 'pitstop' ),
			'params' => array(
			    array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Alignment', 'pitstop' ),
                    'param_name' => 'position',
                    'value' => array(
                        'default' => 'pix-text-left',
                        esc_html__( 'Left', 'pitstop' ) => 'pix-text-left',
                        esc_html__( 'Center', 'pitstop' ) => 'pix-text-center',
                        esc_html__( 'Right', 'pitstop' ) => 'pix-text-right',
                    ),
                ),
            ),
            'admin_enqueue_js' => get_template_directory_uri().'/vc_templates/js/custom-vc-admin.js',
		    'js_view' => 'VcPixContainerView',
		)
	);
 

if(1==2) {
    vc_map(array(
        'name' => esc_html__('Grid', 'pitstop'),
        'base' => 'common_section_grid',
        'class' => 'pix-theme-icon-common',
        'category' => esc_html__('Pitstop', 'pitstop'),
        'params' => array_merge(
            array(
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__('Posts Type', 'pitstop'),
                    'param_name' => 'post_type',
                    'value' => $post_types,
                    'description' => esc_html__('Select posts type to show', 'pitstop')
                ),
            ),
            $post_types_control,
            array(
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__('Greyscale Images', 'pitstop'),
                    'param_name' => 'greyscale',
                    'value' => 'off',
                    'description' => esc_html__('Show greyscale image with colored hover', 'pitstop'),
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__('Rows', 'pitstop'),
                    'param_name' => 'rows',
                    'params' => array(
                        array(
                            'type' => 'radio_images',
                            'heading' => esc_html__('Style', 'pitstop'),
                            'param_name' => 'style',
                            'value' => array(
                                'reviews_people.png' => 'grid-fives',
                                'reviews_feedback.png' => 'grid-three',
                                'reviews_message.png' => 'grid-four',
                                'reviews_profile.png' => 'grid-eight',
                            ),
                            'description' => '',
                        ),
                        array(
                            'type' => 'segmented_button',
                            'heading' => esc_html__('Large Image Position', 'pitstop'),
                            'param_name' => 'position',
                            'value' => array(
                                'default' => 'right',
                                esc_html__('Left', 'pitstop') => 'left',
                                esc_html__('Center', 'pitstop') => 'center',
                                esc_html__('Right', 'pitstop') => 'right',
                            ),
                            'dependency' => array(
                                'element' => 'style',
                                'value' => array('grid-fives'),
                            )
                        ),
                    )
                ),
                
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__('Order', 'pitstop'),
                    'param_name' => 'order',
                    'value' => array(
                        'default' => 'default',
                        esc_html__('First posts', 'pitstop') => 'default',
                        esc_html__('Custom IDs', 'pitstop') => 'ids',
                    ),
                    'description' => esc_html__('Select first posts or custom', 'pitstop')
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Custom IDs', 'pitstop'),
                    'param_name' => 'items',
                    'description' => esc_html__('Input items IDs. First id is large image. (example: 307,304,302,301,300)', 'pitstop'),
                    'dependency' => array(
                        'element' => 'order',
                        'value' => array('ids'),
                    )
                ),
            )
        )
    
    ));
}

	//////////////////////////////////////////////////////////////////////


    /// common_isotope
	vc_map(
		array(
			'name' => esc_html__( 'Isotope', 'pitstop' ),
			'base' => 'common_isotope',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop' ),
			'params' => array_merge(
                array(
                    array(
                        'type' => 'radio_images',
                        'heading' => esc_html__( 'Box Style', 'pitstop' ),
                        'param_name' => 'style',
                        'value' => array(
                            'isotop_hover-info.png;Hover Info' => 'hover-info',
                            'isotop_bottom-info.png;Bottom Info' => 'bottom-info',
                            'isotop_bottom-desc.png;Bottom Description' => 'bottom-desc',
                        ),
                        'col' => 3,
                        'description' => '',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Filter Alignment', 'pitstop' ),
                        'param_name' => 'filter',
                        'value' => array(
                            'default' => 'pix-text-right',
                            esc_html__('Left', 'pitstop') => 'pix-text-left',
                            esc_html__('Center', 'pitstop') => 'pix-text-center',
                            esc_html__('Right', 'pitstop') => 'pix-text-right',
                            esc_html__('Hide', 'pitstop') => 'pix-hide',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Filter Style', 'pitstop' ),
                        'param_name' => 'filter_style',
                        'value' => array(
                            'default' => 'top-filter',
                            esc_html__('Top', 'pitstop') => 'top-filter',
                            esc_html__('Sidebar', 'pitstop') => 'sidebar-filter',
                            esc_html__('Sidebar Out', 'pitstop') => 'sidebar-out-filter',
                        ),
                        'description' => '',
                        'dependency' => array(
                            'element' => 'filter',
                            'value'   => array('pix-text-left', 'pix-text-center', 'pix-text-right')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'All Text', 'pitstop' ),
                        'param_name' => 'filter_all',
                        'value' => esc_html__( 'All', 'pitstop'),
                        'description' => esc_html__( 'Replace All with your text', 'pitstop'),
                        'dependency' => array(
                            'element' => 'filter',
                            'value'   => array('pix-text-left', 'pix-text-center', 'pix-text-right')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Filter Title', 'pitstop' ),
                        'param_name' => 'filter_title',
                        'description' => '',
                        'dependency' => array(
                            'element' => 'filter_style',
                            'value'   => array('sidebar-filter', 'sidebar-out-filter')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Posts Type', 'pitstop' ),
                        'param_name' => 'post_type',
                        'value' => $post_types,
                        'description' => esc_html__( 'Select posts type to show', 'pitstop' ),
                        //'edit_field_class' => 'vc_col-sm-6',
                    ),
                    
                ),
                $post_types_control,
                array(
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Columns', 'pitstop' ),
                        'param_name' => 'col',
                        'value' => array(
                            'default' => 4,
                            esc_html__( '2', 'pitstop' ) => 2,
                            esc_html__( '3', 'pitstop' ) => 3,
                            esc_html__( '4', 'pitstop' ) => 4,
                            esc_html__( '5', 'pitstop' ) => 5,
                            esc_html__( '6', 'pitstop' ) => 6,
                            esc_html__( '8', 'pitstop' ) => 8,
                        ),
                        'description' => esc_html__( 'Select items number per row', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Items Count', 'pitstop' ),
                        'param_name' => 'count',
                        'description' => esc_html__( 'Items number to show. Leave empty to show all items.', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Boxes Gap', 'pitstop' ),
                        'param_name' => 'box_gap',
                        'value' => array(0,1,2,5,10,15,20,30,50),
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Boxes Shape', 'pitstop' ),
                        'param_name' => 'radius',
                        'value' => array(
                            'default' => 'pix-global',
                            esc_html__( 'Global', 'pitstop' ) => 'pix-global',
                            esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                            esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                            esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Greyscale Images', 'pitstop' ),
                        'param_name' => 'greyscale',
                        'value' => 'off',
                        'description' => esc_html__( 'Show greyscale picture with colored hover.', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Image Proportions', 'pitstop' ),
                        'param_name' => 'img_proportions',
                        'value' => array(
                            'default' => 'pixtheme-square',
                            esc_html__( 'Original', 'pitstop' ) => 'pixtheme-original',
                            esc_html__( 'Landscape', 'pitstop' ) => 'pixtheme-landscape',
                            esc_html__( 'Portrait', 'pitstop' ) => 'pixtheme-portrait',
                            esc_html__( 'Square', 'pitstop' ) => 'pixtheme-square',
                        ),
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => esc_html__( 'Css', 'pitstop' ),
                        'param_name' => 'css',
                        'group' => esc_html__( 'Design options', 'pitstop' ),
                    ),
                )
            )
		)
	);
 

 


	vc_map(
		array(
			'name' => esc_html__( 'Carousel', 'pitstop' ),
			'base' => 'common_carousel',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop' ),
			'params' => array_merge(
                array(
                    array(
                        'type' => 'radio_images',
                        'heading' => esc_html__( 'Box Style', 'pitstop' ),
                        'param_name' => 'style',
                        'value' => array(
                            'isotop_hover-info.png;Hover Info' => 'hover-info',
                            'isotop_bottom-info.png;Bottom Info' => 'bottom-info',
                            'isotop_bottom-info.png;Bottom Boxed' => 'bottom-info boxed',
                            'isotop_bottom-desc.png;Bottom Description' => 'bottom-desc',
                        ),
                        'col' => 2,
                        'description' => '',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Posts Type', 'pitstop' ),
                        'param_name' => 'post_type',
                        'value' => $post_types,
                        'description' => esc_html__( 'Select posts type to show', 'pitstop' )
                    ),
                ),
                $post_types_control,
                array(
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Navigation', 'pitstop' ),
                        'param_name' => 'navigation',
                        'value' => array(
							esc_html__( 'Navigation Arrows', 'pitstop' ) => 'nav',
                            esc_html__( 'Pagination Dots', 'pitstop' ) => 'dots',
                            esc_html__( 'Hide', 'pitstop' ) => 'no',
						),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__( 'Title', 'pitstop' ),
                        'param_name' => 'title',
                        'value' => '',
                        'dependency' => array(
                            'element' => 'navigation',
                            'value'   => array('nav')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Columns', 'pitstop' ),
                        'param_name' => 'col',
                        'value' => array(
                            'default' => 3,
                            esc_html__( '1', 'pitstop' ) => 1,
                            esc_html__( '2', 'pitstop' ) => 2,
                            esc_html__( '3', 'pitstop' ) => 3,
                            esc_html__( '4', 'pitstop' ) => 4,
                            esc_html__( '5', 'pitstop' ) => 5,
                            esc_html__( '6', 'pitstop' ) => 6,
                            esc_html__( '7', 'pitstop' ) => 7,
                            esc_html__( '8', 'pitstop' ) => 8,
                        ),
                        'description' => esc_html__( 'Select items number per screen', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-7',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Gap', 'pitstop' ),
                        'param_name' => 'box_gap',
                        'value' => array(0,1,2,5,10,15,20,30,50),
                        'edit_field_class' => 'vc_col-sm-2',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Items Count', 'pitstop' ),
                        'param_name' => 'count',
                        'description' => esc_html__( 'Items number to show. Leave empty to show all items.', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Boxes Shape', 'pitstop' ),
                        'param_name' => 'radius',
                        'value' => array(
                            'default' => 'pix-global',
                            esc_html__( 'Global', 'pitstop' ) => 'pix-global',
                            esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                            esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                            esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Greyscale Images', 'pitstop' ),
                        'param_name' => 'greyscale',
                        'value' => 'off',
                        'description' => esc_html__( 'Show greyscale picture with colored hover', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Hover Icon', 'pitstop' ),
                        'param_name' => 'hover_icon',
                        'value' => array(
							esc_html__( 'No', 'pitstop' ) => '',
                            esc_html__( 'Plus', 'pitstop' ) => 'plus',
                            esc_html__( 'Eye', 'pitstop' ) => 'eye',
                            esc_html__( 'Search', 'pitstop' ) => 'search',
						),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Image Proportions', 'pitstop' ),
                        'param_name' => 'img_proportions',
                        'value' => array(
                            'default' => 'pixtheme-square',
                            esc_html__( 'Original', 'pitstop' ) => 'pixtheme-original',
                            esc_html__( 'Landscape', 'pitstop' ) => 'pixtheme-landscape',
                            esc_html__( 'Portrait', 'pitstop' ) => 'pixtheme-portrait',
                            esc_html__( 'Square', 'pitstop' ) => 'pixtheme-square',
                        ),
                    ),
                )
            )
		)
	);



	if ( class_exists( 'booked_plugin' ) ) {
		/// common_appointment
		vc_map(
			array(
				'name' => esc_html__( 'Book An Appointment', 'pitstop' ),
				'base' => 'common_appointment',
				'class' => 'pix-theme-icon-common',
				'category' => esc_html__( 'Pitstop', 'pitstop'),
				'params' => array(
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Calendar Type', 'pitstop' ),
						'param_name' => 'calendar_type',
						'value' => array(
							esc_html__( 'With Departments Select', 'pitstop' ) => 'switcher',
							esc_html__( 'Single', 'pitstop' ) => 'single',
						),
						'description' => esc_html__( 'Select appointment calendar to show', 'pitstop' )
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Calendar', 'pitstop' ),
						'param_name' => 'calendar_id',
						'value' => $calendars,
						'description' => esc_html__( 'Select appointment calendar to show', 'pitstop' ),
						'dependency' => array(
							'element' => 'calendar_type',
							'value' => 'single',
						),
					),
				)
			)
		);
	}


	
	/// common_brands
	vc_map(
		array(
			'name' => esc_html__( 'Brands', 'pitstop' ),
			'base' => 'common_brands',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop'),
			'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'heading' => esc_html__( 'Title', 'pitstop' ),
                    'param_name' => 'title',
                    'value' => '',
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Brands per page', 'pitstop' ),
                    'param_name' => 'brands_per_page',
                    'description' => esc_html__( 'Select number of columns. Default 5.', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Navigation', 'pitstop' ),
                    'param_name' => 'navigation',
                    'value' => array(
                        esc_html__( 'Arrows Inside', 'pitstop' ) => 'side-left small',
                        esc_html__( 'Arrows Outside', 'pitstop' ) => 'left-right',
                        esc_html__( 'Hide', 'pitstop' ) => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-4',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Popup Images', 'pitstop' ),
                    'param_name' => 'popup',
                    'value' => 'off',
                    'description' => esc_html__( 'Show popup with large image on click. The link doesn\'t work', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-4',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Greyscale Images', 'pitstop' ),
                    'param_name' => 'greyscale',
                    'value' => 'off',
                    'description' => esc_html__( 'Show greyscale image with colored hover', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-4',
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__( 'Brands', 'pitstop' ),
                    'param_name' => 'brands',
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__( 'Image', 'pitstop' ),
                            'param_name' => 'image',
                            'value' => '',
                            'description' => esc_html__( 'Select image from media library.', 'pitstop' )
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Brand Title', 'pitstop' ),
                            'param_name' => 'title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__( 'Link', 'pitstop' ),
                            'param_name' => 'link',
                            'value' => '#',
                        ),
                    )
                ),
            ),
		)

	);
	////////////////////////



	/// common_section_pricetable
	//////// Price Table ////////
	vc_map( array(
		'name' => esc_html__( 'Price Table', 'pitstop' ),
		'base' => 'common_price_table',
		'class' => 'pix-theme-icon-common',
		'category' => esc_html__( 'Pitstop', 'pitstop'),
		'params' => array(
            array(
                'type' => 'radio_images',
                'heading' => esc_html__( 'Style', 'pitstop' ),
                'param_name' => 'style',
                'value' => array(
                    'price_table_default.png' => 'pix-price-box',
                    'price_table_compare.png' => 'pix-price-table',
                    'price_table_long.png' => 'pix-price-long',
                ),
                'col' => 3,
                'description' => '',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Type', 'pitstop' ),
                'param_name' => 'type_table',
                'value' => array(
                    'default' => 'single',
                    esc_html__( 'Single', 'pitstop' ) => 'single',
                    esc_html__( 'Double', 'pitstop' ) => 'double',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-box', 'pix-price-long'),
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'First Selector', 'pitstop' ),
                'param_name' => 'first_text',
                'value' => 'Monthly',
                'description' => esc_html__( 'First tab button text', 'pitstop' ),
                'dependency' => array(
                    'element' => 'type_table',
                    'value' => array('double'),
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Second Selector', 'pitstop' ),
                'param_name' => 'second_text',
                'value' => 'Yearly',
                'description' => esc_html__( 'Second tab button text', 'pitstop' ),
                'dependency' => array(
                    'element' => 'type_table',
                    'value' => array('double'),
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Shape', 'pitstop' ),
                'param_name' => 'gap',
                'value' => array(
                    'default' => 'pix-global',
                    esc_html__( 'Global', 'pitstop' ) => 'pix-global',
                    esc_html__( 'Square', 'pitstop' ) => 'pix-square',
                    esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                    esc_html__( 'Round', 'pitstop' ) => 'pix-round',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-box', 'pix-price-long')
                ),
            ),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Currency', 'pitstop' ),
				'param_name' => 'currency',
				'value' => '$',
				'description' => esc_html__( 'Change currency', 'pitstop' ),
                'edit_field_class' => 'vc_col-sm-4',
			),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Button Text', 'pitstop' ),
                'param_name' => 'btntext',
                'description' => esc_html__( 'Button text', 'pitstop' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Button Position', 'pitstop' ),
                'param_name' => 'btn_position',
                'value' => array(
                    'default' => 'pix-footer',
                    esc_html__( 'Header', 'pitstop' ) => 'pix-header',
                    esc_html__( 'Footer', 'pitstop' ) => 'pix-footer',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-table'),
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Boxes Gap', 'pitstop' ),
                'param_name' => 'box_gap',
                'value' => array(0,1,2,5,10,15,20,30,50),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-box', 'pix-price-long')
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Features Title', 'pitstop' ),
                'param_name' => 'features_title',
                'value' => 'Features',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-table'),
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Features Subtitle', 'pitstop' ),
                'param_name' => 'features_subtitle',
                'value' => '',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-table'),
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textarea',
                'holder' => 'div',
                'heading' => esc_html__( 'Features for Comparison', 'pitstop' ),
                'param_name' => 'compare_features',
                'value' => '',
                'description' => esc_html__( 'This Features is compared with every box options and set enable/disable', 'pitstop' ),
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Price Boxes', 'pitstop' ),
                'param_name' => 'prices',
                'params' => array_merge(
                    array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Title', 'pitstop' ),
                            'param_name' => 'title',
                            'description' => esc_html__( 'Column title', 'pitstop' ),
                            'edit_field_class' => 'vc_col-sm-4',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Subtitle', 'pitstop' ),
                            'param_name' => 'subtitle',
                            'description' => esc_html__( 'Subtitle text', 'pitstop' ),
                            'edit_field_class' => 'vc_col-sm-4',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Button Text', 'pitstop' ),
                            'param_name' => 'btntext_box',
                            'description' => esc_html__( 'Change Global button text', 'pitstop' ),
                            'edit_field_class' => 'vc_col-sm-4',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'First Price', 'pitstop' ),
                            'param_name' => 'first_price',
                            'description' => '',
                            'edit_field_class' => 'vc_col-sm-3',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Second Price', 'pitstop' ),
                            'param_name' => 'second_price',
                            'description' => '',
                            'edit_field_class' => 'vc_col-sm-3',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Price Subtext', 'pitstop' ),
                            'param_name' => 'price_text',
                            'description' => esc_html__( 'Text after price', 'pitstop' ),
                            'edit_field_class' => 'vc_col-sm-3',
                        ),
                        array(
                            'type' => 'switch_button',
                            'heading' => esc_html__( 'Popular', 'pitstop' ),
                            'param_name' => 'is_popular',
                            'value' => 'off',
                            'edit_field_class' => 'vc_col-sm-3',
                        ),
                        array(
                            'type' => 'segmented_button',
                            'heading' => esc_html__( 'Icon Type', 'pitstop' ),
                            'param_name' => 'icon_type',
                            'value' => array(
                                'default' => 'svg',
                                esc_html__( 'SVG/Image', 'pitstop' ) => 'image',
                                esc_html__( 'Font', 'pitstop' ) => 'font',
                            ),
                            'edit_field_class' => 'vc_col-sm-7',
                        ),
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__( 'Image/SVG', 'pitstop' ),
                            'param_name' => 'image',
                            'description' => esc_html__( 'Select image.', 'pitstop' ),
                            'dependency' => array(
                                'element' => 'icon_type',
                                'value' => array('image')
                            ),
                            'edit_field_class' => 'vc_col-sm-5',
                        ),
                    ),
                    pixtheme_get_vc_icons($vc_icons_data, 'icon_type', 'font'),
                    array(
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'heading' => esc_html__( 'Features', 'pitstop' ),
                            'param_name' => 'price_features',
                            'value' => '',
                            'description' => esc_html__( 'The list of Features', 'pitstop' ),
                            'edit_field_class' => 'vc_col-sm-6',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'heading' => esc_html__( 'Additional Information', 'pitstop' ),
                            'param_name' => 'price_content',
                            'value' => '',
                            'description' => esc_html__( 'Enter information', 'pitstop' ),
                            'edit_field_class' => 'vc_col-sm-6',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Product ID', 'pitstop' ),
                            'param_name' => 'id_product',
                            'description' => esc_html__( 'Redirect to checkout', 'pitstop' ),
                            'edit_field_class' => 'vc_col-sm-3',
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__( 'Link', 'pitstop' ),
                            'param_name' => 'link',
                            'description' => esc_html__( 'Item link', 'pitstop' ),
                            'edit_field_class' => 'vc_col-sm-9',
                        ),
                    )
                ),
            ),
		),

	) );






	////////////////////////

	if ( class_exists( 'WooCommerce' ) ) {
		
	    ////////   Woocommerce   ////////
        
        
        /// pix_filter
		vc_map( array(
			'name' => esc_html__( 'Products Filter', 'pitstop' ),
			'base' => 'pix_filter',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop'),
			'params' => array(
                array(
                    'type' => 'pix_filter',
                    'heading' => esc_html__( 'Fields', 'pitstop' ),
                    'param_name' => 'filter',
                    'value' => '',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Title', 'pitstop' ),
                    'param_name' => 'title',
                    'value' => '',
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Step by Step Filter', 'pitstop' ),
                    'param_name' => 'param_step',
                    'value' => 'off',
                    'edit_field_class' => 'vc_col-sm-3',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Show Params Title', 'pitstop' ),
                    'param_name' => 'param_title',
                    'value' => 'off',
                    'edit_field_class' => 'vc_col-sm-3',
                ),
                array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Page with Result', 'pitstop' ),
					'param_name' => 'page',
					'value' => $pages,
					'description' => esc_html__( 'Select page to redirect for results', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-6',
				),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Button Text', 'pitstop' ),
                    'param_name' => 'btn_txt',
                    'value' => '',
                    'edit_field_class' => 'vc_col-sm-6',
                ),
			),

		) );
        
        
        
        /// common_woo_categories
		vc_map(
			array(
				'name' => esc_html__( 'Product Categories Grid', 'pitstop' ),
				'base' => 'common_woo_categories',
				'class' => 'pix-theme-icon-common',
				'category' => esc_html__( 'Pitstop', 'pitstop'),
				'params' => array(
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Categories', 'pitstop' ),
						'param_name' => 'cats',
						'value' => $cats_woo,
						'description' => esc_html__( 'Select categories to show', 'pitstop' ),
					),
					array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Category Image', 'pitstop' ),
                        'param_name' => 'show_image',
                        'value' => 'on',
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Products Number', 'pitstop' ),
                        'param_name' => 'prod_number',
                        'value' => 'on',
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Subcategories Count', 'pitstop' ),
						'param_name' => 'count',
						'description' => esc_html__( 'Leave empty to show all.', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-4',
					),
				)
			)
		);
		
		
		
	    /// common_woocommerce
		vc_map(
			array(
				'name' => esc_html__( 'Woocommerce Products', 'pitstop' ),
				'base' => 'common_woocommerce',
				'class' => 'pix-theme-icon-common',
				'category' => esc_html__( 'Pitstop', 'pitstop'),
				'params' => array(
				    array(
                        'type' => 'radio_images',
                        'heading' => esc_html__( 'Box Style', 'pitstop' ),
                        'param_name' => 'style',
                        'value' => array(
                            'woo_product.png;Default' => 'pix-product',
                            'woo_product-long.png;Product Long' => 'pix-product-long',
                        ),
                        'col' => 2,
                        'description' => '',
                    ),
				    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Products by', 'pitstop' ),
                        'param_name' => 'select_type',
                        'value' => array(
                            'default' => 'default',
                            esc_html__('Label', 'pitstop') => 'default',
                            esc_html__('IDs', 'pitstop') => 'ids',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'IDs', 'pitstop' ),
                        'param_name' => 'items',
                        'description' => esc_html__( 'Input products ID.  (example: 307,304,302,301,300)', 'pitstop' ),
                        'dependency' => array(
                            'element' => 'select_type',
                            'value' => array('ids'),
                        )
                    ),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Label', 'pitstop' ),
						'param_name' => 'labels',
						'value' => array(
                            esc_html__('Best Sellers', 'pitstop') => 'popular',
                            esc_html__('Sales', 'pitstop') => 'sale',
                            esc_html__('Featured', 'pitstop') => 'featured',
                            esc_html__('New', 'pitstop') => 'new',
                        ),
						'description' => esc_html__( 'Select product labels to show', 'pitstop' ),
                        'dependency' => array(
                            'element' => 'select_type',
                            'value' => array('default'),
                        )
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Categories', 'pitstop' ),
						'param_name' => 'cats',
						'value' => $cats_woo,
						'description' => esc_html__( 'Select categories to show', 'pitstop' ),
                        'dependency' => array(
                            'element' => 'select_type',
                            'value' => array('default'),
                        )
					),
					array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__( 'Title', 'pitstop' ),
                        'param_name' => 'title',
                        'value' => '',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
					array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Background', 'pitstop' ),
                        'param_name' => 'bg_color',
                        'value' => array(
                            esc_html__( 'White', 'pitstop' ) => 'pix-white',
                            esc_html__( 'Black', 'pitstop' ) => 'pix-black',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
					array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Navigation', 'pitstop' ),
                        'param_name' => 'navigation',
                        'value' => array(
                            esc_html__( 'Arrows on Top', 'pitstop' ) => 'top-left',
                            esc_html__( 'Arrows on Sides', 'pitstop' ) => 'left-right',
//                            esc_html__( 'Pagination Dots', 'pitstop' ) => 'dots',
                            esc_html__( 'Hide', 'pitstop' ) => 'no',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Items Count', 'pitstop' ),
						'param_name' => 'count',
						'description' => esc_html__( 'Select number products.', 'pitstop' ),
                        'dependency' => array(
                            'element' => 'select_type',
                            'value' => array('default'),
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
					),
                    array(
                        'type' => 'dropdown',
                        'holder' => 'div',
                        'heading' => esc_html__( 'Banner', 'pitstop' ),
                        'param_name' => 'banner_id',
                        'value' => $banners,
                        'description' => esc_html__( 'Select Banner to show', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'dropdown',
                        'holder' => 'div',
                        'heading' => esc_html__( 'Banner 2', 'pitstop' ),
                        'param_name' => 'banner_id_2',
                        'value' => $banners,
                        'description' => esc_html__( 'Select second Banner to show', 'pitstop' ),
                        'edit_field_class' => 'vc_col-sm-4',
                        'dependency' => array(
                            'element' => 'rows',
                            'value' => array('2'),
                        )
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Banner Position', 'pitstop' ),
                        'param_name' => 'banner_position',
                        'value' => array(
                            'default' => 'right',
                            esc_html__( 'Left', 'pitstop' ) => 'left',
                            esc_html__( 'Right', 'pitstop' ) => 'right',
                        ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
				)
			)
		);
	}
	
	
	/// pix_section
	vc_map(
		array(
			'name' => esc_html__( 'Pix Section', 'pitstop' ),
			'base' => 'pix_section',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop'),
			'params' => array(
				array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'heading' => esc_html__( 'Pix Section', 'pitstop' ),
                    'param_name' => 'section_id',
                    'value' => $sections,
                    'description' => esc_html__( 'Select Pix Section to show', 'pitstop' )
                ),

			)
		)
	);
	
	
	/// pix_banner
	vc_map(
		array(
			'name' => esc_html__( 'Banner', 'pitstop' ),
			'base' => 'pix_banner',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pitstop', 'pitstop'),
			'params' => array(
				array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'heading' => esc_html__( 'Banner', 'pitstop' ),
                    'param_name' => 'banner_id',
                    'value' => $banners,
                    'description' => esc_html__( 'Select Banner to show', 'pitstop' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__( 'Height in px', 'pitstop' ),
					'param_name' => 'height',
                    'description' => '',
                    'edit_field_class' => 'vc_col-sm-6',
				),
			)
		)
	);
	//////////////////////////////////////////////////////////////////////
	
	


	if ( class_exists( 'WPBakeryShortCode' ) && class_exists( 'WPBakeryShortCodesContainer' ) ) {

		class WPBakeryShortCode_Box_Container extends WPBakeryShortCodesContainer {
			protected $controls_css_settings = 'out-tc vc_controls-content-widget';
			protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );

			public function __construct( $settings ) {
				parent::__construct( $settings );
			}

			public function contentAdmin( $atts, $content = null ) {

				$elem = $this->getElementHolder( '' );
				$elem = str_ireplace( 'wpb_content_element', '', $elem );
				$elem = str_ireplace( '%wpb_element_content%', '<div class="wpb_column_container vc_container_for_children vc_clearfix vc_empty-container ui-sortable ui-droppable"></div>', $elem );
				$output = $elem;

				return $output;
			}
		}

        class WPBakeryShortCode_Progress extends WPBakeryShortCode {
            public static function convertAttributesToNewProgressBar( $atts ) {
                if ( isset( $atts['values'] ) && strlen( $atts['values'] ) > 0 ) {
                    $values = vc_param_group_parse_atts( $atts['values'] );
                    if ( ! is_array( $values ) ) {
                        $temp = explode( ',', $atts['values'] );
                        $paramValues = array();
                        foreach ( $temp as $value ) {
                            $data = explode( '|', $value );
                            $colorIndex = 2;
                            $newLine = array();
                            $newLine['value'] = isset( $data[0] ) ? $data[0] : 0;
                            $newLine['label'] = isset( $data[1] ) ? $data[1] : '';
                            if ( isset( $data[1] ) && preg_match( '/^\d{1,3}\%$/', $data[1] ) ) {
                                $colorIndex += 1;
                                $newLine['value'] = (float) str_replace( '%', '', $data[1] );
                                $newLine['label'] = isset( $data[2] ) ? $data[2] : '';
                            }
                            if ( isset( $data[ $colorIndex ] ) ) {
                                $newLine['customcolor'] = $data[ $colorIndex ];
                            }
                            $paramValues[] = $newLine;
                        }
                        $atts['values'] = urlencode( json_encode( $paramValues ) );
                    }
                }

                return $atts;
            }
        }


        class WPBakeryShortCode_Common_Title extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Button extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Icon_Box extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Tab_Acc extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Posts_Block extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Special_Offers extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Team extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Reviews extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Video extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Google_Map extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Price_Table extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Points extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Amount_Box extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Progress extends WPBakeryShortCode_Progress {}
		class WPBakeryShortCode_Common_Brands extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Mailchimp extends WPBakeryShortCode {}
		class WPBakeryShortCode_Pix_Calculator extends WPBakeryShortCode {}
		class WPBakeryShortCode_Pix_Section extends WPBakeryShortCode {}
		class WPBakeryShortCode_Pix_Banner extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Cform7 extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Slider extends WPBakeryShortCode_Box_Container {}
		class WPBakeryShortCode_Common_Wrapper extends WPBakeryShortCode_Box_Container {}
        //class WPBakeryShortCode_Common_Section_Grid extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Isotope extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Carousel extends WPBakeryShortCode {}
        if ( class_exists( 'booked_plugin' ) ) {
		    class WPBakeryShortCode_Common_Appointment extends WPBakeryShortCode {}
        }
        class WPBakeryShortCode_Pix_Filter extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Woocommerce extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Woo_Categories extends WPBakeryShortCode {}

	}
?>