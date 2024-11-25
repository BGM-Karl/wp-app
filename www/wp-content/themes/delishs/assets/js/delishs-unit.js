(function($) {
    "use strict";

    // Menu Last
    $('.main-menu .main-menu__list>li').slice(-4).addClass('menu-last');

    // Data Background
    $("[data-background").each(function() {
        $(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
    });

    // Data Background
    $("[data-bg-color]").each(function() {
        $(this).css("background-color", $(this).attr("data-bg-color"));
    });

    // Nice Select Js
    $('.sidebar__single select, .footer-widget select, .postbox__item select, .form-item select, .woocommerce-ordering select, .variations_form select').niceSelect();

    // Post Format: Video
    $(".popup-video").magnificPopup({
        type: "iframe",
    });

    // Post Format: Slider
    var postboxSlider = new Swiper('.postbox__slider', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        autoplay: {
            delay: 3000,
        },
        // Navigation arrows
        navigation: {
            nextEl: ".postbox-slider-button-next",
            prevEl: ".postbox-slider-button-prev",
        },
        breakpoints: {
            '1200': {
                slidesPerView: 1,
            },
            '992': {
                slidesPerView: 1,
            },
            '768': {
                slidesPerView: 1,
            },
            '576': {
                slidesPerView: 1,
            },
            '0': {
                slidesPerView: 1,
            },
        },
    });
})(jQuery);