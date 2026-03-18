<?php
/**
 * Gutenberghub Plugin.
 *
 * @package GutenberghubCompanion
 */

/**
 * All singular plugin related functionalities is provided from this class.
 */
class Gutenberghub_Plugin {

	/**
	 * Plugin data.
	 *
	 * @var array
	 */
	public $data;

	/**
	 * Plugin path.
	 *
	 * @var string
	 */
	public $path;

	/**
	 * Constructor.
	 *
	 * @param array  $data - Plugin data.
	 * @param string $path - Plugin path.
	 *
	 * @return void
	 */
	public function __construct( $data, $path ) {
		$this->data = $data;
		$this->path = $path;

		$this->register_license_settings();
	}

	/**
	 * Constructs the dynamic storage key.
	 *
	 * @return string
	 */
	public function get_license_store_key() {
		return 'gutenberghub_product_' . $this->get_text_domain() . '_license_key';
	}

	/**
	 * Registers necessary license key settings.
	 *
	 * @return void
	 */
	public function register_license_settings() {
		register_setting(
			'gutenberghub-products-licenses',
			$this->get_license_store_key(),
			array(
				'default'           => '',
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
	}

	/**
	 * Obtains the current license key if found, otherwise false.
	 *
	 * @return string|false
	 */
	public function get_license_key() {
		return get_option( $this->get_license_store_key(), '' );
	}

	/**
	 * Updates the license key.
	 *
	 * @param string $license_key - New license key.
	 *
	 * @return bool
	 */
	public function update_license_key( $license_key ) {
		return update_option( $this->get_license_store_key(), $license_key );
	}

	/**
	 * Check if the current plugin has license key.
	 *
	 * @return bool
	 */
	public function has_license_key() {
		return '' !== $this->get_license_key();
	}

	/**
	 * Obtains the current text domain.
	 *
	 * @return string|false
	 */
	public function get_text_domain() {
		return $this->data['TextDomain'];
	}

	/**
	 * Obtains the plugin version.
	 *
	 * @return string
	 */
	public function get_version() {
		return $this->data['Version'];
	}

	/**
	 * Checks if the plugin is currupted.
	 *
	 * Note: A plugin is considered to be currupted when the data is incomplete.
	 *
	 * @return string
	 */
	public function is_currupted() {
		$curruption_status = false;

		if ( ! isset( $this->data['Title'] ) || ! isset( $this->data['TextDomain'] ) || ! isset( $this->data['Version'] ) ) {
			$curruption_status = true;
		}

		return $curruption_status;
	}

	/**
	 * Obtains the plugin name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->data['Title'];
	}

	/**
	 * Obtains the plugin directory name.
	 *
	 * @return string
	 */
	public function get_dir() {
		$path_chunks = explode( '/', $this->path );
		$path_chunks = reset( $path_chunks );
		return $path_chunks;
	}

	/**
	 * Obtains the plugin description.
	 *
	 * @return string
	 */
	public function get_description() {
		return $this->data['Description'];
	}

	/**
	 * Checks if the plugin is activated.
	 *
	 * @return bool
	 */
	public function is_active() {
		return is_plugin_active( $this->path );
	}

	/**
	 * Provides the sdk metadata
	 *
	 * @return array|false - Metadata if found, otherwise false if no sdk found.
	 */
	public function get_sdk_metadata() {

		$directory   = $this->get_dir();
		$plugin_root = ABSPATH . 'wp-content/plugins/' . $directory;

		$sdk_metadata_path = $plugin_root . '/gutenberghub-sdk/sdk.json';

		// Exiting if the metadata not found.
		if ( ! is_readable( $sdk_metadata_path ) || ! file_exists( $sdk_metadata_path ) ) {
			return false;
		}

		$metadata = file_get_contents( $sdk_metadata_path );
		$metadata = json_decode( $metadata, true );

		return $metadata;
	}

	/**
	 * Checks if it's the current plugin the SDK is working from.
	 *
	 * @return bool - True if current plugin, otherwise false.
	 */
	public function is_current_plugin() {
		$directory = $this->get_dir();
		return false !== stripos( __DIR__, $directory );
	}
};
