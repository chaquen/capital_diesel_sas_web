<?php

add_action( 'elementor/element/section/section_layout/before_section_end', function( $element, $args ) {
	
	$element->add_control(
		'custom_control',
		[
			'type' => \Elementor\Controls_Manager::NUMBER,
			'label' => __( 'Custom Control', 'plugin-name' ),
		]
	);
}, 10, 2 );

