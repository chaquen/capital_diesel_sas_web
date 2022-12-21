<?php

defined( 'ABSPATH' ) || exit;

class Hostinger_Default_Options {

	/**
	 * @return void
	 */
	public function add_options() {
		foreach ( $this->options() as $key => $option ) {
			update_option( $key, $option );
		}
	}

	/**
	 * @return array
	 */
	private function options() {
		return [
			'optin_monster_api_activation_redirect_disabled' => 'true',
			'wpforms_activation_redirect'                    => 'true',
			'aioseo_activation_redirect'                     => 'false',
		];
	}
}
