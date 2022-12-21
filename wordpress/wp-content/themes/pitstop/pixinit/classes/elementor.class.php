<?php

class PixTheme_Elementor {

	protected static $instance = null;

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct() {
	    foreach (glob(get_template_directory() . '/templates_el/controls/*.php') as $filename){
			require_once($filename);
		}
		foreach (glob(get_template_directory() . '/templates_el/*.php') as $filename){
            require_once($filename);
        }
		foreach (glob(get_template_directory() . '/templates_el/sections/*.php') as $filename){
            require_once($filename);
        }
		add_action( 'elementor/controls/controls_registered', [ $this, 'pixtheme_register_controls' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'pixtheme_register_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'pixtheme_add_elementor_widget_categories' ] );
	}

	public function pixtheme_register_widgets() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Title() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Button() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Icon_Box() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Amount_Box() );
		//\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Brands() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Price_Table() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Reviews() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Special_Offers() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Team() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Woo_Cats() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Woo() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Filter() );
		//\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Banner() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Posts() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Points() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\PixTheme_EL_Pix_Cform7() );
	}
	
	public function pixtheme_register_controls() {
	    $controls_manager = \Elementor\Plugin::$instance->controls_manager;
		$controls_manager->register_control( 'radio_images', new Radio_Images_Control() );
		$controls_manager->register_control( 'products_filter', new Products_Filter_Control() );
	}
	
	public function pixtheme_add_elementor_widget_categories( $elements_manager ) {
        
        
        //add our categories

        $elements_manager->add_category(
            'pixtheme',
            [
                'title' => __( 'Pix-Theme', 'pitstop' ),
                'icon' => 'fa fa-plug',
            ]
        );

        //hack into the private $categories member, and reorder it so our stuff is at the top

        $reorder_cats = function(){
            uksort($this->categories, function($keyOne, $keyTwo){
                if(substr($keyOne, 0, 3) == 'pix'){
                return -1;
            }
            if(substr($keyTwo, 0, 3) == 'pix'){
                return 1;
            }
            return 0;
        });

        };
        $reorder_cats->call($elements_manager);
    }

}

add_action( 'init', 'pixtheme_elementor_init' );
function pixtheme_elementor_init() {
	PixTheme_Elementor::get_instance();
}