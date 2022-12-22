<?php

defined( 'ABSPATH' ) || exit;

class Hostinger_Extendify {
	const EXTENDIFY_SETTINGS_FILE = HOSTINGER_ABSPATH . 'includes/extendify/extendify.php';

    /**
     * @return void
     */
	public function init() {
		if ( self::extendifyFileExists() ) {
			require_once self::EXTENDIFY_SETTINGS_FILE;
		}
	}

    /**
     * @return bool
     */
	public static function extendifyFileExists() {
		return file_exists( self::EXTENDIFY_SETTINGS_FILE );
	}
}
