<?php

namespace Lamira_Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Control_Init {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {
        add_action( 'elementor/controls/controls_registered', array( $this, 'init_controls' ) );
    }


    public function init_controls( $controls_manager ) {

    }
}

Control_Init::instance();
