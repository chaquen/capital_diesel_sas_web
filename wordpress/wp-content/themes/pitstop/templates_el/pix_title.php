<?php

namespace Elementor;

class PixTheme_EL_Pix_Title extends Widget_Base {
	
	public function get_name() {
		return 'pix-title';
	}
	
	public function get_title() {
		return 'Title';
	}
	
	public function get_icon() {
		return 'fa fa-font';
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
			'pre-title',
			[
				'label' => esc_html__( 'Pre-title', 'pitstop' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your pre-title', 'pitstop' ),
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'pitstop' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your title', 'pitstop' ),
			]
		);
		$this->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'pitstop' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Place your text here', 'pitstop' ),
			]
		);
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'options_section',
			[
				'label' => esc_html__( 'Options', 'pitstop' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'tag',
			[
				'label' => esc_html__( 'Title Tag', 'pitstop' ),
				'type' => Controls_Manager::SELECT,
                'default' => 'h2',
				'options' => [
					'h1' => esc_html__( 'H1', 'pitstop' ),
					'h2' => esc_html__( 'H2', 'pitstop' ),
					'h3' => esc_html__( 'H3', 'pitstop' ),
					'h4' => esc_html__( 'H4', 'pitstop' ),
					'h5' => esc_html__( 'H5', 'pitstop' ),
                    'h6' => esc_html__( 'H6', 'pitstop' ),
                    'div'=> esc_html__( 'DIV', 'pitstop' ),
				],
			]
		);
		$this->add_control(
			'size',
			[
				'label' => esc_html__( 'Title Size', 'pitstop' ),
				'type' => Controls_Manager::SELECT,
                'default' => 'h2',
				'options' => [
					'h1' => esc_html__( 'H1', 'pitstop' ),
					'h2' => esc_html__( 'H2', 'pitstop' ),
					'h3' => esc_html__( 'H3', 'pitstop' ),
					'h4' => esc_html__( 'H4', 'pitstop' ),
					'h5' => esc_html__( 'H5', 'pitstop' ),
                    'h6' => esc_html__( 'H6', 'pitstop' ),
				],
			]
		);
		$this->add_control(
            'decor',
            [
                'label' => esc_html__( 'Decor', 'pitstop' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'on',
                'default' => ''
            ]
        );
		$this->add_control(
			'uppercase',
			[
				'label' => esc_html__( 'Uppercase', 'pitstop' ),
				'type' => Controls_Manager::SWITCHER,
                'return_value' => 'on',
                'default' => ''
			]
		);
		
		$this->add_control(
			'padding',
			[
				'label' => esc_html__( 'Bottom Padding', 'pitstop' ),
				'type' => Controls_Manager::SWITCHER,
                'return_value' => 'on',
                'default' => 'on'
			]
		);
		$this->add_control(
			'no-wrap',
			[
				'label' => esc_html__( 'No Wrap', 'pitstop' ),
				'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'The overflowing text won\'t be moved to a new line.', 'pitstop' ),
                'return_value' => 'on',
                'default' => ''
                
			]
		);
		$this->end_controls_section();
	}
	
	protected function render() {

        $pix_el = $this->get_settings_for_display();
        
        $no_wrap = ($pix_el['no-wrap'] != 'on') ? '' : 'pix-no-wrap';
        $padding = $pix_el['padding'] != 'on' ? '' : 'pix-title-no-padding';
        $uppercase = ($pix_el['uppercase'] != 'on') ? '' : 'pix-uppercase';
        $pre_title = ($pix_el['pre-title'] == '') ? '' : '<div class="pix-pre-title"><span>'.($pix_el['pre-title']).'</span></div>';
        $text = ($pix_el['text'] == '') ? '' : '<p>'.$pix_el['text'].'</p>';
        $decor = ($pix_el['decor'] != 'on') ? '' : '<span class="sep-element"></span>';
        $title = ($pix_el['title'] == '') ? '' : '<'.esc_attr($pix_el['tag']).' class="pix-title '.esc_attr($pix_el['size'].'-size').' '.esc_attr($padding).' '.esc_attr($no_wrap).' '.esc_attr($uppercase).'">'.$pix_el['title'].$decor.'</'.esc_attr($pix_el['tag']).'>';
        
        $out = '
        <div class="pix-section-title">
            '.($pre_title).'
            '.($title).'
            '.($text).'
        </div>';
		pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}