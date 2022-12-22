<?php

namespace Elementor;

class PixTheme_EL_Pix_Icon_Box extends Widget_Base {
	
	public function get_name() {
		return 'pix-icon-box';
	}
	
	public function get_title() {
		return 'Icon Box';
	}
	
	public function get_icon() {
		return 'fab fa-fonticons-fi';
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
			'style',
			[
				'label' => esc_html__( 'Style', 'pitstop' ),
				'type' => 'radio_images',
                'default' => 'pix-ibox-side',
				'options' => [
					'pix-ibox-side' => 'icon_box-side.png',
                    'pix-ibox-title-side' => 'icon_box-title-side.png',
                    'pix-ibox-top' => 'icon_box-top.png',
                    'pix-ibox-flip' => 'services_cat_flip.png',
				]
			]
		);
		$this->add_control(
			'bg_image',
			[
				'label' => esc_html__( 'Background Image', 'pitstop' ),
				'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'style' => 'pix-ibox-flip',
                ]
			]
		);
		$this->add_control(
			'flip',
			[
				'label' => esc_html__( 'Flip', 'pitstop' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'on',
                'default' => 'on',
                'condition' => [
                    'style' => 'pix-ibox-flip',
                ]
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
			'position_with_center',
			[
                'label' => esc_html__( 'Alignment', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-text-left',
                'options' => [
                    'pix-text-left'    =>  esc_html__( 'Left', 'pitstop' ),
					'pix-text-center'  =>  esc_html__( 'Center', 'pitstop' ),
	                'pix-text-right'   =>  esc_html__( 'Right', 'pitstop' ),
                ],
                'condition' => [
                    'style' => 'pix-ibox-top',
                ]
            ]
		);
		$this->add_control(
			'position_no_center',
			[
                'label' => esc_html__( 'Alignment', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-text-review-left',
                'options' => [
                    'pix-text-review-left'    =>  esc_html__( 'Left', 'pitstop' ),
	                'pix-text-review-right'   =>  esc_html__( 'Right', 'pitstop' ),
                ],
                'condition' => [
                    'style' => ['pix-ibox-side', 'pix-ibox-title-side']
                ]
            ]
		);
		$this->add_control(
			'border',
			[
				'label' => esc_html__( 'Border', 'pitstop' ),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'Show border around the box', 'pitstop' ),
                'return_value' => 'off',
                'default' => 'off',
                'condition' => [
                    'style' => 'pix-ibox-top',
                ]
			]
		);
		$this->add_control(
			'filled',
			[
				'label' => esc_html__( 'Fill on Hover', 'pitstop' ),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'Fill the background with the main color on hover', 'pitstop' ),
                'return_value' => 'off',
                'default' => 'off',
                'condition' => [
                    'style' => 'pix-ibox-top',
                ]
			]
		);
		$this->add_control(
			'no_padding',
			[
				'label' => esc_html__( 'No Padding', 'pitstop' ),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'Set default padding to 0', 'pitstop' ),
                'return_value' => 'off',
                'default' => 'off',
                'condition' => [
                    'style' => 'pix-ibox-top',
                ]
			]
		);
		$this->add_control(
			'fill_color',
			[
                'label' => esc_html__( 'Fill Color', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-main-color',
                'options' => [
                    'pix-main-color'        =>  esc_html__( 'Main', 'pitstop' ),
                    'pix-additional-color'  =>  esc_html__( 'Additional', 'pitstop' ),
                    'pix-gradient-color'    =>  esc_html__( 'Gradient', 'pitstop' ),
	                'pix-black-color'       =>  esc_html__( 'Black', 'pitstop' ),
                ],
                'condition' => [
                    'filled' => 'on'
                ]
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
			'icon_shape',
			[
                'label' => esc_html__( 'Icon Background', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'transparent',
                'options' => [
                    'transparent'    =>  esc_html__( 'Transparent', 'pitstop' ),
                    'round'    =>  esc_html__( 'Round', 'pitstop' ),
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
                    'pix-icon-gradient'     =>  esc_html__( 'Gradient', 'pitstop' ),
                    'pix-icon-default'      =>  esc_html__( 'Monochrome', 'pitstop' ),
                ],
                'condition' => [
                    'icon_type' => 'font'
                ]
            ]
		);
		$this->add_control(
			'icon_bg_color',
			[
                'label' => esc_html__( 'Background Color', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-icon-bg-main-color',
                'options' => [
                    'pix-icon-bg-main-color'        =>  esc_html__( 'Main', 'pitstop' ),
                    'pix-icon-bg-additional-color'  =>  esc_html__( 'Additional', 'pitstop' ),
                    'pix-icon-bg-gradient-color'    =>  esc_html__( 'Gradient', 'pitstop' ),
                    'pix-icon-bg-black-color'       =>  esc_html__( 'Black', 'pitstop' ),
                    'pix-icon-bg-white-color'       =>  esc_html__( 'White', 'pitstop' ),
                ],
                'condition' => [
                    'icon_shape' => 'round'
                ]
            ]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter text used as title of icon.', 'pitstop' ),
			]
		);
		$this->add_control(
			'title_size',
			[
                'label' => esc_html__( 'Title Size', 'pitstop' ),
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
			'link',
			[
				'label' => esc_html__( 'Link', 'pitstop' ),
				'type' => Controls_Manager::URL,
				'description' => esc_html__( 'Button link', 'pitstop' ),
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
			'link_type',
			[
                'label' => esc_html__( 'Link Type', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__( 'If Overlay the whole box is a link. Don\'t use links in content', 'pitstop' ),
                'default' => 'overlay',
                'options' => [
                    'overlay'   =>  esc_html__( 'Overlay', 'pitstop' ),
                    'button'    =>  esc_html__( 'Button', 'pitstop' ),
                    'href'      =>  esc_html__( 'Text Link', 'pitstop' ),
                ],
            ]
		);
		$this->add_control(
			'btn_link_txt',
			[
				'label' => esc_html__( 'Button/Link Text', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
                'condition' => [
                    'link_type' => ['button', 'href']
                ]
			]
		);
		$this->add_control(
			'content_position',
			[
                'label' => esc_html__( 'Content Position', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-top',
                'options' => [
                    'pix-top'       =>  esc_html__( 'Top', 'pitstop' ),
                    'pix-middle'    =>  esc_html__( 'Middle', 'pitstop' ),
                    'pix-bottom'    =>  esc_html__( 'Bottom', 'pitstop' ),
                ],
                'condition' => [
                    'style' => 'pix-ibox-side'
                ]
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
		
		$this->start_controls_section(
            'carousel_section',
            [
                'label' => esc_html__( 'Carousel', 'pitstop' ),
                'tab' => Controls_Manager::TAB_CONTENT,
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
		
		$href = $pix_el['link'];
		$target = $pix_el['link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $pix_el['link']['nofollow'] ? ' rel="nofollow"' : '';
		
		$style = !isset($pix_el['style']) || $pix_el['style'] == '' ? 'pix-ibox-top' : $pix_el['style'];
		$radius = ($pix_el['radius'] != '') ? $pix_el['radius'] : 'pix-global';
		$border_class = $pix_el['border'] == 'on' ? 'pix-has-border' : '';
		$filled_class = $pix_el['filled'] == 'on' ? 'pix-hover-filled' : '';
		$overlay = $pix_el['filled'] == 'on' ? '<div class="pix-overlay '.esc_attr($fill_color).'"></div>' : '';
		$no_padding_class = $pix_el['no_padding'] == 'on' ? 'pix-no-padding' : '';
		
		$css_classes = array(
			$radius,
			$border_class,
			$filled_class,
			$no_padding_class,
		);
		
		$css_class = implode( ' ', array_filter( array_unique( $css_classes ) ) );
		
		if($style == 'pix-ibox-top'){
		    $position = $position_with_center;
		} else {
		    $position = $position_no_center;
		}
		
		$class_text = in_array($style, array('pix-ibox-side')) ? 'text '.esc_attr($content_position) : '';
		if(!empty( $href['url'] )){
		    if($link_type == 'overlay') {
		        $href_container_before = '<a ' . ($target . $nofollow) . ' href="' . esc_url($href['url']) . '" class="pix-image-link">';
		        $href_container_after = '</a>';
		    } else {
		        $href_before = '<a ' . ($target . $nofollow) . ' href="' . esc_url($href['url']) . '" class="pix-title-link">';
		        $href_after = '</a>';
		        $hover_class = 'pix-icon-hover';
		    }
		}
		if($icon_type == 'image' && isset($pix_el['image']) && $pix_el['image']['url'] != ''){
		    $img_path = wp_get_attachment_image_src( $pix_el['image']['id'], 'thumbnail' );
			$show_icon = isset($img_path[0]) ? '<div class="icon">'.($href_before).'<img src="'.esc_url($img_path[0]).'" alt="'.esc_attr($title).'">'.($href_after).'</div>' : '';
		} elseif($icon_type == 'font' && $pix_el['font']['library'] == 'svg') {
			$show_icon = '<div class="icon">'.($href_before).'<img src="'.esc_url($pix_el['font']['value']['url']).'" alt="'.esc_attr($title).'">'.($href_after).'</div>';
		} else {
			$show_icon = '<div class="icon">'.($href_before).'<span class="'.esc_attr($pix_el['font']['value']).'" ></span>'.($href_after).'</div>';
		}
		
		$bg_image = '';
		if(isset($pix_el['bg_image']) && $pix_el['bg_image']['id'] != 0){
		    $bg_img_path = wp_get_attachment_image_src( $pix_el['bg_image']['id'], array(555,555) );
		    if(isset($bg_img_path[0])) {
		        $bg_image = $bg_img_path[0];
		    }
		}
		
		$out_icon = '<div class="'.esc_attr($icon_shape).' '.esc_attr($icon_size).' '.esc_attr($icon_color).' '.esc_attr($icon_bg_color).' '.esc_attr($hover_class).'">'.($show_icon).'</div>';
		$final_title = $pix_el['title'] == '' ? '' : '<div class="pix-item-title '.esc_attr($title_size).'">'.($pix_el['title']).'</div>';
		$final_content = ($pix_el['content'] == '') ? '' : '<p>'.do_shortcode($pix_el['content']).'</p>';
		$btn_link_class = $pix_el['link_type'] == 'button' ? 'pix-button' : 'pix-link';
		$final_btn = ($pix_el['btn_link_txt'] == '') ? '' : '<a href="'.esc_url($href['url']).'" class="'.esc_attr($btn_link_class).'" '.($target . $nofollow).'>'.($btn_link_txt).'</a>';
		
		$out = '<div class="pix-box ' . esc_attr($css_class) . '">';
		
		$out .= ($href_container_before).'
				<div class="'.esc_attr($style).' '.esc_attr($position).' '.esc_attr($icon_size).'">';
		
		if($style == 'pix-ibox-side' && $position_no_center == 'pix-text-review-right'){
		    $out .= '
		            <div class="pix-block-content ">
		                <div class="'.esc_attr($class_text).'">
		                    '.($final_title).'
		                    '.($final_content).'
		                    '.($final_btn).'
		                </div>
		                '.($out_icon).'
		            </div>';
		} elseif($style == 'pix-ibox-title-side'){
		    if($position_no_center == 'pix-text-review-right') {
		        $title_top = '
		            <div class="pix-ibox-title">'.($final_title).'</div>
		            '.($out_icon);
		    } else {
		        $title_top = '
		            '.($out_icon).'
		            <div class="pix-ibox-title">'.($final_title).'</div>';
		    }
		    $out .= '
		            '.($overlay).'
		            <div class="pix-block-content">
		                <div class="pix-ibox-title-side-top">
		                    '.($title_top).'
		                </div>
		                <div class="'.esc_attr($class_text).'">
		                    '.($final_content).'
		                    '.($final_btn).'
		                </div>
					</div>';
		} elseif($style == 'pix-ibox-flip'){
		    if(isset($pix_el['flip']) && $pix_el['flip'] == 'on'){
		        $out .= '
		                    <div class="pix-icon-box-flip flip">
		                        <div class="service-box-3">
		                            <div class="service-box-3__container '.esc_attr($icon_size).'">
		                                <div class="icon '.esc_attr($icon_color).' ">'.($show_icon).'</div>
		                                '.($final_title).'
		                            </div>
		                            <img src="'.esc_url($bg_image).'" alt="'.esc_attr($title).'">
		                        </div>
		                        <div class="service-box-3 under">
		                            '.($href_before).'
		                            <div class="service-box-3__container two">
		                                '.($final_title).'
		                                '.($final_content).'
		                            </div>
		                            '.($href_after).'
		                            <img src="'.esc_url($bg_image).'" alt="'.esc_attr($title).'">
		                        </div>
		                    </div>';
		    } else {
		        $out .= '
		                    <div class="pix-icon-box-flip">
		                        <div class="service-box-3">
		                            '.($href_before).'
		                            <div class="service-box-3__container '.esc_attr($icon_size).'">
		                                <div class="icon '.esc_attr($icon_color).' ">'.($show_icon).'</div>
		                                '.($final_title).'
		                            </div>
		                            '.($href_after).'
		                            <img src="'.esc_url($bg_image).'" alt="'.esc_attr($title).'">
		                        </div>
		                    </div>';
		    }
		} else {
		    $out .= '
		            '.($overlay).'
		            <div class="pix-block-content">
		                '.($out_icon).'
		                <div class="'.esc_attr($class_text).'">
		                    '.($final_title).'
		                    '.($final_content).'
		                    '.($final_btn).'
		                </div>
					</div>';
		}
		$out .= '
				</div>
				'.($href_container_after);
		
		$out .= '</div>';
		
		pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}