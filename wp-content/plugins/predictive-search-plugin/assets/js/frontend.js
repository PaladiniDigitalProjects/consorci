(function($) {
    'use strict';
    
    let searchTimeout = null;
    let currentRequest = null;
    
    $(document).ready(function() {
        
        // Inicializar cada instancia del buscador
        $('.ps-search-form').each(function() {
            initSearchForm($(this));
        });
        
        // Checklist de diagnóstico en consola (si está habilitado)
        if (typeof psAjax !== 'undefined' && psAjax.diagnostic) {
            runDiagnosticChecklist();
        }
    });
    
    /**
     * Jerarquía de comprobaciones y checklist en consola para localizar fallos desde el front
     */
    function runDiagnosticChecklist() {
        var groupLabel = '[Predictive Search] Diagnóstico';
        var checks = [];
        
        // 1. Variables globales del plugin
        if (typeof psAjax === 'undefined') {
            checks.push({ ok: false, name: 'psAjax', msg: 'No existe psAjax (script no localizado)' });
        } else {
            checks.push({ ok: true, name: 'psAjax', msg: 'Objeto psAjax disponible' });
            
            if (!psAjax.ajaxurl) {
                checks.push({ ok: false, name: 'psAjax.ajaxurl', msg: 'Falta ajaxurl' });
            } else {
                checks.push({ ok: true, name: 'psAjax.ajaxurl', msg: psAjax.ajaxurl });
            }
            
            if (!psAjax.nonce) {
                checks.push({ ok: false, name: 'psAjax.nonce', msg: 'Falta nonce' });
            } else {
                checks.push({ ok: true, name: 'psAjax.nonce', msg: 'Nonce presente' });
            }
        }
        
        // 2. DOM del buscador
        var $form = $('.ps-search-form').first();
        if (!$form.length) {
            checks.push({ ok: false, name: 'DOM formulario', msg: 'No se encontró .ps-search-form' });
        } else {
            checks.push({ ok: true, name: 'DOM formulario', msg: 'Formulario encontrado' });
            
            var $input = $form.find('.ps-search-input');
            if (!$input.length) {
                checks.push({ ok: false, name: 'DOM input', msg: 'No se encontró .ps-search-input' });
            } else {
                var minChars = $input.data('min-chars');
                var minCharsOk = minChars !== undefined && minChars !== '';
                checks.push({
                    ok: minCharsOk,
                    name: 'data-min-chars',
                    msg: minCharsOk ? 'min_chars = ' + minChars : 'Falta o inválido data-min-chars en el input'
                });
            }
            
            if (!$form.find('.ps-search-results').length) {
                checks.push({ ok: false, name: 'DOM resultados', msg: 'No se encontró .ps-search-results' });
            } else {
                checks.push({ ok: true, name: 'DOM resultados', msg: 'Contenedor de resultados OK' });
            }
        }
        
        // 3. jQuery
        checks.push({
            ok: typeof $ !== 'undefined' && typeof $.ajax === 'function',
            name: 'jQuery + AJAX',
            msg: typeof $.ajax === 'function' ? 'jQuery y $.ajax disponibles' : 'jQuery o $.ajax no disponible'
        });
        
        // Llamada AJAX de diagnóstico (backend + nonce + índice)
        if (typeof psAjax !== 'undefined' && psAjax.ajaxurl && psAjax.nonce) {
            $.ajax({
                url: psAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'ps_diagnostic',
                    nonce: psAjax.nonce
                },
                success: function(response) {
                    if (response.success && response.data && response.data.checks) {
                        $.each(response.data.checks, function(key, c) {
                            checks.push({ ok: c.ok, name: c.name, msg: c.msg });
                        });
                        if (response.data.index_count > 0) {
                            checks.push({
                                ok: true,
                                name: 'Índice (resumen)',
                                msg: response.data.index_count + ' elementos · Última indexación: ' + (response.data.last_index || 'N/A')
                            });
                        }
                    }
                    printChecklistToConsole(groupLabel, checks);
                },
                error: function(xhr, status, err) {
                    checks.push({ ok: false, name: 'Llamada diagnóstico', msg: status + ': ' + (err || xhr.status) });
                    printChecklistToConsole(groupLabel, checks);
                }
            });
        } else {
            printChecklistToConsole(groupLabel, checks);
        }
    }
    
    function printChecklistToConsole(groupLabel, checks) {
        if (typeof console === 'undefined' || !console.groupCollapsed) return;
        
        var failed = 0;
        var list = checks.map(function(c) {
            if (!c.ok) failed++;
            return (c.ok ? '✅' : '❌') + ' ' + c.name + (c.msg ? ': ' + c.msg : '');
        });
        
        console.groupCollapsed(
            '%c' + groupLabel + ' — ' + (failed === 0 ? 'OK' : failed + ' fallo(s)'),
            failed ? 'color: #c00; font-weight: bold;' : 'color: #0a0;'
        );
        list.forEach(function(line, i) {
            console.log(checks[i].ok ? '%c' + line : '%c' + line, checks[i].ok ? 'color: #0a0;' : 'color: #c00;');
        });
        console.groupEnd();
    }
    
    function logDebug() {
        if (typeof psAjax !== 'undefined' && psAjax.debug && console && console.log) {
            // Use console.log variadic safely
            console.log.apply(console, arguments);
        }
    }
    
    function initSearchForm($form) {
        const $input = $form.find('.ps-search-input');
        const $results = $form.find('.ps-search-results');
        const $resultsList = $form.find('.ps-results-list');
        const $loading = $form.find('.ps-loading');
        const $noResults = $form.find('.ps-no-results');
        const $clearBtn = $form.find('.ps-search-clear');
        const minChars = parseInt($input.data('min-chars')) || 3;
        
        logDebug('[PS] initSearchForm', {
            minChars: minChars,
            form: $form.get(0)
        });
        
        // Event listener para el input
        $input.on('input', function() {
            const query = $(this).val().trim();
            logDebug('[PS] input change', { query: query, length: query.length });
            
            // Mostrar/ocultar botón clear
            if (query.length > 0) {
                $clearBtn.show();
            } else {
                $clearBtn.hide();
                $results.hide();
                return;
            }
            
            // Cancelar búsqueda anterior
            if (searchTimeout) {
                clearTimeout(searchTimeout);
                logDebug('[PS] debounce clearTimeout');
            }
            
            // Cancelar request AJAX anterior
            if (currentRequest) {
                logDebug('[PS] abort previous request');
                currentRequest.abort();
            }
            
            // Verificar caracteres mínimos
            if (query.length < minChars) {
                logDebug('[PS] below minChars, not searching', {
                    queryLength: query.length,
                    minChars: minChars
                });
                $results.hide();
                return;
            }
            
            // Mostrar loading
            $results.show();
            $loading.show();
            $resultsList.empty();
            $noResults.hide();
            
            // Realizar búsqueda con debounce
            searchTimeout = setTimeout(function() {
                logDebug('[PS] performSearch (debounced)', { query: query });
                performSearch(query, $form);
            }, 300);
        });
        
        // Event listener para el botón clear
        $clearBtn.on('click', function() {
            logDebug('[PS] clear button click');
            $input.val('').focus();
            $clearBtn.hide();
            $results.hide();
        });
        
        // Event listener para submit
        $form.on('submit', function(e) {
            e.preventDefault();
            const query = $input.val().trim();
            logDebug('[PS] form submit', { query: query });
            
            if (query.length >= minChars) {
                // Si hay resultados, ir al primero
                const $firstResult = $resultsList.find('.ps-result-item:first a');
                if ($firstResult.length) {
                    window.location.href = $firstResult.attr('href');
                }
            }
        });
        
        // Cerrar resultados al hacer click fuera
        $(document).on('click', function(e) {
            if (!$form.is(e.target) && $form.has(e.target).length === 0) {
                $results.hide();
            }
        });
        
        // Mostrar resultados al hacer focus si hay query
        $input.on('focus', function() {
            const query = $(this).val().trim();
            if (query.length >= minChars && $resultsList.children().length > 0) {
                $results.show();
            }
        });
    }
    
    function performSearch(query, $form) {
        const $results = $form.find('.ps-search-results');
        const $resultsList = $form.find('.ps-results-list');
        const $loading = $form.find('.ps-loading');
        const $noResults = $form.find('.ps-no-results');
        
        // Detectar idioma actual (mejorado para WPML)
        let currentLanguage = '';
        
        // Método 1: WPML - desde variable global (más confiable)
        if (typeof wpml_current_language !== 'undefined' && wpml_current_language) {
            currentLanguage = wpml_current_language;
        }
        
        // Método 2: WPML - desde data attribute en el body/html
        if (!currentLanguage && $('body').data('lang')) {
            currentLanguage = $('body').data('lang');
        }
        
        if (!currentLanguage && $('html').data('lang')) {
            currentLanguage = $('html').data('lang');
        }
        
        // Método 3: WPML - desde el HTML lang attribute
        if (!currentLanguage && document.documentElement.lang) {
            const langAttr = document.documentElement.lang;
            // Puede ser 'es-ES' o 'es', tomar solo el código principal
            currentLanguage = langAttr.split('-')[0];
        }
        
        // Método 4: Polylang - desde variable global
        if (!currentLanguage && typeof pll_current_language !== 'undefined') {
            currentLanguage = pll_current_language;
        }
        
        // Método 5: Desde URL (útil para WPML)
        if (!currentLanguage && window.location.pathname) {
            const pathParts = window.location.pathname.split('/').filter(p => p);
            // WPML suele usar /es/, /en/, etc. al inicio
            if (pathParts.length > 0 && pathParts[0].length === 2) {
                const possibleLang = pathParts[0];
                // Verificar que sea un código de idioma válido
                if (/^[a-z]{2}$/i.test(possibleLang)) {
                    currentLanguage = possibleLang;
                }
            }
        }
        
        logDebug('[PS] AJAX search start', {
            query: query,
            language: currentLanguage,
            ajaxurl: typeof psAjax !== 'undefined' ? psAjax.ajaxurl : null
        });
        
        currentRequest = $.ajax({
            url: psAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'ps_search',
                nonce: psAjax.nonce,
                query: query,
                language: currentLanguage
            },
            success: function(response) {
                $loading.hide();
                logDebug('[PS] AJAX search success', {
                    query: query,
                    language: currentLanguage,
                    total: response && response.data ? response.data.total : null
                });
                
                if (response.success && response.data.results.length > 0) {
                    displayResults(response.data.results, $resultsList, query);
                    $noResults.hide();
                } else {
                    $resultsList.empty();
                    $noResults.show();
                }
            },
            error: function(xhr) {
                if (xhr.statusText !== 'abort') {
                    logDebug('[PS] AJAX search error', {
                        status: xhr.status,
                        statusText: xhr.statusText
                    });
                    $loading.hide();
                    $resultsList.empty();
                    $noResults.show();
                    console.error('Error en la búsqueda:', xhr);
                }
            },
            complete: function() {
                logDebug('[PS] AJAX search complete');
                currentRequest = null;
            }
        });
    }
    
    function displayResults(results, $container, query) {
        $container.empty();
        
        results.forEach(function(result) {
            const $item = $('<div class="ps-result-item"></div>');
            
            let html = '<a href="' + escapeHtml(result.url) + '">';
            
            // Thumbnail si existe
            if (result.thumbnail) {
                html += '<div class="ps-result-thumbnail">';
                html += '<img src="' + escapeHtml(result.thumbnail) + '" alt="" loading="lazy" />';
                html += '</div>';
            }
            
            html += '<div class="ps-result-content">';
            
            // Título
            if (result.title) {
                html += '<h4 class="ps-result-title">' + highlightQuery(escapeHtml(result.title), query) + '</h4>';
            }
            
            // Excerpt
            if (result.excerpt) {
                const excerpt = result.excerpt.length > 120 
                    ? result.excerpt.substring(0, 120) + '...' 
                    : result.excerpt;
                html += '<p class="ps-result-excerpt">' + escapeHtml(excerpt) + '</p>';
            }
            
            // Metadata
            html += '<div class="ps-result-meta">';
            html += '<span class="ps-result-type">' + escapeHtml(result.type) + '</span>';
            if (result.date) {
                const date = new Date(result.date);
                html += '<span class="ps-result-date">' + formatDate(date) + '</span>';
            }
            html += '</div>';
            
            html += '</div>';
            html += '</a>';
            
            $item.html(html);
            $container.append($item);
        });
    }
    
    function highlightQuery(text, query) {
        if (!query) return text;
        const regex = new RegExp('(' + escapeRegex(query) + ')', 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    }
    
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
    }
    
    function escapeRegex(text) {
        return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&');
    }
    
    function formatDate(date) {
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return date.toLocaleDateString('es-ES', options);
    }
    
})(jQuery);
