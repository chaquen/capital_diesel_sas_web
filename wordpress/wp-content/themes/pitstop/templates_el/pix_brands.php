<?php

namespace Elementor;

class PixTheme_EL_Pix_Brands extends Widget_Base {
	
	public function get_name() {
		return 'pix-brands';
	}
	
	public function get_title() {
		return 'Brands';
	}
	
	public function get_icon() {
		return 'fas fa-ad';
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
			'title',
			[
				'label' => esc_html__( 'Title', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter text used as title of carousel.', 'pitstop' ),
			]
		);
		$this->add_control(
			'brands_per_page',
			[
				'label' => esc_html__( 'Brands per page', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter number of columns. Default 5.', 'pitstop' ),
			]
		);
		$this->add_control(
			'popup',
			[
				'label' => esc_html__( 'Popup Images', 'pitstop' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'off',
                'default' => 'off',
				'description' => esc_html__( 'Show popup with large image on click. The link doesn\'t work', 'pitstop' ),
			]
		);
		$this->add_control(
			'greyscale',
			[
				'label' => esc_html__( 'Greyscale Images', 'pitstop' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'off',
                'default' => 'off',
				'description' => esc_html__( 'Show greyscale image with colored hover', 'pitstop' ),
			]
		);
		
		$repeater = new Repeater();
		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'pitstop' ),
                'type' => Controls_Manager::MEDIA,
			]
		);
		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Brand Title', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'pitstop' ),
				'type' => Controls_Manager::URL,
				'description' => esc_html__( 'Brand link', 'pitstop' ),
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
			'brands',
			[
				'label' => esc_html__( 'Brands', 'pitstop' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
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
        
		$title = $pix_el['title'];
		$brands_per_page = is_numeric($pix_el['brands_per_page']) ? $pix_el['brands_per_page'] : 5;
		$gallery_class = $pix_el['popup'] == 'on' ? 'pix-popup-gallery' : '';
		$greyscale = $pix_el['greyscale'] == 'off' ? '' : 'pix-img-greyscale';
		$swiper_arr = pixtheme_vc_get_params_array($pix_el, 'swiper');
		
		$image_size = array(100, 100);
		if( pixtheme_retina() ){
		    $image_size = array(200, 200);
		}
		
		$brands = $pix_el['brands'];
		$brands_out = array();
		foreach($brands as $key => $item){
            $url = empty($item['link']['url']) ? '#' : $item['link']['url'];
            $target = $item['link']['is_external'] ? ' target="_blank"' : '';
            $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
		    if(isset($item['image']) && $item['image']['url'] != ''){
		        $img_path = wp_get_attachment_image_src( $item['image']['id'], $image_size );
		        $img_full = wp_get_attachment_image_src( $item['image']['id'], 'full' );
		        $url = $pix_el['popup'] == 'on' && isset($img_full[0]) ? $img_full[0] : $url;
		        $item_title = isset($item['title']) ? $item['title'] : '';
		        if(isset($img_path[0])) {
		            $brands_out[] = '
		        <div class="pix__clientsItem swiper-slide">
		            <a ' . ($target.$nofollow) . ' href="' . esc_url($url) . '"><img class="pix-no-lazy-load" src="' . esc_url($img_path[0]) . '" alt="' . esc_attr($item_title) . '"></a>
		        </div>';
		        }
		    }
		
		}
		
		$swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
		$data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
		$nav_enable = isset($swiper_options_arr['navigation']) && !$swiper_options_arr['navigation'] ? 'disabled' : '';
		$page_enable = isset($swiper_options_arr['pagination']) && !$swiper_options_arr['pagination'] ? 'disabled' : '';
		$col = isset($swiper_options_arr['items']) != '' ? $swiper_options_arr['items'] : $brands_per_page;
		$swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($col);
		
		
		$out = '
		
		<div class="pix-images-slider">
		    <div class="pix-carousel-title pix-title h3 mt-0 mb-0 pl-0 pr-20">'.($title).'</div>
		    <div class="pix-nav side-left small '.esc_attr($nav_enable).'">
		        <div class="swiper-button-prev"></div>
		        <div class="swiper-button-next"></div>
		    </div>
		    <div class="pix__clientsList '.esc_attr($gallery_class).' '.esc_attr($swiper_class).' '.esc_attr($greyscale).'" '.($data_swiper).'>
		        <div class="swiper-wrapper">
		        '.implode( "\n", $brands_out ).'
		        </div>
		    </div>
		    <div class="pix-swiper-pagination swiper-pagination '.esc_attr($page_enable).'"></div>
		</div>';
		
		pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}