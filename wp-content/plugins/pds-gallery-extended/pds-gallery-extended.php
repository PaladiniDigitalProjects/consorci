<?php
/**
 * Plugin Name:  PDS Gallery Extended
 * Description:  Estén el bloc de galeria de Gutenberg: layouts (masonry, filmstrip, focal), lightbox propi amb prev/next i scroll horitzontal automàtic.
 * Version:      1.0.0
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * Author:       Paladini Digital Solutions
 * Text Domain:  pds-gallery-extended
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PDS_GALLERY_DIR', plugin_dir_path( __FILE__ ) );
define( 'PDS_GALLERY_URL', plugin_dir_url( __FILE__ ) );
define( 'PDS_GALLERY_VER', '1.0.0' );

/* ─── Enqueue editor script ────────────────────────────────────────── */
add_action( 'enqueue_block_editor_assets', 'pds_gallery_editor_assets' );
function pds_gallery_editor_assets() {
	$js  = PDS_GALLERY_DIR . 'build/editor.js';
	$css = PDS_GALLERY_DIR . 'build/editor.css';

	wp_enqueue_script(
		'pds-gallery-editor',
		PDS_GALLERY_URL . 'build/editor.js',
		[ 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-hooks', 'wp-compose', 'wp-i18n' ],
		file_exists( $js ) ? filemtime( $js ) : PDS_GALLERY_VER,
		true
	);

	if ( file_exists( $css ) ) {
		wp_enqueue_style(
			'pds-gallery-editor-style',
			PDS_GALLERY_URL . 'build/editor.css',
			[ 'wp-edit-blocks' ],
			filemtime( $css )
		);
	}
}

/* ─── Enqueue frontend assets ──────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', 'pds_gallery_frontend_assets' );
function pds_gallery_frontend_assets() {
	if ( ! is_singular() ) return;

	global $post;
	if ( ! has_block( 'core/gallery', $post ) ) return;

	$js  = PDS_GALLERY_DIR . 'build/frontend.js';
	$css = PDS_GALLERY_DIR . 'build/style-style.css';

	if ( file_exists( $css ) ) {
		wp_enqueue_style(
			'pds-gallery-style',
			PDS_GALLERY_URL . 'build/style-style.css',
			[],
			filemtime( $css )
		);
	}

	if ( file_exists( $js ) ) {
		wp_enqueue_script(
			'pds-gallery-frontend',
			PDS_GALLERY_URL . 'build/frontend.js',
			[],
			filemtime( $js ),
			true
		);
	}
}

/* ─── render_block: afegir classes i data-attrs al HTML del bloc ───── */
add_filter( 'render_block', 'pds_gallery_render_block', 10, 2 );
function pds_gallery_render_block( $html, $block ) {
	if ( 'core/gallery' !== $block['blockName'] ) {
		return $html;
	}

	$attrs  = $block['attrs'] ?? [];
	$layout = $attrs['galleryLayout']       ?? 'default';
	$lb     = ! empty( $attrs['enableLightbox'] );
	$scroll = ! empty( $attrs['enableScroll'] );
	$duration  = intval( $attrs['scrollDuration']  ?? 8000 );
	$dir_raw   = $attrs['scrollDirection'] ?? 'ltr';
	$direction = in_array( $dir_raw, [ 'ltr', 'rtl' ] ) ? $dir_raw : 'ltr';
	$loop      = isset( $attrs['scrollLoop'] ) ? (bool) $attrs['scrollLoop'] : true;
	$fx         = floatval( $attrs['focalPoint']['x']  ?? 0.5 );
	$fy         = floatval( $attrs['focalPoint']['y']  ?? 0.5 );
	$fh         = intval( $attrs['focalHeight']        ?? 300 );
	$fmax       = intval( $attrs['focalMaxHeight']     ?? 400 );
	$falign_raw = $attrs['focalAlign'] ?? 'center';
	$falign     = in_array( $falign_raw, [ 'flex-start', 'center', 'flex-end' ] ) ? $falign_raw : 'center';

	$classes = [];
	if ( 'default' !== $layout ) {
		$classes[] = 'pds-gallery--' . sanitize_html_class( $layout );
	}
	if ( $lb )     $classes[] = 'pds-gallery--lightbox';
	if ( $scroll ) $classes[] = 'pds-gallery--autoscroll';

	if ( empty( $classes ) ) {
		return $html;
	}

	/* Afegir classes al primer tag */
	$class_str = implode( ' ', $classes );
	$html = preg_replace(
		'/(class="[^"]*wp-block-gallery)/i',
		'$1 ' . esc_attr( $class_str ),
		$html,
		1
	);

	/* Afegir data-attrs al primer tag */
	$data = '';
	if ( 'focal' === $layout ) {
		$data .= ' data-focal-max-height="' . $fmax . '"';
		$data .= ' data-focal-align="'      . esc_attr( $falign ) . '"';
		$data .= ' data-scroll-duration="'  . $duration . '"';
		$data .= ' data-scroll-direction="' . esc_attr( $direction ) . '"';
	}
	if ( $scroll ) {
		$data .= ' data-scroll-duration="'  . $duration . '"';
		$data .= ' data-scroll-direction="' . esc_attr( $direction ) . '"';
		$data .= ' data-scroll-loop="'      . ( $loop ? 'true' : 'false' ) . '"';
	}

	if ( $data ) {
		$html = preg_replace( '/(<(?:figure|ul)[^>]*)>/i', '$1' . $data . '>', $html, 1 );
	}

	return $html;
}
