<?php
/**
 * Plugin Name:       Tabs
 * Description:       Introducing the "Tabs Block" plugin for WordPress – your key to flexibility and creativity! This versatile block lets you add any blocks inside for content and provides unique features like separate tabs buttons and tab content blocks, empowering you to design layouts just the way you want. Plus, with the Collapsible block, you can hide content for inactive tabs buttons, revealing it only when the corresponding tab is active. Enjoy the freedom of great styling options to make your tabs stand out effortlessly. Unleash your content presentation like never before!
 * Requires at least: 6.1
 * Tested up to: 6.2
 * Requires PHP:      7.3
 * Version:           1.0.0
 * Author:            GutenbergHub
 * Author URI:  https://shop.gutenberghub.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gutenberghub-tabs
 *
 * @package           Gutenberghub_Tabs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'GUTENBERGHUB_TABS_DIR_PATH' ) ) {
	define( 'GUTENBERGHUB_TABS_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'GUTENBERGHUB_TABS_URL' ) ) {
	define( 'GUTENBERGHUB_TABS_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'GUTENBERGHUB_TABS_FILE' ) ) {
	define( 'GUTENBERGHUB_TABS_FILE', __FILE__ );
}

// Gutenberg SDK.
require_once GUTENBERGHUB_TABS_DIR_PATH . 'gutenberghub-sdk/loader.php';

/**
 * Initialises the block.
 */
function gutenberghub_tabs_block_init() {
	register_block_type( __DIR__ . '/build/blocks/tab-container' );
	register_block_type( __DIR__ . '/build/blocks/tab-buttons-container' );
	register_block_type( __DIR__ . '/build/blocks/tab-contents-container' );
	register_block_type( __DIR__ . '/build/blocks/tab-button' );
	register_block_type( __DIR__ . '/build/blocks/tab-collapsible' );
	register_block_type( __DIR__ . '/build/blocks/tab-content' );

	require_once GUTENBERGHUB_TABS_DIR_PATH . 'includes/gutenberghub-tabs-block-patterns.php';

	wp_register_script(
		'gutenberghub-tabs-frontend-script',
		GUTENBERGHUB_TABS_URL . 'scripts/frontend.js',
		array(),
		uniqid(),
		false
	);
}

add_action( 'init', 'gutenberghub_tabs_block_init' );

add_filter(
	'block_categories_all',
	function( $categories ) {
		// Check if "GutenbergHub" category already exists.
		foreach ( $categories as $category ) {
			if ( 'ghub-products' === $category['slug'] ) {
				// "GutenbergHub" category already exists, do not add again.
				return $categories;
			}
		}

			// Adding "GutenbergHub" category.
			$categories[] = array(
				'slug'  => 'ghub-products',
				'title' => 'GutenbergHub',
			);

			return $categories;
	}
);
