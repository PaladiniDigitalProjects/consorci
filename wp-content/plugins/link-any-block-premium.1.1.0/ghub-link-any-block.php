<?php

/**
 * Plugin Name:       Link Any Block
 * Description:       This plugin adds a simple yet powerful feature to Gutenberg, allowing users to add a link to any block. This functionality provides greater flexibility and control in creating engaging and interactive content for your website.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           1.1.0
 * Author:            GutenbergHub
 * Author URI:  	  https://shop.gutenberghub.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ghub-link-any-block
 *
 */


if (!defined('ABSPATH')) {
	die('No direct access');
}

if (!defined('GHUBLINKANYBLOCK')) {
	define('GHUBLINKANYBLOCK', plugins_url('/', __FILE__));
}

if (!defined('GHUBLINKANYBLOCK_DIR_PATH')) {
	define('GHUBLINKANYBLOCK_DIR_PATH', plugin_dir_path(__FILE__));
}

if (!class_exists('Gutenberghub_Link_Any_Block')) {
	/**
	 * Main plugin class
	 */
	final class Gutenberghub_Link_Any_Block {

		/**
		 * Constructor
		 *
		 * @return void
		 */
		public function __construct() {
			add_action('init', array($this, 'register_scripts'));
			add_action('enqueue_block_assets', array($this, 'enqueue_editor_assets'));
			add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
			add_filter('block_categories_all', array($this, 'register_category'));
			add_filter('render_block', array($this, 'render_block'), 10, 2);

			require_once GHUBLINKANYBLOCK_DIR_PATH . 'gutenberghub-sdk/loader.php';
		}
		public function register_scripts() {
			\wp_register_script(
				"ghub-link-any-block-script",
				GHUBLINKANYBLOCK . 'build/index.js',
				array(
					"lodash",
					"wp-element",
					"wp-compose",
					"wp-hooks",
					"wp-block-editor",
					"wp-i18n"
				),
				uniqid()
			);

			\wp_register_style(
				'ghub-link-any-block-editor-style',
				GHUBLINKANYBLOCK . 'build/index.css',
				array(),
				uniqid()
			);
			\wp_register_style(
				'ghub-link-any-block-frontend-style',
				GHUBLINKANYBLOCK . 'build/style-index.css',
				array(),
				uniqid()
			);
			\wp_register_script(
				'ghub-link-any-block-frontend-script',
				GHUBLINKANYBLOCK . 'scripts/frontend.js',
				array(),
				uniqid()
			);

			// Get the list of unsupported blocks
			$unsupported_blocks = array("core/paragraph", "core/heading", "core/button");

			// Get the list of supported blocks
			$supported_blocks = array();

			// Apply filters to modify the list of unsupported and supported blocks
			$unsupported_blocks = apply_filters('gutenberghub_link_any_block_unsupported_blocks', $unsupported_blocks);
			$supported_blocks = apply_filters('gutenberghub_link_any_block_supported_blocks', $supported_blocks);

			// Only use the list of unsupported blocks if the user has not filtered the list of supported blocks
			if (empty($supported_blocks)) {
				\wp_localize_script(
					'ghub-link-any-block-script',
					'ghub_link_any_block_unsupported_blocks',
					$unsupported_blocks
				);
			}
			\wp_localize_script(
				'ghub-link-any-block-script',
				'ghub_link_any_block_supported_blocks',
				$supported_blocks
			);
		}

		/**
		 * Enqueue editor assets
		 */
		public function enqueue_editor_assets() {
			\wp_enqueue_script('ghub-link-any-block-script');
			\wp_enqueue_style('ghub-link-any-block-editor-style');
		}

		/**
		 * Enqueue frontend assets
		 */
		public function enqueue_frontend_assets() {
			if (!is_admin()) {
				\wp_enqueue_style('ghub-link-any-block-frontend-style');
				\wp_enqueue_script('ghub-link-any-block-frontend-script');
			}
		}

		public function render_block($block_content, $block) {
			$unsupported_blocks = apply_filters('gutenberghub_link_any_block_unsupported_blocks', array());
			$supported_blocks = apply_filters('gutenberghub_link_any_block_supported_blocks', array());

			$should_ghub_link_apply =
				!empty($supported_blocks) ||
				count($supported_blocks) > 0
				? in_array($block['blockName'], $supported_blocks)
				: !in_array($block['blockName'], $unsupported_blocks);

			$attributes = isset($block['attrs']) ? $block['attrs'] : array();
			if (!isset($attributes['ghubLink']) || empty($attributes['ghubLink']['url']) || !$should_ghub_link_apply) {
				return $block_content;
			}

			// Find the first HTML tag in the block content
			$first_tag_start_pos = strpos($block_content, '<');
			$first_tag_end_pos = strpos($block_content, '>', $first_tag_start_pos);
			$first_tag = substr($block_content, $first_tag_start_pos, $first_tag_end_pos - $first_tag_start_pos + 1);

			// Replace the class and add data attributes to the first tag
			$replaced_string = sprintf(
				'data-ghub-url="%1$s" class="%2$s%3$s%4$shas-ghub-link ',
				$attributes['ghubLink']['url'], // 1
				isset($attributes['ghubLink']['opensInNewTab']) && $attributes['ghubLink']['opensInNewTab'] ? 'ghub-link-new-tab ' : '', // 2
				isset($attributes['ghubLink']['noOpener']) && $attributes['ghubLink']['noOpener'] ? 'ghub-link-no-opener ' : '', // 3
				isset($attributes['ghubLink']['noReferrer']) && $attributes['ghubLink']['noReferrer'] ? 'ghub-link-no-referrer ' : '', // 4
			);
			$first_tag_replaced = str_replace('class="', $replaced_string, $first_tag);
			$block_content = substr_replace($block_content, $first_tag_replaced, $first_tag_start_pos, $first_tag_end_pos - $first_tag_start_pos + 1);

			return $block_content;
		}

		/**
		 * Register custom category
		 * 
		 */
		public function register_category($categories) {
			// Check if "GutenbergHub" category already exists
			foreach ($categories as $category) {
				if ($category['slug'] === 'ghub-products') {
					// "GutenbergHub" category already exists, do not add again
					return $categories;
				}
			}

			// Adding "GutenbergHub" category.
			$categories[] = array(
				'slug'  => 'ghub-products',
				'title' => 'GutenbergHub'
			);

			return $categories;
		}
	}

	new Gutenberghub_Link_Any_Block();
}
