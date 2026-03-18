<?php
/**
 * Installed Plugins License Form.
 *
 * @package GutenberghubCompanion
 */

/**
 * Renders the installed plugins license form.
 */
class Gutenberghub_Installed_Plugins_License_Form {

	/**
	 * Renders the form.
	 *
	 * @return void
	 */
	public static function render() {
		static::handle_submission();

		$installed_plugins = Gutenberghub_Plugins::get_installed_plugins();
		$current_plugin    = Gutenberghub_Plugins::get_current_instance();

		if ( 0 === count( $installed_plugins ) ) {
			Gutenberghub_No_Installed_Plugins::render();
			return;
		}

		?>
			<form class="gutenberghub-license-form" method="post">
			<h1><?php esc_html_e( 'Manage License', 'gutenberghub-sdk' ); ?></h1>
					<p><?php esc_html_e( 'Manage licenses for all the Gutenberghub plugins here to enable updates and other features.', 'gutenberghub-sdk' ); ?></p>
				<?php wp_nonce_field( 'gutenberghub-save-license', 'nonce' ); ?>

				<div class="gutenberghub-plugins">
					<?php
					foreach ( $installed_plugins as $installed_plugin ) {

						if ( $installed_plugin->is_currupted() ) {
							continue;
						}

						$store_key = $installed_plugin->get_license_store_key();

						?>
							<div class="card gutenberghub-license-card">
								<div>
									<div class="gutenberghub-card-header">
										<h2 class="title">
											<?php echo esc_html( $installed_plugin->get_name() ); ?>
										</h2>
									</div>
									<div class="inside">
										<p><?php echo esc_html( $installed_plugin->get_description() ); ?></p>
									</div>
								</div>
								<input 
									type="password"
									name="<?php echo esc_attr( $store_key ); ?>"
									value="<?php echo esc_attr( $installed_plugin->get_license_key() ); ?>" 
									placeholder="<?php esc_html_e( 'Enter your license key', 'gutenberghub-sdk' ); ?>" 
								/>
							</div>
						<?php

					}

					?>

				</div>

				<button class="button button-primary gutenberghub-submit">
					<?php esc_html_e( 'Save Changes', 'gutenberghub-sdk' ); ?>
				</button>
			</form>
		<?php
	}

	/**
	 * Handles the necessary submissions.
	 *
	 * @return void
	 */
	private static function handle_submission() {
		$installed_plugins = Gutenberghub_Plugins::get_installed_plugins();

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		if ( false === wp_verify_nonce( $nonce, 'gutenberghub-save-license' ) ) {
			return;
		}

		foreach ( $installed_plugins as $installed_plugin ) {
			$store_key      = $installed_plugin->get_license_store_key();
			$has_submission = isset( $_POST[ $store_key ] );

			if ( false === $has_submission ) {
				continue;
			}

			$new_value = sanitize_text_field( wp_unslash( $_POST[ $store_key ] ) );
			$installed_plugin->update_license_key( $new_value );

		}
	}

	/**
	 * Enqueues the necessary assets for the view.
	 *
	 * @return void
	 */
	public static function enqueue_assets() {
		wp_enqueue_style(
			'gutenberghub-license-form',
			GHUB_SDK_PLUGIN_URL . 'css/gutenberghub-license-form.css',
			array(),
			'initial'
		);
	}
};
