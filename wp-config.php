<?php

//define( 'ITSEC_ENCRYPTION_KEY', 'WERJfigjanQsKmRZLVpjKll0VFlIci4gXSs4VVA+K3xbVFJAKCU+b0xTfUYpUFNZVXdHYHk2PUVSIGljQlguQQ==' );
// define( 'WP_CACHE', true );

define( 'WP_CACHE', false );



/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
// define('DB_NAME', "qj1t5ek3_doga_svrl");
// define('DB_USER', "qj1t5ek3_doga_svrl");
// define('DB_PASSWORD', "pB+hga[s+a6.");
// define('DB_HOST', "localhost");
// define('DB_CHARSET', 'utf8mb4');
// define('DB_COLLATE', '');


define('DB_NAME', "wordpress");
define('DB_USER', "wordpress");
define('DB_PASSWORD', "wordpress");
define('DB_HOST', "database");
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');




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
define('AUTH_KEY',         'SA8NbuI97gT62+h%N%1(IkC4G@x8xV?DuCKkpVDeAI>cyh0S[JPwpkA[kxMFv[||');
define('SECURE_AUTH_KEY',  'H|b,us>-}CQ]AG6j{WNXAQ@t2VX~1m~CwY?1_YRZv]h~)V@;eIWi)=`b*ZXC?fk[');
define('LOGGED_IN_KEY',    '~6[dyVAw*z+k{^J5+6R0q~Ao)It@`[9QneC^jTF_5L3qtaxsyx>,PEzOn2gS1;6b');
define('NONCE_KEY',        'L3hTMfk#dUTP*KJLj@quq74#Ze:1UA`Z>SKEw9Z--ZJOvlBOJ:7@y-F g!#[lL`!');
define('AUTH_SALT',        '=/`8{=9Q< sY%m}v1jPUb7_8n)w-4PvL;(|0Cc;J}]h8ehqG4P]]9Xg#!BB_fw9-');
define('SECURE_AUTH_SALT', '{rT hOD%$|z!l#);TJ+j|uv+Jc-AveDo-$sZdg]$*^AE%dqBB(RT:ntu`4`Obr4)');
define('LOGGED_IN_SALT',   'Z+zR.+rp^E6zby1(CG 4x3x*?wr[i%TiqN/8KWN|4FYW!bv?Wbm.>z(A|9DL<} M');
define('NONCE_SALT',       'G6#k=@j#|9YxuD.*3d^0Fl}oU6_AYu-zW13OXZf-t-h(^r={]7m_*Cb4=v[f U4y');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'PDP_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', false);

define('WP_MEMORY_LIMIT', '2048M');
define('WP_MAX_MEMORY_LIMIT', '2048M');

// @ini_set( 'session.cookie_httponly', true );
// @ini_set( 'session.cookie_secure', true );
// @ini_set( 'session.cookie_samesite', 'Strict' );

// define( 'COOKIE_SECURE', true );
// define( 'COOKIE_HTTPONLY', true );

/* Add any custom values between this line and the "stop editing" line. */

// Lando Traefik proxy: trust X-Forwarded-Proto so is_ssl() works correctly
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
	$_SERVER['HTTPS'] = 'on';
}

// define( 'WP_HOME', 'https://www.doga.es' );
define( 'WP_HOME', 'http://consorci.lndo.site' );
// define( 'WP_SITEURL', 'https://www.doga.es' );
define( 'WP_SITEURL', 'http://consorci.lndo.site' );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
//Disable File Edits
// if (!defined('DISALLOW_FILE_EDIT')) { define('DISALLOW_FILE_EDIT', true); }