<?php
/**
 * Upgrader.
 *
 * @package GutenberghubCompanion
 */

/**
 * Custom plugin upgrader.
 */
class Gutenberghub_Upgrader {

	/**
	 * Plugin.
	 *
	 * @var Gutenberghub_Plugin
	 */
	public $plugin;

	/**
	 * Plugin API.
	 *
	 * @var Gutenberghub_API
	 */
	public $api;

	/**
	 * Constructor.
	 *
	 * @param Gutenberghub_Plugin $plugin - Plugin.
	 *
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		$this->api = new Gutenberghub_API( $plugin, true );
		add_filter( 'plugins_api', array( $this, 'get_info' ), 20, 3 );
		add_filter( 'site_transient_update_plugins', array( $this, 'update' ) );
	}

	/**
	 * Obtains the plugin information to display.
	 *
	 * @param false|object|array $res - The result object or array. Default false.
	 * @param string             $action - The type of information being requested from the Plugin Installation API.
	 * @param object             $args - Plugin API arguments..
	 *
	 * @return stdClass - Info.
	 */
	public function get_info( $res, $action, $args ) {

		// Do nothing if you're not getting plugin information right now.
		if ( 'plugin_information' !== $action ) {
			return $res;
		}

		// Do nothing if it is not our plugin.
		if ( $this->plugin->path !== $args->slug ) {
			return $res;
		}

		$latest_tag = $this->api->get_latest_tag();

		if ( false === $latest_tag ) {
			return '';
		}

		$download_link = $this->api->get_download_link( $latest_tag );
		$res           = new stdClass();

		$res->name           = $this->plugin->get_name();
		$res->slug           = $this->plugin->path;
		$res->version        = $latest_tag['version'];
		$res->requires       = $latest_tag['requires_platform_version'];
		$res->author         = 'Gutenberghub';
		$res->author_profile = 'Gutenberghub';
		$res->download_link  = $download_link;
		$res->trunk          = $download_link;

		$res->sections = array(
			'description' => $this->plugin->get_description(),
			'changelog'   => $latest_tag['changelog'],
		);

		return $res;

	}

	/**
	 * Handles the plugin update.
	 *
	 * @param array $transient - Transient.
	 * @return stdClass - Data.
	 */
	public function update( $transient ) {

		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$latest_tag = $this->api->get_latest_tag();

		if ( false === $latest_tag || ! isset( $latest_tag['version'] ) || ! isset( $latest_tag['requires_platform_version'] ) ) {
			return $transient;
		}

		$download_link = $this->api->get_download_link( $latest_tag );

		if (
		version_compare( $this->plugin->get_version(), $latest_tag['version'], '<' )
		&& version_compare( $latest_tag['requires_platform_version'], get_bloginfo( 'version' ), '<=' )
		) {
			$res              = new stdClass();
			$res->slug        = $this->plugin->path;
			$res->plugin      = $this->plugin->path;
			$res->new_version = $latest_tag['version'];
			$res->package     = $download_link;
			$res->tested      = $latest_tag['requires_platform_version'];

			$transient->response[ $res->plugin ] = $res;

		}

		return $transient;

	}


};
