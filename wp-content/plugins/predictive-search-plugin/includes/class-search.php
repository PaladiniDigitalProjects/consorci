<?php
/**
 * Clase para manejar búsquedas
 */

if (!defined('ABSPATH')) {
    exit;
}

class PS_Search {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        // AJAX para usuarios logueados
        add_action('wp_ajax_ps_search', array($this, 'ajax_search'));
        add_action('wp_ajax_ps_diagnostic', array($this, 'ajax_diagnostic'));
        
        // AJAX para usuarios no logueados
        add_action('wp_ajax_nopriv_ps_search', array($this, 'ajax_search'));
        add_action('wp_ajax_nopriv_ps_diagnostic', array($this, 'ajax_diagnostic'));
    }
    
    /**
     * Diagnóstico para el checklist del frontend (índice, backend, nonce)
     */
    public function ajax_diagnostic() {
        $result = array(
            'ok'            => true,
            'checks'        => array(),
            'index_count'   => 0,
            'index_exists'   => false,
            'last_index'    => '',
            'message'       => '',
        );
        
        $index_dir  = PS_PLUGIN_DIR . 'index';
        $index_file = $index_dir . '/search-index.json';
        
        $result['checks']['backend'] = array(
            'name' => 'Backend AJAX',
            'ok'   => true,
            'msg'  => 'Endpoint de diagnóstico responde',
        );
        
        $result['checks']['nonce'] = array(
            'name' => 'Nonce búsqueda',
            'ok'   => false,
            'msg'  => '',
        );
        if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'ps_search_nonce')) {
            $result['checks']['nonce']['ok'] = true;
            $result['checks']['nonce']['msg'] = 'Nonce válido';
        } else {
            $result['checks']['nonce']['msg'] = 'Nonce inválido o no enviado';
        }
        
        $result['checks']['index_dir'] = array(
            'name' => 'Directorio índice',
            'ok'   => file_exists($index_dir) && is_readable($index_dir),
            'msg'  => file_exists($index_dir) ? (is_readable($index_dir) ? 'Directorio existe y es legible' : 'Directorio existe pero no es legible') : 'Directorio del índice no existe',
        );
        
        $result['checks']['index_file'] = array(
            'name' => 'Archivo índice JSON',
            'ok'   => file_exists($index_file) && is_readable($index_file),
            'msg'  => '',
        );
        if (file_exists($index_file)) {
            $result['index_exists'] = true;
            $result['checks']['index_file']['msg'] = 'Archivo existe y es legible';
            $content = @file_get_contents($index_file);
            $decoded = $content ? json_decode($content, true) : null;
            $result['index_count'] = is_array($decoded) ? count($decoded) : 0;
            $result['checks']['index_data'] = array(
                'name' => 'Índice con datos',
                'ok'   => $result['index_count'] > 0,
                'msg'  => $result['index_count'] > 0 ? $result['index_count'] . ' elementos indexados' : 'Índice vacío o JSON inválido',
            );
        } else {
            $result['checks']['index_file']['msg'] = 'Archivo search-index.json no existe';
        }
        
        $result['last_index'] = get_option('ps_last_index_time', '');
        
        foreach ($result['checks'] as $c) {
            if (!$c['ok']) {
                $result['ok'] = false;
                break;
            }
        }
        
        $result['message'] = $result['ok'] ? 'Todos los checks correctos' : 'Revisa los checks fallidos en la consola';
        
        wp_send_json_success($result);
    }
    
    /**
     * Manejar búsqueda AJAX
     */
    public function ajax_search() {
        check_ajax_referer('ps_search_nonce', 'nonce');
        
        $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
        $language = isset($_POST['language']) ? sanitize_text_field($_POST['language']) : '';
        $min_chars = get_option('ps_min_chars', 3);
        
        if (strlen($query) < $min_chars) {
            wp_send_json_success(array(
                'results' => array(),
                'message' => sprintf(__('Escribe al menos %d caracteres', 'predictive-search'), $min_chars)
            ));
        }
        
        $results = $this->search($query, $language);
        
        wp_send_json_success(array(
            'results' => $results,
            'total' => count($results),
            'language' => $language
        ));
    }
    
    /**
     * Realizar búsqueda en el índice
     */
    public function search($query, $language = '') {
        $index_format = get_option('ps_index_format', 'json');
        $index = PS_Indexer::get_instance()->get_index($index_format);
        
        if (empty($index)) {
            return array();
        }
        
        // Detectar idioma actual si no se proporcionó (mejorado para WPML)
        if (empty($language)) {
            // Método 1: WPML usando apply_filters (más confiable)
            if (function_exists('apply_filters')) {
                $wpml_current_lang = apply_filters('wpml_current_language', null);
                if (!empty($wpml_current_lang)) {
                    $language = $wpml_current_lang;
                }
            }
            
            // Método 2: WPML constante ICL_LANGUAGE_CODE
            if (empty($language) && defined('ICL_LANGUAGE_CODE')) {
                $language = ICL_LANGUAGE_CODE;
            }
            
            // Método 3: Polylang
            if (empty($language) && function_exists('pll_current_language')) {
                $language = pll_current_language();
            }
        }
        
        $query = strtolower($query);
        $results = array();
        $max_results = get_option('ps_max_results', 10);
        
        foreach ($index as $item) {
            // Filtrar por idioma si está definido (compatibilidad WPML mejorada)
            if (!empty($language) && isset($item['language'])) {
                // Comparación flexible: puede ser 'es' vs 'es-ES' o viceversa
                $item_lang = substr($item['language'], 0, 2);
                $current_lang = substr($language, 0, 2);
                
                if ($item_lang !== $current_lang && $item['language'] !== $language) {
                    continue; // Saltar este resultado si no coincide el idioma
                }
            }
            
            $score = $this->calculate_relevance($item, $query);
            
            if ($score > 0) {
                $results[] = array(
                    'id' => $item['id'],
                    'title' => isset($item['title']) ? $item['title'] : '',
                    'excerpt' => isset($item['excerpt']) ? $item['excerpt'] : '',
                    'url' => $item['url'],
                    'type' => $item['type'],
                    'thumbnail' => isset($item['thumbnail']) ? $item['thumbnail'] : '',
                    'score' => $score,
                    'date' => isset($item['date']) ? $item['date'] : '',
                    'language' => isset($item['language']) ? $item['language'] : ''
                );
            }
        }
        
        // Ordenar por relevancia
        usort($results, function($a, $b) {
            return $b['score'] - $a['score'];
        });
        
        // Limitar resultados
        return array_slice($results, 0, $max_results);
    }
    
    /**
     * Calcular relevancia de un elemento
     */
    private function calculate_relevance($item, $query) {
        $score = 0;
        $query_lower = strtolower($query);
        
        // Búsqueda en título (peso 10)
        if (isset($item['title'])) {
            $title_lower = strtolower($item['title']);
            if (stripos($title_lower, $query_lower) !== false) {
                $score += 10;
                // Bonus si empieza con el query
                if (stripos($title_lower, $query_lower) === 0) {
                    $score += 5;
                }
            }
        }
        
        // Búsqueda en contenido (peso 3)
        if (isset($item['content'])) {
            $content_lower = strtolower($item['content']);
            if (stripos($content_lower, $query_lower) !== false) {
                $score += 3;
                // Contar ocurrencias
                $count = substr_count($content_lower, $query_lower);
                $score += min($count, 5); // Máximo 5 puntos extra
            }
        }
        
        // Búsqueda en excerpt (peso 5)
        if (isset($item['excerpt'])) {
            if (stripos(strtolower($item['excerpt']), $query_lower) !== false) {
                $score += 5;
            }
        }
        
        // Búsqueda en categorías (peso 4)
        if (isset($item['categories'])) {
            if (stripos(strtolower($item['categories']), $query_lower) !== false) {
                $score += 4;
            }
        }
        
        // Búsqueda en tags (peso 4)
        if (isset($item['tags'])) {
            if (stripos(strtolower($item['tags']), $query_lower) !== false) {
                $score += 4;
            }
        }
        
        // Búsqueda en autor (peso 2)
        if (isset($item['author'])) {
            if (stripos(strtolower($item['author']), $query_lower) !== false) {
                $score += 2;
            }
        }
        
        // Búsqueda en ACF (peso 3)
        if (isset($item['acf']) && is_array($item['acf'])) {
            foreach ($item['acf'] as $field_value) {
                if (stripos(strtolower($field_value), $query_lower) !== false) {
                    $score += 3;
                    break;
                }
            }
        }
        
        // Búsqueda en eventos (peso 6)
        if (isset($item['event_venue'])) {
            if (stripos(strtolower($item['event_venue']), $query_lower) !== false) {
                $score += 6;
            }
        }
        
        // Búsqueda en meta fields (peso 2)
        if (isset($item['meta']) && is_array($item['meta'])) {
            foreach ($item['meta'] as $meta_value) {
                if (stripos(strtolower($meta_value), $query_lower) !== false) {
                    $score += 2;
                    break;
                }
            }
        }
        
        return $score;
    }
}
