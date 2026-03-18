<?php

/**
 * Plugin Name:       Breadcrumbs
 * Description:       A straightforward block that enables the use of breadcrumb trails and is compatible with JSON-LD structured data.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            GutenbergHub
 * Author URI:        https://shop.gutenberghub.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gutenberghub-breadcrumbs
 *
 * @package           ghub-breadcrumbs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/includes/gutenberghub-breadcrumbs.php';
require_once plugin_dir_path( __FILE__ ) . 'gutenberghub-sdk/loader.php';



/**
 * Provides the icon from slug.
 *
 * @param string $slug - Icon slug.
 * @return string|false - Icon if found, otherwise false.
 */
function gbr_get_icon( $slug ) {
	$path = __DIR__ . '/assets/icons/' . $slug . '.svg';

	if ( is_readable( $path ) ) {
		return file_get_contents( $path );
	}

	return false;
}

add_action(
	'init',
	function() {
		register_block_type_from_metadata(
			__DIR__ . '/build/block.json',
			array(
				'render_callback' => function ( $attributes, $content ) {

					$separator = gbr_get_icon( $attributes['separator'] ) ?? '/';

					$content = Gutenberghub_Breadcrumbs::get_instance()->get_breadcrumb_trail(
						array(
							'separator' => $separator,
							'labels'    => array(
								'home' => $attributes['homeLabel'] ?? '',
							),
						)
					);

					$styles = array();

					if ( isset( $attributes['gap'] ) ) {
						$styles[] = '--ghub-breadcrumb-item-gap:' . $attributes['gap'] . 'px;';
					}

					$styles = count( $styles ) > 0 ? \implode( '', $styles ) : '';

					$block_classes = array( 'ghub-breadcrumb-container', 'ghub-breadcrumbs-align-' . $attributes['alignment'] );

					if ( $attributes['showCurrentPage'] ?? false ) {
						$block_classes[] = 'show-current-page';
					}

					if ( $attributes['showHomePage'] ?? false ) {
						$block_classes[] = 'show-home-page';
					}

					$wrapper_attributes = get_block_wrapper_attributes(
						array(
							'style' => $styles,
							'class' => implode( ' ', $block_classes ),
						)
					);

					return sprintf( '<div %1$s>%2$s</div>', $wrapper_attributes, $content );
				},
			)
		);

		/**
		 * Register custom category.
		 *
		 * @param array $categories - Categories.
		 * @return array - Updated categories.
		 */
		add_filter(
			'block_categories_all',
			function ( $categories ) {
				// Check if "GutenbergHub" category already exists.
				foreach ( $categories as $category ) {
					if ( 'ghub-products' === $category['slug'] ) {
						// "GutenbergHub" category already exists, do not add again
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
	}
);



