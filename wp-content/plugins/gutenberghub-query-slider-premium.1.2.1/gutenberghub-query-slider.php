<?php

/**
 * Plugin Name:       Query Slider
 * Description:       The Query Slider Block enhances the default WordPress Post block by transforming it into a slider format, offering a more engaging way to display images in your posts or pages.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           1.2.1
 * Author:            GutenbergHub
 * Author URI:        https://shop.gutenberghub.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gutenberghub-query-slider-ext
 *
 */
if (!defined('ABSPATH')) {
	die('No direct access');
}

if (!defined('GUTENBERGHUB_QUERY_SLIDER_BLOCK_PATH')) {
	define('GUTENBERGHUB_QUERY_SLIDER_BLOCK_PATH', plugin_dir_path(__FILE__));
}

if (!defined('GUTENBERGHUB_QUERY_SLIDER_BLOCK_EXT')) {
	define('GUTENBERGHUB_QUERY_SLIDER_BLOCK_EXT', plugins_url('/', __FILE__));
}

require_once GUTENBERGHUB_QUERY_SLIDER_BLOCK_PATH . "gutenberghub-sdk/loader.php";
add_action('init', function () {
	require_once GUTENBERGHUB_QUERY_SLIDER_BLOCK_PATH . "includes/function.php";

	wp_register_script(
		"gutenberghub-query-slider-plugin-script",
		GUTENBERGHUB_QUERY_SLIDER_BLOCK_EXT . 'build/index.js',
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
		"gutenberghub-query-slider-plugin-cdn-script",
		GUTENBERGHUB_QUERY_SLIDER_BLOCK_EXT . 'scripts/slider.js',
		array(),
		uniqid()
	);

	wp_register_script(
		"gutenberghub-query-slider-plugin-frontend-script",
		GUTENBERGHUB_QUERY_SLIDER_BLOCK_EXT . 'scripts/frontend.js',
		array(),
		uniqid()
	);
	wp_register_style(
		'gutenberghub-query-slider-plugin-editor-style',
		GUTENBERGHUB_QUERY_SLIDER_BLOCK_EXT . 'build/index.css',
		array(),
		uniqid()
	);

	wp_register_style(
		'gutenberghub-query-slider-plugin-frontend-style',
		GUTENBERGHUB_QUERY_SLIDER_BLOCK_EXT . 'build/style-index.css',
		array(),
		uniqid()
	);
});

function query_slider_custom_block_args($args, $block_type) {
	// Check if it's the specific block type you want to modify
	if ('core/query' === $block_type) {
		$current_provided_editor_style = isset($args['editor_style_handles']) ? $args['editor_style_handles'] : array();
		$current_provided_editor_scripts = isset($args['editor_script_handles']) ? $args['editor_script_handles'] : array();

		$args['editor_style_handles'] = array_merge($current_provided_editor_style, array('gutenberghub-query-slider-plugin-editor-style'));
		$args['editor_script_handles'] = array_merge($current_provided_editor_scripts, array('gutenberghub-query-slider-plugin-script'));
	}
	return $args;
}
add_filter('register_block_type_args', 'query_slider_custom_block_args', 10, 2);

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
function prepare_query_id_consumption($args, $block_name) {
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
			'gutenberghubAutoPlayDelay'			=> "gutenberghubAutoPlayDelay",
			'ghubSpeed'			               => "ghubSpeed",
			'ghubLoopOn'			           	=> "ghubLoopOn",
			'gutenberghubHeight'			    	=> "gutenberghubHeight",
			'gutenberghubPauseOnHover' 			=> 'gutenberghubPauseOnHover',
			'gutenberghubAutoPlayOn' 			=> 'gutenberghubAutoPlayOn',
			'gutenberghubNavigationOn' 			=> 'gutenberghubNavigationOn',
			'gutenberghubIndicatorOn'			=> 'gutenberghubIndicatorOn',
			'gutenberghubSlidesGap'				=> 'gutenberghubSlidesGap',
			'navigationColor'					=> 'navigationColor',
			'paginationColor'					=> 'paginationColor',
			'inActivePaginationColor'			=> 'inActivePaginationColor',
			'sliderDirection'					=> 'sliderDirection',
			'gutenberghubNavigationIcon'	    		=> 'gutenberghubNavigationIcon',
			'gutenberghubNavigationVerticalAlign'	=> 'gutenberghubNavigationVerticalAlign',
			'gutenberghubNavigationJustification'	=> 'gutenberghubNavigationJustification',
			'gutenberghubNavigationSize'	   		=> 'gutenberghubNavigationSize',
			'gutenberghubIndicatorStyle'	   		=> 'gutenberghubIndicatorStyle',
			'gutenberghubIndicatorVerticalAlign' 	=> 'gutenberghubIndicatorVerticalAlign',
			'gutenberghubIndicatorJustification' 	=> 'gutenberghubIndicatorJustification',
			'gutenberghubIndicatorSize'	          => 'gutenberghubIndicatorSize',
			'ghubSlideBgColor'	                 	=> 'ghubSlideBgColor',
			'ghubSlidePadding'	                 	=> 'ghubSlidePadding',
			'ghubSlideRadius'	                 	=> 'ghubSlideRadius',
			'ghubSlideBorder'	                 	=> 'ghubSlideBorder',
			'gutenberghubVariation'              	=> 'gutenberghubVariation',
			'navigationBorderRadius'				=> 'navigationBorderRadius',
			'navigationBgColor'					=> 'navigationBgColor',
			'navigationBorder'					=> 'navigationBorder',
			'ghubQueryId' 						=> 'ghubQueryId'
		));
	} else {
		$current_use_context  = isset($args['uses_context']) ? $args['uses_context'] : array();
		$args['uses_context'] = array_merge($current_use_context, array(
			'gutenberghubAutoPlayDelay',
			'ghubLoopOn',
			'ghubSpeed',
			'gutenberghubPauseOnHover',
			'gutenberghubAutoPlayOn',
			'gutenberghubNavigationOn',
			'gutenberghubIndicatorOn',
			'gutenberghubSlidesGap',
			'navigationColor',
			'paginationColor',
			'inActivePaginationColor',
			'sliderDirection',
			'gutenberghubNavigationIcon',
			'gutenberghubNavigationVerticalAlign',
			'gutenberghubNavigationJustification',
			'gutenberghubNavigationSize',
			'gutenberghubIndicatorStyle',
			'gutenberghubIndicatorVerticalAlign',
			'gutenberghubIndicatorJustification',
			'gutenberghubIndicatorSize',
			'gutenberghubHeight',
			'ghubSlideBgColor',
			'ghubSlidePadding',
			'ghubSlideRadius',
			'ghubSlideBorder',
			'gutenberghubVariation',
			'navigationBorderRadius',
			'navigationBorder',
			'navigationBgColor',
			'ghubQueryId'
		));
	}

	return $args;
}
add_filter('register_block_type_args',  'prepare_query_id_consumption', 10, 2);


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

	if (!array_key_exists('gutenberghubVariation', $block_instance->context) || (array_key_exists('gutenberghubVariation', $block_instance->context) && 'ghub-query-slider' !== $block_instance->context['gutenberghubVariation'])) {
		return $raw_block_content;
	}
	wp_enqueue_script('gutenberghub-query-slider-plugin-cdn-script');
	wp_enqueue_style('gutenberghub-query-slider-plugin-frontend-style');
	wp_enqueue_script('gutenberghub-query-slider-plugin-frontend-script');

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
		$content .= '<div class="swiper-slide ' . esc_attr($post_classes) . '"> <div class="ghub-inner-content"> ' . $block_content . '</div></div>';
		wp_reset_postdata();
	}
	$style = sprintf(
		'%1$s',
		""
	);
	$datasets = gutenberghub_get_query_slider_datasets($block_instance->context);

	$block_elements  = explode('<div', $block_content);


	/**
	 * 
	 * Block class
	 *  */

	if (strpos($block_elements[1], 'class=') !== false) {
		$block_elements[1] = preg_replace('/class="(.*?)"/', 'class="swiper-wrapper"', $block_elements[1]);
	} else {
		$block_elements[1] = ' class="swiper-wrapper"' . $block_elements[1];
	}
	/**
	 *
	 * Block styles 
	 */
	if (strpos($block_elements[1], 'style=') !== false) {
		$block_elements[1] = preg_replace('/style="(.*?)"/', 'style="$1; ' . $style . '"', $block_elements[1]);
	} else {
		$block_elements[1] = ' style="' . $style . '"' . $block_elements[1];
	}

	$block_content = implode('<div', $block_elements);

	/**
	 * Slider pagination
	 */
	$pagination = get_gutenberghub_query_slider_pagination($attributes);

	/**
	 * Slider navigation
	 */
	$navigation = get_gutenberghub_query_slider_navigation($attributes);
	$splitted_border = gutenberghub_split_border($attributes, "ghubSlideBorder");

	$styleVariables = sprintf(
		'style="%1$s%2$s%3$s%4$s%5$s%6$s%7$s%8$s%9$s%10$s%11$s%12$s%13$s%14$s%15$s%16$s%17$s%18$s"',
		array_key_exists('navigationColor', $attributes) ? '--ghub-slider-navigation-color:' . $attributes['navigationColor'] . ';' : "", //1
		array_key_exists('gutenberghubNavigationSize', $attributes) ? '--ghub-slider-navigation-size:' . $attributes['gutenberghubNavigationSize'] . ';' : "", //2
		array_key_exists('paginationColor', $attributes) ? '--ghub-slider-pagination-color:' . $attributes['paginationColor'] . ';' : "--ghub-slider-pagination-color: #0693E3;", //3
		array_key_exists('inActivePaginationColor', $attributes) ? '--swiper-pagination-bullet-inactive-color:' . $attributes['inActivePaginationColor'] . ';' : '--swiper-pagination-bullet-inactive-color: #cccccc;', //4
		array_key_exists('gutenberghubIndicatorSize', $attributes) ? '--swiper-pagination-bullet-size:' . $attributes['gutenberghubIndicatorSize'] . ';' : "", //5
		array_key_exists('ghubSlideBgColor', $attributes) ? '--ghub-slide-bg-color:' . $attributes['ghubSlideBgColor'] . ';' : "", //6
		array_key_exists('ghubSlidePadding', $attributes) && array_key_exists('top', $attributes['ghubSlidePadding']) ? '--ghub-slide-padding-top:' . $attributes['ghubSlidePadding']['top'] . ';' : "", //7
		array_key_exists('ghubSlidePadding', $attributes) && array_key_exists('left', $attributes['ghubSlidePadding']) ? '--ghub-slide-padding-left:' . $attributes['ghubSlidePadding']['left'] . ';' : "", //8
		array_key_exists('ghubSlidePadding', $attributes) && array_key_exists('bottom', $attributes['ghubSlidePadding']) ? '--ghub-slide-padding-bottom:' . $attributes['ghubSlidePadding']['bottom'] . ';' : "", //9
		array_key_exists('ghubSlidePadding', $attributes) && array_key_exists('right', $attributes['ghubSlidePadding']) ? '--ghub-slide-padding-right:' . $attributes['ghubSlidePadding']['right'] . ';' : "", //10
		array_key_exists('ghubSlideRadius', $attributes) && array_key_exists('top', $attributes['ghubSlideRadius']) ? '--ghub-slide-radius-top-left:' . $attributes['ghubSlideRadius']['top'] . ';' : "", //11
		array_key_exists('ghubSlideRadius', $attributes) && array_key_exists('right', $attributes['ghubSlideRadius']) ? '--ghub-slide-radius-top-right:' . $attributes['ghubSlideRadius']['right'] . ';' : "", //12
		array_key_exists('ghubSlideRadius', $attributes) && array_key_exists('bottom', $attributes['ghubSlideRadius']) ? '--ghub-slide-radius-bottom-left:' . $attributes['ghubSlideRadius']['bottom'] . ';' : "", //13
		array_key_exists('ghubSlideRadius', $attributes) && array_key_exists('right', $attributes['ghubSlideRadius']) ? '--ghub-slide-radius-bottom-right:' . $attributes['ghubSlideRadius']['left'] . ';' : "", //14
		array_key_exists('top', $splitted_border) ? gutenberghub_apply_border_variable($splitted_border, 'top', 'slide') : "", //15
		array_key_exists('right', $splitted_border) ? gutenberghub_apply_border_variable($splitted_border, 'right', 'slide') : "", //16
		array_key_exists('bottom', $splitted_border) ? gutenberghub_apply_border_variable($splitted_border, 'bottom', 'slide') : "", //17
		array_key_exists('left', $splitted_border) ? gutenberghub_apply_border_variable($splitted_border, 'left', 'slide') : "", //18	
	);

	return sprintf(
		'<div class="ghub-slider-container %9$s" data-pagekey="%6$s" data-maxpages="%10$s" data-totalpages="%7$s" %2$s %8$s>
				<div class="swiper-wrapper">%1$s</div>
					%4$s
					%3$s
		</div>',
		$content, //1
		$datasets, //2
		array_key_exists('gutenberghubIndicatorOn', $attributes) && true === $attributes['gutenberghubIndicatorOn'] ? $pagination : "", //3
		!array_key_exists('gutenberghubNavigationOn', $attributes) || false !== $attributes['gutenberghubNavigationOn'] ? $navigation : "", // 4
		array_key_exists('align', $attributes) ? ' align' . $attributes['align'] : '', //5
		add_query_arg($page_key, ''), //6
		ceil($query->found_posts / $per_page), //7
		$styleVariables, //8
		array_key_exists('gutenberghubHeight', $attributes) ?  sprintf('ghub-slider-%1$s', $attributes['gutenberghubHeight']) : 'ghub-slider-equal', //9
		array_key_exists('pages', $attributes['query']) && !empty($attributes['query']['pages']) ? $attributes['query']['pages'] : '-1', //1

	);
}, 10, 3);
