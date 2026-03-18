<?php
/**
 * Clase para indexar contenido
 */

if (!defined('ABSPATH')) {
    exit;
}

class PS_Indexer {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('ps_daily_indexing', array($this, 'create_index'));
        add_action('save_post', array($this, 'update_index_on_save'), 10, 3);
        add_action('delete_post', array($this, 'update_index_on_delete'));
    }
    
    /**
     * Crear el índice completo
     */
    public function create_index() {
        // Log inicio
        error_log('Predictive Search: Iniciando creación de índice...');
        
        $index_data = array();
        
        // Obtener post types habilitados por el usuario
        $enabled_post_types = get_option('ps_enabled_post_types', array());
        
        // Si no hay configuración, usar todos los post types públicos
        if (empty($enabled_post_types)) {
            $enabled_post_types = get_post_types(array('public' => true), 'names');
        }
        
        // Log post types encontrados
        error_log('Predictive Search: Post types habilitados para indexar: ' . implode(', ', $enabled_post_types));
        
        // Obtener configuración de campos por post type
        $post_type_fields = get_option('ps_post_type_fields', array());
        
        $args = array(
            'post_type' => $enabled_post_types,
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        $query = new WP_Query($args);
        
        error_log('Predictive Search: Posts encontrados: ' . $query->found_posts);
        
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                
                $post_id = get_the_ID();
                $post_type = get_post_type($post_id);
                
                // Obtener campos excluidos para este post type específico
                $excluded_fields = isset($post_type_fields[$post_type]) ? $post_type_fields[$post_type] : array();
                
                $post_data = $this->get_post_data($post_id, $excluded_fields);
                
                if (!empty($post_data)) {
                    $index_data[] = $post_data;
                }
            }
            wp_reset_postdata();
        } else {
            $error_msg = 'No se encontraron posts publicados para indexar.';
            error_log('Predictive Search Warning: ' . $error_msg);
            update_option('ps_last_error', $error_msg);
        }
        
        error_log('Predictive Search: Elementos a indexar: ' . count($index_data));
        
        // Guardar índice en JSON
        $json_success = $this->save_index($index_data, 'json');
        
        // Guardar índice en XML
        $xml_success = $this->save_index($index_data, 'xml');
        
        if ($json_success || $xml_success) {
            error_log('Predictive Search: Índice creado exitosamente');
            return true;
        } else {
            error_log('Predictive Search Error: No se pudo crear ningún índice');
            return false;
        }
    }
    
    /**
     * Obtener datos del post para indexar
     */
    private function get_post_data($post_id, $excluded_fields = array()) {
        $post = get_post($post_id);
        
        if (!$post) {
            return null;
        }
        
        $data = array(
            'id' => $post_id,
            'type' => $post->post_type,
            'url' => get_permalink($post_id),
            'date' => $post->post_date
        );
        
        // WPML - Información de idioma (mejorado)
        $data['language'] = '';
        $data['language_name'] = '';
        
        // Obtener el tipo de elemento formateado para WPML (ej: 'post' -> 'post_post')
        $wpml_element_type = '';
        if (function_exists('apply_filters')) {
            $wpml_element_type = apply_filters('wpml_element_type', $post->post_type);
        } else {
            $wpml_element_type = 'post_' . $post->post_type;
        }
        
        // Método 1: WPML usando apply_filters con parámetros correctos
        if (function_exists('apply_filters') && !empty($wpml_element_type)) {
            // Intentar con array (versión más reciente de WPML)
            $wpml_language = apply_filters('wpml_element_language_code', null, array(
                'element_id' => $post_id,
                'element_type' => $post->post_type
            ));
            
            // Si no funciona, intentar método alternativo
            if (empty($wpml_language) && class_exists('SitePress')) {
                global $sitepress;
                if ($sitepress) {
                    $lang_details = $sitepress->get_element_language_details($post_id, $wpml_element_type);
                    if ($lang_details && isset($lang_details->language_code)) {
                        $wpml_language = $lang_details->language_code;
                    }
                }
            }
            
            if (!empty($wpml_language)) {
                $data['language'] = $wpml_language;
            }
        }
        
        // Método 2: WPML usando wpml_get_language_information
        if (empty($data['language']) && function_exists('wpml_get_language_information')) {
            $lang_info = wpml_get_language_information($post_id);
            if (!is_wp_error($lang_info) && isset($lang_info['language_code'])) {
                $data['language'] = $lang_info['language_code'];
                $data['language_name'] = isset($lang_info['display_name']) ? $lang_info['display_name'] : '';
            }
        }
        
        // Método 3: WPML constante ICL_LANGUAGE_CODE (fallback)
        if (empty($data['language']) && defined('ICL_LANGUAGE_CODE')) {
            $data['language'] = ICL_LANGUAGE_CODE;
        }
        
        // Método 4: Polylang
        if (empty($data['language']) && function_exists('pll_get_post_language')) {
            $polylang_code = pll_get_post_language($post_id);
            if (!empty($polylang_code)) {
                $data['language'] = $polylang_code;
            }
        }
        
        // Si no hay plugin de idiomas, usar locale de WordPress
        if (empty($data['language'])) {
            $locale = get_locale();
            $data['language'] = substr($locale, 0, 2); // Solo código de idioma (es, en, etc.)
        }
        
        // Guardar también el ID de traducción de WPML si existe (usando sintaxis correcta)
        if (function_exists('apply_filters') && !empty($wpml_element_type)) {
            try {
                // Sintaxis correcta: apply_filters('wpml_element_trid', null, $element_id, $element_type)
                $trid = apply_filters('wpml_element_trid', null, $post_id, $wpml_element_type);
                if ($trid) {
                    $data['wpml_trid'] = $trid;
                }
            } catch (Exception $e) {
                // Silenciar errores si WPML no está completamente inicializado
                error_log('Predictive Search WPML Error: ' . $e->getMessage());
            }
        }
        
        // Título
        if (!in_array('title', $excluded_fields)) {
            $data['title'] = get_the_title($post_id);
        }
        
        // Contenido
        if (!in_array('content', $excluded_fields)) {
            $data['content'] = wp_strip_all_tags($post->post_content);
        }
        
        // Excerpt
        if (!in_array('excerpt', $excluded_fields)) {
            $data['excerpt'] = get_the_excerpt($post_id);
        }
        
        // Categorías
        if (!in_array('categories', $excluded_fields)) {
            $categories = wp_get_post_categories($post_id, array('fields' => 'names'));
            $data['categories'] = implode(', ', $categories);
        }
        
        // Tags
        if (!in_array('tags', $excluded_fields)) {
            $tags = wp_get_post_tags($post_id, array('fields' => 'names'));
            $data['tags'] = implode(', ', $tags);
        }
        
        // Autor
        if (!in_array('author', $excluded_fields)) {
            $data['author'] = get_the_author_meta('display_name', $post->post_author);
        }
        
        // ACF Fields
        if (!in_array('acf', $excluded_fields) && function_exists('get_fields')) {
            $acf_fields = get_fields($post_id);
            if ($acf_fields) {
                $acf_data = array();
                foreach ($acf_fields as $key => $value) {
                    if (is_string($value) || is_numeric($value)) {
                        $acf_data[$key] = $value;
                    } elseif (is_array($value)) {
                        $acf_data[$key] = implode(', ', array_filter($value, 'is_scalar'));
                    }
                }
                $data['acf'] = $acf_data;
            }
        }
        
        // The Events Calendar
        if (!in_array('events', $excluded_fields) && function_exists('tribe_get_event')) {
            if ($post->post_type === 'tribe_events') {
                $data['event_start'] = tribe_get_start_date($post_id, false, 'Y-m-d H:i:s');
                $data['event_end'] = tribe_get_end_date($post_id, false, 'Y-m-d H:i:s');
                $data['event_venue'] = tribe_get_venue($post_id);
            }
        }
        
        // WooCommerce Products
        if ($post->post_type === 'product' && class_exists('WooCommerce')) {
            $product = wc_get_product($post_id);
            
            if ($product) {
                // SKU
                if (!in_array('product_sku', $excluded_fields)) {
                    $sku = $product->get_sku();
                    if ($sku) {
                        $data['product_sku'] = $sku;
                    }
                }
                
                // Precio
                if (!in_array('product_price', $excluded_fields)) {
                    $data['product_price'] = $product->get_price();
                    $data['product_regular_price'] = $product->get_regular_price();
                    $data['product_sale_price'] = $product->get_sale_price();
                }
                
                // Atributos
                if (!in_array('product_attributes', $excluded_fields)) {
                    $attributes = $product->get_attributes();
                    $attr_data = array();
                    
                    foreach ($attributes as $attribute) {
                        if ($attribute->is_taxonomy()) {
                            $terms = wp_get_post_terms($post_id, $attribute->get_name(), array('fields' => 'names'));
                            $attr_data[] = implode(', ', $terms);
                        } else {
                            $attr_data[] = $attribute->get_options();
                        }
                    }
                    
                    if (!empty($attr_data)) {
                        $data['product_attributes'] = implode(' | ', array_filter($attr_data));
                    }
                }
                
                // Categorías de producto
                if (!in_array('categories', $excluded_fields)) {
                    $product_cats = wp_get_post_terms($post_id, 'product_cat', array('fields' => 'names'));
                    if (!empty($product_cats)) {
                        $data['categories'] = implode(', ', $product_cats);
                    }
                }
                
                // Tags de producto
                if (!in_array('tags', $excluded_fields)) {
                    $product_tags = wp_get_post_terms($post_id, 'product_tag', array('fields' => 'names'));
                    if (!empty($product_tags)) {
                        $data['tags'] = implode(', ', $product_tags);
                    }
                }
            }
        }
        
        // Metadatos personalizados
        if (!in_array('custom_fields', $excluded_fields)) {
            $custom_fields = get_post_custom($post_id);
            $data['meta'] = array();
            
            foreach ($custom_fields as $key => $value) {
                // Excluir campos privados (que empiezan con _)
                if (substr($key, 0, 1) !== '_') {
                    $data['meta'][$key] = is_array($value) ? implode(', ', $value) : $value;
                }
            }
        }
        
        // Imagen destacada
        if (!in_array('thumbnail', $excluded_fields)) {
            $thumbnail_id = get_post_thumbnail_id($post_id);
            if ($thumbnail_id) {
                $data['thumbnail'] = wp_get_attachment_image_url($thumbnail_id, 'thumbnail');
            }
        }
        
        return $data;
    }
    
    /**
     * Guardar índice en archivo dentro del directorio del plugin
     */
    private function save_index($data, $format = 'json') {
        // Guardar índice dentro del directorio del plugin
        $index_dir = PS_PLUGIN_DIR . 'index';
        
        error_log('Predictive Search: Intentando guardar en: ' . $index_dir);
        
        // Verificar y crear directorio
        if (!file_exists($index_dir)) {
            error_log('Predictive Search: Directorio no existe, creando...');
            
            // Intentar wp_mkdir_p primero
            $created = wp_mkdir_p($index_dir);
            error_log('Predictive Search: wp_mkdir_p resultado: ' . ($created ? 'true' : 'false'));
            
            if (!$created) {
                // Intentar crear con mkdir nativo de PHP
                error_log('Predictive Search: Intentando mkdir() nativo...');
                $created = @mkdir($index_dir, 0755, true);
                error_log('Predictive Search: mkdir() resultado: ' . ($created ? 'true' : 'false'));
            }
            
            if (!$created) {
                $error_msg = sprintf(
                    'No se pudo crear el directorio: %s. Verifica los permisos del directorio del plugin.',
                    $index_dir
                );
                error_log('Predictive Search Error: ' . $error_msg);
                update_option('ps_last_error', $error_msg);
                return false;
            } else {
                // Crear archivo .htaccess para proteger el directorio
                $htaccess_content = "Order deny,allow\nDeny from all\n";
                @file_put_contents($index_dir . '/.htaccess', $htaccess_content);
            }
            
            // Verificar que se creó
            if (!file_exists($index_dir)) {
                $error_msg = 'El directorio no existe después de intentar crearlo: ' . $index_dir;
                error_log('Predictive Search Error: ' . $error_msg);
                update_option('ps_last_error', $error_msg);
                return false;
            }
            
            error_log('Predictive Search: Directorio creado exitosamente');
        } else {
            error_log('Predictive Search: Directorio ya existe');
        }
        
        // Verificar permisos de escritura
        if (!is_writable($index_dir)) {
            $error_msg = sprintf(
                'El directorio no tiene permisos de escritura: %s',
                $index_dir
            );
            error_log('Predictive Search Error: ' . $error_msg);
            update_option('ps_last_error', $error_msg);
            return false;
        }
        
        // Preparar contenido según formato
        if ($format === 'json') {
            $file_path = $index_dir . '/search-index.json';
            error_log('Predictive Search: Ruta completa del archivo: ' . $file_path);
            $content = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
            if ($content === false) {
                $error_msg = 'Error al codificar datos a JSON: ' . json_last_error_msg();
                error_log('Predictive Search Error: ' . $error_msg);
                update_option('ps_last_error', $error_msg);
                return false;
            }
        } else {
            $file_path = $index_dir . '/search-index.xml';
            error_log('Predictive Search: Ruta completa del archivo: ' . $file_path);
            $content = $this->array_to_xml($data);
            
            if ($content === false) {
                $error_msg = 'Error al crear XML';
                error_log('Predictive Search Error: ' . $error_msg);
                update_option('ps_last_error', $error_msg);
                return false;
            }
        }
        
        // Intentar escribir el archivo
        error_log('Predictive Search: Intentando escribir archivo...');
        $bytes_written = @file_put_contents($file_path, $content);
        
        if ($bytes_written === false) {
            $error_msg = sprintf(
                'No se pudo escribir el archivo: %s. Verifica permisos.',
                $file_path
            );
            error_log('Predictive Search Error: ' . $error_msg);
            update_option('ps_last_error', $error_msg);
            return false;
        }
        
        error_log('Predictive Search: Bytes escritos: ' . $bytes_written);
        
        // Verificar que el archivo se creó correctamente
        if (!file_exists($file_path)) {
            $error_msg = sprintf(
                'El archivo no existe después de escribir: %s',
                $file_path
            );
            error_log('Predictive Search Error: ' . $error_msg);
            update_option('ps_last_error', $error_msg);
            return false;
        }
        
        error_log('Predictive Search: Archivo verificado en: ' . $file_path);
        
        // Todo bien - actualizar timestamp y limpiar error
        update_option('ps_last_index_time', current_time('mysql'));
        update_option('ps_last_index_count', count($data));
        update_option('ps_last_index_path', $file_path); // Guardar ruta para verificación
        delete_option('ps_last_error');
        
        // Log de éxito
        error_log(sprintf(
            'Predictive Search: Índice %s creado exitosamente con %d elementos (%s bytes) en: %s',
            $format,
            count($data),
            number_format($bytes_written),
            $file_path
        ));
        
        return true;
    }
    
    /**
     * Convertir array a XML
     */
    private function array_to_xml($data) {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><search_index></search_index>');
        
        foreach ($data as $item) {
            $post = $xml->addChild('post');
            foreach ($item as $key => $value) {
                if (is_array($value)) {
                    $child = $post->addChild($key);
                    foreach ($value as $subkey => $subvalue) {
                        $child->addChild($subkey, htmlspecialchars($subvalue));
                    }
                } else {
                    $post->addChild($key, htmlspecialchars($value));
                }
            }
        }
        
        return $xml->asXML();
    }
    
    /**
     * Actualizar índice cuando se guarda un post
     */
    public function update_index_on_save($post_id, $post, $update) {
        // Evitar actualizaciones en autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Solo posts publicados
        if ($post->post_status !== 'publish') {
            return;
        }
        
        // Regenerar índice completo
        $this->create_index();
    }
    
    /**
     * Actualizar índice cuando se elimina un post
     */
    public function update_index_on_delete($post_id) {
        $this->create_index();
    }
    
    /**
     * Obtener el índice desde el directorio del plugin
     */
    public function get_index($format = 'json') {
        $index_dir = PS_PLUGIN_DIR . 'index';
        $file_path = $index_dir . '/search-index.' . $format;
        
        if (!file_exists($file_path)) {
            $this->create_index();
            // Intentar leer de nuevo después de crear
            if (!file_exists($file_path)) {
                return array();
            }
        }
        
        if ($format === 'json') {
            $content = file_get_contents($file_path);
            $decoded = json_decode($content, true);
            return $decoded !== null ? $decoded : array();
        } else {
            $xml = @simplexml_load_file($file_path);
            return $xml !== false ? $xml : array();
        }
    }
}
