<?php

defined( 'ABSPATH' ) || exit;

class Hostinger_Admin_Redirect {
	const PLATFORM_HPANEL = 'hpanel';

	/**
	 * @return void
	 */
	public function redirect() {
		if ( ! isset( $_GET['platform'] ) ) {
			return;
		}
		$redirect = $_GET['platform'];
		if ( $redirect === self::PLATFORM_HPANEL && !Hostinger_Extendify::extendifyFileExists() ) {
			$this->redirect_to_oldest_post();
		}
	}

	/**
	 * @return void
	 */
	private function redirect_to_oldest_post() {
		$posts = get_posts( [
			'numberposts' => 1,
			'order'       => 'ASC'
		] );

		if ( isset( $posts[0] ) ) {
			$firstPost = $posts[0];

			$redirect_url = admin_url( 'post.php?post=' . $firstPost->ID . '&action=edit' );
			wp_redirect( $redirect_url );
			exit;
		}
	}
}
