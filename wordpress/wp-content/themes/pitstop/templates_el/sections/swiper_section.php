<?php

add_action( 'elementor/element/after_section_start', function( $element, $section_id, $args ) {
    
    $elements = ['pix-woo-cats', 'pix-woo', 'pix-special-offers', 'pix-team', 'pix-brands', 'pix-reviews'];
    
	if ( in_array($element->get_name(), $elements) && 'carousel_section' === $section_id ) {
		$element->add_control(
			'swiper',
			[
				'label' => esc_html__( 'Carousel', 'pitstop' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'on',
                'default' => 'on'
			]
		);
		$element->add_control(
			'swiper_slides_per_view',
			[
                'label' => '<i class="fas fa-desktop ultra"></i>',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '6',
                'options' => [
                    1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
                    6 => '6',
					7 => '7',
					8 => '8',
					9 => '9',
					10 => '10',
                ],
            ]
		);
		$element->add_control(
			'swiper_items_desktop',
			[
                'label' => '<i class="fas fa-desktop"></i>',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
                    6 => '6',
					7 => '7',
					8 => '8',
					9 => '9',
					10 => '10',
                ],
            ]
		);
		$element->add_control(
			'swiper_items_laptop',
			[
                'label' => '<i class="fas fa-laptop"></i>',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
                    6 => '6',
					7 => '7',
					8 => '8',
					9 => '9',
					10 => '10',
                ],
            ]
		);
		$element->add_control(
			'swiper_items_tablet_land',
			[
                'label' => '<i class="fas fa-tablet-alt landscape"></i>',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
                    6 => '6',
					7 => '7',
					8 => '8',
					9 => '9',
					10 => '10',
                ],
            ]
		);
		$element->add_control(
			'swiper_items_tablet',
			[
                'label' => '<i class="fas fa-tablet-alt"></i>',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '2',
                'options' => [
                    1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
                    6 => '6',
					7 => '7',
					8 => '8',
					9 => '9',
					10 => '10',
                ],
            ]
		);
		$element->add_control(
			'swiper_items_mobile',
			[
                'label' => '<i class="fas fa-mobile-alt"></i>',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
                    6 => '6',
					7 => '7',
					8 => '8',
					9 => '9',
					10 => '10',
                ],
            ]
		);
		$element->add_control(
			'swiper_pagination',
			[
				'label' => esc_html__( 'Pagination', 'pitstop' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'on',
                'default' => '',
                'condition' => [
                    'swiper' => 'on',
                ]
			]
		);
		$element->add_control(
			'swiper_navigation',
			[
				'label' => esc_html__( 'Navigation', 'pitstop' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'on',
                'default' => '',
                'condition' => [
                    'swiper' => 'on',
                ]
			]
		);
		$element->add_control(
			'swiper_loop',
			[
				'label' => esc_html__( 'Loop', 'pitstop' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'on',
                'default' => '',
                'condition' => [
                    'swiper' => 'on',
                ]
			]
		);
		$element->add_control(
			'swiper_space_between',
			[
				'label' => esc_html__( 'Space Between', 'pitstop' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
				'max' => 200,
				'step' => 5,
				'default' => 50,
                'condition' => [
                    'swiper' => 'on',
                ]
			]
		);
		$element->add_control(
			'swiper_space_between_tablet',
			[
				'label' => esc_html__( 'Space Between on Tablet', 'pitstop' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
				'max' => 200,
				'step' => 5,
				'default' => 30,
                'condition' => [
                    'swiper' => 'on',
                ]
			]
		);
		$element->add_control(
			'swiper_space_between_mobile',
			[
				'label' => esc_html__( 'Space Between on Mobile', 'pitstop' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
				'max' => 200,
				'step' => 5,
				'default' => 20,
                'condition' => [
                    'swiper' => 'on',
                ]
			]
		);
		$element->add_control(
			'swiper_slides_per_column',
			[
                'label' => esc_html__( 'Rows', 'pitstop' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    1 => '1',
					2 => '2',
                ],
                'condition' => [
                    'swiper' => 'on',
                ]
            ]
		);
		$element->add_control(
			'swiper_slides_to_scroll',
			[
                'label' => esc_html__( 'Scroll by', 'pitstop' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    1 => '1',
					2 => '2',
                ],
                'condition' => [
                    'swiper' => 'on',
                ]
            ]
		);
		$element->add_control(
			'swiper_speed',
			[
				'label' => esc_html__( 'Speed', 'pitstop' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 10000,
						'step' => 100,
					]
				],
				'default' => [
					'unit' => 'ms',
					'size' => 700,
				],
                'condition' => [
                    'swiper' => 'on',
                ]
			]
		);
		$element->add_control(
			'swiper_autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'pitstop' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'off',
                'default' => '',
                'condition' => [
                    'swiper' => 'on',
                ]
			]
		);
		$element->add_control(
			'swiper_autoplay_delay',
			[
				'label' => esc_html__( 'Autoplay Delay', 'pitstop' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 10000,
						'step' => 100,
					]
				],
				'default' => [
					'unit' => 'ms',
					'size' => 700,
				],
                'condition' => [
                    'swiper' => 'on',
                ]
			]
		);
		$element->add_control(
			'swiper_variable_width',
			[
				'label' => esc_html__( 'Variable Width', 'pitstop' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'off',
                'default' => '',
                'condition' => [
                    'swiper' => 'on',
                ]
			]
		);
		
	}
}, 10, 3 );