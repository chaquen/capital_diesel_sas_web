<?php

namespace Lamira_Elementor;

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Init {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

        // Registered Widgets.
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'remove_unnecessary_widgets' ], 15 );

        add_filter( 'elementor/utils/get_the_archive_title', [ $this, 'change_portfolio_archive_title' ] );

        require_once get_template_directory() . '/pixinit/elementor/widgets/native/section.php';

    }

    /**
     * Add category.
     *
     * @since  1.0.0
     *
     * @access public
     *
     * @param \Elementor\Elements_Manager $elements_manager
     */
    public function add_elementor_widget_categories( $elements_manager ) {
        $elements_manager->add_category(
            'lamira',
            [
                'title' => esc_html__( 'Lamira', 'lamira' ),
                'icon' => 'fa fa-plug',
                'active' => true,
            ]
        );
    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them
     *
     * @since  1.0.0
     *
     * @access public
     */
    public function init_widgets() {

        // Include Widget files.
        require_once get_template_directory() . '/elementor/modules/module-query-custom.php';
        require_once get_template_directory() . '/elementor/widgets/base.php';
        require_once get_template_directory() . '/elementor/widgets/carousel/base-carousel.php';
        require_once get_template_directory() . '/elementor/widgets/carousel/base-posts-carousel.php';

        require_once get_template_directory() . '/elementor/widgets/title.php';
        require_once get_template_directory() . '/elementor/widgets/banner.php';
        require_once get_template_directory() . '/elementor/widgets/social-icons.php';
        require_once get_template_directory() . '/elementor/widgets/button.php';
        require_once get_template_directory() . '/elementor/widgets/cform7.php';

        require_once get_template_directory() . '/elementor/widgets/carousel/logos-carousel.php';
        require_once get_template_directory() . '/elementor/widgets/carousel/posts-carousel.php';
        require_once get_template_directory() . '/elementor/widgets/carousel/team-double-block-carousel.php';


        // Register Widgets.
        Plugin::instance()->widgets_manager->register_widget_type( new Widget_Title() );

        Plugin::instance()->widgets_manager->register_widget_type( new Widget_Logos_Carousel() );
        Plugin::instance()->widgets_manager->register_widget_type( new Widget_Posts_Carousel() );
        Plugin::instance()->widgets_manager->register_widget_type( new Widget_Team_Double_Block_Carousel() );

        Plugin::instance()->widgets_manager->register_widget_type( new Widget_Banner() );
        Plugin::instance()->widgets_manager->register_widget_type( new Widget_Social_Icons() );
        Plugin::instance()->widgets_manager->register_widget_type( new Widget_Button() );
        Plugin::instance()->widgets_manager->register_widget_type( new Widget_Cform7() );

        if ( lamira_use_woo() ) {
            require_once get_template_directory() . '/elementor/widgets/carousel/products-extended-carousel.php';
            require_once get_template_directory() . '/elementor/widgets/carousel/products-vcards-carousel.php';
            require_once get_template_directory() . '/elementor/widgets/carousel/products-hcards-carousel.php';
            require_once get_template_directory() . '/elementor/widgets/carousel/products-double-block-carousel.php';
            require_once get_template_directory() . '/elementor/widgets/carousel/product-categories-carousel.php';

            Plugin::instance()->widgets_manager->register_widget_type( new Widget_Products_Extended_Carousel() );
            Plugin::instance()->widgets_manager->register_widget_type( new Widget_Products_Vcards_Carousel() );
            Plugin::instance()->widgets_manager->register_widget_type( new Widget_Products_Hcards_Carousel() );
            Plugin::instance()->widgets_manager->register_widget_type( new Widget_Products_Double_Block_Carousel() );
            Plugin::instance()->widgets_manager->register_widget_type( new Widget_Product_Categories_Carousel() );
        }
    }

    function remove_unnecessary_widgets( $widgets_manager ) {
        $elementor_unnecessary_widgets_list =
            [
                'woocommerce-menu-cart',
            ];

        foreach ( $elementor_unnecessary_widgets_list as $widget_name ) {
            $widgets_manager->unregister_widget_type( $widget_name );
        }
    }

    public function change_portfolio_archive_title( $title ) {
        if ( is_tax( 'pix-portfolio-category' ) || is_post_type_archive( 'pix-portfolio' ) ) {
            $title = lamira_get_option( 'header_archive_portfolio_title', esc_html__( 'Portfolios', 'lamira' ) );
        }

        return $title;
    }
}

Widget_Init::instance();
