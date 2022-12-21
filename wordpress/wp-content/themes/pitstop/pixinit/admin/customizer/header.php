<?php

	function pixtheme_customize_header_tab($wp_customize, $theme_name){

		$wp_customize->add_panel('pixtheme_header_panel',  array(
            'title' => 'Header',
            'priority' => 30,
            )
        );



		$wp_customize->add_section( 'pixtheme_header_settings' , array(
		    'title'      => esc_html__( 'General Settings', 'pitstop' ),
		    'priority'   => 5,
			'panel' => 'pixtheme_header_panel'
		) );


		$wp_customize->add_setting( 'pixtheme_header_type' , array(
				'default'     => 'header1',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_type',
            array(
                'label'    => esc_html__( 'Type', 'pitstop' ),
                'section'  => 'pixtheme_header_settings',
                'settings' => 'pixtheme_header_type',
                'type'     => 'select',
                'choices'  => array(
                    'header1' => esc_html__( 'Default', 'pitstop' ),
                    'header2' => esc_html__( 'Centered Logo', 'pitstop' ),
		            'header3' => esc_html__( 'Top Logo (2 levels)', 'pitstop' ),
		            'header4' => esc_html__( 'Top Info (2 levels)', 'pitstop' ),
                    'header5' => esc_html__( 'Search (2 levels)', 'pitstop' ),
                    'header_catalog' => esc_html__( 'Catalog Button (2 levels)', 'pitstop' ),
//		            'header6' => esc_html__( 'Slideout Sidebar', 'pitstop' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_layout' , array(
			'default'     => 'container',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_layout',
            array(
                'label'    => esc_html__( 'Layout', 'pitstop' ),
                'section'  => 'pixtheme_header_settings',
                'settings' => 'pixtheme_header_layout',
                'type'     => 'select',
                'choices'  => array(
                    'container'  => esc_html__( 'Normal', 'pitstop' ),
		            'container boxed'  => esc_html__( 'Boxed', 'pitstop' ),
		            'container-fluid' => esc_html__( 'Full Width', 'pitstop' ),
                ),
            )
        );
		
		$wp_customize->add_setting( 'pixtheme_header_layout_bottom' , array(
            'default'     => 'container',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_layout_bottom',
            array(
                'label'         => esc_html__( 'Bottom Layout', 'pitstop' ),
                'section'       => 'pixtheme_header_settings',
                'settings'      => 'pixtheme_header_layout_bottom',
                'type'          => 'select',
                'choices'       => array(
                    'container'  => esc_html__( 'Normal', 'pitstop' ),
		            'container boxed'  => esc_html__( 'Boxed', 'pitstop' ),
		            'container-fluid' => esc_html__( 'Full Width', 'pitstop' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_sticky' , array(
				'default'     => 'sticky',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_sticky',
            array(
                'label'         => esc_html__( 'Sticky', 'pitstop' ),
                'section'       => 'pixtheme_header_settings',
                'settings'      => 'pixtheme_header_sticky',
                'type'          => 'select',
                'choices'       => array(
                    '' => esc_html__( 'No', 'pitstop' ),
                    'sticky'  => esc_html__( 'Yes', 'pitstop' ),
                    'sticky-up'  => esc_html__( 'On Up Scroll', 'pitstop' ),
                ),
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_header_sticky_width' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_sticky_width',
            array(
                'label'         => esc_html__( 'Sticky Layout', 'pitstop' ),
                'section'       => 'pixtheme_header_settings',
                'settings'      => 'pixtheme_header_sticky_width',
                'type'          => 'select',
                'choices'       => array(
                    'boxed'  => esc_html__( 'Boxed', 'pitstop' ),
                    '' => esc_html__( 'Full Width', 'pitstop' ),
                ),
            )
        );
		
		$wp_customize->add_setting( 'pixtheme_header_menu_pos' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_menu_pos',
            array(
                'label'    => esc_html__( 'Menu Position', 'pitstop' ),
                'description'   => '',
                'section'  => 'pixtheme_header_settings',
                'settings' => 'pixtheme_header_menu_pos',
                'type'     => 'select',
                'choices'  => array(
                    'pix-text-right' => esc_html__( 'Right', 'pitstop' ),
                    'pix-text-left'  => esc_html__( 'Left', 'pitstop' ),
                    'pix-text-center'  => esc_html__( 'Center', 'pitstop' ),
                ),
            )
        );
		
		
		
		/// HEADER MOBILE ///

		$wp_customize->add_section( 'pixtheme_header_settings_mobile' , array(
		    'title'      => esc_html__( 'Mobile', 'pitstop' ),
		    'priority'   => 7,
			'panel' => 'pixtheme_header_panel'
		) );


		$wp_customize->add_setting( 'pixtheme_header_type_mobile' , array(
				'default'     => 'mobile',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_type_mobile',
            array(
                'label'    => esc_html__( 'Type', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_mobile',
                'settings' => 'pixtheme_header_type_mobile',
                'type'     => 'select',
                'choices'  => array(
                    'mobile' => esc_html__( 'Default', 'pitstop' ),
                    'mobile_cat' => esc_html__( 'Catalog Button (2 levels)', 'pitstop' ),
                ),
            )
        );
		
		$wp_customize->add_setting( 'pixtheme_header_sticky_mobile' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_sticky_mobile',
            array(
                'label'         => esc_html__( 'Sticky Mobile', 'pitstop' ),
                'section'       => 'pixtheme_header_settings_mobile',
                'settings'      => 'pixtheme_header_sticky_mobile',
                'type'          => 'select',
                'choices'       => array(
                    '' => esc_html__( 'No', 'pitstop' ),
                    'sticky'  => esc_html__( 'Yes', 'pitstop' ),
                    'sticky-up'  => esc_html__( 'On Up Scroll', 'pitstop' ),
                ),
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_header_mobile_cat_txt' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_mobile_cat_txt',
			array(
				'label'    => esc_html__( 'Catalog Text', 'pitstop' ),
				'section'  => 'pixtheme_header_settings_mobile',
				'settings' => 'pixtheme_header_mobile_cat_txt',
				'type'     => 'text',
			)
		);



		/// HEADER COLORS ///

		$wp_customize->add_section( 'pixtheme_header_settings_style' , array(
		    'title'      => esc_html__( 'Colors', 'pitstop' ),
		    'priority'   => 10,
			'panel' => 'pixtheme_header_panel'
		) );


		$wp_customize->add_setting( 'pixtheme_top_bar_background' , array(
            'default'     => 'black',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_top_bar_background',
            array(
                'label'    => esc_html__( 'Top Bar Background Color', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_style',
                'settings' => 'pixtheme_top_bar_background',
                'type'     => 'select',
                'choices'  => array(
                    'white' => esc_html__( 'White', 'pitstop' ),
		            'black' => esc_html__( 'Black', 'pitstop' ),
                    'main-color' => esc_html__( 'Main', 'pitstop' ),
                    'add-color' => esc_html__( 'Additional', 'pitstop' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_top_bar_transparent' , array(
			'default'     => '100',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
			new PixTheme_Slider_Single_Control(
				$wp_customize,
				'pixtheme_top_bar_transparent',
				array(
					'label' => esc_html__( 'Top Bar Transparent', 'pitstop' ),
					'section' => 'pixtheme_header_settings_style',
					'settings' => 'pixtheme_top_bar_transparent',
					'min' => 0,
					'max' => 100,
					'unit'=> '%',
				)
			)
	    );

		$wp_customize->add_setting( 'pixtheme_header_background' , array(
				'default'     => 'black',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_background',
            array(
                'label'    => esc_html__( 'Background Color', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_style',
                'settings' => 'pixtheme_header_background',
                'type'     => 'select',
                'choices'  => array(
                    'white' => esc_html__( 'White', 'pitstop' ),
		            'black' => esc_html__( 'Black', 'pitstop' ),
                    'main-color' => esc_html__( 'Main', 'pitstop' ),
                    'add-color' => esc_html__( 'Additional', 'pitstop' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_transparent' , array(
			'default'     => '0',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
			new PixTheme_Slider_Single_Control(
				$wp_customize,
				'pixtheme_header_transparent',
				array(
					'label' => esc_html__( 'Transparent', 'pitstop' ),
					'section' => 'pixtheme_header_settings_style',
					'settings' => 'pixtheme_header_transparent',
					'min' => 0,
					'max' => 100,
					'unit'=> '%',
				)
			)
	    );
		
		$wp_customize->add_setting( 'pixtheme_header_background_bottom' , array(
				'default'     => 'white',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_background_bottom',
            array(
                'label'    => esc_html__( 'Bottom Background Color', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_style',
                'settings' => 'pixtheme_header_background_bottom',
                'type'     => 'select',
                'choices'  => array(
                    'white' => esc_html__( 'White', 'pitstop' ),
		            'black' => esc_html__( 'Black', 'pitstop' ),
                    'main-color' => esc_html__( 'Main', 'pitstop' ),
                    'add-color' => esc_html__( 'Additional', 'pitstop' ),
                ),
            )
        );
		
		$wp_customize->add_setting( 'pixtheme_header_transparent_bottom' , array(
			'default'     => '100',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
			new PixTheme_Slider_Single_Control(
				$wp_customize,
				'pixtheme_header_transparent_bottom',
				array(
					'label' => esc_html__( 'Bottom Transparent', 'pitstop' ),
					'section' => 'pixtheme_header_settings_style',
					'settings' => 'pixtheme_header_transparent_bottom',
					'min' => 0,
					'max' => 100,
					'unit'=> '%',
				)
			)
	    );
        
        $wp_customize->add_setting( 'pixtheme_header_border' , array(
            'default'     => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_border',
            array(
                'label'    => esc_html__( 'Borders', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_style',
                'settings' => 'pixtheme_header_border',
                'type'     => 'select',
                'choices'  => array(
                    '0' => esc_html__( 'Off', 'pitstop' ),
                    'top'  => esc_html__( 'Top', 'pitstop' ),
                    'bottom'  => esc_html__( 'Bottom', 'pitstop' ),
                    'both'  => esc_html__( 'Both', 'pitstop' ),
                ),
            )
        );

		



        /// HEADER ELEMENTS ///

		$wp_customize->add_section( 'pixtheme_header_settings_elements' , array(
		    'title'      => esc_html__( 'Elements', 'pitstop' ),
		    'priority'   => 15,
			'panel' => 'pixtheme_header_panel'
		) );


		$wp_customize->add_setting( 'pixtheme_header_bar' , array(
				'default'     => '0',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'pixtheme_header_bar',
			array(
				'label'    => esc_html__( 'Top Bar', 'pitstop' ),
				'section'  => 'pixtheme_header_settings_elements',
				'settings' => 'pixtheme_header_bar',
				'type'     => 'select',
				'choices'  => array(
						'1'  => esc_html__( 'On', 'pitstop' ),
						'0' => esc_html__( 'Off', 'pitstop' ),
				),
			)
		);
		
		$wp_customize->add_setting( 'pixtheme_header_search' , array(
            'default'     => '1',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_search',
            array(
                'label'    => esc_html__( 'Search', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_search',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'pitstop' ),
                    '0' => esc_html__( 'Off', 'pitstop' ),
                ),
            )
        );
		
		$wp_customize->add_setting( 'pixtheme_header_currency' , array(
            'default'     => '1',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_currency',
            array(
                'label'    => esc_html__( 'Currency', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_currency',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'pitstop' ),
                    '0' => esc_html__( 'Off', 'pitstop' ),
                ),
            )
        );
		
		$wp_customize->add_setting( 'pixtheme_header_compare' , array(
            'default'     => '1',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_compare',
            array(
                'label'    => esc_html__( 'Compare', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_compare',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'pitstop' ),
                    '0' => esc_html__( 'Off', 'pitstop' ),
                ),
            )
        );
		
		$wp_customize->add_setting( 'pixtheme_header_wishlist' , array(
            'default'     => '1',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_wishlist',
            array(
                'label'    => esc_html__( 'Wishlist', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_wishlist',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'pitstop' ),
                    '0' => esc_html__( 'Off', 'pitstop' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_minicart' , array(
				'default'     => '1',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_minicart',
            array(
                'label'    => esc_html__( 'Minicart', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_minicart',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'pitstop' ),
                    '0' => esc_html__( 'Off', 'pitstop' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_account' , array(
				'default'     => '1',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_account',
            array(
                'label'    => esc_html__( 'Account', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_account',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'pitstop' ),
                    '0' => esc_html__( 'Off', 'pitstop' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_socials' , array(
				'default'     => '1',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_socials',
            array(
                'label'    => esc_html__( 'Socials', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_socials',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'pitstop' ),
                    '0' => esc_html__( 'Off', 'pitstop' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_button' , array(
            'default'     => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_button',
            array(
                'label'    => esc_html__( 'Button', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_button',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'pitstop' ),
                    '0' => esc_html__( 'Off', 'pitstop' ),
                ),
            )
		);

		$wp_customize->add_setting( 'pixtheme_header_catalog_height' , array(
            'default'     => 'pix-catalog-100',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_catalog_height',
            array(
                'label'    => esc_html__( 'Catalog Height', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_catalog_height',
                'type'     => 'select',
                'choices'  => array(
                    'pix-catalog-100' => esc_html__( '100%', 'pitstop' ),
                    'pix-catalog-overlay'  => esc_html__( 'With Vertical Scroll', 'pitstop' ),
                    'pix-catalog-hide'  => esc_html__( 'Hide Subcategories', 'pitstop' ),
                ),
            )
		);



        /// HEADER INFO ///

		$wp_customize->add_section( 'pixtheme_header_settings_info' , array(
		    'title'      => esc_html__( 'Info Texts', 'pitstop' ),
		    'priority'   => 25,
			'panel' => 'pixtheme_header_panel'
		) );


		$wp_customize->add_setting( 'pixtheme_header_phone' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_phone',
			array(
				'label'    => esc_html__( 'Phone', 'pitstop' ),
				'section'  => 'pixtheme_header_settings_info',
				'settings' => 'pixtheme_header_phone',
				'type'     => 'text',
			)
		);
        
		$wp_customize->add_setting( 'pixtheme_header_email' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_email',
			array(
				'label'    => esc_html__( 'E-mail', 'pitstop' ),
				'section'  => 'pixtheme_header_settings_info',
				'settings' => 'pixtheme_header_email',
				'type'     => 'text',
			)
		);

		$wp_customize->add_setting( 'pixtheme_header_address' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_address',
			array(
				'label'    => esc_html__( 'Address', 'pitstop' ),
				'section'  => 'pixtheme_header_settings_info',
				'settings' => 'pixtheme_header_address',
				'type'     => 'text',
			)
		);
        
		$wp_customize->add_setting( 'pixtheme_header_button_text' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_button_text',
			array(
					'label'    => esc_html__( 'Button Text', 'pitstop' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_button_text',
					'type'     => 'text',
			)
		);

		$wp_customize->add_setting( 'pixtheme_header_button_link' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'esc_url'
		) );
		$wp_customize->add_control(
				'pixtheme_header_button_link',
				array(
						'label'    => esc_html__( 'Button Link', 'pitstop' ),
						'section'  => 'pixtheme_header_settings_info',
						'settings' => 'pixtheme_header_button_link',
						'type'     => 'text',
				)
		);



		$wp_customize->add_setting( 'pixtheme_header_info_segment', array(
            'default' => 'info_1',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Segmented_Control(
                $wp_customize,
                'pixtheme_header_info_segment',
                array(
                    'label' => esc_html__( 'Info Sections', 'pitstop' ),
                    'section' => 'pixtheme_header_settings_info',
                    'settings' => 'pixtheme_header_info_segment',
                    'choices'  => array(
                        'info_1' => esc_html__( 'Info 1', 'pitstop' ),
                        'info_2' => esc_html__( 'Info 2', 'pitstop' ),
                        'info_3' => esc_html__( 'Info 3', 'pitstop' ),
                    ),
                    'align' => 'center',
                    'type' => 'tabs',
                    'hide_label' => 'hide',
                )
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_info_icon_1' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_icon_1',
			array(
					'label'    => esc_html__( 'Icon 1', 'pitstop' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_icon_1',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_title_1' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_title_1',
			array(
					'label'    => esc_html__( 'Title 1', 'pitstop' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_title_1',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_1' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_1',
			array(
					'label'    => esc_html__( 'Info 1', 'pitstop' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_1',
					'type'     => 'text',
			)
		);

		$wp_customize->add_setting( 'pixtheme_header_info_icon_2' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_icon_2',
			array(
					'label'    => esc_html__( 'Icon 2', 'pitstop' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_icon_2',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_title_2' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_title_2',
			array(
					'label'    => esc_html__( 'Title 2', 'pitstop' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_title_2',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_2' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_2',
			array(
					'label'    => esc_html__( 'Info 2', 'pitstop' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_2',
					'type'     => 'text',
			)
		);

		$wp_customize->add_setting( 'pixtheme_header_info_icon_3' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_icon_3',
			array(
					'label'    => esc_html__( 'Icon 3', 'pitstop' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_icon_3',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_title_3' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_title_3',
			array(
					'label'    => esc_html__( 'Title 3', 'pitstop' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_title_3',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_3' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_3',
			array(
					'label'    => esc_html__( 'Info 3', 'pitstop' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_3',
					'type'     => 'text',
			)
		);



        /// HEADER BACKGROUND ///

        $wp_customize->add_section( 'pixtheme_header_settings_bg_image' , array(
            'title'      => esc_html__( 'Background Image', 'pitstop' ),
            'priority'   => 30,
            'panel' => 'pixtheme_header_panel'
        ) );


        $wp_customize->add_setting( 'pixtheme_tab_bg_image' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'pixtheme_tab_bg_image',
                array(
                    'label'      => esc_html__( 'Background Image', 'pitstop' ),
                    'section'    => 'pixtheme_header_settings_bg_image',
                    'settings'   => 'pixtheme_tab_bg_image',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_tab_bg_image_size' , array(
            'default'     => 'cover',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_bg_image_size',
            array(
                'label'    => esc_html__( 'Background Size', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_bg_image',
                'settings' => 'pixtheme_tab_bg_image_size',
                'type'     => 'select',
                'choices'  => array(
                    'cover'  => esc_html__( 'Cover', 'pitstop' ),
                    'contain' => esc_html__( 'Contain', 'pitstop' ),
                    'auto' => esc_html__( 'Auto', 'pitstop' ),
                ),
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_tab_bg_image_repeat' , array(
            'default'     => 'no-repeat',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_bg_image_repeat',
            array(
                'label'    => esc_html__( 'Background Repeat', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_bg_image',
                'settings' => 'pixtheme_tab_bg_image_repeat',
                'type'     => 'select',
                'choices'  => array(
                    'no-repeat'  => esc_html__( 'No Repeat', 'pitstop' ),
                    'repeat'  => esc_html__( 'Repeat', 'pitstop' ),
                    'repeat-x'  => esc_html__( 'Repeat X', 'pitstop' ),
                    'repeat-y'  => esc_html__( 'Repeat Y', 'pitstop' ),
                ),
            )
        );

        $wp_customize->add_setting(	'pixtheme_tab_bg_image_horizontal_pos', array(
            'default' => '50',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_bg_image_horizontal_pos',
                array(
                    'label' => esc_html__( 'Horizontal Position', 'pitstop' ),
                    'section' => 'pixtheme_header_settings_bg_image',
                    'settings' => 'pixtheme_tab_bg_image_horizontal_pos',
                    'min' => 0,
                    'max' => 100,
                    'unit' => '%',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_tab_bg_image_vertical_pos', array(
            'default' => '50',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_bg_image_vertical_pos',
                array(
                    'label' => esc_html__( 'Vertical Position', 'pitstop' ),
                    'section' => 'pixtheme_header_settings_bg_image',
                    'settings' => 'pixtheme_tab_bg_image_vertical_pos',
                    'min' => 0,
                    'max' => 100,
                    'unit' => '%',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_bg_image_fixed' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_bg_image_fixed',
            array(
                'label'    => esc_html__( 'Fixed Image', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_bg_image',
                'settings' => 'pixtheme_tab_bg_image_fixed',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'No', 'pitstop' ),
                    'pix-bg-image-fixed' => esc_html__( 'Yes', 'pitstop' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_bg_color' , array(
            'default'     => get_option('pixtheme_default_tab_bg_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_tab_bg_color',
                array(
                    'label'      => esc_html__( 'Overlay Color', 'pitstop' ),
                    'section'    => 'pixtheme_header_settings_bg_image',
                    'settings'   => 'pixtheme_tab_bg_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_bg_color_gradient' , array(
            'default'     => get_option('pixtheme_default_tab_bg_color_gradient'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_tab_bg_color_gradient',
                array(
                    'label'      => esc_html__( 'Gradient Color', 'pitstop' ),
                    'description'    => esc_html__( 'Set this color for gradient overlay', 'pitstop'),
                    'section'    => 'pixtheme_header_settings_bg_image',
                    'settings'   => 'pixtheme_tab_bg_color_gradient',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_gradient_direction' , array(
            'default'     => get_option('pixtheme_default_tab_gradient_direction'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_gradient_direction',
            array(
                'label'    => esc_html__( 'Gradient Direction', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_bg_image',
                'settings' => 'pixtheme_tab_gradient_direction',
                'type'     => 'select',
                'choices'  => array(
                    'to right' => esc_html__( 'To Right ', 'pitstop' ).html_entity_decode('&rarr;'),
                    'to left' => esc_html__( 'To Left ', 'pitstop' ).html_entity_decode('&larr;'),
                    'to bottom' => esc_html__( 'To Bottom ', 'pitstop' ).html_entity_decode('&darr;'),
                    'to top' => esc_html__( 'To Top ', 'pitstop' ).html_entity_decode('&uarr;'),
                    'to bottom right' => esc_html__( 'To Bottom Right ', 'pitstop' ).html_entity_decode('&#8600;'),
                    'to bottom left' => esc_html__( 'To Bottom Left ', 'pitstop' ).html_entity_decode('&#8601;'),
                    'to top right' => esc_html__( 'To Top Right ', 'pitstop' ).html_entity_decode('&#8599;'),
                    'to top left' => esc_html__( 'To Top Left ', 'pitstop' ).html_entity_decode('&#8598;'),
                    //'angle' => esc_html__( 'Angle ', 'pitstop' ).html_entity_decode('&#10227;'),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_bg_opacity' , array(
            'default'     => get_option('pixtheme_default_tab_bg_opacity'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_bg_opacity',
                array(
                    'label' => esc_html__( 'Overlay Opacity', 'pitstop' ),
                    'section' => 'pixtheme_header_settings_bg_image',
                    'settings' => 'pixtheme_tab_bg_opacity',
                    'min' => 0,
                    'max' => 100,
                    'unit' => '%',
                )
            )
        );




        /// TITLE & BREADCRUMBS ///

        $wp_customize->add_section( 'pixtheme_header_settings_tab' , array(
            'title'      => esc_html__( 'Title & Breadcrumbs', 'pitstop' ),
            'priority'   => 35,
            'panel' => 'pixtheme_header_panel'
        ) );


        $wp_customize->add_setting( 'pixtheme_tab_tone' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_tone',
            array(
                'label'    => esc_html__( 'Text Tone', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_tab',
                'settings' => 'pixtheme_tab_tone',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'Light', 'pitstop' ),
                    'pix-tab-tone-dark' => esc_html__( 'Dark', 'pitstop' ),
                ),
            )
        );


        $wp_customize->add_setting( 'pixtheme_tab_position' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_position',
            array(
                'label'    => esc_html__( 'Title & Breadcrumbs Position', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_tab',
                'settings' => 'pixtheme_tab_position',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'Both Center', 'pitstop' ),
                    'left' => esc_html__( 'Both Left', 'pitstop' ),
                    'right' => esc_html__( 'Both Right', 'pitstop' ),
                    'left_right' => esc_html__( 'Title Left Breadcrumbs Right', 'pitstop' ),
                    'right_left' => esc_html__( 'Title Right Breadcrumbs Left', 'pitstop' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_hide' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_hide',
            array(
                'label'    => esc_html__( 'Title & Breadcrumbs Show', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_tab',
                'settings' => 'pixtheme_tab_hide',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'Show Both', 'pitstop' ),
                    'hide_title' => esc_html__( 'Hide Title', 'pitstop' ),
                    'hide_breadcrumbs' => esc_html__( 'Hide Breadcrumbs', 'pitstop' ),
                    'hide' => esc_html__( 'Hide Both', 'pitstop' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_breadcrumbs_v_position' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_breadcrumbs_v_position',
            array(
                'label'    => esc_html__( 'Breadcrumbs Vertical Position', 'pitstop' ),
                'description' => esc_html__( 'Show breadcrumbs over or under title', 'pitstop'),
                'section'  => 'pixtheme_header_settings_tab',
                'settings' => 'pixtheme_tab_breadcrumbs_v_position',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'Under', 'pitstop' ),
                    'over' => esc_html__( 'Over', 'pitstop' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_breadcrumbs_current' , array(
            'default'     => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_breadcrumbs_current',
            array(
                'label'    => esc_html__( 'Breadcrumbs Show Current Page', 'pitstop' ),
                'section'  => 'pixtheme_header_settings_tab',
                'settings' => 'pixtheme_tab_breadcrumbs_current',
                'type'     => 'select',
                'choices'  => array(
                    '0' => esc_html__( 'No', 'pitstop' ),
                    '1' => esc_html__( 'Yes', 'pitstop' ),
                ),
            )
        );

        $wp_customize->add_setting(	'pixtheme_tab_padding_top', array(
            'default' => get_option('pixtheme_default_tab_padding_top'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_padding_top',
                array(
                    'label' => esc_html__( 'Header Padding Top', 'pitstop' ),
                    'section' => 'pixtheme_header_settings_tab',
                    'settings' => 'pixtheme_tab_padding_top',
                    'min' => 0,
                    'max' => 500,
                    'unit' => 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_tab_padding_bottom', array(
            'default' => get_option('pixtheme_default_tab_padding_bottom'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_padding_bottom',
                array(
                    'label' => esc_html__( 'Header Padding Bottom', 'pitstop' ),
                    'section' => 'pixtheme_header_settings_tab',
                    'settings' => 'pixtheme_tab_padding_bottom',
                    'min' => 0,
                    'max' => 500,
                    'unit' => 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_tab_margin_bottom', array(
            'default' => get_option('pixtheme_default_tab_margin_bottom'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_margin_bottom',
                array(
                    'label' => esc_html__( 'Header Margin Bottom', 'pitstop' ),
                    'section' => 'pixtheme_header_settings_tab',
                    'settings' => 'pixtheme_tab_margin_bottom',
                    'min' => 0,
                    'max' => 200,
                    'unit' => 'px',
                )
            )
        );

		
	}
		
?>