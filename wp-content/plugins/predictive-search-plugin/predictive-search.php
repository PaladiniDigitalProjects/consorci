<?php
/**
 * Plugin Name: Predictive Search Plugin
 * Plugin URI: https://tu-sitio.com
 * Description: Plugin de búsqueda predictiva con AJAX que indexa contenido diariamente y permite búsquedas en tiempo real
 * Version: 1.0.0
 * Author: Tu Nombre
 * Author URI: https://tu-sitio.com
 * License: GPL v2 or later
 * Text Domain: predictive-search
 */

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes
define('PS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PS_VERSION', '1.0.0');

// Incluir archivos necesarios
require_once PS_PLUGIN_DIR . 'includes/class-indexer.php';
require_once PS_PLUGIN_DIR . 'includes/class-admin.php';
require_once PS_PLUGIN_DIR . 'includes/class-search.php';

class Predictive_Search_Plugin {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_hooks();
    }
    
    private function init_hooks() {
        // Activación del plugin
        register_activation_hook(__FILE__, array($this, 'activate'));
        
        // Desactivación del plugin
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        
        // Cargar scripts y estilos
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // Inicializar admin INMEDIATAMENTE
        PS_Admin::get_instance();
        
        // Inicializar otras clases
        add_action('init', array($this, 'init_classes'));
        
        // Crear índice inicial si es necesario
        add_action('admin_init', array($this, 'create_initial_index'));
        
        // Shortcode para el buscador
        add_shortcode('predictive_search', array($this, 'search_box_shortcode'));
        
        // Widget
        add_action('widgets_init', array($this, 'register_widget'));
    }
    
    public function activate() {
        // Crear directorio para el índice dentro del plugin si no existe
        $index_dir = PS_PLUGIN_DIR . 'index';
        
        if (!file_exists($index_dir)) {
            $created = wp_mkdir_p($index_dir);
            if (!$created) {
                // Log del error
                error_log('Predictive Search: No se pudo crear el directorio en la activación');
            } else {
                // Crear archivo .htaccess para proteger el directorio
                $htaccess_content = "Order deny,allow\nDeny from all\n";
                @file_put_contents($index_dir . '/.htaccess', $htaccess_content);
            }
        }
        
        // Programar cron para indexación diaria
        if (!wp_next_scheduled('ps_daily_indexing')) {
            wp_schedule_event(time(), 'daily', 'ps_daily_indexing');
        }
        
        // Opciones por defecto
        if (!get_option('ps_excluded_fields')) {
            update_option('ps_excluded_fields', array());
        }
        
        // Establecer post types habilitados por defecto (TODOS)
        if (!get_option('ps_enabled_post_types')) {
            $all_post_types = get_post_types(array('public' => true), 'names');
            update_option('ps_enabled_post_types', $all_post_types);
        }
        
        // Establecer valores por defecto para configuración
        if (!get_option('ps_min_chars')) {
            update_option('ps_min_chars', 3);
        }
        
        if (!get_option('ps_max_results')) {
            update_option('ps_max_results', 10);
        }
        
        if (!get_option('ps_index_format')) {
            update_option('ps_index_format', 'json');
        }
        
        // Marcar que necesita crear índice en el siguiente page load
        update_option('ps_needs_initial_index', true);
    }
    
    public function deactivate() {
        // Eliminar cron
        wp_clear_scheduled_hook('ps_daily_indexing');
    }
    
    public function init_classes() {
        // Inicializar indexador
        PS_Indexer::get_instance();
        
        // Inicializar búsqueda
        PS_Search::get_instance();
    }
    
    public function create_initial_index() {
        // Solo ejecutar en admin y si está marcado que necesita índice
        if (!is_admin() || !get_option('ps_needs_initial_index')) {
            return;
        }
        
        // Verificar que no estemos en AJAX
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }
        
        // Eliminar la marca para no ejecutar múltiples veces
        delete_option('ps_needs_initial_index');
        
        // Crear el índice
        error_log('Predictive Search: Creando índice inicial después de activación');
        PS_Indexer::get_instance()->create_index();
    }
    
    public function enqueue_frontend_assets() {
        // CSS
        wp_enqueue_style(
            'ps-frontend-style',
            PS_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            PS_VERSION
        );
        
        // JavaScript
        wp_enqueue_script(
            'ps-frontend-script',
            PS_PLUGIN_URL . 'assets/js/frontend.js',
            array('jquery'),
            PS_VERSION,
            true
        );
        
        // Localizar script
        wp_localize_script('ps-frontend-script', 'psAjax', array(
            'ajaxurl'   => admin_url('admin-ajax.php'),
            'nonce'     => wp_create_nonce('ps_search_nonce'),
            'debug'     => defined('WP_DEBUG') && WP_DEBUG,
            'diagnostic' => true,
        ));
    }
    
    public function enqueue_admin_assets($hook) {
        // Solo cargar en la página de configuración del plugin
        if ('toplevel_page_predictive-search' !== $hook) {
            return;
        }
        
        wp_enqueue_style(
            'ps-admin-style',
            PS_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            PS_VERSION
        );
        
        wp_enqueue_script(
            'ps-admin-script',
            PS_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            PS_VERSION,
            true
        );
        
        // Localizar script con ajaxurl y nonce
        wp_localize_script('ps-admin-script', 'psAdminAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ps_regenerate_index')
        ));
    }
    
    public function search_box_shortcode($atts) {
        $atts = shortcode_atts(array(
            'placeholder' => __('Buscar...', 'predictive-search'),
            'min_chars' => 3
        ), $atts);
        
        ob_start();
        include PS_PLUGIN_DIR . 'templates/search-box.php';
        return ob_get_clean();
    }
    
    public function register_widget() {
        require_once PS_PLUGIN_DIR . 'includes/class-widget.php';
        register_widget('PS_Search_Widget');
    }
}

// Inicializar el plugin inmediatamente
Predictive_Search_Plugin::get_instance();
