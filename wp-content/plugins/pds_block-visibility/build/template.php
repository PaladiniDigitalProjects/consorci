<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Determine if the block should be displayed.
$should_render = true;

// Mobile detection using WordPress function.
if ( wp_is_mobile() ) {
    // Check for mobile visibility.
    if ( empty( $attributes['visibilityMobile'] ) ) {
        $should_render = false;
    }
} elseif ( function_exists( 'wp_is_tablet' ) && wp_is_tablet() ) {
    // Tablet detection (ensure you have a custom function for this).
    if ( empty( $attributes['visibilityTablet'] ) ) {
        $should_render = false;
    }
} else {
    // Desktop detection.
    if ( empty( $attributes['visibilityDesktop'] ) ) {
        $should_render = false;
    }
}

// Render the block only if it should be displayed.
if ( $should_render ) {
    echo '<div>' . $content . '</div>';
}
?>
