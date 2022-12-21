<?php 
	
	function pixtheme_customize_general_tab($wp_customize, $theme_name){

        $wp_customize->add_panel('pixtheme_general_panel',  array(
                'title' => esc_html__( 'General Settings', 'pitstop' ),
                'priority' => 25,
            )
        );


        $wp_customize->add_section( 'pixtheme_general_settings' , array(
            'title'      => esc_html__( 'Logo', 'pitstop' ),
            'priority'   => 15,
            'panel' => 'pixtheme_general_panel'
        ) );
		
		
		/* logo image */
		
		$wp_customize->add_setting( 'pixtheme_general_settings_logo' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'pixtheme_general_settings_logo',
				array(
				   'label'      => esc_html__( 'Image', 'pitstop' ),
				   'section'    => 'pixtheme_general_settings',
				   'settings'   => 'pixtheme_general_settings_logo',
				)
	       )
	    );

		$wp_customize->add_setting(	'pixtheme_general_settings_logo_width', array(
            'default' => get_option('pixtheme_default_logo_width'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_general_settings_logo_width',
                array(
                    'label' => esc_html__( 'Max Width', 'pitstop' ),
                    'description'=> esc_html__( 'Retina Logo should be 2x large than max width', 'pitstop' ),
                    'section' => 'pixtheme_general_settings',
                    'settings' => 'pixtheme_general_settings_logo_width',
                    'min' => 0,
                    'max' => 300,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_general_settings_logo_height', array(
            'default' => get_option('pixtheme_default_logo_height'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_general_settings_logo_height',
                array(
                    'label' => esc_html__( 'Min Height', 'pitstop' ),
                    'description'=> esc_html__( 'Header Menu height', 'pitstop' ),
                    'section' => 'pixtheme_general_settings',
                    'settings' => 'pixtheme_general_settings_logo_height',
                    'min' => 75,
                    'max' => 200,
                    'unit'=> 'px',
                )
            )
        );

		$wp_customize->add_setting( 'pixtheme_general_settings_logo_text' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'pixtheme_general_settings_logo_text',
			array(
				'label'    => esc_html__( 'Logo Text', 'pitstop' ),
				'section'  => 'pixtheme_general_settings',
				'settings' => 'pixtheme_general_settings_logo_text',
				'type'     => 'text',
			)
		);

		$wp_customize->add_setting( 'pixtheme_general_settings_logo_mobile' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'pixtheme_general_settings_logo_mobile',
				array(
				   'label'      => esc_html__( 'Mobile Logo', 'pitstop' ),
				   'section'    => 'pixtheme_general_settings',
				   'settings'   => 'pixtheme_general_settings_logo_mobile',
				)
	       )
	    );

		
		
		
        /// COLOR SETTINGS ///

        $wp_customize->add_section( 'pixtheme_style_settings' , array(
            'title'      => esc_html__( 'Colors', 'pitstop' ),
            'priority'   => 20,
            'panel' => 'pixtheme_general_panel'
        ) );


        $wp_customize->add_setting( 'pixtheme_style_settings_main_color', array(
            'default' => get_option('pixtheme_default_main_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_style_settings_main_color',
                array(
                    'label' => esc_html__( 'Main', 'pitstop' ),
                    'section' => 'pixtheme_style_settings',
                    'settings' => 'pixtheme_style_settings_main_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_style_settings_additional_color', array(
            'default' => get_option('pixtheme_default_additional_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_style_settings_additional_color',
                array(
                    'label' => esc_html__( 'Additional', 'pitstop' ),
                    'section' => 'pixtheme_style_settings',
                    'settings' => 'pixtheme_style_settings_additional_color',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_style_settings_gradient_color', array(
            'default' => get_option('pixtheme_default_gradient_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_style_settings_gradient_color',
                array(
                    'label' => esc_html__( 'Gradient', 'pitstop' ),
                    'section' => 'pixtheme_style_settings',
                    'settings' => 'pixtheme_style_settings_gradient_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_gradient_direction' , array(
            'default'     => get_option('pixtheme_default_gradient_direction'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_gradient_direction',
            array(
                'label'    => esc_html__( 'Gradient Direction', 'pitstop' ),
                'section'  => 'pixtheme_style_settings',
                'settings' => 'pixtheme_gradient_direction',
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
        
        $wp_customize->add_setting( 'pixtheme_style_settings_bg_color', array(
            'default' => get_option('pixtheme_default_bg_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_style_settings_bg_color',
                array(
                    'label' => esc_html__( 'Background', 'pitstop' ),
                    'section' => 'pixtheme_style_settings',
                    'settings' => 'pixtheme_style_settings_bg_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_style_settings_black_color', array(
            'default' => get_option('pixtheme_default_black_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_style_settings_black_color',
                array(
                    'label' => esc_html__( 'Black Tone', 'pitstop' ),
                    'section' => 'pixtheme_style_settings',
                    'settings' => 'pixtheme_style_settings_black_color',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_style_theme_tone' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_style_theme_tone',
            array(
                'label'    => esc_html__( 'Theme Tone', 'pitstop' ),
                'section'  => 'pixtheme_style_settings',
                'settings' => 'pixtheme_style_theme_tone',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'Light', 'pitstop' ),
                    'pix-theme-tone-dark' => esc_html__( 'Dark', 'pitstop' ),
                ),
            )
        );








        /// FONT SETTINGS ///

        $wp_customize->add_section( 'pixtheme_style_font_settings' , array(
            'title'      => esc_html__( 'Fonts', 'pitstop' ),
            'priority'   => 30,
            'panel' => 'pixtheme_general_panel',
        ) );


        $wp_customize->add_setting( 'pixtheme_fonts_embed' , array(
            'default'     => get_option('pixtheme_default_fonts_embed'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'wp_kses'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Fonts_Loader_Control(
                $wp_customize,
                'pixtheme_fonts_embed',
                array(
                    'label' => esc_html__( 'Google Fonts Embed', 'pitstop' ),
                    'description' => wp_kses(__('<a href="https://data.true-emotions.studio/images/google_fonts_embed.png" target="_blank" data-lightbox="embed">Get Fonts Embed String</a>', 'pitstop'), 'post'),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_fonts_embed',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_fonts_tags' , array(
            'default'     => 'pixtheme_font_p',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_fonts_tags',
            array(
                'section'  => 'pixtheme_style_font_settings',
                'settings' => 'pixtheme_fonts_tags',
                'type'     => 'select',
                'choices'  => array(
                    'pixtheme_font_p' => esc_html__( 'Text', 'pitstop' ),
                    'pixtheme_font_h1' => esc_html__( 'H1', 'pitstop' ),
                    'pixtheme_font_h2' => esc_html__( 'H2', 'pitstop' ),
                    'pixtheme_font_h3' => esc_html__( 'H3', 'pitstop' ),
                    'pixtheme_font_h4' => esc_html__( 'H4', 'pitstop' ),
                    'pixtheme_font_h5' => esc_html__( 'H5', 'pitstop' ),
                    'pixtheme_font_h6' => esc_html__( 'H6', 'pitstop' ),
                    'pixtheme_font_pre_title' => esc_html__( 'Pre title', 'pitstop' ),
                    'pixtheme_font_title_s' => esc_html__( 'Title S', 'pitstop' ),
                    'pixtheme_font_title_m' => esc_html__( 'Title M', 'pitstop' ),
                    'pixtheme_font_title_l' => esc_html__( 'Title L', 'pitstop' ),
                    'pixtheme_font_title_xl' => esc_html__( 'Title XL', 'pitstop' ),
                    'pixtheme_font_link' => esc_html__( 'Link', 'pitstop' ),
                    'pixtheme_font_button' => esc_html__( 'Button', 'pitstop' ),
                ),
            )
        );


        // Text
        $wp_customize->add_setting( 'pixtheme_font_family' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Control(
                $wp_customize,
                'pixtheme_font_family',
                array(
                    'label' => esc_html__( 'Font', 'pitstop' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_family',
                    'weight_id' => 'pixtheme_font_weight',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_font_weight' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'pixtheme_sanitize_text'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Weight_Control(
                $wp_customize,
                'pixtheme_font_weight',
                array(
                    'label' => esc_html__( 'Weight', 'pitstop' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_weight',
                    'weight_id' => 'pixtheme_font_weight',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_font_size', array(
            'default' => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_font_size',
                array(
                    'label' => esc_html__( 'Size', 'pitstop' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_size',
                    'min' => 10,
                    'max' => 100,
                    'unit'=> 'px',
                )
            )
        );
        
        $wp_customize->add_setting(	'pixtheme_font_line_height', array(
            'default' => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_font_line_height',
                array(
                    'label' => esc_html__( 'Line height', 'pitstop' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_line_height',
                    'min' => 0,
                    'max' => 3,
                    'step' => 0.01,
                    'unit'=> '',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_style' , array(
            'default'     => 'normal',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_font_style',
            array(
                'label'    => esc_html__( 'Style', 'pitstop' ),
                'section'  => 'pixtheme_style_font_settings',
                'settings' => 'pixtheme_font_style',
                'type'     => 'select',
                'choices'  => array(
                    'normal' => esc_html__( 'Normal', 'pitstop' ),
                    'italic' => esc_html__( 'Italic', 'pitstop' ),
                    'oblique' => esc_html__( 'Oblique', 'pitstop' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_font_color', array(
            'default' => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_font_color',
                array(
                    'label' => esc_html__( 'Color', 'pitstop' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_color',
                )
            )
        );
        
        
        $wp_customize->add_setting( 'pixtheme_font_p' , array(
            'default'     => get_option('pixtheme_default_font_p'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_p',
                array(
                    'label' => esc_html__( 'Text', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_p',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_h1' , array(
            'default'     => get_option('pixtheme_default_font_h1'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_h1',
                array(
                    'label' => esc_html__( 'H1', 'pitstop' ),
                    'type' => '',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_h1',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_h2' , array(
            'default'     => get_option('pixtheme_default_font_h2'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_h2',
                array(
                    'label' => esc_html__( 'H2', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_h2',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_h3' , array(
            'default'     => get_option('pixtheme_default_font_h3'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_h3',
                array(
                    'label' => esc_html__( 'H3', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_h3',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_h4' , array(
            'default'     => get_option('pixtheme_default_font_h4'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_h4',
                array(
                    'label' => esc_html__( 'H4', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_h4',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_h5' , array(
            'default'     => get_option('pixtheme_default_font_h5'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_h5',
                array(
                    'label' => esc_html__( 'H5', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_h5',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_h6' , array(
            'default'     => get_option('pixtheme_default_font_h6'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_h6',
                array(
                    'label' => esc_html__( 'H6', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_h6',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_pre_title' , array(
            'default'     => get_option('pixtheme_default_font_pre_title'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_pre_title',
                array(
                    'label' => esc_html__( 'Pre title', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_pre_title',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_title_s' , array(
            'default'     => get_option('pixtheme_default_font_title_s'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_title_s',
                array(
                    'label' => esc_html__( 'Title S', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_title_s',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_title_m' , array(
            'default'     => get_option('pixtheme_default_font_title_m'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_title_m',
                array(
                    'label' => esc_html__( 'Title M', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_title_m',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_title_l' , array(
            'default'     => get_option('pixtheme_default_font_title_l'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_title_l',
                array(
                    'label' => esc_html__( 'Title L', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_title_l',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_title_xl' , array(
            'default'     => get_option('pixtheme_default_font_title_xl'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_title_xl',
                array(
                    'label' => esc_html__( 'Title XL', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_title_xl',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_link' , array(
            'default'     => get_option('pixtheme_default_font_link'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_link',
                array(
                    'label' => esc_html__( 'Link', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_link',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_font_button' , array(
            'default'     => get_option('pixtheme_default_font_button'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_js'
        ) );
        $wp_customize->add_control(
            new PixTheme_JSON_Control(
                $wp_customize,
                'pixtheme_font_button',
                array(
                    'label' => esc_html__( 'Button', 'pitstop' ),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_button',
                )
            )
        );
      


        

        /// DECOR SETTINGS ///

        $wp_customize->add_section( 'pixtheme_decor_settings' , array(
            'title'      => esc_html__( 'Decor', 'pitstop' ),
            'priority'   => 35,
            'panel' => 'pixtheme_general_panel',
        ) );

        $wp_customize->add_setting( 'pixtheme_decor_show' , array(
            'default'     => get_option('pixtheme_default_decor'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_decor_show',
            array(
                'label'    => esc_html__( 'Show Decor', 'pitstop' ),
                'section'  => 'pixtheme_decor_settings',
                'settings' => 'pixtheme_decor_show',
                'type'     => 'select',
                'choices'  => array(
                    '1' => esc_html__( 'Yes', 'pitstop' ),
                    '0' => esc_html__( 'No', 'pitstop' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_decor_img' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'pixtheme_decor_img',
				array(
				   'label'      => esc_html__( 'Decor', 'pitstop' ),
				   'section'    => 'pixtheme_decor_settings',
				   'settings'   => 'pixtheme_decor_img',
				)
	       )
	    );

        $wp_customize->add_setting(	'pixtheme_decor_width', array(
            'default' => '40',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_decor_width',
                array(
                    'label' => esc_html__( 'Width', 'pitstop' ),
                    'section' => 'pixtheme_decor_settings',
                    'settings' => 'pixtheme_decor_width',
                    'min' => 0,
                    'max' => 100,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_decor_height', array(
            'default' => '10',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_decor_height',
                array(
                    'label' => esc_html__( 'Height', 'pitstop' ),
                    'section' => 'pixtheme_decor_settings',
                    'settings' => 'pixtheme_decor_height',
                    'min' => 0,
                    'max' => 50,
                    'unit'=> 'px',
                )
            )
        );





        /// BUTTONS SETTINGS ///

        $wp_customize->add_section( 'pixtheme_buttons_settings' , array(
            'title'      => esc_html__( 'Buttons', 'pitstop' ),
            'priority'   => 40,
            'panel' => 'pixtheme_general_panel',
        ) );

        $wp_customize->add_setting( 'pixtheme_buttons_shape' , array(
		    'default'     => get_option('pixtheme_default_button_shape'),
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'pixtheme_buttons_shape',
			array(
				'label'    => esc_html__( 'Shape', 'pitstop' ),
				'section'  => 'pixtheme_buttons_settings',
				'settings' => 'pixtheme_buttons_shape',
				'type'     => 'select',
				'choices'  => array(
					'pix-square'  => esc_html__( 'Square', 'pitstop' ),
					'pix-rounded' => esc_html__( 'Rounded', 'pitstop' ),
					'pix-round' => esc_html__( 'Round', 'pitstop' ),
				),
			)
		);
        
        $wp_customize->add_setting( 'pixtheme_buttons_color' , array(
            'default'     => get_option('pixtheme_default_button_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_buttons_color',
            array(
                'label'    => esc_html__( 'Color', 'pitstop' ),
                'section'  => 'pixtheme_buttons_settings',
                'settings' => 'pixtheme_buttons_color',
                'type'     => 'select',
                'choices'  => array(
                    'main' => esc_html__( 'Main Color', 'pitstop' ),
                    'additional' => esc_html__( 'Additional Color', 'pitstop' ),
                    'gradient' => esc_html__( 'Gradient', 'pitstop' ),
                    'white' => esc_html__( 'White', 'pitstop' ),
                    'black' => esc_html__( 'Black', 'pitstop' ),
                ),
            )
        );

		$wp_customize->add_setting(	'pixtheme_buttons_border', array(
            'default' => get_option('pixtheme_default_button_border'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_border',
                array(
                    'label' => esc_html__( 'Border Width', 'pitstop' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_border',
                    'min' => 0,
                    'max' => 5,
                    'unit'=> 'px',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_buttons_shadow' , array(
            'default'     => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_buttons_shadow',
            array(
                'label'    => esc_html__( 'Shadow', 'pitstop' ),
                'section'  => 'pixtheme_buttons_settings',
                'settings' => 'pixtheme_buttons_shadow',
                'type'     => 'select',
                'choices'  => array(
                    '1' => esc_html__( 'Yes', 'pitstop' ),
                    '0' => esc_html__( 'No', 'pitstop' ),
                ),
            )
        );

        $wp_customize->add_setting(	'pixtheme_buttons_shadow_h', array(
            'default' => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_h',
                array(
                    'label' => esc_html__( 'Horizontal Position', 'pitstop' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_h',
                    'min' => -100,
                    'max' => 100,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_buttons_shadow_v', array(
            'default' => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_v',
                array(
                    'label' => esc_html__( 'Vertical Position', 'pitstop' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_v',
                    'min' => -100,
                    'max' => 100,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_buttons_shadow_blur', array(
            'default' => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_blur',
                array(
                    'label' => esc_html__( 'Blur', 'pitstop' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_blur',
                    'min' => 0,
                    'max' => 100,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_buttons_shadow_spread', array(
            'default' => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_spread',
                array(
                    'label' => esc_html__( 'Spread', 'pitstop' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_spread',
                    'min' => -100,
                    'max' => 100,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_buttons_shadow_color', array(
            'default' => '#333',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_color',
                array(
                    'label' => esc_html__( 'Color', 'pitstop' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_buttons_shadow_opacity' , array(
            'default'     => '100',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_opacity',
                array(
                    'label' => esc_html__( 'Opacity', 'pitstop' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_opacity',
                    'min' => 0,
                    'max' => 100,
                    'unit'=> '%',
                )
            )
        );






        /// OTHER SETTINGS ///

        $wp_customize->add_section( 'pixtheme_other_settings' , array(
            'title'      => esc_html__( 'Other', 'pitstop' ),
            'priority'   => 100,
            'panel' => 'pixtheme_general_panel',
        ) );

        $wp_customize->add_setting( 'pixtheme_theme_boxes_shape' , array(
		    'default'     => 'pix-rounded',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'pixtheme_theme_boxes_shape',
			array(
				'label'    => esc_html__( 'Boxes Shape', 'pitstop' ),
				'section'  => 'pixtheme_other_settings',
				'settings' => 'pixtheme_theme_boxes_shape',
				'type'     => 'select',
				'choices'  => array(
					'pix-square'  => esc_html__( 'Square', 'pitstop' ),
					'pix-rounded' => esc_html__( 'Rounded', 'pitstop' ),
					'pix-round' => esc_html__( 'Round', 'pitstop' ),
				),
			)
		);

        $wp_customize->add_setting( 'pixtheme_general_settings_loader' , array(
		    'default'     => 'useall',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'pixtheme_general_settings_loader',
			array(
				'label'    => esc_html__( 'Page Loader', 'pitstop' ),
				'section'  => 'pixtheme_other_settings',
				'settings' => 'pixtheme_general_settings_loader',
				'type'     => 'select',
				'choices'  => array(
					'off'  => esc_html__( 'Off', 'pitstop' ),
					'usemain' => esc_html__( 'Use on main', 'pitstop' ),
					'useall' => esc_html__( 'Use on all pages', 'pitstop' ),
				),
			)
		);

		$wp_customize->add_setting( 'pixtheme_loader_img' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'pixtheme_loader_img',
				array(
				   'label'      => esc_html__( 'Loader Image', 'pitstop' ),
				   'section'    => 'pixtheme_other_settings',
				   'settings'   => 'pixtheme_loader_img',
				)
	       )
	    );

		
		
	}
	
	