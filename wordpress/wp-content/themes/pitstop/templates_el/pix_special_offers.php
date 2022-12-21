<?php

namespace Elementor;

class PixTheme_EL_Pix_Special_Offers extends Widget_Base {
	
	public function get_name() {
		return 'pix-special-offers';
	}
	
	public function get_title() {
		return 'Special Offers';
	}
	
	public function get_icon() {
		return 'fas fa-coffee';
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
				'label' => esc_html__( 'Title', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'pitstop' ),
				'type' => Controls_Manager::TEXT,
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
			'offers',
			[
				'label' => esc_html__( 'Offers', 'pitstop' ),
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
				
		$radius = ($pix_el['radius'] != '') ? $pix_el['radius'] : 'pix-global';
		$title_size = ($pix_el['title_size'] != '') ? $pix_el['title_size'] : 'pix-title-l';
        
        $image_size = 'pixtheme-original-col-3';
        
        $offers = $pix_el['offers'];
        $offers_out = array();
        $count = 1;
        $cnt = count($offers);
        $i = $offset = 0;
        foreach($offers as $key => $item){
        
            $image = $href_before = $href_after = '';
            $href = $item['link']['url'] ? $item['link'] : '';
            $target = $item['link']['is_external'] ? ' target="_blank"' : '';
            $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
        
            if( isset($item['image']) && $item['image']['url'] != '' ){
                $img = wp_get_attachment_image_src( $item['image']['id'], $image_size );
                $image =  isset($img[0]) ? '<img src="'.esc_url($img[0]).'" alt="'.esc_attr($item['title']).'">' : '';
            }
            if(!empty( $href['url'] )){
                $href_before = '<a ' . ($target.$nofollow) . ' href="' . esc_url($href['url']) . '" class="pix-shadow-link">';
                $href_after = '</a>';
            }
            $subtitle = isset($item['subtitle']) && $item['subtitle'] != '' ? $item['subtitle'] : '';
        
            $class_red = $count % 2 == 0 ? 'pix-offer-slider-item-red' : '';
            $offers_out[] = '
                <div class="pix-offer-item swiper-slide">
                    '.($href_before).'
                    <div class="pix-offer-item-inner">
                        <div class="pix-offer-item-img">
                            '.($image).'
                        </div>
                        <div class="pix-offer-item-info">
                            <div class="pix-offer-item-title">
                                <div class="'.esc_attr($title_size).' pix-text-overflow">'.($item['title']).'</div>
                                <span class="pix-text-overflow">'.($subtitle).'</span>
                            </div>
                            <div class="pix-offer-item-text">
                                <p class="pix-text-overflow">'.($item['content']).'</p>
                            </div>
                        </div>
                    </div>
                    '.($href_after).'
                </div>';
        
            $count ++;
        }
        
        $swiper_arr = pixtheme_vc_get_params_array($pix_el, 'swiper');
        $swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
        $data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
        $nav_enable = isset($swiper_options_arr['navigation']) && !$swiper_options_arr['navigation'] ? 'disabled' : '';
        $page_enable = isset($swiper_options_arr['pagination']) && !$swiper_options_arr['pagination'] ? 'disabled' : '';
        $col = isset($swiper_options_arr['items']) ? $swiper_options_arr['items'] : 4;
        $swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($col);
        
        
        $out = '
        <div class="pix-swiper">
            <div class="pix-offer-list '.esc_attr($swiper_class).' '.esc_attr($radius).' " '.($data_swiper).'>
                <div class="swiper-wrapper">
                    '.implode( "\n", $offers_out ).'
                </div>
            </div>
            <div class="pix-nav left-right pix-offer-list-nav '.esc_attr($nav_enable).'">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <div class="pix-swiper-pagination swiper-pagination pix-offer-list-paging '.esc_attr($page_enable).'"></div>
        </div>';
        
        
        pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}