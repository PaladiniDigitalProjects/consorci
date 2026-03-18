<?php
/**
 * Gutenberghub Plugins.
 *
 * @package GutenberghubCompanion
 */

/**
 * All plugins related functionalities is provided from this class.
 */
class Gutenberghub_Plugins {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'initialize_upgrader' ) );
	}

	/**
	 * Initialises the plugin upgrader.
	 *
	 * @return void
	 */
	public function initialize_upgrader() {
		$raw_installed_plugins = static::get_installed_plugins();

		foreach ( $raw_installed_plugins as $gutenberghub_plugin ) {
			new Gutenberghub_Upgrader( $gutenberghub_plugin );
		}
	}

	/**
	 * Provides the current plugin instance.
	 *
	 * @return Gutenberghub_Plugin|false - Current plugin instance.
	 */
	public static function get_current_instance() {
		$raw_installed_plugins = static::get_installed_plugins();
		$current_plugin        = false;

		foreach ( $raw_installed_plugins as $gutenberghub_plugin ) {
			if ( $gutenberghub_plugin->is_current_plugin() ) {
				$current_plugin = $gutenberghub_plugin;
				break;
			}
		}

		return $current_plugin;
	}

	/**
	 * Obtains a list of all gutenberghub installed plugins.
	 *
	 * @param bool $skip_current - Skips the current plugin if true.
	 * @return Gutenberghub_Plugin[] - List of installed plugins.
	 */
	public static function get_installed_plugins( $skip_current = false ) {

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$raw_installed_plugins = get_plugins();
		$gutenberghub_plugins  = array();

		foreach ( $raw_installed_plugins as $plugin_path => $raw_installed_plugin ) {
			if ( isset( $raw_installed_plugin['AuthorName'] ) && 'gutenberghub' === strtolower( $raw_installed_plugin['AuthorName'] ) ) {
				$gutenberghub_plugin = new Gutenberghub_Plugin( $raw_installed_plugin, $plugin_path );

				// Skip inactive plugins.
				if ( false === $gutenberghub_plugin->is_active() || ( $skip_current && $gutenberghub_plugin->is_current_plugin() ) ) {
					continue;
				}

				$gutenberghub_plugins[] = $gutenberghub_plugin;
			}
		}

		return $gutenberghub_plugins;
	}

};
