<?php
    // Soporte shortcode ($atts) y widget ($instance)
    if (isset($atts)) {
        $placeholder = isset($atts['placeholder']) ? $atts['placeholder'] : __('Buscar...', 'predictive-search');
        $min_chars   = isset($atts['min_chars']) ? (int) $atts['min_chars'] : 3;
    } elseif (isset($instance)) {
        $placeholder = !empty($instance['placeholder']) ? $instance['placeholder'] : __('Buscar...', 'predictive-search');
        $min_chars   = !empty($instance['min_chars']) ? (int) $instance['min_chars'] : 3;
    } else {
        $placeholder = __('Buscar...', 'predictive-search');
        $min_chars   = 3;
    }
?>
<div class="ps-search-wrapper">
    <div class="ps-search-container">
        <form class="ps-search-form" role="search">
            <div class="ps-search-input-wrapper">
                <input 
                    type="text" 
                    class="ps-search-input" 
                    placeholder="<?php echo esc_attr($placeholder); ?>" 
                    autocomplete="off"
                    data-min-chars="<?php echo esc_attr($min_chars); ?>"
                    aria-label="<?php _e('Buscar', 'predictive-search'); ?>"
                />
                <button type="submit" class="ps-search-submit" aria-label="<?php _e('Search', 'predictive-search'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </button>
                <button type="button" class="ps-search-clear" style="display: none;" aria-label="<?php _e('Limpiar', 'predictive-search'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            
            <div class="ps-search-results" style="display: none;">
                <div class="ps-loading" style="display: none;">
                    <span class="ps-spinner"></span>
                    <span><?php _e('Searching...', 'predictive-search'); ?></span>
                </div>
                <div class="ps-results-list"></div>
                <div class="ps-no-results" style="display: none;">
                    <p><?php _e('No se encontraron resultados', 'predictive-search'); ?></p>
                </div>
            </div>
        </form>
    </div>
</div>
