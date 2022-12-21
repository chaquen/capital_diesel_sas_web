<?php

namespace Elementor;

class PixTheme_EL_Pix_Points extends Widget_Base {
	
	public function get_name() {
		return 'pix-points';
	}
	
	public function get_title() {
		return esc_html__( 'Image Points', 'pitstop' );
	}
	
	public function get_icon() {
		return 'fas fa-hand-point-down';
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
			'image',
			[
                'label' => esc_html__( 'Image', 'pitstop' ),
                'type' => Controls_Manager::MEDIA,
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
            ]
		);
		$this->add_control(
			'unit',
			[
                'label' => esc_html__( 'Point Units', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-text-review-left',
                'options' => [
                    '%'    =>  esc_html__( 'Percent', 'pitstop' ),
	                'px'   =>  esc_html__( 'Pixels', 'pitstop' ),
                ],
            ]
		);
		
		$repeater = new Repeater();
		$repeater->add_control(
			'top_pos',
			[
				'label' => esc_html__( 'Top Position', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'left_pos',
			[
				'label' => esc_html__( 'Left Position', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'content', [
				'label' => esc_html__( 'Popup Text', 'pitstop' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Click to enter text' , 'pitstop' ),
			]
		);
		$this->add_control(
			'points',
			[
				'label' => esc_html__( 'Points', 'pitstop' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ top_pos }}}',
			]
		);
		
		$this->end_controls_section();
		
	}
	
	protected function render() {

        $pix_el = $this->get_settings_for_display();
        
        $icon_shape = $href_container_before = $href_container_after = $href_before = $href_after = $fill_color = $hover_class = $content_position = '';
		$border = $filled = $no_padding = 'off';
		$link_type = $pix_el['link_type'] == '' ? 'overlay' : $pix_el['link_type'];
		$icon_size = $pix_el['icon_size'] == '' ? 'pix-icon-l' : $pix_el['icon_size'];
		$icon_color = $pix_el['icon_color'] == '' ? 'pix-icon-color' : $pix_el['icon_color'];
		$icon_bg_color = $pix_el['icon_bg_color'] == '' ? 'pix-icon-bg-main-color' : $pix_el['icon_bg_color'];
		$title = $pix_el['title'];
		$title_size = $pix_el['title_size'] == '' ? 'pix-title-l' : $pix_el['title_size'];
		$icon_type = $pix_el['icon_type'];
		$position = $position_with_center = $position_no_center = 'pix-text-left';
		
		$out = $unit = $radius = '';
		
		$unit = $unit == '' ? 'px' : $unit;
		$img_id = preg_replace( '/[^\d]/', '', $image );
		$img_path = wp_get_attachment_image_src( $img_id, 'large' );
		$image = '<img src="'.esc_url($img_path[0]).'" alt="'.esc_attr__('Points', 'pitstop').'">';
		
		$points = $pix_el['points'];
		$points_out = array();
		foreach($points as $key => $item){
		
		    $points_out[] = '
		        <div class="pix-car-repair-point" style="top: '.esc_attr($item['top_pos'].$unit).'; left: '.esc_attr($item['left_pos'].$unit).';">
		            <div class="pix-car-repair-point-text">
		                <p>'.($item['content_d']).'</p>
		            </div>
		        </div>
		    ';
		
		}
		
		
		$out = '
		<div class="pix-car-repair-box '.esc_attr($radius).'">
		    <div class="pix-car-repair-img">
		        '.($image).'
		    </div>
		    <div class="pix-car-repair-points">
		        '.implode( "\n", $points_out ).'
		    </div>
		</div>';
		
		
		pixtheme_out($out);

		
	}
	
	protected function _content_template() {

    }
	
	
}