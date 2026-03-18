<?php
/**
 * Breadcrumbs Root.
 *
 * @package GutenberghubBreadcrumbs
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Gutenberghub_Breadcrumbs' ) ) {

	/**
	 * Main breadcrumbs class.
	 */
	class Gutenberghub_Breadcrumbs {
		/**
		 * All items belonging to the current breadcrumb trail.
		 *
		 * @var array
		 */
		protected $items = array();

		/**
		 * Arguments to build the breadcrumb trail.
		 *
		 * @var array
		 */
		protected $args = array();

		/**
		 * Plugin instance
		 *
		 * @var Breadcrumbs
		 */
		private static $instance;

		/**
		 * A dummy constructor
		 */
		private function __construct() {
			add_action( 'wp_footer', array( $this, 'render_structured_data' ) );
		}

		/**
		 * Initialize the instance.
		 *
		 * @return Gutenberghub_Breadcrumbs
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Gutenberghub_Breadcrumbs ) ) {
				self::$instance = new Gutenberghub_Breadcrumbs();
			}

			return self::$instance;
		}

		/**
		 * Add an item to the breadcrumbs trail.
		 *
		 * @param string $name Name - Item name.
		 * @param string $link Link - Item link.
		 * @param array  $attrs - Item attributes.
		 *
		 * @return void
		 */
		public function add_item( $name, $link = '', $attrs = array() ) {
			$this->items[] = array( wp_strip_all_tags( $name ), $link, $attrs );
		}


		/**
		 * Build the breadcrumb items
		 *
		 * @return array
		 */
		public function generate() {
			$conditionals = array(
				'is_home',
				'is_404',
				'is_attachment',
				'is_single',
				'is_page',
				'is_post_type_archive',
				'is_category',
				'is_tag',
				'is_author',
				'is_date',
				'is_tax',
			);

			$is_woocommerce_activated = $this->is_woocommerce_activated();
			if ( $is_woocommerce_activated ) {
				array_splice(
					$conditionals,
					4,
					0,
					array(
						'is_product_category',
						'is_product_tag',
						'is_shop',
					)
				);
			}

			if ( ( ! is_front_page() && ( ! $is_woocommerce_activated || ! ( is_post_type_archive() && intval( get_option( 'page_on_front' ) ) === wc_get_page_id( 'shop' ) ) ) ) || is_paged() ) {
				$this->add_crumbs_front_page();

				foreach ( $conditionals as $conditional ) {
					if ( call_user_func( $conditional ) ) {
						call_user_func( array( $this, 'add_crumbs_' . substr( $conditional, 3 ) ) );
						break;
					}
				}

				$this->add_search_result_trail();
				$this->add_page_trail();
			}

			return $this->get_items();
		}

		/**
		 * Get the breadcrumb items.
		 *
		 * @return array
		 */
		public function get_items() {
			return $this->items;
		}

		/**
		 * Reset the breadcrumb items.
		 *
		 * @return void
		 */
		public function reset() {
			$this->items = array();
		}

		/**
		 * Parse the arguments with the deaults.
		 *
		 * @param  array $args - Arguments.
		 * @return array
		 */
		public function parse_args( $args ) {
			// Parse args.
			$this->args = wp_parse_args(
				$args,
				array(
					'container'   => 'nav',
					'before'      => '',
					'after'       => '',
					'list_tag'    => 'ol',
					'item_tag'    => 'li',
					'item_before' => '',
					'item_after'  => '',
					'separator'   => '',
					'aria_label'  => esc_attr_x( 'Breadcrumbs', 'breadcrumb aria label', 'ghub-breadcrumb' ),
					'labels'      => array(),
					'echo'        => false,
				)
			);

			return $this->args;
		}

		/**
		 * Get the breadcrumb trail.
		 *
		 * @param  array $args - Args.
		 * @return array
		 */
		public function get_breadcrumb_trail( $args = array() ) {
			$args = $this->parse_args( $args );

			$this->reset();

			$this->generate();

			$breadcrumb = '';
			$item_count = count( $this->items );

			if ( 0 < $item_count ) {
				$breadcrumb .= $args['before'];

				$breadcrumb .= sprintf( '<%s class="gutenberghub-breadcrumb-items">', tag_escape( $args['list_tag'] ) );

				foreach ( $this->items as $key => $crumb ) {
					$item_position = $key + 1;

					$item = '';

					if ( ! empty( $crumb[1] ) && $item_count !== $item_position ) {
						$item .= sprintf( '<a href="%1$s"><span class="gutenberghub-breadcrumb-item-name">%2$s</span></a>', esc_url( $crumb[1] ), esc_html( $crumb[0] ) );
					} else {
						$item .= sprintf( '<span class="gutenberghub-breadcrumb-item-name">%1$s</span>', esc_html( $crumb[0] ) );
					}

					if ( $item_count !== $item_position && $args['separator'] ) {
						$item .= sprintf( '<span class="gutenberghub-separator">%s</span>', $args['separator'] );
					}

					$item_classes = array( 'gutenberghub-breadcrumb-item' );

					if ( $item_count === $item_position ) {
						$item_classes[] = 'gutenberghub-breadcrumb-item-current';
					} elseif ( $item_count - 1 === $item_position ) {
						$item_classes[] = 'gutenberghub-breadcrumb-item-parent';
					}

					$attributes = '';

					if ( ! empty( $crumb[2] ) ) {
						$attrs = $crumb[2];
						if ( 'home' === ( $attrs['rel'] ?? '' ) ) {
							$item_classes[] = 'gutenberghub-breadcrumb-item-home';
							unset( $attrs['rel'] );
						}

						$attributes .= array_reduce(
							array_keys( $attrs ),
							function ( $carry, $key ) use ( $attrs ) {
								return $carry . ' ' . $key . '="' . htmlspecialchars( $attrs[ $key ] ) . '"';
							},
							''
						);
					}

					$attributes = sprintf( 'class="%1$s"%2$s', \implode( ' ', $item_classes ), $attributes );

					$breadcrumb .= sprintf( '<%1$s %2$s>%3$s</%1$s>', tag_escape( $args['item_tag'] ), $attributes, $item );
				}

				$breadcrumb .= sprintf( '</%s>', tag_escape( $args['list_tag'] ) );

				$breadcrumb .= $args['after'];

				$breadcrumb = sprintf(
					'<%1$s role="navigation" aria-label="%2$s" class="gutenberghub-breadcrumb-wrap">%3$s</%1$s>',
					tag_escape( $args['container'] ),
					esc_attr( $args['aria_label'] ),
					$breadcrumb
				);
			}

			if ( false === $args['echo'] ) {
				return $breadcrumb;
			}

			// phpcs:ignore
			echo $breadcrumb;
		}

		/**
		 * Front page trail.
		 */
		protected function add_crumbs_front_page() {
			$home_label = $this->args['labels']['home'] ?? '';
			$home_text  = empty( $home_label ) ? __( 'Home', 'ghub-breadcrumb' ) : $home_label;
			$this->add_item( $home_text, esc_url( user_trailingslashit( home_url() ) ), array( 'rel' => 'home' ) );
		}

		/**
		 * Is home trail.
		 */
		protected function add_crumbs_home() {
			$this->add_item( single_post_title( '', false ), false, array( 'aria-current' => 'page' ) );
		}

		/**
		 * 404 trail.
		 */
		protected function add_crumbs_404() {
			$this->add_item( __( 'Error 404', 'ghub-breadcrumb' ), false, array( 'aria-current' => 'page' ) );
		}

		/**
		 * Attachment trail.
		 */
		protected function add_crumbs_attachment() {
			global $post;

			$this->add_crumbs_single( $post->post_parent, get_permalink( $post->post_parent ) );
			$this->add_item( get_the_title(), get_permalink(), array( 'aria-current' => 'page' ) );
		}

		/**
		 * Single post trail.
		 *
		 * @param int    $post_id   Post ID.
		 * @param string $permalink Post permalink.
		 */
		protected function add_crumbs_single( $post_id = 0, $permalink = '' ) {
			if ( ! $post_id ) {
				global $post;
			} else {
				// phpcs:ignore
				$post = get_post( $post_id );
			}

			if ( ! $permalink ) {
				$permalink = get_permalink( $post );
			}

			if ( 'product' === get_post_type( $post ) ) {
				$this->prepend_shop_page();

				$terms = wc_get_product_terms(
					$post->ID,
					'product_cat',
					array(
						'orderby' => 'parent',
						'order'   => 'DESC',
					)
				);

				if ( $terms ) {
					$main_term = $terms[0];
					$this->term_ancestors( $main_term->term_id, 'product_cat' );
					$this->add_item( $main_term->name, get_term_link( $main_term ) );
				}
			} elseif ( 'post' !== get_post_type( $post ) ) {
				$post_type = get_post_type_object( get_post_type( $post ) );

				if ( ! empty( $post_type->has_archive ) ) {
					$this->add_item( $post_type->labels->name, get_post_type_archive_link( get_post_type( $post ) ) );
				}
			} else {
				$cats = get_the_category( $post );
				if ( $cats ) {
					$cat = $cats[0];
					$this->term_ancestors( $cat->term_id, 'category' );
					$this->add_item( $cat->name, get_term_link( $cat ) );
				}
			}

			$this->add_item( get_the_title( $post ), $permalink, array( 'aria-current' => 'page' ) );
		}

		/**
		 * Product category trail.
		 */
		protected function add_crumbs_product_category() {
			$current_term = $GLOBALS['wp_query']->get_queried_object();

			$this->prepend_shop_page();
			$this->term_ancestors( $current_term->term_id, 'product_cat' );
			$this->add_item( $current_term->name, get_term_link( $current_term, 'product_cat' ) );
		}

		/**
		 * Product tag trail.
		 */
		protected function add_crumbs_product_tag() {
			$current_term = $GLOBALS['wp_query']->get_queried_object();

			$this->prepend_shop_page();

			/* translators: %s: product tag */
			$this->add_item( sprintf( __( 'Products tagged &ldquo;%s&rdquo;', 'ghub-breadcrumb' ), $current_term->name ), get_term_link( $current_term, 'product_tag' ) );
		}

		/**
		 * Shop breadcrumb.
		 */
		protected function add_crumbs_shop() {
			if ( intval( get_option( 'page_on_front' ) ) === wc_get_page_id( 'shop' ) ) {
				return;
			}

			$_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

			if ( ! $_name ) {
				$product_post_type = get_post_type_object( 'product' );
				$_name             = $product_post_type->labels->name;
			}

			$this->add_item( $_name, get_post_type_archive_link( 'product' ) );
		}

		/**
		 * Prepend the shop page to shop breadcrumbs.
		 */
		protected function prepend_shop_page() {
			$permalinks   = wc_get_permalink_structure();
			$shop_page_id = wc_get_page_id( 'shop' );
			$shop_page    = get_post( $shop_page_id );

			// If permalinks contain the shop page in the URI prepend the breadcrumb with shop.
			if ( $shop_page_id && $shop_page && isset( $permalinks['product_base'] ) && strstr( $permalinks['product_base'], '/' . $shop_page->post_name ) && intval( get_option( 'page_on_front' ) ) !== $shop_page_id ) {
				$this->add_item( get_the_title( $shop_page ), get_permalink( $shop_page ) );
			}
		}

		/**
		 * Page trail.
		 */
		protected function add_crumbs_page() {
			global $post;

			if ( $post->post_parent ) {
				$parent_crumbs = array();
				$parent_id     = $post->post_parent;

				while ( $parent_id ) {
					$page            = get_post( $parent_id );
					$parent_id       = $page->post_parent;
					$parent_crumbs[] = array( get_the_title( $page->ID ), get_permalink( $page->ID ) );
				}

				$parent_crumbs = array_reverse( $parent_crumbs );

				foreach ( $parent_crumbs as $crumb ) {
					$this->add_item( $crumb[0], $crumb[1] );
				}
			}

			$this->add_item( get_the_title(), get_permalink(), array( 'aria-current' => 'page' ) );
		}

		/**
		 * Post type archive trail.
		 */
		protected function add_crumbs_post_type_archive() {
			$post_type = get_post_type_object( get_post_type() );

			if ( $post_type ) {
				$this->add_item( $post_type->labels->name, get_post_type_archive_link( get_post_type() ) );
			}
		}

		/**
		 * Category trail.
		 */
		protected function add_crumbs_category() {
			$this_category = get_category( $GLOBALS['wp_query']->get_queried_object() );

			if ( 0 !== intval( $this_category->parent ) ) {
				$this->term_ancestors( $this_category->term_id, 'category' );
			}

			$this->add_item( single_cat_title( '', false ), get_category_link( $this_category->term_id ) );
		}

		/**
		 * Tag trail.
		 */
		protected function add_crumbs_tag() {
			$queried_object = $GLOBALS['wp_query']->get_queried_object();

			/* translators: %s: tag name */
			$this->add_item( sprintf( __( 'Posts tagged &ldquo;%s&rdquo;', 'ghub-breadcrumb' ), single_tag_title( '', false ) ), get_tag_link( $queried_object->term_id ) );
		}

		/**
		 * Add crumbs for date based archives.
		 */
		protected function add_crumbs_date() {
			if ( is_year() || is_month() || is_day() ) {
				$this->add_item( get_the_time( 'Y' ), get_year_link( get_the_time( 'Y' ) ) );
			}
			if ( is_month() || is_day() ) {
				$this->add_item( get_the_time( 'F' ), get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) );
			}
			if ( is_day() ) {
				$this->add_item( get_the_time( 'd' ) );
			}
		}

		/**
		 * Add crumbs for taxonomies
		 */
		protected function add_crumbs_tax() {
			$this_term = $GLOBALS['wp_query']->get_queried_object();
			$taxonomy  = get_taxonomy( $this_term->taxonomy );

			$this->add_item( $taxonomy->labels->name );

			if ( 0 !== intval( $this_term->parent ) ) {
				$this->term_ancestors( $this_term->term_id, $this_term->taxonomy );
			}

			$this->add_item( single_term_title( '', false ), get_term_link( $this_term->term_id, $this_term->taxonomy ) );
		}

		/**
		 * Add a breadcrumb for author archives.
		 */
		protected function add_crumbs_author() {
			global $author;

			$userdata = get_userdata( $author );

			/* translators: %s: author name */
			$this->add_item( sprintf( __( 'Author: %s', 'ghub-breadcrumb' ), $userdata->display_name ) );
		}

		/**
		 * Add crumbs for a term.
		 *
		 * @param int    $term_id  Term ID.
		 * @param string $taxonomy Taxonomy.
		 */
		protected function term_ancestors( $term_id, $taxonomy ) {
			$ancestors = get_ancestors( $term_id, $taxonomy );
			$ancestors = array_reverse( $ancestors );

			foreach ( $ancestors as $ancestor ) {
				$ancestor = get_term( $ancestor, $taxonomy );

				if ( ! is_wp_error( $ancestor ) && $ancestor ) {
					$this->add_item( $ancestor->name, get_term_link( $ancestor ) );
				}
			}
		}

		/**
		 * Adds a breadcrumb item for search results.
		 */
		protected function add_search_result_trail() {
			if ( is_search() ) {
				/* translators: %s: search term */
				$this->add_item( sprintf( __( 'Search results for &ldquo;%s&rdquo;', 'ghub-breadcrumb' ), get_search_query() ), remove_query_arg( 'paged' ) );
			}
		}

		/**
		 * Add a breadcrumb for pagination.
		 */
		protected function add_page_trail() {
			if ( get_query_var( 'paged' ) ) {
				/* translators: %d: page number */
				$this->add_item( sprintf( __( 'Page %d', 'ghub-breadcrumb' ), get_query_var( 'paged' ) ) );
			}
		}

		/**
		 * Generates breadcrumbs SEO structured data.
		 *
		 * @param Gutenberghub_Breadcrumbs $breadcrumbs Breadcrumb data.
		 * @return array - Structured data.
		 */
		public function get_breadcrumb_structured_data( $breadcrumbs ) {
			$crumbs = $breadcrumbs->get_items();

			if ( empty( $crumbs ) || ! is_array( $crumbs ) ) {
				return;
			}

			$markup                    = array();
			$markup['@context']        = 'http://schema.org';
			$markup['@type']           = 'BreadcrumbList';
			$markup['itemListElement'] = array();

			foreach ( $crumbs as $key => $crumb ) {
				$markup['itemListElement'][ $key ] = array(
					'@type'    => 'ListItem',
					'position' => $key + 1,
					'item'     => array(
						'name' => $crumb[0],
					),
				);

				if ( ! empty( $crumb[1] ) ) {
					$markup['itemListElement'][ $key ]['item'] += array( '@id' => $crumb[1] );
				} elseif ( isset( $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'] ) ) {
					$protocol    = isset( $_SERVER['HTTPS'] ) && ! empty( $_SERVER['HTTPS'] ) ? 'https' : 'http';
					$current_url = esc_url_raw( $protocol . '://' . wp_unslash( $_SERVER['HTTP_HOST'] ) . wp_unslash( $_SERVER['REQUEST_URI'] ) );

					$markup['itemListElement'][ $key ]['item'] += array( '@id' => $current_url );
				}
			}

			return $markup;
		}


		/**
		 * Renders the SEO structured data.
		 *
		 * @return void
		 */
		public function render_structured_data() {
			$structured_data = $this->get_breadcrumb_structured_data( $this );

			?>
				<script type="application/ld+json">
					<?php
						echo _wp_specialchars( wp_json_encode( $structured_data ), ENT_NOQUOTES, 'UTF-8', true )
					?>
				</script>
			<?php
		}

		/**
		 * Check is woocommere activated
		 *
		 * @return boolean
		 */
		public function is_woocommerce_activated() {
			return class_exists( 'woocommerce' );
		}
	}
}

