<?php
/**
 * Widget de búsqueda predictiva
 */

if (!defined('ABSPATH')) {
    exit;
}

class PS_Search_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'ps_search_widget',
            __('Predictive Search', 'predictive-search'),
            array(
                'description' => __('Buscador predictivo con AJAX', 'predictive-search')
            )
        );
    }
    
    /**
     * Front-end display
     */
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $placeholder = !empty($instance['placeholder']) ? $instance['placeholder'] : __('Buscar...', 'predictive-search');
        $min_chars = !empty($instance['min_chars']) ? $instance['min_chars'] : 3;
        
        // Renderizar el formulario de búsqueda
        include PS_PLUGIN_DIR . 'templates/search-box.php';
        
        echo $args['after_widget'];
    }
    
    /**
     * Back-end widget form
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Búsqueda', 'predictive-search');
        $placeholder = !empty($instance['placeholder']) ? $instance['placeholder'] : __('Buscar...', 'predictive-search');
        $min_chars = !empty($instance['min_chars']) ? $instance['min_chars'] : 3;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Título:', 'predictive-search'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('placeholder'); ?>">
                <?php _e('Placeholder:', 'predictive-search'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo $this->get_field_id('placeholder'); ?>" 
                   name="<?php echo $this->get_field_name('placeholder'); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($placeholder); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('min_chars'); ?>">
                <?php _e('Caracteres mínimos:', 'predictive-search'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo $this->get_field_id('min_chars'); ?>" 
                   name="<?php echo $this->get_field_name('min_chars'); ?>" 
                   type="number" 
                   value="<?php echo esc_attr($min_chars); ?>" 
                   min="1" 
                   max="10" />
        </p>
        <?php
    }
    
    /**
     * Update widget settings
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['placeholder'] = (!empty($new_instance['placeholder'])) ? sanitize_text_field($new_instance['placeholder']) : '';
        $instance['min_chars'] = (!empty($new_instance['min_chars'])) ? intval($new_instance['min_chars']) : 3;
        
        return $instance;
    }
}
