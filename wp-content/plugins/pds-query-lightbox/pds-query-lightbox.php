<?php
/**
 * Plugin Name: PDS Query Lightbox
 * Description: Extiende el bloque Query Loop con un lightbox: al hacer clic en una entrada se abre su contenido via Ajax sin salir de la página.
 * Version:     1.0.0
 * Author:      PDS
 * Text Domain: pds-ql
 */

defined( 'ABSPATH' ) || exit;

define( 'PDS_QL_VERSION', '1.0.0' );
define( 'PDS_QL_URL',     plugin_dir_url( __FILE__ ) );
define( 'PDS_QL_PATH',    plugin_dir_path( __FILE__ ) );

// ---------------------------------------------------------------------------
// Assets
// ---------------------------------------------------------------------------

add_action( 'init', 'pds_ql_register_assets' );
function pds_ql_register_assets() {

	// Editor script
	wp_register_script(
		'pds-ql-editor',
		PDS_QL_URL . 'build/editor.js',
		[ 'wp-hooks', 'wp-compose', 'wp-block-editor', 'wp-components', 'wp-element' ],
		PDS_QL_VERSION,
		true
	);

	// Frontend script
	wp_register_script(
		'pds-ql-frontend',
		PDS_QL_URL . 'build/frontend.js',
		[],
		PDS_QL_VERSION,
		true
	);

	wp_localize_script( 'pds-ql-frontend', 'pdsQL', [
		'restUrl' => esc_url_raw( rest_url() ),
		'nonce'   => wp_create_nonce( 'wp_rest' ),
		'i18n'    => [
			'loading'  => __( 'Cargando…', 'pds-ql' ),
			'notFound' => __( 'No se encontró el contenido.', 'pds-ql' ),
			'error'    => __( 'Error al cargar el contenido.', 'pds-ql' ),
			'viewFull' => __( 'Ver página completa', 'pds-ql' ),
			'close'    => __( 'Cerrar', 'pds-ql' ),
		],
	] );

	// Styles
	wp_register_style(
		'pds-ql-style',
		PDS_QL_URL . 'build/style-style.css',
		[],
		PDS_QL_VERSION
	);
}

// Enqueue in editor
add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_script( 'pds-ql-editor' );
} );

// Enqueue on frontend only when a query block with lightbox exists on the page
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_script( 'pds-ql-frontend' );
	wp_enqueue_style( 'pds-ql-style' );
} );

// ---------------------------------------------------------------------------
// Render filter: inject data attributes into the Query Loop wrapper
// ---------------------------------------------------------------------------

add_filter( 'render_block', 'pds_ql_render_query_block', 10, 2 );
function pds_ql_render_query_block( $content, $block ) {

	if ( 'core/query' !== $block['blockName'] ) {
		return $content;
	}

	if ( empty( $block['attrs']['pdsEnableLightbox'] ) ) {
		return $content;
	}

	// Determine REST base for the queried post type
	$post_type = $block['attrs']['query']['postType'] ?? 'post';
	$pt_obj    = get_post_type_object( $post_type );
	$rest_base = $pt_obj ? ( $pt_obj->rest_base ?: $post_type ) : $post_type;

	// Add data attributes to the outermost <div class="wp-block-query ...">
	$content = preg_replace(
		'/(<div\b[^>]*\bwp-block-query\b[^>]*)>/i',
		'$1 data-pds-lightbox="true" data-pds-rest-base="' . esc_attr( $rest_base ) . '">',
		$content,
		1
	);

	return $content;
}
