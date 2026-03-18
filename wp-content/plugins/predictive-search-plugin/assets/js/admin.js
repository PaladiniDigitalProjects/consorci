(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Confirmación y feedback al regenerar índice (AJAX asíncrono)
        $('#ps-regenerate-form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $btn = $('#ps-regenerate-btn');
            const originalText = $btn.val();
            const isCreating = originalText.includes('Crear');
            
            const message = isCreating 
                ? '¿Estás seguro de que deseas crear el índice? Este proceso puede tardar varios minutos dependiendo de la cantidad de contenido.'
                : '¿Estás seguro de que deseas regenerar el índice? Este proceso puede tardar varios minutos.';
            
            const confirmed = confirm(message);
            
            if (!confirmed) {
                return false;
            }
            
            // Mostrar estado de carga
            $form.addClass('ps-loading');
            $btn.prop('disabled', true);
            const originalBtnText = $btn.val();
            $btn.val('⏳ Generando índice...');
            
            // Mostrar overlay de carga
            showLoadingOverlay();
            
            // Realizar petición AJAX
            $.ajax({
                url: psAdminAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'ps_ajax_regenerate_index',
                    nonce: psAdminAjax.nonce
                },
                success: function(response) {
                    hideLoadingOverlay();
                    
                    if (response.success) {
                        // Mostrar mensaje de éxito
                        showNotice(
                            '✅ ' + response.data.message + ' Se indexaron ' + response.data.total_posts + ' elementos. Tamaño: ' + response.data.file_size,
                            'success'
                        );
                        
                        // Recargar la página después de 2 segundos para actualizar estadísticas
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    } else {
                        showNotice('❌ Error: ' + response.data.message, 'error');
                        $btn.prop('disabled', false);
                        $btn.val(originalBtnText);
                    }
                },
                error: function(xhr, status, error) {
                    hideLoadingOverlay();
                    showNotice('❌ Error al generar el índice: ' + error, 'error');
                    $btn.prop('disabled', false);
                    $btn.val(originalBtnText);
                }
            });
            
            return false;
        });
        
        // Mostrar mensaje de éxito si se regeneró
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('regenerated') === '1') {
            // Limpiar URL después de un momento
            setTimeout(function() {
                const cleanUrl = window.location.pathname + '?page=predictive-search';
                window.history.replaceState({}, document.title, cleanUrl);
            }, 3000);
        }
        
        // Tooltip para campos excluidos
        $('.ps-field-checkboxes input[type="checkbox"]').on('change', function() {
            const checkedCount = $('.ps-field-checkboxes input[type="checkbox"]:checked').length;
            const totalCount = $('.ps-field-checkboxes input[type="checkbox"]').length;
            
            if (checkedCount === totalCount) {
                alert('⚠️ Advertencia: Has excluido todos los campos. La búsqueda no devolverá ningún resultado.');
            }
        });
        
        // Confirmar si hay cambios sin guardar al salir
        let formChanged = false;
        $('form[action="options.php"] input, form[action="options.php"] select').on('change', function() {
            formChanged = true;
        });
        
        $('form[action="options.php"]').on('submit', function() {
            formChanged = false;
        });
        
        $(window).on('beforeunload', function() {
            if (formChanged) {
                return '¿Estás seguro de que deseas salir? Hay cambios sin guardar.';
            }
        });
    });
    
    function showLoadingOverlay() {
        // Remover overlay existente si hay uno
        $('.ps-loading-overlay').remove();
        
        const overlay = $('<div class="ps-loading-overlay">' +
            '<div class="ps-loading-content">' +
            '<div class="ps-spinner-large"></div>' +
            '<p><strong>Generando índice de búsqueda...</strong></p>' +
            '<p class="ps-loading-hint">Por favor, espera. Este proceso puede tardar varios minutos.</p>' +
            '</div>' +
            '</div>');
        
        $('body').append(overlay);
        
        // Estilos inline para el overlay
        $('.ps-loading-overlay').css({
            'position': 'fixed',
            'top': 0,
            'left': 0,
            'right': 0,
            'bottom': 0,
            'background': 'rgba(0, 0, 0, 0.7)',
            'display': 'flex',
            'align-items': 'center',
            'justify-content': 'center',
            'z-index': 999999
        });
        
        $('.ps-loading-content').css({
            'background': '#fff',
            'padding': '40px',
            'border-radius': '8px',
            'text-align': 'center',
            'box-shadow': '0 4px 20px rgba(0, 0, 0, 0.3)'
        });
        
        $('.ps-spinner-large').css({
            'width': '50px',
            'height': '50px',
            'border': '5px solid #f3f3f3',
            'border-top': '5px solid #2271b1',
            'border-radius': '50%',
            'animation': 'ps-spin 1s linear infinite',
            'margin': '0 auto 20px'
        });
        
        $('.ps-loading-hint').css({
            'color': '#666',
            'font-size': '12px',
            'margin-top': '10px'
        });
    }
    
    function hideLoadingOverlay() {
        $('.ps-loading-overlay').fadeOut(300, function() {
            $(this).remove();
        });
    }
    
    function showNotice(message, type) {
        const $notice = $('<div class="notice notice-' + type + ' is-dismissible ps-notice"><p>' + message + '</p></div>');
        $('.wrap h1').after($notice);
        
        // Auto-dismiss después de 5 segundos
        setTimeout(function() {
            $notice.fadeOut(function() {
                $(this).remove();
            });
        }, 5000);
    }
    
})(jQuery);
