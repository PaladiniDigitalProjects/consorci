<?php
/**
 * Clase para el panel de administración
 */

if (!defined('ABSPATH')) {
    exit;
}

class PS_Admin {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_post_ps_regenerate_index', array($this, 'regenerate_index'));
        
        // AJAX para regenerar índice de forma asíncrona
        add_action('wp_ajax_ps_ajax_regenerate_index', array($this, 'ajax_regenerate_index'));
    }
    
    /**
     * Agregar menú de administración
     */
    public function add_admin_menu() {
        add_menu_page(
            __('Predictive Search', 'predictive-search'),
            __('Predictive Search', 'predictive-search'),
            'manage_options',
            'predictive-search',
            array($this, 'render_admin_page'),
            'dashicons-search',
            30
        );
    }
    
    /**
     * Registrar configuraciones
     */
    public function register_settings() {
        register_setting('ps_settings', 'ps_excluded_fields');
        register_setting('ps_settings', 'ps_min_chars');
        register_setting('ps_settings', 'ps_max_results');
        register_setting('ps_settings', 'ps_index_format');
        register_setting('ps_settings', 'ps_enabled_post_types');
        register_setting('ps_settings', 'ps_post_type_fields');
        
        add_settings_section(
            'ps_general_section',
            __('Configuración General', 'predictive-search'),
            array($this, 'general_section_callback'),
            'predictive-search'
        );
        
        add_settings_field(
            'ps_min_chars',
            __('Caracteres mínimos', 'predictive-search'),
            array($this, 'min_chars_callback'),
            'predictive-search',
            'ps_general_section'
        );
        
        add_settings_field(
            'ps_max_results',
            __('Resultados máximos', 'predictive-search'),
            array($this, 'max_results_callback'),
            'predictive-search',
            'ps_general_section'
        );
        
        add_settings_field(
            'ps_index_format',
            __('Formato del índice', 'predictive-search'),
            array($this, 'index_format_callback'),
            'predictive-search',
            'ps_general_section'
        );
        
        add_settings_section(
            'ps_post_types_section',
            __('Post Types a Indexar', 'predictive-search'),
            array($this, 'post_types_section_callback'),
            'predictive-search'
        );
        
        add_settings_field(
            'ps_enabled_post_types',
            __('Seleccionar Post Types', 'predictive-search'),
            array($this, 'post_types_callback'),
            'predictive-search',
            'ps_post_types_section'
        );
        
        add_settings_section(
            'ps_fields_section',
            __('Campos a Indexar por Post Type', 'predictive-search'),
            array($this, 'fields_section_callback'),
            'predictive-search'
        );
        
        add_settings_field(
            'ps_post_type_fields',
            __('Configurar campos', 'predictive-search'),
            array($this, 'post_type_fields_callback'),
            'predictive-search',
            'ps_fields_section'
        );
    }
    
    public function general_section_callback() {
        echo '<p>' . __('Configura los parámetros generales de búsqueda.', 'predictive-search') . '</p>';
    }
    
    public function post_types_section_callback() {
        echo '<p>' . __('Selecciona qué tipos de contenido deseas incluir en el índice de búsqueda.', 'predictive-search') . '</p>';
    }
    
    public function fields_section_callback() {
        echo '<p>' . __('Configura qué campos específicos se indexarán para cada tipo de contenido.', 'predictive-search') . '</p>';
    }
    
    public function min_chars_callback() {
        $value = get_option('ps_min_chars', 3);
        echo '<input type="number" name="ps_min_chars" value="' . esc_attr($value) . '" min="1" max="10" />';
        echo '<p class="description">' . __('Número mínimo de caracteres antes de mostrar resultados.', 'predictive-search') . '</p>';
    }
    
    public function max_results_callback() {
        $value = get_option('ps_max_results', 10);
        echo '<input type="number" name="ps_max_results" value="' . esc_attr($value) . '" min="1" max="50" />';
        echo '<p class="description">' . __('Número máximo de resultados a mostrar.', 'predictive-search') . '</p>';
    }
    
    public function index_format_callback() {
        $value = get_option('ps_index_format', 'json');
        ?>
        <select name="ps_index_format">
            <option value="json" <?php selected($value, 'json'); ?>>JSON</option>
            <option value="xml" <?php selected($value, 'xml'); ?>>XML</option>
        </select>
        <p class="description"><?php _e('Formato del archivo de índice.', 'predictive-search'); ?></p>
        <?php
    }
    
    public function post_types_callback() {
        $enabled_post_types = get_option('ps_enabled_post_types', array());
        $all_post_types = get_post_types(array('public' => true), 'objects');
        
        // Si no hay configuración guardada, seleccionar todos por defecto
        if (empty($enabled_post_types)) {
            $enabled_post_types = array_keys($all_post_types);
        }
        
        echo '<div class="ps-post-types-grid">';
        
        foreach ($all_post_types as $post_type_key => $post_type) {
            $checked = in_array($post_type_key, $enabled_post_types) ? 'checked' : '';
            $count = wp_count_posts($post_type_key);
            $total = isset($count->publish) ? $count->publish : 0;
            
            echo '<label class="ps-post-type-item">';
            echo '<input type="checkbox" name="ps_enabled_post_types[]" value="' . esc_attr($post_type_key) . '" ' . $checked . ' /> ';
            echo '<strong>' . esc_html($post_type->labels->name) . '</strong>';
            echo ' <span class="ps-post-type-count">(' . number_format($total) . ')</span>';
            echo '<br><small style="color: #666;">' . esc_html($post_type->description ?: $post_type_key) . '</small>';
            echo '</label>';
        }
        
        echo '</div>';
        echo '<p class="description">' . __('Solo se indexarán los tipos de contenido marcados.', 'predictive-search') . '</p>';
    }
    
    public function post_type_fields_callback() {
        $post_type_fields = get_option('ps_post_type_fields', array());
        $enabled_post_types = get_option('ps_enabled_post_types', array());
        
        // Si no hay post types habilitados, obtener todos
        if (empty($enabled_post_types)) {
            $all_post_types = get_post_types(array('public' => true), 'names');
            $enabled_post_types = $all_post_types;
        }
        
        // Campos disponibles para indexar
        $available_fields = array(
            'title' => __('Título', 'predictive-search'),
            'content' => __('Contenido', 'predictive-search'),
            'excerpt' => __('Extracto', 'predictive-search'),
            'categories' => __('Categorías', 'predictive-search'),
            'tags' => __('Etiquetas', 'predictive-search'),
            'author' => __('Autor', 'predictive-search'),
            'acf' => __('Campos ACF', 'predictive-search'),
            'custom_fields' => __('Campos personalizados', 'predictive-search'),
            'thumbnail' => __('Imagen destacada', 'predictive-search')
        );
        
        // Agregar campos específicos según el post type
        $post_types_objects = get_post_types(array('public' => true), 'objects');
        
        echo '<div class="ps-post-type-fields-config">';
        echo '<p class="description" style="margin-bottom: 15px;">';
        echo __('Marca los campos que deseas <strong>EXCLUIR</strong> de la indexación para cada tipo de contenido.', 'predictive-search');
        echo '</p>';
        
        foreach ($enabled_post_types as $post_type_key) {
            if (!isset($post_types_objects[$post_type_key])) continue;
            
            $post_type_obj = $post_types_objects[$post_type_key];
            $excluded_for_type = isset($post_type_fields[$post_type_key]) ? $post_type_fields[$post_type_key] : array();
            
            echo '<div class="ps-field-group">';
            echo '<h4 class="ps-field-group-title">';
            echo '<span class="dashicons dashicons-' . esc_attr($post_type_obj->menu_icon ?: 'admin-post') . '"></span> ';
            echo esc_html($post_type_obj->labels->name);
            echo '</h4>';
            
            echo '<div class="ps-field-checkboxes">';
            
            // Campos comunes
            foreach ($available_fields as $field_key => $field_label) {
                // Algunos campos no aplican a ciertos post types
                if ($field_key === 'categories' && !is_object_in_taxonomy($post_type_key, 'category')) {
                    continue;
                }
                if ($field_key === 'tags' && !is_object_in_taxonomy($post_type_key, 'post_tag')) {
                    continue;
                }
                
                $checked = in_array($field_key, $excluded_for_type) ? 'checked' : '';
                $field_name = 'ps_post_type_fields[' . $post_type_key . '][]';
                
                echo '<label>';
                echo '<input type="checkbox" name="' . esc_attr($field_name) . '" value="' . esc_attr($field_key) . '" ' . $checked . ' /> ';
                echo esc_html($field_label);
                echo '</label>';
            }
            
            // Campos específicos para eventos (si existe The Events Calendar)
            if ($post_type_key === 'tribe_events' && function_exists('tribe_get_event')) {
                $checked = in_array('events', $excluded_for_type) ? 'checked' : '';
                $field_name = 'ps_post_type_fields[' . $post_type_key . '][]';
                
                echo '<label>';
                echo '<input type="checkbox" name="' . esc_attr($field_name) . '" value="events" ' . $checked . ' /> ';
                echo __('Datos de eventos (fecha, lugar)', 'predictive-search');
                echo '</label>';
            }
            
            // Campos específicos para productos (si existe WooCommerce)
            if ($post_type_key === 'product' && class_exists('WooCommerce')) {
                $woo_fields = array(
                    'product_sku' => __('SKU del producto', 'predictive-search'),
                    'product_price' => __('Precio', 'predictive-search'),
                    'product_attributes' => __('Atributos del producto', 'predictive-search')
                );
                
                foreach ($woo_fields as $woo_key => $woo_label) {
                    $checked = in_array($woo_key, $excluded_for_type) ? 'checked' : '';
                    $field_name = 'ps_post_type_fields[' . $post_type_key . '][]';
                    
                    echo '<label>';
                    echo '<input type="checkbox" name="' . esc_attr($field_name) . '" value="' . esc_attr($woo_key) . '" ' . $checked . ' /> ';
                    echo esc_html($woo_label);
                    echo '</label>';
                }
            }
            
            echo '</div>'; // .ps-field-checkboxes
            echo '</div>'; // .ps-field-group
        }
        
        echo '</div>'; // .ps-post-type-fields-config
        
        echo '<p class="description" style="margin-top: 15px;">';
        echo '💡 ' . __('Los campos marcados NO serán incluidos en la búsqueda para ese tipo de contenido.', 'predictive-search');
        echo '</p>';
    }
    
    /**
     * Renderizar página de administración
     */
    public function render_admin_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Mostrar notificación si se regeneró el índice
        if (isset($_GET['regenerated']) && $_GET['regenerated'] === '1') {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><strong><?php _e('¡Índice regenerado correctamente!', 'predictive-search'); ?></strong></p>
            </div>
            <?php
        }
        
        // Mostrar notificación si se guardó configuración
        if (isset($_GET['settings-updated']) && $_GET['settings-updated'] === 'true') {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><strong><?php _e('Configuración guardada correctamente.', 'predictive-search'); ?></strong></p>
            </div>
            <?php
        }
        
        // Mostrar errores si existen
        $last_error = get_option('ps_last_error');
        if ($last_error) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><strong><?php _e('❌ Error al crear el índice:', 'predictive-search'); ?></strong></p>
                <p><?php echo esc_html($last_error); ?></p>
                <p>
                    <a href="#ps-troubleshooting" class="button">
                        <?php _e('Ver soluciones abajo', 'predictive-search'); ?>
                    </a>
                </p>
            </div>
            <?php
        }
        
        $last_index = get_option('ps_last_index_time');
        $last_count = get_option('ps_last_index_count', 0);
        $index_dir = PS_PLUGIN_DIR . 'index';
        $index_file = $index_dir . '/search-index.json';
        $index_exists = file_exists($index_file);
        $dir_exists = file_exists($index_dir);
        $is_writable = $dir_exists ? is_writable($index_dir) : false;
        $total_posts = 0;
        
        // Contar posts indexados
        if ($index_exists) {
            $index_data = json_decode(file_get_contents($index_file), true);
            $total_posts = is_array($index_data) ? count($index_data) : 0;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <div class="ps-admin-header">
                <div class="ps-status-box">
                    <h3><?php _e('Estado del Índice', 'predictive-search'); ?></h3>
                    
                    <?php if ($index_exists): ?>
                        <div class="ps-status-info">
                            <p class="ps-status-indicator ps-status-active">
                                <span class="dashicons dashicons-yes-alt"></span>
                                <strong><?php _e('Índice activo', 'predictive-search'); ?></strong>
                            </p>
                            <p>
                                <strong><?php _e('Total de elementos indexados:', 'predictive-search'); ?></strong> 
                                <?php echo number_format($total_posts); ?>
                            </p>
                            <?php if ($last_index): ?>
                                <p>
                                    <strong><?php _e('Última actualización:', 'predictive-search'); ?></strong> 
                                    <?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($last_index)); ?>
                                </p>
                            <?php endif; ?>
                            <p>
                                <strong><?php _e('Tamaño del archivo:', 'predictive-search'); ?></strong> 
                                <?php echo size_format(filesize($index_file)); ?>
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="ps-status-info">
                            <p class="ps-status-indicator ps-status-inactive">
                                <span class="dashicons dashicons-warning"></span>
                                <strong><?php _e('El índice aún no ha sido creado.', 'predictive-search'); ?></strong>
                            </p>
                            <p class="description">
                                <?php _e('Haz clic en el botón de abajo para crear el índice por primera vez.', 'predictive-search'); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" id="ps-regenerate-form">
                        <input type="hidden" name="action" value="ps_regenerate_index" />
                        <?php wp_nonce_field('ps_regenerate_index', 'ps_nonce'); ?>
                        <?php submit_button(
                            $index_exists ? __('🔄 Regenerar Índice Ahora', 'predictive-search') : __('✨ Crear Índice Ahora', 'predictive-search'), 
                            'primary', 
                            'submit', 
                            false,
                            array('id' => 'ps-regenerate-btn')
                        ); ?>
                    </form>
                    
                    <p class="description" style="margin-top: 10px;">
                        <?php _e('💡 El índice se actualiza automáticamente cada día a las 00:00 hrs.', 'predictive-search'); ?>
                    </p>
                </div>
            </div>
            
            <form action="options.php" method="post">
                <?php
                settings_fields('ps_settings');
                do_settings_sections('predictive-search');
                submit_button(__('Guardar Cambios', 'predictive-search'));
                ?>
            </form>
            
            <div class="ps-usage-section">
                <h2><?php _e('Cómo usar', 'predictive-search'); ?></h2>
                
                <h3><?php _e('Shortcode', 'predictive-search'); ?></h3>
                <p><?php _e('Inserta el buscador en cualquier página o entrada:', 'predictive-search'); ?></p>
                <code>[predictive_search]</code>
                
                <p><?php _e('Con parámetros personalizados:', 'predictive-search'); ?></p>
                <code>[predictive_search placeholder="Buscar contenido..." min_chars="2"]</code>
                
                <h3><?php _e('Widget', 'predictive-search'); ?></h3>
                <p><?php _e('Ve a Apariencia → Widgets y añade el widget "Predictive Search" en cualquier área de widgets.', 'predictive-search'); ?></p>
                
                <h3><?php _e('Código PHP', 'predictive-search'); ?></h3>
                <p><?php _e('Inserta directamente en tus plantillas:', 'predictive-search'); ?></p>
                <code>&lt;?php echo do_shortcode('[predictive_search]'); ?&gt;</code>
            </div>
            
            <div class="ps-debug-section" id="ps-troubleshooting" style="margin-top: 30px; background: #f9f9f9; padding: 20px; border-radius: 4px; border: 1px solid #e5e5e5;">
                <h3><?php _e('🔧 Información Técnica y Solución de Problemas', 'predictive-search'); ?></h3>
                
                <?php
                // Detectar WPML
                $wpml_active = defined('ICL_SITEPRESS_VERSION') || function_exists('icl_object_id');
                $polylang_active = function_exists('pll_current_language');
                
                if ($wpml_active || $polylang_active):
                ?>
                <div style="background: #e7f5e7; padding: 15px; margin-bottom: 20px; border-left: 4px solid #00a32a; border-radius: 4px;">
                    <h4 style="margin-top: 0;">
                        <?php if ($wpml_active): ?>
                            ✅ WPML Detectado y Activo
                        <?php elseif ($polylang_active): ?>
                            ✅ Polylang Detectado y Activo
                        <?php endif; ?>
                    </h4>
                    <p>
                        <strong><?php _e('El plugin está configurado para trabajar con multiidioma.', 'predictive-search'); ?></strong>
                    </p>
                    
                    <?php if ($wpml_active): ?>
                    <p><?php _e('WPML Versión:', 'predictive-search'); ?> <code><?php echo ICL_SITEPRESS_VERSION; ?></code></p>
                    
                    <?php
                    // Obtener idiomas activos
                    if (function_exists('icl_get_languages')) {
                        $languages = icl_get_languages('skip_missing=0');
                        if ($languages):
                    ?>
                    <p><strong><?php _e('Idiomas activos:', 'predictive-search'); ?></strong></p>
                    <ul style="margin-left: 20px;">
                        <?php foreach ($languages as $lang): ?>
                            <li>
                                <strong><?php echo $lang['native_name']; ?></strong> 
                                (<?php echo $lang['code']; ?>)
                                <?php if ($lang['active']): ?>
                                    <span style="color: #00a32a;">← <?php _e('Idioma actual', 'predictive-search'); ?></span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php 
                        endif;
                    }
                    ?>
                    
                    <p style="margin-top: 10px;">
                        <strong><?php _e('Comportamiento:', 'predictive-search'); ?></strong><br>
                        • <?php _e('El índice incluye posts de TODOS los idiomas', 'predictive-search'); ?><br>
                        • <?php _e('Las búsquedas se filtran automáticamente por el idioma actual', 'predictive-search'); ?><br>
                        • <?php _e('Solo verás resultados del idioma en que estés navegando', 'predictive-search'); ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if ($polylang_active): ?>
                    <p><strong><?php _e('Comportamiento con Polylang:', 'predictive-search'); ?></strong><br>
                        • <?php _e('El índice incluye posts de TODOS los idiomas', 'predictive-search'); ?><br>
                        • <?php _e('Las búsquedas se filtran automáticamente por el idioma actual', 'predictive-search'); ?>
                    </p>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div style="background: #f0f0f1; padding: 15px; margin-bottom: 20px; border-left: 4px solid #72aee6; border-radius: 4px;">
                    <h4 style="margin-top: 0;">ℹ️ <?php _e('Multiidioma no detectado', 'predictive-search'); ?></h4>
                    <p>
                        <?php _e('No se detectó WPML ni Polylang. Si tu sitio es multiidioma:', 'predictive-search'); ?>
                    </p>
                    <ol style="margin-left: 20px;">
                        <li><?php _e('Instala y activa WPML o Polylang', 'predictive-search'); ?></li>
                        <li><?php _e('Regenera el índice', 'predictive-search'); ?></li>
                        <li><?php _e('Las búsquedas se filtrarán automáticamente por idioma', 'predictive-search'); ?></li>
                    </ol>
                </div>
                <?php endif; ?>
                
                <table class="widefat">
                    <tr>
                        <td style="width: 30%;"><strong><?php _e('Ruta del directorio:', 'predictive-search'); ?></strong></td>
                        <td><code><?php echo esc_html($index_dir); ?></code></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Ubicación:', 'predictive-search'); ?></strong></td>
                        <td><?php _e('Dentro del directorio del plugin', 'predictive-search'); ?> ✅</td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Directorio existe:', 'predictive-search'); ?></strong></td>
                        <td><?php echo $dir_exists ? '✅ Sí' : '❌ No'; ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Directorio writable:', 'predictive-search'); ?></strong></td>
                        <td>
                            <?php 
                            echo $is_writable ? '✅ Sí' : '❌ No - <strong style="color: #d63638;">Necesitas cambiar permisos a 755</strong>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Permisos del directorio:', 'predictive-search'); ?></strong></td>
                        <td>
                            <code><?php echo $dir_exists ? substr(sprintf('%o', fileperms($index_dir)), -4) : 'N/A'; ?></code>
                            <?php if ($dir_exists && !$is_writable): ?>
                                <span style="color: #d63638;"> ← Cambiar a 0755</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Archivo de índice:', 'predictive-search'); ?></strong></td>
                        <td><code><?php echo esc_html(basename($index_file)); ?></code></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Archivo existe:', 'predictive-search'); ?></strong></td>
                        <td><?php echo $index_exists ? '✅ Sí' : '❌ No'; ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Total de posts publicados:', 'predictive-search'); ?></strong></td>
                        <td>
                            <?php 
                            $count = wp_count_posts();
                            echo isset($count->publish) ? number_format($count->publish) : '0';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Posts indexados:', 'predictive-search'); ?></strong></td>
                        <td><?php echo number_format($total_posts); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Próxima indexación automática:', 'predictive-search'); ?></strong></td>
                        <td>
                            <?php 
                            $next_cron = wp_next_scheduled('ps_daily_indexing');
                            if ($next_cron) {
                                echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $next_cron);
                            } else {
                                echo '<span style="color: #dba617;">No programado</span>';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php if ($last_error): ?>
                    <tr style="background: #fff3cd;">
                        <td><strong style="color: #d63638;"><?php _e('Último error:', 'predictive-search'); ?></strong></td>
                        <td><code style="color: #d63638;"><?php echo esc_html($last_error); ?></code></td>
                    </tr>
                    <?php endif; ?>
                </table>
                
                <?php if (!$dir_exists): ?>
                <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-left: 4px solid #dba617; border-radius: 4px;">
                    <h4 style="margin-top: 0;">⚠️ El Directorio No Existe</h4>
                    <p><strong>El directorio de índices no se ha creado.</strong> Esto puede deberse a:</p>
                    <ol>
                        <li>Permisos insuficientes en <code>/wp-content/uploads/</code></li>
                        <li>Restricciones del servidor</li>
                    </ol>
                    <p><strong>Solución:</strong></p>
                    <ol>
                        <li>Accede a tu servidor por FTP o cPanel File Manager</li>
                        <li>Ve a: <code><?php echo esc_html(PS_PLUGIN_DIR); ?></code></li>
                        <li>Crea una carpeta llamada: <code>index</code></li>
                        <li>Cambia los permisos a <strong>755</strong></li>
                        <li>Vuelve aquí y haz clic en "Crear Índice Ahora"</li>
                    </ol>
                    <p><strong>Comando SSH (si tienes acceso):</strong></p>
                    <code>mkdir -p <?php echo esc_html($index_dir); ?> && chmod 755 <?php echo esc_html($index_dir); ?></code>
                </div>
                <?php elseif (!$is_writable): ?>
                <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-left: 4px solid #dba617; border-radius: 4px;">
                    <h4 style="margin-top: 0;">⚠️ Problema de Permisos Detectado</h4>
                    <p><strong>El directorio existe pero no tiene permisos de escritura.</strong></p>
                    <p><strong>Solución:</strong></p>
                    <ol>
                        <li>Accede a tu servidor por FTP o cPanel File Manager</li>
                        <li>Localiza la carpeta: <code><?php echo esc_html($index_dir); ?></code></li>
                        <li>Haz clic derecho → Permisos/CHMOD</li>
                        <li>Cambia los permisos a <strong>755</strong> (rwxr-xr-x)</li>
                        <li>Vuelve aquí y haz clic en "Crear Índice Ahora"</li>
                    </ol>
                    <p><strong>Comando SSH (si tienes acceso):</strong></p>
                    <code>chmod 755 <?php echo esc_html($index_dir); ?></code>
                    
                    <p style="margin-top: 15px;"><strong>Permisos actuales:</strong> <code><?php echo $dir_exists ? substr(sprintf('%o', fileperms($index_dir)), -4) : 'N/A'; ?></code></p>
                    <p><strong>Permisos requeridos:</strong> <code>0755</code></p>
                </div>
                <?php elseif (!$index_exists && $is_writable && isset($count->publish) && $count->publish > 0): ?>
                <div style="margin-top: 20px; padding: 15px; background: #e7f5e7; border-left: 4px solid #00a32a; border-radius: 4px;">
                    <h4 style="margin-top: 0;">✅ Todo está listo para crear el índice</h4>
                    <p>El directorio existe y tiene permisos correctos. Tienes <strong><?php echo $count->publish; ?></strong> posts publicados.</p>
                    <p><strong>Haz clic en el botón "Crear Índice Ahora" arriba para generar el archivo.</strong></p>
                    <p style="margin-top: 10px; font-size: 12px; color: #666;">
                        Si después de hacer clic el archivo no se crea, revisa el archivo <code>/wp-content/debug.log</code> para ver mensajes de error detallados.
                    </p>
                </div>
                <?php elseif (!$index_exists && $is_writable && (!isset($count->publish) || $count->publish == 0)): ?>
                <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-left: 4px solid #dba617; border-radius: 4px;">
                    <h4 style="margin-top: 0;">⚠️ No hay contenido para indexar</h4>
                    <p>El directorio está configurado correctamente, pero no tienes posts publicados.</p>
                    <p><strong>Publica al menos un post o página</strong> y luego haz clic en "Crear Índice Ahora".</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Regenerar índice manualmente
     */
    public function regenerate_index() {
        if (!current_user_can('manage_options')) {
            wp_die(__('No tienes permisos para realizar esta acción.', 'predictive-search'));
        }
        
        check_admin_referer('ps_regenerate_index', 'ps_nonce');
        
        PS_Indexer::get_instance()->create_index();
        
        wp_redirect(add_query_arg(
            array('page' => 'predictive-search', 'regenerated' => '1'),
            admin_url('admin.php')
        ));
        exit;
    }
    
    /**
     * Regenerar índice vía AJAX (asíncrono)
     */
    public function ajax_regenerate_index() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('No tienes permisos para realizar esta acción.', 'predictive-search')));
        }
        
        check_ajax_referer('ps_regenerate_index', 'nonce');
        
        // Ejecutar indexación
        $result = PS_Indexer::get_instance()->create_index();
        
        if ($result) {
            $index_dir = PS_PLUGIN_DIR . 'index';
            $index_file = $index_dir . '/search-index.json';
            $total_posts = 0;
            
            if (file_exists($index_file)) {
                $index_data = json_decode(file_get_contents($index_file), true);
                $total_posts = is_array($index_data) ? count($index_data) : 0;
            }
            
            wp_send_json_success(array(
                'message' => __('Índice regenerado correctamente.', 'predictive-search'),
                'total_posts' => $total_posts,
                'last_index_time' => get_option('ps_last_index_time'),
                'file_size' => file_exists($index_file) ? size_format(filesize($index_file)) : '0 B'
            ));
        } else {
            $error = get_option('ps_last_error', __('Error desconocido al crear el índice.', 'predictive-search'));
            wp_send_json_error(array('message' => $error));
        }
    }
}
