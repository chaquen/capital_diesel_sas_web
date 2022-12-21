<?php

namespace Elementor;

class PixTheme_EL_Pix_Tab_Acc extends Widget_Base {
	
	public function get_name() {
		return 'pix-tab-acc';
	}
	
	public function get_title() {
		return esc_html__( 'Tabs/Accordion', 'pitstop' );
	}
	
	public function get_icon() {
		return 'fas fa-th-list';
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
			'toggle_type',
			[
                'label' => esc_html__( 'Toggle Type', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'tabs',
                'options' => [
                    'tabs'      =>  esc_html__( 'Tabs', 'pitstop' ),
	                'accordion' =>  esc_html__( 'Accordion', 'pitstop' ),
                ],
            ]
		);
		$this->add_control(
			'collapse',
			[
				'label' => esc_html__( 'Collapse', 'pitstop' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'off',
                'default' => 'off',
                'condition' => [
                    'toggle_type' => 'accordion',
                ]
			]
		);
		
		$repeater = new Repeater();
		$repeater->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter text used as title of bar', 'pitstop' ),
			]
		);
		$repeater->add_control(
			'content', [
				'label' => esc_html__( 'Text', 'pitstop' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Offer Content' , 'pitstop' ),
				'show_label' => false,
			]
		);
		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'pitstop' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Tabs', 'pitstop' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
                'condition' => [
                    'toggle_type' => 'tabs',
                ]
			]
		);
		
		$this->add_control(
			'link_type',
			[
                'label' => esc_html__( 'Link Type', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-global',
                'options' => [
                    'button'  =>  esc_html__( 'Button', 'pitstop' ),
					'href'    =>  esc_html__( 'Text Link', 'pitstop' ),
                ],
				'condition' => [
                    'toggle_type' => 'tabs',
                ]
            ]
		);
		$this->add_control(
			'btn_link_txt',
			[
                'label' => esc_html__( 'Button/Link Text', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
                'condition' => [
                    'toggle_type' => 'tabs',
                ]
            ]
		);
		
		$repeater2 = new Repeater();
		$repeater2->add_control(
			'label_a',
			[
				'label' => esc_html__( 'Label', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter text used as title of bar', 'pitstop' ),
			]
		);
		$repeater2->add_control(
			'content_a', [
				'label' => esc_html__( 'Text', 'pitstop' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Offer Content' , 'pitstop' ),
				'show_label' => false,
			]
		);
		$this->add_control(
			'accordion',
			[
				'label' => esc_html__( 'Accordion', 'pitstop' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater2->get_controls(),
				'title_field' => '{{{ label_a }}}',
                'condition' => [
                    'toggle_type' => 'accordion',
                ]
			]
		);
		
		$this->end_controls_section();
		
	}
	
	protected function render() {

        $pix_el = $this->get_settings_for_display();
        
        $toggle_type = $pix_el['toggle_type'];
        $collapse = $pix_el['collapse'];
        $link_type = $pix_el['link_type'];
        $btn_link_txt = $pix_el['btn_link_txt'];
        $id_prefix = rand();
		
		$out = '<div class="pix-tabs-acc">';
		
		if($toggle_type == 'accordion'){
		
		    $accordion = $pix_el['accordion'];
		    $acc_arr = array();
		    $i = 0;
		    foreach ($accordion as $item) {
		
		        $class_active = 'collapsed';
		        $class_active_cont = '';
		        if($i == 0 && $collapse != 'on'){
		            $class_active = '';
		            $class_active_cont = 'show';
		        }
				
		        $id = $id_prefix.'-'.$i;
		        $acc_arr[$i] = '
		            <div class="pix-accordion-row">
		                <div class="pix-accordion-btn">
		                    <button class="'.esc_attr($class_active).'" type="button" data-toggle="collapse" data-target="#'.esc_attr($id).'">
		                        '.($item['label_a']).'
		                    </button>
		                </div>
		
		                <div id="'.esc_attr($id).'" class="collapse '.esc_attr($class_active_cont).'" data-parent="#pix-question-accordion">
		                    <div class="pix-accordion-body">'.($item['content_a']).'</div>
		                </div>
		            </div>
		        ';
		
		        $i++;
		    }
		
		    $out .= '
		    <div class="" id="pix-question-accordion">
		        '.implode($acc_arr).'
		    </div>';
		
		} else {
		
		    $tabs = $pix_el['tabs'];
		    $tabs_labels = $tabs_contents = array();
		    $btn_link = '';
		    $i = 0;
		    foreach ($tabs as $item) {
		    	$href = $item['link'];
                $target = $item['link']['is_external'] ? ' target="_blank"' : '';
                $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
		        if(!empty( $href['url'] )){
		            $btn_link_class = $link_type == 'button' ? 'pix-button' : 'pix-link';
		            $btn_link = ($btn_link_txt == '') ? '' : '<a href="'.esc_url($href['url']).'" class="'.esc_attr($btn_link_class).'" '.($target.$nofollow).'>'.($btn_link_txt).'</a>';
		        }
		
		        $class_active = $class_active_cont = '';
		        if($i == 0){
		            $class_active = 'active';
		            $class_active_cont = 'show active';
		        }
		        $id = $id_prefix.'-'.$i;
		        $tabs_labels[$i] = '
		            <li>
		                <a class="'.esc_attr($class_active).'" data-toggle="tab" role="tab" href="#'.esc_attr($id).'">'.($item['label']).'</a>
		            </li>
		        ';
		        $tabs_contents[$i] = '
		            <div class="tab-pane fade '.esc_attr($class_active_cont).'" id="'.esc_attr($id).'" role="tabpanel">
		                <p>'.($item['content']).'</p>
		                '.($btn_link).'
		            </div>
		        ';
		
		        $i++;
		    }
		
		    $out .= '
		    <div class="pix-section-tabs">
		        <ul class="nav nav-tabs" role="tablist">
		            '.implode($tabs_labels).'
		        </ul>
		        <div class="tab-content">
		            '.implode($tabs_contents).'
		        </div>
		    </div>';
		
		}
		
		$out .= '</div>';
		
		pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}