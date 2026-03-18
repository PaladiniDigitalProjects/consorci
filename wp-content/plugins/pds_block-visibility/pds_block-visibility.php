<?php
/**
 * Plugin Name:       Pds Block Visibility
 * Description:       Adds visibility control (for phone, tablet, and desktop) to Gutenberg blocks.
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            Your Name
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pds-block-visibility
 *
 * @package           pds-block-visibility
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register block assets
function pds_block_visibility_register_block() {
    register_block_type(
        __DIR__ . '/build',
        array(
            'render_callback' => 'pds_block_visibility_render_callback',
        )
    );
}
add_action( 'init', 'pds_block_visibility_register_block' );

/**
 * Render the block on the frontend.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block content.
 * @param WP_Block $block      Block instance.
 * @return string The rendered output.
 */
function pds_block_visibility_render_callback( $attributes, $content ) {
    $is_mobile = wp_is_mobile(); // WordPress utility function to detect mobile devices

    if ( $is_mobile ) {
        // Render only if mobile visibility is enabled
        if ( empty( $attributes['visibilityMobile'] ) ) {
            return ''; // Prevent rendering on mobile
        }
    } else {
        // Render only if desktop visibility is enabled
        if ( empty( $attributes['visibilityDesktop'] ) ) {
            return ''; // Prevent rendering on desktop
        }
    }

    $classes = '';

    if ( isset( $attributes['className'] ) ) {
        $classes .= ' ' . esc_attr( $attributes['className'] );
    }

    return '<div class="' . trim( $classes ) . '">' . $content . '</div>';
}




