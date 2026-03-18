<?php
/**
 * No Installed Plugins View.
 *
 * @package GutenberghubCompanion
 */

/**
 * Renders the no installed plugins screen.
 */
class Gutenberghub_No_Installed_Plugins {

	/**
	 * Renders the form.
	 *
	 * @return void
	 */
	public static function render() {
		?>
			<h1><?php esc_html_e( 'No Gutenberghub Plugins Found', 'gutenberghub-sdk' ); ?></h1>
			<p><?php esc_html_e( 'You don\'t have any gutenberghub plugins activated on your site.', 'gutenberghub-sdk' ); ?></p>
		<?php
	}

};
