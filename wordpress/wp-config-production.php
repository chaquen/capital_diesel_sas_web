<?php
define('WP_MEMORY_LIMIT', '256M');//EDGUZMAN 9-11-2022: SE AGREGA SEGUN RECOMENDACION DE DOCUMENTACION DE PLANTILLA
define( 'WP_CACHE', true );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u414068002_t6sNG' );

/** Database username */
define( 'DB_USER', 'u414068002_GPwtY' );

/** Database password */
define( 'DB_PASSWORD', 'tOKlXE0qZX' );

/** Database hostname */
define( 'DB_HOST', 'mysql' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'bW%]E`ll&w2>&^#NIn;tND&)*@+M!WYK`N*DBXfzwo^WZJP@7p4(,vREzFy=?5ie' );
define( 'SECURE_AUTH_KEY',   'mn9RJsHSE](KdCrNFPKzrm{H~Q%8-jIyAd]JZGiNWP:4&!O=vg;b&0vj3y?i/9ZT' );
define( 'LOGGED_IN_KEY',     'BWA_c~xW09=7eHU}PJbDP1.z8SbDo~YisSQeeVTwou9N8X5HZ&!L=_$P^OkP/@$O' );
define( 'NONCE_KEY',         'N~4fo,b:HLev1V3O:2 T@45X&+5N8uZeVb~y3H./q>`j,x_].Kuj(H_xxf0z[3ju' );
define( 'AUTH_SALT',         'P`+-ObN4olG_5d8%0dwPvDlV&E%>}G*;UR>jK8j]!OFm~hNhU8p;X_gXu<XggLM_' );
define( 'SECURE_AUTH_SALT',  'E1K|8)2__ k938%HV?mQrPhRRvLCc6j:AWxDRog~47I=:}OU]0~hNAdi0ByM<;Y!' );
define( 'LOGGED_IN_SALT',    ',N7d+k]F6eOZvr`lbfmpC.N;m sxb6&b8^`8Zm|=03B3G;4h)+WpqkN0jP2 &;7O' );
define( 'NONCE_SALT',        '`544v(Iv{~^&6Zx]JA+TOuu/]8#O*8s`JQ11{p;ddj3HNiv^UOGk,h`)Y^J)[s-Y' );
define( 'WP_CACHE_KEY_SALT', 'M G`6lLPc9)4,BS+0.T2D<asuQU)h[RKZ$CICC,G1l!do[!x`xa)v)Z;-~Ts!hDp' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
