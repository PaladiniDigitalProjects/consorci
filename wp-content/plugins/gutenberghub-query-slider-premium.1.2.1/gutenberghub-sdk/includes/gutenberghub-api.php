<?php
/**
 * Gutenberghub API.
 *
 * @package GutenberghubCompanion
 */

/**
 * Handles the plugin api.
 */
class Gutenberghub_API {

	/**
	 * Plugin.
	 *
	 * @var Gutenberghub_Plugin
	 */
	public $plugin;

	/**
	 * Api Base URL.
	 *
	 * @var string
	 */
	public $api_base;

	/**
	 * Is caching allowed?.
	 *
	 * @var bool
	 */
	public $cache_allowed;

	/**
	 * Cache Key.
	 *
	 * @var string
	 */
	public $cache_key;

	/**
	 * Constructor.
	 *
	 * @param Gutenberghub_Plugin $plugin - Plugin.
	 * @param bool                $cache_allowed - Is the caching allowed?.
	 *
	 * @return void
	 */
	public function __construct( $plugin, $cache_allowed ) {
		$this->plugin        = $plugin;
		$this->cache_allowed = $cache_allowed;
		$this->cache_key     = 'gutenberghub_upgrade_cache_' . $this->plugin->path;
		$this->api_base      = 'https://shop.gutenberghub.com/wp-json';

		add_action( 'upgrader_process_complete', array( $this, 'purge' ), 10, 2 );
	}

	/**
	 * Provides the constructed api route.
	 *
	 * @param string $path - Api path.
	 * @param array  $params - Query Params.
	 *
	 * @return string
	 */
	public function route( $path, $params ) {

		$route = $this->api_base . $path;
		$route = add_query_arg(
			$params,
			$route
		);

		return $route;
	}

	/**
	 * Provides the constructed download link for the given tag.
	 *
	 * @param array $tag - Tag to generate link for.
	 *
	 * @return string Constructed url
	 */
	public function get_download_link( $tag ) {

		if ( ! isset( $tag['id'] ) ) {
			return '';
		}

		return $this->route(
			'/plugins/download/tag',
			array(
				'id'      => $tag['id'],
				'domain'  => rawurlencode( $this->plugin->get_text_domain() ),
				'license' => rawurlencode( $this->plugin->get_license_key() ),
			)
		);

	}

	/**
	 * Purges the api cache (when cached).
	 *
	 * @param WP_Upgrader $upgrader - Upgrader.
	 * @param array       $options - Extra options.
	 *
	 * @return void
	 */
	public function purge( $upgrader, $options ) {

		if (
			$this->cache_allowed
			&& 'update' === $options['action']
			&& 'plugin' === $options['type']
		) {
			// Just cleaning the cache when new plugin version is installed.
			delete_transient( $this->cache_key );
		}

	}

	/**
	 * Retrieves the plugin latest deployment tag.
	 *
	 * @return array|false - False on failure, otherwise the new tag.
	 */
	public function get_latest_tag() {

		$route = $this->route(
			'/plugins/api/update',
			array(
				'license' => rawurlencode( $this->plugin->get_license_key() ),
				'domain'  => rawurlencode( $this->plugin->get_text_domain() ),
			)
		);

		$cached_response = get_transient( $this->cache_key );

		if ( false !== $cached_response && $this->cache_allowed ) {
			return get_transient( $this->cache_key );
		}

		$response = wp_remote_request( $route );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$latest_tag = wp_remote_retrieve_body( $response );

		// Decoding the response body.
		$latest_tag = json_decode( $latest_tag, true );

		// Adding it to the transient.
		if ( $this->cache_allowed ) {
			set_transient( $this->cache_key, $latest_tag, DAY_IN_SECONDS );
		}

		return $latest_tag;
	}

};
