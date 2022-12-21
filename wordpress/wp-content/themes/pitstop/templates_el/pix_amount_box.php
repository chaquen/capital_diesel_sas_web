<?php

namespace Elementor;

class PixTheme_EL_Pix_Amount_Box extends Widget_Base {
	
	public function get_name() {
		return 'pix-amount-box';
	}
	
	public function get_title() {
		return 'Amount Box';
	}
	
	public function get_icon() {
		return 'fas fa-stopwatch-20';
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
			'icon_type',
			[
                'label' => esc_html__( 'Icon Type', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'font',
                'options' => [
                    'image' =>  esc_html__( 'Image', 'pitstop' ),
                    'font'  =>  esc_html__( 'Font Icon/SVG', 'pitstop' ),
                ],
            ]
		);
		$this->add_control(
			'image',
			[
                'label' => esc_html__( 'Image', 'pitstop' ),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'icon_type' => 'image'
                ]
            ]
		);
		$this->add_control(
			'font',
			[
                'label' => esc_html__( 'Icon', 'pitstop' ),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'icon_type' => 'font'
                ]
            ]
		);
		$this->add_control(
			'icon_size',
			[
                'label' => esc_html__( 'Icon Size', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-icon-l',
                'options' => [
                    'pix-icon-s'    =>  esc_html__( 'S', 'pitstop' ),
                    'pix-icon-m'    =>  esc_html__( 'M', 'pitstop' ),
                    'pix-icon-l'    =>  esc_html__( 'L', 'pitstop' ),
                    'pix-icon-xl'   =>  esc_html__( 'XL', 'pitstop' ),
                ],
            ]
		);
		$this->add_control(
			'position',
			[
                'label' => esc_html__( 'Icon Position', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-text-center',
                'options' => [
                    'pix-text-left'    =>  esc_html__( 'Left', 'pitstop' ),
					'pix-text-center'  =>  esc_html__( 'Top', 'pitstop' ),
	                'pix-text-right'   =>  esc_html__( 'Right', 'pitstop' ),
                ],
            ]
		);
		$this->add_control(
			'icon_color',
			[
                'label' => esc_html__( 'Icon Color', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-icon-color',
                'options' => [
                    'pix-icon-color'        =>  esc_html__( 'Color', 'pitstop' ),
                    'pix-icon-default'      =>  esc_html__( 'Monochrome', 'pitstop' ),
                ],
                'condition' => [
                    'icon_type' => 'font'
                ]
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
			'title_size',
			[
                'label' => esc_html__( 'Title Style', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-title-l',
                'options' => [
                    'pix-title-s'    =>  esc_html__( 'Title S', 'pitstop' ),
                    'pix-title-m'    =>  esc_html__( 'Title M', 'pitstop' ),
                    'pix-title-l'    =>  esc_html__( 'Title L', 'pitstop' ),
                    'pix-title-xl'   =>  esc_html__( 'Title XL', 'pitstop' ),
                ],
            ]
		);
		$this->add_control(
			'amount',
			[
				'label' => esc_html__( 'Amount', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter amount number', 'pitstop' )
			]
		);
		$this->add_control(
			'content',
			[
				'label' => esc_html__( 'Content', 'pitstop' ),
				'type' => Controls_Manager::WYSIWYG,
                'placeholder' => esc_html__( 'Type your description here', 'pitstop' )
			]
		);
		$this->end_controls_section();
		
	}
	
	protected function render() {

        $pix_el = $this->get_settings_for_display();
        
        $show_icon_right = '';
		$amount = $pix_el['amount'];
		$title = $pix_el['title'];
		$title_size = $pix_el['title_size'] == '' ? 'pix-title-l' : $pix_el['title_size'];
		$icon_type = $pix_el['icon_type'];
		$position = $pix_el['position'];
		$icon_size = $pix_el['icon_size'] == '' ? 'pix-icon-l' : $pix_el['icon_size'];
		$icon_color = $pix_el['icon_color'] == '' ? 'pix-icon-color' : $pix_el['icon_color'];
		
		if($icon_type == 'image' && isset($pix_el['image']) && $pix_el['image']['url'] != ''){
		    $img_path = wp_get_attachment_image_src( $pix_el['image']['id'], 'thumbnail' );
			$show_icon = isset($img_path[0]) ? '<div class="icon"><img src="'.esc_url($img_path[0]).'" alt="'.esc_attr($title).'"></div>' : '';
		} elseif($icon_type == 'font' && $pix_el['font']['library'] == 'svg') {
			$show_icon = '<div class="icon"><img src="'.esc_url($pix_el['font']['value']['url']).'" alt="'.esc_attr($title).'"></div>';
		} else {
			$show_icon = '<div class="icon"><span class="'.esc_attr($pix_el['font']['value']).'" ></span></div>';
		}
		
		if($position == 'pix-text-right'){
		    $show_icon_right = $show_icon;
		    $show_icon = '';
		}
		
		if($show_icon_right == $show_icon){
		    $icon_size = 'pix-no-icon';
		}
		
		$final_content = ($pix_el['content'] == '') ? '' : '<p>'.$pix_el['content'].'</p>';
		
		$out = '
		<div class="stats pix-easy-chart">
			<div class="counter-item '.esc_attr($position).' '.esc_attr($icon_size).' '.esc_attr($icon_color).'">
			    '.($show_icon).'
				<div class="chart " data-percent="'.esc_attr($amount).'">
		            <span class="percent">'.($amount).'</span>
		            <span class="percent-plus">+</span>
		            <div class="percent-text '.esc_attr($title_size).'">'.($title).'</div>
		            <canvas height="0" width="0"></canvas>
			    </div>
			    '.($show_icon_right).'
		    </div>
		    '.($final_content).'
		</div>';
		
		pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}