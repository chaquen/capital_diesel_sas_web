<?php

defined( 'ABSPATH' ) || exit;

class Hostinger_Activator {

	/**
	 * @return void
	 */
	public static function activate() {
		require_once HOSTINGER_ABSPATH . 'includes/class-hostinger-default-options.php';
		$options = new Hostinger_Default_Options();
		$options->add_options();
	}
}
