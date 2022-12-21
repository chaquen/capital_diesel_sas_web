<?php

namespace Lamira_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Products_Double_Block_Carousel extends Base_Posts_Carousel {

    public function get_name() {
        return 'lamira-products-double-block-carousel';
    }

    public function get_title() {
        return esc_html__( 'Products Big Double Slider', 'lamira' );
    }

    public function get_icon() {
        return 'eicon-slides';
    }

    public function get_keywords() {
        return [ 'products', 'woocommerce', 'carousel' ];
    }

    public function get_script_depends() {
        return [
            'lamira-widgets-carousel',
            'lamira-widgets-slider-images'
        ];
    }

    protected function get_post_type() {
        return 'product';
    }

    protected function get_taxonomy() {
        return 'product_cat';
    }

    protected function _register_controls() {
        $this->add_section_content();
        $this->add_image_size_section();
        parent::_register_controls();
        $this->update_controls();
    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'lamira' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__( 'Heading', 'lamira' ),
                'default' => esc_html__( 'Products', 'lamira' ),
            ]
        );

        $this->add_control(
            'indent_class',
            [
                'label' => esc_html__( 'Title left indent', 'lamira' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'No indent', 'lamira' ),
                    'ml-xl-70 ml-xz-140' => esc_html__( 'Indented', 'lamira' ),
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'lamira' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'video_url',
            [
                'label' => esc_html__( 'Video Url', 'lamira' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://youtu.be/QQMFPjNM3pU', 'lamira' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function add_image_size_section() {
        $this->start_controls_section(
            'image_size_section',
            [
                'label' => esc_html__( 'Image Size', 'lamira' ),
            ]
        );

        $this->add_control(
            'image_size_default',
            [
                'label'        => esc_html__( 'Use Default Thumbnail Size', 'lamira' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '1',
                'return_value' => '1',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image_size',
                'default'   => 'full',
                'condition' => [
                    'image_size_default!' => '1',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function update_controls() {
        $this->update_responsive_control(
            'slides_per_view',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
            ]
        );

        $this->update_responsive_control(
            'space',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => 0,
            ]
        );

        $this->update_responsive_control(
            'slides_per_group',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
            ]
        );

        $this->update_responsive_control(
            'slides_per_column',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
            ]
        );

        $this->update_control(
            'show_dots',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => 'no',
            ]
        );
    }

    protected function print_slider( array $settings = null ) {
        if ( null === $settings ) {
            $settings = $this->get_settings_for_display();
        }

        $slider_settings = $this->get_slider_settings( $settings );

        $default_settings = [
            'class' => [
                'section',
                'bg-0',
                'bigSlider',
                'reorder'
            ],
        ];

        $slider_settings = array_merge_recursive( $default_settings, $slider_settings );

        $this->add_render_attribute( 'slider', $slider_settings );

        ?>

        <section <?php $this->print_render_attribute_string( 'slider' ); ?>>
                <div class="container mb-60 mb-xl-0">
                    <div class="row">
                        <div class="col-xl-6 py-140">
                            <div class="mx-sm-40 mx-md-70 mx-xz-140">
                                <div class="section__title <?php echo esc_attr( $settings['indent_class'] ); ?>">
                                    <?php if ( ! empty( $title = $settings['title'] ) ) : ?>
                                        <h2><?php echo esc_html( $title ); ?></h2>
                                    <?php endif; ?>
                                </div>

                                <?php
                                $this->query_posts();

                                $posts_query = $this->get_query();
                                ?>
                                <div class="swiper-container bigSliderContainer">
                                    <div class="swiper-wrapper">
                                        <?php if ( $posts_query->have_posts() ) : ?>
                                            <?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
                                                <div class="swiper-slide">
                                                    <?php $this->print_slide( $settings ); ?>
                                                </div>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bigSlider__video">
                    <?php echo wp_get_attachment_image( $settings['image']['id'], 'full' ); ?>
                    <?php if ( ! empty( $video_url = $settings['video_url']['url'] ) ) : ?>
                        <a href="<?php echo esc_url( $video_url ); ?>" data-fancybox><i class="pix-icon-play"></i></a>
                    <?php endif; ?>
                </div>
                <div class="slideControl"></div>
            </section>
        <?php
    }

    protected function print_slide( array $settings ) {
        set_query_var( 'settings', $settings );

        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        get_template_part( 'template-parts/elementor/woocommerce/content', 'product-big' );
    }

}
