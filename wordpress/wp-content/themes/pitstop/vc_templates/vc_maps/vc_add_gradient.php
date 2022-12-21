<?php

    $padding_attr = array(
        array(
            'type' => 'segmented_button',
            'holder' => 'div',
            'class' => 'pix-padding-vc-row pix-top',
            'heading' => esc_html__( 'Padding Top', 'pitstop' ),
            'param_name' => 'pix_padding_top',
            'value' => array(
                'default' => 'padding L',
                esc_html__( 'No Padding', 'pitstop' ) => 'padding No',
                esc_html__( 'S', 'pitstop' ) => 'padding S',
                esc_html__( 'M', 'pitstop' ) => 'padding M',
                esc_html__( 'L', 'pitstop' ) => 'padding L',
                esc_html__( 'XL', 'pitstop' ) => 'padding XL',
            ),
            'group' => esc_html__( 'PixSettings', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
        array(
            'type' => 'segmented_button',
            'holder' => 'div',
            'class' => 'pix-padding-vc-row pix-bottom',
            'heading' => esc_html__( 'Padding Bottom', 'pitstop' ),
            'param_name' => 'pix_padding_bottom',
            'value' => array(
                'default' => 'padding L',
                esc_html__( 'No Padding', 'pitstop' ) => 'padding No',
                esc_html__( 'S', 'pitstop' ) => 'padding S',
                esc_html__( 'M', 'pitstop' ) => 'padding M',
                esc_html__( 'L', 'pitstop' ) => 'padding L',
                esc_html__( 'XL', 'pitstop' ) => 'padding XL',
            ),
            'group' => esc_html__( 'PixSettings', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
    );

    $padding_no_attr = array(
        array(
            'type' => 'segmented_button',
            'class' => 'pix-padding-vc-row pix-top',
            'heading' => esc_html__( 'Padding Top', 'pitstop' ),
            'param_name' => 'pix_padding_top',
            'value' => array(
                'default' => 'padding No',
                esc_html__( 'No Padding', 'pitstop' ) => 'padding No',
                esc_html__( 'S', 'pitstop' ) => 'padding S',
                esc_html__( 'M', 'pitstop' ) => 'padding M',
                esc_html__( 'L', 'pitstop' ) => 'padding L',
                esc_html__( 'XL', 'pitstop' ) => 'padding XL',
            ),
            'group' => esc_html__( 'PixSettings', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
        array(
            'type' => 'segmented_button',
            'class' => 'pix-padding-vc-row pix-bottom',
            'heading' => esc_html__( 'Padding Bottom', 'pitstop' ),
            'param_name' => 'pix_padding_bottom',
            'value' => array(
                'default' => 'padding No',
                esc_html__( 'No Padding', 'pitstop' ) => 'padding No',
                esc_html__( 'S', 'pitstop' ) => 'padding S',
                esc_html__( 'M', 'pitstop' ) => 'padding M',
                esc_html__( 'L', 'pitstop' ) => 'padding L',
                esc_html__( 'XL', 'pitstop' ) => 'padding XL',
            ),
            'group' => esc_html__( 'PixSettings', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
    );

    $column_gap_attr = array(
        array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Column Gap', 'pitstop' ),
            'param_name' => 'pix_column_gap',
            'value' => array(
                'default' => 'default-gap',
                esc_html__( 'Default', 'pitstop' ) => 'default-gap',
                esc_html__( '40px', 'pitstop' ) => 'pix-column-gap-40',
            ),
            'group' => esc_html__( 'PixSettings', 'pitstop' ),
        ),
    );

	$row_attr = array(
        array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Container Shape', 'pitstop' ),
            'param_name' => 'radius',
            'value' => array(
                'default' => 'default',
                esc_html__( 'Square', 'pitstop' ) => 'default',
                esc_html__( 'Rounded', 'pitstop' ) => 'pix-rounded',
                esc_html__( 'Round', 'pitstop' ) => 'pix-round',
            ),
            'group' => esc_html__( 'PixSettings', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
        array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Text Color', 'pitstop' ),
            'param_name' => 'ptextcolor',
            'value' => array(
                'default' => 'Default',
                esc_html__( 'Default', 'pitstop' ) => 'Default',
                esc_html__( 'Light', 'pitstop' ) => 'White',
                esc_html__( 'on Colored', 'pitstop' ) => 'Color',
                esc_html__( 'Dark', 'pitstop' ) => 'Black',
            ),
            'group' => esc_html__( 'PixSettings', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
		array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Overflow Visible', 'pitstop' ),
            'param_name' => 'overflow',
            'value' => 'off',
            'group' => esc_html__( 'PixSettings', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
        array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Top offset', 'pitstop' ),
			'param_name' => 'top_offset',
			'value' => '',
			'description' => esc_html__( 'The value can be negative (example: -50px)', 'pitstop' ),
			'dependency' => array(
				'element' => 'overflow',
				'value' => 'on',
			),
			'group' => esc_html__( 'PixSettings', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-6',
		),

    );

	$stretch_attr = array(
	    array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Not Stretch Content Alignment', 'pitstop' ),
            'param_name' => 'pix_not_stretch_content',
            'value' => array(
                'default' => 'off',
                esc_html__( 'Off', 'pitstop' ) => 'off',
                esc_html__( 'Left', 'pitstop' ) => 'pix-col-content-left',
                esc_html__( 'Center', 'pitstop' ) => 'pix-col-content-center',
                esc_html__( 'Right', 'pitstop' ) => 'pix-col-content-right',
            ),
            'description' => esc_html__( 'If you don\'t want to stretch content in column with row setting \'Stretch row and content\'.', 'pitstop' ),
            'group' => esc_html__( 'PixSettings', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
	    array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Left/Right Padding', 'pitstop' ),
            'param_name' => 'pix_main_boxed_column',
            'value' => 'off',
            'description' => esc_html__( 'For Boxed Container on Home Template', 'pitstop' ),
            'group' => esc_html__( 'PixSettings', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
    );
    $column_attr = array(
        array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Text Color', 'pitstop' ),
            'param_name' => 'ptextcolor',
            'value' => array(
                'default' => 'Default',
                esc_html__( 'Default', 'pitstop' ) => 'Default',
                esc_html__( 'Light', 'pitstop' ) => 'White',
                esc_html__( 'on Colored', 'pitstop' ) => 'Color',
                esc_html__( 'Dark', 'pitstop' ) => 'Black',
            ),
            'group' => esc_html__( 'PixSettings', 'pitstop' ),
        ),
    );


    $gradient_attr = array(
		// Gradient
        array(
            'type' => 'param_group',
            'value' => '',
            'heading' => esc_html__( 'Gradient', 'pitstop' ),
            'param_name' => 'gradient_colors',
            // Note params is mapped inside param-group:
            'params' => array(
                array(
                    'type' => 'colorpicker',
                    'value' => '',
                    'heading' => esc_html__( 'Color For Gradient', 'pitstop' ),
                    'param_name' => 'gradient_color',
                )
            ),
		    'group' => esc_html__( 'Gradient', 'pitstop' ),
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Direction', 'pitstop' ),
			'param_name' => 'gradient_direction',
			'value' => array(
				esc_html__( 'To Right ', 'pitstop' ).html_entity_decode('&rarr;') => 'to right',
				esc_html__( 'To Left ', 'pitstop' ).html_entity_decode('&larr;') => 'to left',
				esc_html__( 'To Bottom ', 'pitstop' ).html_entity_decode('&darr;') => 'to bottom',
				esc_html__( 'To Top ', 'pitstop' ).html_entity_decode('&uarr;') => 'to top',
				esc_html__( 'To Bottom Right ', 'pitstop' ).html_entity_decode('&#8600;') => 'to bottom right',
				esc_html__( 'To Bottom Left ', 'pitstop' ).html_entity_decode('&#8601;') => 'to bottom left',
				esc_html__( 'To Top Right ', 'pitstop' ).html_entity_decode('&#8599;') => 'to top right',
				esc_html__( 'To Top Left ', 'pitstop' ).html_entity_decode('&#8598;') => 'to top left',
				esc_html__( 'Angle ', 'pitstop' ).html_entity_decode('&#10227;') => 'angle',
			),
			'description' => '',
			'group' => esc_html__( 'Gradient', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-4',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Angle Direction', 'pitstop' ),
			'param_name' => 'gradient_angle',
			'value' => '90',
			'description' => esc_html__( 'Values -360 - 360', 'pitstop' ),
			'dependency' => array(
				'element' => 'gradient_direction',
				'value' => 'angle',
			),
			'group' => esc_html__( 'Gradient', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-4',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Opacity', 'pitstop' ),
			'param_name' => 'gradient_opacity',
			'value' => '1',
			'description' => esc_html__( 'Values 0.01 - 0.99', 'pitstop' ),
			'group' => esc_html__( 'Gradient', 'pitstop' ),
            'edit_field_class' => 'vc_col-sm-4',
		),
        
	);


	$decor_attr = array(
        
        // Decors
        // Top Decor
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Show Top Decor', 'pitstop' ),
            'param_name' => 'pdecor',
            'value' => 'off',
            'description' => esc_html__( 'Show decor at the top of the section.', 'pitstop' ),
            'group' => esc_html__( 'Decor', 'pitstop' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Height', 'pitstop' ),
            'param_name' => 'decor_height',
            'value' => '150',
            'description' => esc_html__( 'Values 0 - 300', 'pitstop' ),
            'dependency' => array(
                'element' => 'pdecor',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'pitstop' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Top Decor Opacity', 'pitstop' ),
            'param_name' => 'decor_opacity',
            'value' => '',
            'description' => esc_html__( 'Values 0.01 - 0.99', 'pitstop' ),
            'dependency' => array(
                'element' => 'pdecor',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'pitstop' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Top Decor Points', 'pitstop' ),
            'param_name' => 'decor_points_top',
            'value' => '',
            'description' => esc_html__( 'Example: 0,100 50,50 100,100', 'pitstop' ),
            'dependency' => array(
                'element' => 'pdecor',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'pitstop' ),
        ),

        // Bottom Decor
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Show Bottom Decor', 'pitstop' ),
            'param_name' => 'pdecor_bottom',
            'value' => 'off',
            'description' => esc_html__( "Show decor at the bottom of the section.", 'pitstop' ),
            'group' => esc_html__( 'Decor', 'pitstop' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Height', 'pitstop' ),
            'param_name' => 'decor_bottom_height',
            'value' => '150',
            'description' => esc_html__( 'Values 0 - 300', 'pitstop' ),
            'dependency' => array(
                'element' => 'pdecor_bottom',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'pitstop' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Bottom Decor Opacity', 'pitstop' ),
            'param_name' => 'decor_bottom_opacity',
            'value' => '',
            'description' => esc_html__( 'Values 0.01 - 0.99', 'pitstop' ),
            'dependency' => array(
                'element' => 'pdecor_bottom',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'pitstop' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Bottom Decor Points', 'pitstop' ),
            'param_name' => 'decor_points_bottom',
            'value' => '',
            'description' => esc_html__( 'Example: 0,100 50,50 100,100', 'pitstop' ),
            'dependency' => array(
                'element' => 'pdecor_bottom',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'pitstop' ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Overlay', 'pitstop' ),
            'param_name' => 'poverlay',
            'value' => array(
                esc_html__( "Use", 'pitstop' ) => 'pix-row-overlay',
                esc_html__( "None", 'pitstop' ) => 'no-overlay',
            ),
            'description' => '',
            'group' => esc_html__( 'Decor', 'pitstop' ),
        ),
	);

	vc_add_params( 'vc_row', array_merge($padding_attr, $column_gap_attr, $row_attr, $gradient_attr) );
	vc_add_params( 'vc_row_inner', array_merge($padding_no_attr, $column_gap_attr, $row_attr, $gradient_attr) );
	vc_add_params( 'vc_column', array_merge($padding_no_attr, $stretch_attr, $column_attr, $gradient_attr) );

	vc_add_params( 'common_title', $stretch_attr );

?>