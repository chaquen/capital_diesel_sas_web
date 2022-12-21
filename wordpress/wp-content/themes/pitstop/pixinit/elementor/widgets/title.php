<?php

namespace Lamira_Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Title extends Base {

    public function get_name() {
        return 'lamira-title';
    }

    public function get_title() {
        return esc_html__( 'Title', 'lamira' );
    }

    public function get_icon() {
        return 'eicon-t-letter';
    }

    public function get_keywords() {
        return [ 'heading', 'title', 'text' ];
    }

    protected function _register_controls() {
        $this->add_section_content();
    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'lamira' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'lamira' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Default title', 'lamira' ),
                'placeholder' => esc_html__( 'Type your title here', 'lamira' ),
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
            'bottom_padding_style',
            [
                'label' => esc_html__( 'Bottom padding style', 'lamira' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default', 'lamira' ),
                    'custom' => esc_html__( 'Custom', 'lamira' ),
                ],
            ]
        );

        $this->add_responsive_control(
            'bottom_padding',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__( 'Bottom padding', 'lamira' ),
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 120,
                    ],
                ],
                'size_units' => [ 'px' ],
                'default' => [
                    'size' => 72,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .section__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'bottom_padding_style' => 'custom',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $title = $settings['title'];

        if ( ! empty( $title ) ) {
            echo '<div class="section__title ' . esc_attr( $settings['indent_class'] ) . '"><h2>' . $title . '</h2></div>';
        }
    }

    protected function _content_template() {
        ?>
        <#
            var title= settings.title;
            #>
            <# if ( '' !== title ) { #>
                <div class="section__title {{{ settings.indent_class }}}">
                    <h2>{{{ title }}}</h2>
                </div>
            <# } #>
        <?php
    }
}
