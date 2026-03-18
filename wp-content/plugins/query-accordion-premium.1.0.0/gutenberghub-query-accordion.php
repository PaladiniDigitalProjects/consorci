<?php

/**
 * Plugin Name:       Query Accordion
 * Description:       This query accordion block empowers you to effortlessly showcase your posts or custom post types in a sleek and engaging accordion format, capturing your audience's attention like never before.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            GutenbergHub
 * Author URI:        https://shop.gutenberghub.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gutenberghub-query-accordion-ext
 *
 */
if (!defined('ABSPATH')) {
	die('No direct access');
}

if (!defined('GUTENBERGHUB_QUERY_ACCORDION_BLOCK_PATH')) {
	define('GUTENBERGHUB_QUERY_ACCORDION_BLOCK_PATH', plugin_dir_path(__FILE__));
}

if (!defined('GUTENBERGHUB_QUERY_ACCORDION_BLOCK_EXT')) {
	define('GUTENBERGHUB_QUERY_ACCORDION_BLOCK_EXT', plugins_url('/', __FILE__));
}

require_once GUTENBERGHUB_QUERY_ACCORDION_BLOCK_PATH . "gutenberghub-sdk/loader.php";
add_action('init', function () {
	require_once GUTENBERGHUB_QUERY_ACCORDION_BLOCK_PATH . "includes/function.php";

	wp_register_script(
		"gutenberghub-query-accordion-plugin-script",
		GUTENBERGHUB_QUERY_ACCORDION_BLOCK_EXT . 'build/index.js',
		array(
			"wp-element",
			"wp-compose",
			"wp-hooks",
			"wp-block-editor",
			"wp-i18n",
			"lodash"
		),
		uniqid()
	);

	wp_register_script(
		"gutenberghub-query-accordion-plugin-frontend-script",
		GUTENBERGHUB_QUERY_ACCORDION_BLOCK_EXT . 'scripts/frontend.js',
		array(),
		uniqid()
	);

	wp_register_style(
		'gutenberghub-query-accordion-plugin-editor-style',
		GUTENBERGHUB_QUERY_ACCORDION_BLOCK_EXT . 'build/index.css',
		array(),
		uniqid()
	);

	wp_register_style(
		'gutenberghub-query-accordion-plugin-frontend-style',
		GUTENBERGHUB_QUERY_ACCORDION_BLOCK_EXT . 'build/style-index.css',
		array(),
		uniqid()
	);
});

function query_accordion_custom_block_args($args, $block_type)
{
	// Check if it's the specific block type you want to modify
	if ('core/query' === $block_type) {
		$current_provided_editor_style = isset($args['editor_style_handles']) ? $args['editor_style_handles'] : array();
		$current_provided_editor_scripts = isset($args['editor_script_handles']) ? $args['editor_script_handles'] : array();

		$args['editor_style_handles'] = array_merge($current_provided_editor_style, array('gutenberghub-query-accordion-plugin-editor-style'));
		$args['editor_script_handles'] = array_merge($current_provided_editor_scripts, array('gutenberghub-query-accordion-plugin-script'));
	}
	return $args;
}
add_filter('register_block_type_args', 'query_accordion_custom_block_args', 10, 2);

add_filter('block_categories_all', function ($categories) {
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
});

/**
 * Prepares all blocks to consume our custom query id.
 *
 * @param array  $args - Registeration arguments.
 * @param string $block_name - Block type name.
 *
 * @return array - Modified arguments to consume custom query context id.
 */
function prepare_query_accordion_id_consumption($args, $block_name)
{
	if ('core/query' === $block_name) {
		$args['attributes'] = array_merge(
			$args['attributes'],
			array(
				'ghubQueryId' => array(
					'type' => 'string',
					'default' => ''
				)
			)
		);

		$args['provides_context'] = array_merge($args['provides_context'], array(
			'gutenberghubVariation'              	=> 'gutenberghubVariation',
			'ghubQueryId' 						    => 'ghubQueryId',
			'ghubQaOrientation'	                 	=> 'ghubQaOrientation',
			'ghubQaTriggers'	                 	=> 'ghubQaTriggers',
			'ghubQaHeight'	                 	    => 'ghubQaHeight',
			'ghubQaGap'	                 	        => 'ghubQaGap',
			'ghubQaSpeed'	                 	    => 'ghubQaSpeed',
			'ghubQaActiveItemSize'	                => 'ghubQaActiveItemSize',
			'ghubQaActiveFirstItem'              	=> 'ghubQaActiveFirstItem',

		));
	} else {
		$current_use_context  = isset($args['uses_context']) ? $args['uses_context'] : array();
		$args['uses_context'] = array_merge($current_use_context, array(
			'gutenberghubVariation',
			'ghubQueryId',
			'ghubQaOrientation',
			'ghubQaTriggers',
			'ghubQaGap',
			'ghubQaSpeed',
			'ghubQaActiveItemSize',
			'ghubQaActiveFirstItem',
			'ghubQaHeight',
		));
	}

	return $args;
}
add_filter('register_block_type_args',  'prepare_query_accordion_id_consumption', 10, 2);


/**
 * @param string 	$raw_block_content - Block Content.
 * @param array 	$block - Parsed Block.
 * @param WP_Block 	$block_instance - Parsed Block instance.
 * 
 * @return string - Rendered query block.
 */
add_filter("render_block", function ($raw_block_content, $block, $block_instance) {


	if ('core/post-template' !== $block_instance->name) {
		return $raw_block_content;
	}

	if (!array_key_exists('gutenberghubVariation', $block_instance->context) || (array_key_exists('gutenberghubVariation', $block_instance->context) && 'ghub-query-accordion' !== $block_instance->context['gutenberghubVariation'])) {
		return $raw_block_content;
	}

	wp_enqueue_style('gutenberghub-query-accordion-plugin-frontend-style');
	wp_enqueue_script('gutenberghub-query-accordion-plugin-frontend-script');

	$attributes = $block_instance->context;

	/**
	 * Dynamic Query
	 */
	// Use global query if needed.
	$use_global_query = (isset($block_instance->context['query']['inherit']) && $block_instance->context['query']['inherit']);

	/**
	 * @var WP_Query - Query.
	 */
	$query = null;
	$page_key = isset($block_instance->context['queryId']) ? 'query-' . $block_instance->context['queryId'] . '-page' : 'query-page';
	$page     = empty($_GET[$page_key]) ? 1 : (int) $_GET[$page_key];
	$per_page = (int) $block_instance->context['query']['perPage'];
	$pages = (int) $block_instance->context['query']['pages'];

	if ($use_global_query) {
		global $wp_query;
		$query =  $wp_query;
	} else {
		$query_args = build_query_vars_from_query_block($block_instance, $page);
		$query_args['paged'] = $page;
		$query_args['posts_per_page'] = $per_page;

		$query      = new WP_Query($query_args);
	}

	$content = '';
	$posts = 1;

	while ($query->have_posts() && $per_page >= $posts) {
		$posts++;
		$query->the_post();

		$featured_image =  get_the_post_thumbnail_url(get_the_ID());

		// Get an instance of the current Post Template block.
		$block_instance_parsed = $block_instance->parsed_block;

		// Set the block name to one that does not correspond to an existing registered block.
		// This ensures that for the inner instances of the Post Template block, we do not render any block supports.
		$block_instance_parsed['blockName'] = 'core/null';

		// Render the inner blocks of the Post Template block with `dynamic` set to `false` to prevent calling
		// `render_callback` and ensure that no wrapper markup is included.
		$block_content = (new WP_Block(
			$block_instance_parsed,
			array(
				'postType' => get_post_type(),
				'postId'   => get_the_ID()
			)
		)
		)->render(array('dynamic' => true));

		$post_classes = implode(' ', get_post_class('wp-block-post'));
		$content .= '<div class="ghub-query-accordion-item-container ' . esc_attr($post_classes) . '"> <div class="ghub-inner-content"> ' . $block_content . '</div></div>';
		wp_reset_postdata();
	}

	$style = sprintf(
		'%1$s',
		""
	);

	$datasets = gutenberghub_get_query_accordion_datasets($block_instance->context);

	$styleVariables  = gutenberghub_style_variables($attributes);

	return sprintf(
		'<div class="ghub-query-accordion-container %4$s" %2$s %3$s>
			%1$s
		</div>',
		$content, //1
		$datasets, //2
		$styleVariables, //3
		array_key_exists('ghubQaOrientation', $attributes) ? 'ghub-qa-accordion-orientation-' . $attributes['ghubQaOrientation'] : 'ghub-qa-accordion-orientation-horizontal' //4
	);
}, 10, 3);
