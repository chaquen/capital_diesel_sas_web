<?php

namespace Elementor;

class PixTheme_EL_Pix_Cform7 extends Widget_Base {
	
	public function get_name() {
		return 'pix-cform7';
	}
	
	public function get_title() {
		return 'Contact Form 7';
	}
	
	public function get_icon() {
		return 'fab fa-wpforms';
	}
	
	public function get_categories() {
		return [ 'pixtheme' ];
	}
	
	protected function _register_controls() {
	    
	    $args = [ 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1 ];
        $forms = get_posts($args);
        $cform7 = [];
        if(empty($forms['errors'])){
            foreach($forms as $form){
                $cform7[$form->ID] = $form->post_title;
            }
        }

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'pitstop' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'form_id',
			[
                'label' => esc_html__( 'Contact Form', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__( 'Select contact form to show', 'pitstop' ),
                'options' => $cform7,
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
			'box_gap',
			[
                'label' => esc_html__( 'Boxes Gap', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [
                    0 => '0',
                    1 => '1',
					2 => '2',
					5 => '5',
                    10 => '10',
					15 => '15',
					20 => '20',
					30 => '30',
					50 => '50',
                ],
            ]
		);
        $this->add_control(
            'btn_position',
            [
                'label' => esc_html__( 'Send Button Position', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-text-left',
                'options' => [
                    'pix-text-left'         =>  esc_html__( 'Left', 'pitstop' ),
					'pix-text-center'       =>  esc_html__( 'Center', 'pitstop' ),
	                'pix-text-right'        =>  esc_html__( 'Right', 'pitstop' ),
                    'pix-text-full-width'   =>  esc_html__( 'Full Width', 'pitstop' ),
                ],
            ]
        );
		$this->end_controls_section();
		
	}
	
	protected function render() {

        $pix_el = $this->get_settings_for_display();
        
		$form_id = $pix_el['form_id'];
		$box_gap = $pix_el['box_gap'];
		$radius = ($pix_el['radius'] != '') ? $pix_el['radius'] : 'pix-global';
		$btn_position = $pix_el['btn_position'];
		
        $out = '
        <div class="pix-gap-'.esc_attr($box_gap).' '.esc_attr($radius).' '.esc_attr($btn_position).'">
            '.do_shortcode('[contact-form-7 id="'.esc_attr($form_id).'"]').'
        </div>';
        
        pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}