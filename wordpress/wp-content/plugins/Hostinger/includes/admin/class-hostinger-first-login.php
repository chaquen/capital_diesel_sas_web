<?php

defined( 'ABSPATH' ) || exit;

class Hostinger_First_Login {
	public function __construct() {
		$this->register_actions();
		update_option( 'hostinger_first_login_at', date('Y-m-d H:i:s') );
	}

	/**
	 * @return void
	 */
	public function register_actions() {
		require_once HOSTINGER_ABSPATH . 'includes/admin/class-hostinger-admin-redirect.php';
		add_action( 'init', [ new Hostinger_Admin_Redirect(), 'redirect' ] );
	}
}

new Hostinger_First_Login();
