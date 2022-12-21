<?php

namespace Elementor;

class PixTheme_EL_Pix_Button extends Widget_Base {
	
	public function get_name() {
		return 'pix-button';
	}
	
	public function get_title() {
		return 'Button';
	}
	
	public function get_icon() {
		return 'fas fa-mouse';
	}
	
	public function get_categories() {
		return [ 'pixtheme' ];
	}
	
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'pitstop' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Button text', 'pitstop' ),
				'default' => esc_html__( 'Go', 'pitstop' ),
			]
		);
		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'pitstop' ),
				'type' => Controls_Manager::URL,
				'description' => esc_html__( 'Button link', 'pitstop' ),
				'placeholder' => 'https://your-link.com',
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);
		$this->add_control(
			'button_type',
			[
				'label' => esc_html__( 'As Link', 'pitstop' ),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'Use as simple link with hover underline', 'pitstop' ),
                'return_value' => 'off',
                'default' => 'off',
			]
		);
		$this->add_control(
			'radius',
			[
                'label' => esc_html__( 'Box Shape', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-global',
                'options' => [
                    'pix-global'    =>  esc_html__( 'Global', 'pitstop' ),
					'pix-square'    =>  esc_html__( 'Square', 'pitstop' ),
	                'pix-rounded'   =>  esc_html__( 'Rounded', 'pitstop' ),
					'pix-round'     =>  esc_html__( 'Round', 'pitstop' ),
                ],
                'condition' => [
                    'button_type' => 'off',
                ]
            ]
		);
		$this->add_control(
			'transparent',
			[
				'label' => esc_html__( 'Transparent', 'pitstop' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'off',
                'default' => 'off',
                'condition' => [
                    'button_type' => 'off',
                ]
			]
		);
		$this->add_control(
			'size_v',
			[
                'label' => esc_html__( 'Top/Bottom Paddings', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-v-s',
                'options' => [
                    'pix-v-s'    =>  esc_html__( 'S', 'pitstop' ),
					'pix-v-m'    =>  esc_html__( 'M', 'pitstop' ),
	                'pix-v-l'   =>  esc_html__( 'L', 'pitstop' ),
					'pix-v-xl'     =>  esc_html__( 'XL', 'pitstop' ),
                ],
                'condition' => [
                    'button_type' => 'off',
                ]
            ]
		);
		$this->add_control(
			'size_h',
			[
                'label' => esc_html__( 'Left/Right Paddings', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-h-l',
                'options' => [
                    'pix-h-s'    =>  esc_html__( 'S', 'pitstop' ),
					'pix-h-m'    =>  esc_html__( 'M', 'pitstop' ),
	                'pix-h-l'   =>  esc_html__( 'L', 'pitstop' ),
					'pix-h-xl'     =>  esc_html__( 'XL', 'pitstop' ),
                ],
                'condition' => [
                    'button_type' => 'off',
                ]
            ]
		);
		$this->add_control(
			'font_size',
			[
                'label' => esc_html__( 'Font Size', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-font-m',
                'options' => [
                    'pix-font-s'    =>  esc_html__( 'S', 'pitstop' ),
					'pix-font-m'    =>  esc_html__( 'M', 'pitstop' ),
	                'pix-font-l'   =>  esc_html__( 'L', 'pitstop' ),
					'pix-font-xl'     =>  esc_html__( 'XL', 'pitstop' ),
                ],
            ]
		);
		$this->add_control(
			'color',
			[
                'label' => esc_html__( 'Color', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-colored',
                'options' => [
                    'pix-colored'    =>  esc_html__( 'Colored', 'pitstop' ),
					'pix-dark'    =>  esc_html__( 'Dark', 'pitstop' ),
	                'pix-light'   =>  esc_html__( 'Light', 'pitstop' ),
                ],
            ]
		);
		$this->add_control(
			'position',
			[
                'label' => esc_html__( 'Alignment', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-text-left',
                'options' => [
                    'pix-text-left'    =>  esc_html__( 'Left', 'pitstop' ),
					'pix-text-center'    =>  esc_html__( 'Center', 'pitstop' ),
	                'pix-text-right'   =>  esc_html__( 'Right', 'pitstop' ),
                ],
            ]
		);
		$this->end_controls_section();
		
	}
	
	protected function render() {

        $pix_el = $this->get_settings_for_display();
		
		$text = $pix_el['text'];
		$size_h = $pix_el['size_h'];
		$size_v = $pix_el['size_v'];
		$radius = ($pix_el['radius'] != '') ? $pix_el['radius'] : 'pix-global';
		$position = $pix_el['position'];
		$font_size = $pix_el['font_size'];
		
		$href = $pix_el['link']['url'] ? '#' : $pix_el['link']['url'];
		$target = $pix_el['link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $pix_el['link']['nofollow'] ? ' rel="nofollow"' : '';
		
		$color = $pix_el['color'];
		$transparent = ($pix_el['transparent'] == 'off') ? '' : 'pix-transparent';
		$button_class = ($pix_el['button_type'] == 'on') ? 'pix-link' : 'pix-button';
		
		$out = '
			<div class="pix-button-container ' . esc_attr($position) . '">
				<a href="'.esc_url($href).'" '.wp_kses($target.$nofollow, 'post').' class="'.esc_attr($button_class).' '.esc_attr($font_size).' '.esc_attr($size_h).' '.esc_attr($size_v).' '.esc_attr($transparent).' '.esc_attr($color).' '.esc_attr($radius).'">'.wp_kses($text, 'post').'</a>
			</div>';
		
		pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}