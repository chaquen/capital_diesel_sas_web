<?php

namespace Elementor;

class PixTheme_EL_Pix_Video extends Widget_Base {
	
	public function get_name() {
		return 'pix-video';
	}
	
	public function get_title() {
		return 'Video';
	}
	
	public function get_icon() {
		return 'fas fa-play';
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
			'link',
			[
				'label' => esc_html__( 'YouTube or Vimeo Link', 'pitstop' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://www.youtube.com/watch?v=PssMYGPiyl0',
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'display',
			[
                'label' => esc_html__( 'Display Type', 'pitstop' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'popup',
                'options' => [
                    'popup'     =>  esc_html__( 'Popup Window', 'pitstop' ),
	                'embed'     =>  esc_html__( 'Embedded Video', 'pitstop' ),
	                'button'    =>  esc_html__( 'Button with Popup', 'pitstop' ),
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
                    'pix-text-left'     =>  esc_html__( 'Left', 'pitstop' ),
	                'pix-text-center'   =>  esc_html__( 'Center', 'pitstop' ),
	                'pix-text-right'    =>  esc_html__( 'Right', 'pitstop' ),
                ],
                'condition' => [
                    'display' => 'button',
                ]
            ]
		);
		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'pitstop' ),
				'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'display' => ['popup', 'embed'],
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
			'height',
			[
				'label' => esc_html__( 'Height', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Default 500px', 'pitstop' ),
				'default' => '500px',
				'condition' => [
                    'display' => ['popup', 'embed'],
                ]
			]
		);
		$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Overlay Color', 'pitstop' ),
				'type' => Controls_Manager::COLOR,
				'description' => esc_html__( 'Default 500px', 'pitstop' ),
				'default' => '#00000030',
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: {{VALUE}}',
				],
				'condition' => [
                    'display' => ['popup', 'embed'],
                ]
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter text used as title of carousel.', 'pitstop' ),
				'condition' => [
                    'display' => ['popup', 'embed'],
                ]
			]
		);
		$this->add_control(
			'content',
			[
				'label' => esc_html__( 'Content', 'pitstop' ),
				'type' => Controls_Manager::WYSIWYG,
                'placeholder' => esc_html__( 'Type your description here', 'pitstop' ),
				'condition' => [
                    'display' => ['popup', 'embed'],
                ]
			]
		);
		$this->end_controls_section();
		
	}
	
	protected function render() {

        $pix_el = $this->get_settings_for_display();
		
        $img_bg = $btn_class = $pix_btn = '';
        
		$url = $pix_el['link']['url'];
		$radius = ($pix_el['radius'] != '') ? $pix_el['radius'] : 'pix-global';
		$display = $pix_el['display'];
		$height = $pix_el['height'] == '' ? '500px' : $pix_el['height'];
		$position = $pix_el['position'];
		$color = $pix_el['color'];
		$title = $pix_el['title'] == '' ? '' : '<div class="title">'.($pix_el['title']).'</div>';
		$fullcontent = $pix_el['content'] ? '' : '<div class="duration">'.do_shortcode($pix_el['content']).'</div>';
		if($pix_el['image']['url'] != '') {
		    $img_path = wp_get_attachment_image_src($pix_el['image']['id'], 'large');
		    $img_bg = isset($img_path[0]) ? 'background: url(' . esc_url($img_path[0]) . ') no-repeat 50% 50%;' : '';
		}
		
		$pix_video_class = 'pix_video_' . rand();
		if($display == 'button'){
		    $height = '70px';
		    $btn_class = 'pix-video-button';
		    $color = 'transparent';
		    $pix_btn = '<div class="pix-button pix-transparent">'.esc_html__('Watch the Video', 'pitstop').'</div>';
		}
		$pix_video_style = 'jQuery("head").append("<style> .'.esc_attr($pix_video_class).'{'.($img_bg).'display:grid;position:relative;height:'.esc_attr($height).'}.'.esc_attr($pix_video_class).' .pix-video{background-color:'.esc_attr($color).'}</style>");';
		wp_add_inline_script( 'pixtheme-common', $pix_video_style );
		
		if($display != 'embed') {
		$out = '
		     <div class="'.esc_attr($pix_video_class).' '.esc_attr($radius).'">
		        <div class="pix-video '.esc_attr($btn_class).' '.esc_attr($position).'">
		            '.($title).'
		            <a class="pix-video-popup" href="'.esc_url($url).'" >
		                '.($pix_btn).'
		                <div class="item-pulse">
		                    <img class="play" src="'.get_template_directory_uri().'/images/play.svg" alt="'.esc_attr($title).'">
		                </div>
		            </a>
		            '.($fullcontent).'
		        </div>
		    </div>';
		} else {
		    $vendor = parse_url($url);
		    $video_id = $vendor_name = '';
		    if ($vendor['host'] == 'www.youtube.com' || $vendor['host'] == 'youtu.be' || $vendor['host'] == 'www.youtu.be' || $vendor['host'] == 'youtube.com') {
		        if ($vendor['host'] == 'www.youtube.com') {
		            parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
		            $video_id = $my_array_of_vars['v'];
		        } else {
		            $video_id = parse_url($url, PHP_URL_PATH);
		        }
		        $vendor_name = 'youtube';
		    } elseif ($vendor['host'] == 'vimeo.com'){
		        $video_id = parse_url($url, PHP_URL_PATH);
		        $vendor_name = 'vimeo';
		    }
		    $out = '
		    <div class="' . esc_attr($pix_video_class) . ' '.esc_attr($radius).'">
		        <div class="pix-video embed" data-vendor="' . esc_attr($vendor_name) . '" data-embed="' . esc_attr($video_id) . '">
		            ' . ($title) . '
		                <div class="play-button">
		                    <div class="item-pulse">
		                        <img class="play" src="' . get_template_directory_uri() . '/images/play.svg" alt="' . esc_attr($title) . '">
		                    </div>
		                </div>
		            ' . ($fullcontent) . '
		        </div>
		    </div>';
		}
		
		pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}