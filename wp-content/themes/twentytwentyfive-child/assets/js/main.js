document.addEventListener('DOMContentLoaded', function() {
    jQuery(function($){

    var mywindow = $(window);
    var mypos = mywindow.scrollTop();

    mywindow.scroll(function() {
    if (mypos > 10) {
        if(mywindow.scrollTop() > mypos) {
            $('header.wp-block-template-part').addClass('headerup');
            $('header.wp-block-template-part').removeClass('fullheader');
            // $('.single-products .apertura').removeClass('fixed');
        } else {
            $('header.wp-block-template-part').removeClass('headerup');
            $('header.wp-block-template-part').addClass('fullheader');
            // $('.single-products .apertura').addClass('fixed');      
        } if (mypos = 0) {
            $('header.wp-block-template-part').removeClass('fullheader');
            }
        }
        mypos = mywindow.scrollTop();
        });

        $('#btn-open').click(function (e) {
            if ($('.menu-nav or body or #btn-close').hasClass("active")) {
                $('.menu-nav').removeClass("active");
                $('body').removeClass("active");
                $('#btn-close').removeClass("active");
            }
            else {
                $('.menu-nav').addClass("active");
                $('body').addClass("active");
                $('#btn-close').addClass("active");
            }
        });

        $('#btn-close').click(function (e) {
                $('.menu-nav').removeClass("active");
                $('body').removeClass("active");
                $('#btn-close').removeClass("active");
        });

    });    
});

window.addEventListener('load', function() {


    /* NAVEGACIÓ SUBSECCIONS */


    function activarSubmenusUniversal(triggerSelector = '.submenu > a', className = 'hide') {
    const triggers = document.querySelectorAll(triggerSelector);

    triggers.forEach(trigger => {
        const targetId = trigger.getAttribute('rel');
        const panel = document.getElementById(targetId);

        if (!panel) return;

        // Mostrar cuando el mouse entra al trigger
        trigger.addEventListener('mouseenter', () => {
        panel.classList.remove(className);
        });

        // Ocultar cuando el mouse sale del trigger
        trigger.addEventListener('mouseleave', () => {
        panel.classList.add(className);
        });

        // También ocultar cuando el mouse salga del panel
        panel.addEventListener('mouseleave', () => {
        panel.classList.add(className);
        });

        // (Opcional) mantener visible si el mouse entra al panel
        panel.addEventListener('mouseenter', () => {
        panel.classList.remove(className);
        });
    });
    }
    activarSubmenusUniversal();
    console.log('La página ha terminado de cargarse!!');
});


