<?php
/**
 * Plugin Name:       Query Loop Post Selector
 * Description:       A native query loop extension that adds a new option in the filter that allows user to specifically pick certain posts to display
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           1.0.5
 * Tested up to:      6.7
 * Author:            Small Plugins
 * Author URI:        https://smallplugins.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       query-loop-post-selector
 *
 * @package           QueryLoopPostSelector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'QLPSP_DIR_PATH' ) ) {
	define( 'QLPSP_DIR_PATH', plugin_dir_path( __FILE__ ) );
}


if ( ! defined( 'QLPSP_PLUGIN_URI' ) ) {
	define( 'QLPSP_PLUGIN_URI', plugins_url( '/', __FILE__ ) );
}

if ( ! class_exists( 'QLPSP_Query_Loop_Post_Selector' ) ) {

	/**
	 * Main Class.
	 */
	class QLPSP_Query_Loop_Post_Selector {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_assets' ) );
			add_filter( 'query_loop_block_query_vars', array( $this, 'apply_query' ), 10, 3 );

			// Using init tag to make sure all post types are loaded.
			add_action(
				'init',
				function() {
					$post_types = get_post_types();
					// Adding rest api support for all post types.
					foreach ( $post_types as $post_type ) {
						add_filter( sprintf( 'rest_%s_query', $post_type ), array( $this, 'add_rest_support' ), 10, 2 );
					};
				},
				12
			);

		}

		/**
		 * Applies the query on the frontend query loop block.
		 *
		 * @param array    $query - Current Query arguments.
		 * @param WP_Block $block - Block instance.
		 * @return array - Updated query arguments.
		 */
		public function apply_query( $query, $block ) {
			$selective_posts = isset( $block->context['query']['qlpspSelectivePosts'] ) ? $block->context['query']['qlpspSelectivePosts'] : array();

			// Check 1: Checking if there are any posts selected.
			if ( 0 === count( $selective_posts ) ) {
				return $query;
			}

			$post_ids = array_map(
				function ( $post ) {
					return isset( $post['id'] ) ? $post['id'] : -1;
				},
				$selective_posts
			);

			$query['orderby']  = 'post__in';
			$query['post__in'] = $post_ids;

			return $query;
		}

		/**
		 * Enable support for the query in the editor via rest api.
		 *
		 * @param array           $args - Arguments.
		 * @param WP_REST_Request $request - Request.
		 *
		 * @return array - Modified query arguments.
		 */
		public function add_rest_support( $args, $request ) {

			$has_selective_posts = $request->has_param( 'qlpspSelectivePosts' );

			if ( ! $has_selective_posts ) {
				return $args;
			}

			$selective_posts = $request->get_param( 'qlpspSelectivePosts' );
			$post_ids        = array_map(
				function ( $post ) {
					return isset( $post['id'] ) ? $post['id'] : -1;
				},
				$selective_posts
			);

			$args['orderby']  = 'post__in';
			$args['post__in'] = $post_ids;

			return $args;
		}

		/**
		 * Enqueues the necessary extension assets.
		 *
		 * @return void
		 */
		public function enqueue_assets() {
			wp_enqueue_script( 'small-plugins-query-loop-post-selector', QLPSP_PLUGIN_URI . 'build/index.js', array( 'lodash', 'wp-block-editor', 'wp-components', 'wp-compose', 'wp-data', 'wp-element', 'wp-hooks', 'wp-i18n', 'wp-dom' ), 'initial', true );
		}
	}

	new QLPSP_Query_Loop_Post_Selector();
}
