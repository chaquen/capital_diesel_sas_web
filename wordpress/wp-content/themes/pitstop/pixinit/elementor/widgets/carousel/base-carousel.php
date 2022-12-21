<?php

namespace Lamira_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

abstract class Base_Carousel extends Base {

    protected $slide_prints_count = 0;

    protected function _register_controls() {
        $this->add_section_options();
    }

    private function add_section_options() {
        $this->start_controls_section(
            'section_carousel_options',
            [
                'label' => esc_html__( 'Carousel Options', 'lamira' ),
            ]
        );

        $this->add_responsive_control(
            'slides_per_view',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__( 'Slides Per View', 'lamira' ),
                'description' => esc_html__( "Number of slides per view (slides visible at the same time on slider's container).", 'lamira' ),
                'options'  => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
                'default'        => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
            ]
        );

         $this->add_responsive_control(
            'slides_per_group',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__( 'Slides per swipe.', 'lamira' ),
                'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'lamira' ),
                'options'  => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
                'default'        => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
            ]
        );

        $this->add_responsive_control(
            'slides_per_column',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__( 'Number of slides per column', 'lamira' ),
                'description' => esc_html__( 'Number of slides per column, for multirow layout ( Number of slides per column > 1) is currently not compatible with loop mode (loop: true)', 'lamira' ),
                'options'  => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                ),
                'default'        => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label'   => esc_html__( 'Space Between', 'lamira' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 0,
                'max'     => 200,
                'step'    => 1,
                'default' => 30,
            ]
        );

        $this->add_control(
            'speed',
            [
                'label'   => esc_html__( 'Transition Duration', 'lamira' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1000,
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'   => esc_html__( 'Infinite Loop', 'lamira' ),
                'description' => esc_html__( 'For multirow layout ( Number of slides per column > 1) is currently not compatible with loop mode (loop: true)', 'lamira' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__( 'Auto Play', 'lamira' ),
                'description' => esc_html__( 'Delay between transitions (in ms). For e.g: 3000. Leave blank to disabled. Input 1 to make smooth transition.', 'lamira' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '',
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'   => esc_html__( 'Pause on Hover', 'lamira' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Arrows', 'lamira' ),
                'default' => 'yes',
                'label_off' => esc_html__( 'Hide', 'lamira' ),
                'label_on' => esc_html__( 'Show', 'lamira' ),
            ]
        );

        $this->add_control(
            'show_dots',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Dots', 'lamira' ),
                'default' => 'yes',
                'label_off' => esc_html__( 'Hide', 'lamira' ),
                'label_on' => esc_html__( 'Show', 'lamira' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function update_slider_settings( $settings, $slider_settings ) {
        return $slider_settings;
    }

    protected function get_slider_settings( array $settings ) {
        $slider_settings = [
            'class' => [ 'pix-swiper pix-swiper-widget' ],
            'data-lg-slides-per-view' => $settings['slides_per_view'],
            'data-md-slides-per-view' => $settings['slides_per_view_tablet'],
            'data-sm-slides-per-view' => $settings['slides_per_view_mobile'],
            'data-lg-slides-per-group' => $settings['slides_per_group'],
            'data-md-slides-per-group' => $settings['slides_per_group_tablet'],
            'data-sm-slides-per-group' => $settings['slides_per_group_mobile'],
            'data-lg-slides-per-column' => $settings['slides_per_column'],
            'data-md-slides-per-column' => $settings['slides_per_column_tablet'],
            'data-sm-slides-per-column' => $settings['slides_per_column_mobile'],
            'data-lg-space' => $settings['space'],
            'data-md-space' => $settings['space_tablet'],
            'data-sm-space' => $settings['space_mobile'],
        ];

        if ( ! empty( $settings['speed'] ) ) {
            $slider_settings['data-speed'] = $settings['speed'];
        }

        if ( ! empty( $settings['autoplay'] ) ) {
            $slider_settings['data-autoplay'] = $settings['autoplay'];
        }

        if ( ! empty( $settings['pause_on_hover'] ) && 'yes' === $settings['pause_on_hover'] ) {
            $slider_settings['data-pause-on-hover'] = '1';
        }

         if ( ! empty( $settings['loop'] ) && 'yes' === $settings['loop'] ) {
            $slider_settings['data-loop'] = '1';
        }

        if ( ! empty( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] ) {
            $slider_settings['data-arrows'] = '1';
        }

        if ( ! empty( $settings['show_dots'] ) && 'yes' === $settings['show_dots'] ) {
            $slider_settings['data-dots'] = '1';
        }

        if ( ! empty( $settings['vertical_align'] ) ) {
            $slider_settings['class'][] = 'v-' . $settings['vertical_align'];
        }

        if ( ! empty( $settings['horizontal_align'] ) ) {
            $slider_settings['class'][] = 'h-' . $settings['horizontal_align'];
        }

        $slider_settings = $this->update_slider_settings( $settings, $slider_settings );

        return $slider_settings;
    }

    protected function get_slide_image_url( $slide, array $settings, $image_size_key = 'image_size' ) {
        $image_url = Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], $image_size_key, $settings );

        if ( ! $image_url ) {
            $image_url = $slide['image']['url'];
        }

        return $image_url;
    }

    protected function get_slide_image_alt( $slide, array $settings ) {
        $image_alt = get_post_meta( $slide['image']['id'], '_wp_attachment_image_alt', true );

        return $image_alt;
    }

    protected function render() {
        $this->print_slider();
    }

}
