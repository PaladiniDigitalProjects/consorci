<?php
/**
 * Admin.
 *
 * @package GutenbergHubSDK
 */

/**
 * Class that handles admin related functionalities.
 */
class Gutenberghub_Admin {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		$this->add_license_shortcut();
	}

	/**
	 * Registers the admin page.
	 *
	 * @return void
	 */
	public function register_admin_page() {
		add_menu_page(
			__( 'GutenbergHub', 'gutenberghub-sdk' ),
			__( 'GutenbergHub', 'gutenberghub-sdk' ),
			'manage_options',
			'gutenberghub',
			array( Gutenberghub_Installed_Plugins_License_Form::class, 'render' ),
			'dashicons-admin-generic'
		);
	}

	/**
	 * Adds a license shortcut to the plugin.
	 *
	 * @return void
	 */
	public function add_license_shortcut() {
		foreach ( Gutenberghub_Plugins::get_installed_plugins() as $gutenberghub_plugin ) {
			add_action(
				'plugin_action_links_' . $gutenberghub_plugin->path,
				/**
				 * Adding a shortcut link.
				 *
				 * @param string[] $actions - An array of existing plugin actions.
				 * @return string[] - An array of new plugin actions.
				 */
				function( $actions ) use ( $gutenberghub_plugin ) {

					$shortcut  = sprintf(
						'<a href="%1$s">%2$s</a>',
						admin_url( 'admin.php?page=gutenberghub' ),
						$gutenberghub_plugin->has_license_key() ? __( 'Manage License', 'gutenberghub-sdk' ) : __( 'Activate License', 'gutenberghub-sdk' )
					);
					$actions[] = $shortcut;

					return $actions;
				},
				10,
				1
			);
		}
	}

	/**
	 * Loads the necessary assets.
	 *
	 * @param string $hook_suffix - Admin page suffix.
	 *
	 * @return void
	 */
	public function load_assets( $hook_suffix ) {

		if ( 'toplevel_page_gutenberghub' === $hook_suffix ) {
			Gutenberghub_Installed_Plugins_License_Form::enqueue_assets();
		}

	}

};

new Gutenberghub_Admin();
