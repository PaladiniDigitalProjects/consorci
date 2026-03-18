<?php
/**
 * Loader File.
 *
 * @package GutenbergHubSDK
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}

if ( ! defined( 'GHUB_SDK_FILE' ) ) {
	define( 'GHUB_SDK_FILE', __FILE__ );
}

if ( ! defined( 'GHUB_SDK_DIR_PATH' ) ) {
	define( 'GHUB_SDK_DIR_PATH', \plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'GHUB_SDK_PLUGIN_URL' ) ) {
	define( 'GHUB_SDK_PLUGIN_URL', \plugins_url( '/', __FILE__ ) );
}

if ( ! class_exists( 'Gutenberghub_SDK' ) ) {
	/**
	 * Main plugin class
	 */
	final class Gutenberghub_SDK {

		/**
		 * Var to make sure we only load once
		 *
		 * @var boolean $loaded
		 */
		public static $loaded = false;

		/**
		 * Constructor
		 *
		 * @return void
		 */
		public function __construct() {
			if ( ! static::$loaded ) {

				// Views.
				require_once GHUB_SDK_DIR_PATH . 'includes/views/gutenberghub-no-installed-plugins.php';
				require_once GHUB_SDK_DIR_PATH . 'includes/views/gutenberghub-installed-plugins-license-form.php';

				// Core.
				require_once GHUB_SDK_DIR_PATH . 'includes/gutenberghub-api.php';
				require_once GHUB_SDK_DIR_PATH . 'includes/gutenberghub-upgrader.php';
				require_once GHUB_SDK_DIR_PATH . 'includes/gutenberghub-plugin.php';
				require_once GHUB_SDK_DIR_PATH . 'includes/gutenberghub-plugins.php';
				require_once GHUB_SDK_DIR_PATH . 'includes/gutenberghub-admin.php';

				new Gutenberghub_Plugins();

				static::$loaded = true;
			}
		}
	}

	new Gutenberghub_SDK();

}
