(function($) {
    "use strict";

    function heroSection() {
        $("[data-background").each(function() {
            $(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
        });
    }

    function heroSlider() {
        $("[data-background").each(function() {
            $(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
        });
        let banner__slider = new Swiper ('.banner__slider', {
            slidesPerView: '1',
            centeredSlides: true,
            loop: true,
            loopedSlides: 6,
            autoplay: {
                delay: 4000,
            },
        });
        let banner__thumbnail = new Swiper ('.banner__thumbnail', {
            slidesPerView: 'auto',
            spaceBetween: 10,
            centeredSlides: true,
            loop: true,
            slideToClickedSlide: true,
        });
        banner__slider.controller.control = banner__thumbnail;
        banner__thumbnail.controller.control = banner__slider;
    }

    function gallerySlider() {
        $("[data-background").each(function() {
            $(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
        });
        let customerFeedback__active = new Swiper(".our-project__slider", {
            slidesPerView: 5,
            spaceBetween: 15,
            loop: true,
            autoplay: {
                delay: 3000,
            },
            navigation: {
                prevEl: ".our-project__slider__arrow-prev",
                nextEl: ".our-project__slider__arrow-next",
            },
            breakpoints: {
                1500: {
                    slidesPerView: 5,
                },
                1200: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 3,
                },
                575: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });
    }

    function counterSection() {
        $("[data-background").each(function() {
            $(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
        });
        $('.odometer').waypoint(function(direction) {
            if (direction === 'down') {
                let countNumber = $(this.element).attr("data-count");
                $(this.element).html(countNumber);
            }
        }, {
            offset: '80%'
        });
        if ($(".count-bar").length) {
            $(".count-bar").appear(
                function() {
                    var el = $(this);
                    var percent = el.data("percent");
                    $(el).css("width", percent).addClass("counted");
                }, {
                    accY: -50
                }
            );
        }
    }

    function callTOAction() {
        $("[data-background").each(function() {
            $(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
        });
    }

    function discountSection() {
        $("[data-background").each(function() {
            $(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
        });
    }

    function advancedFoodMenu() {
        $('.grid').imagesLoaded(function () {
            var $grid = $('.grid').isotope({
                itemSelector: '.grid-item',
                layoutMode: 'fitRows'
            });
    
            $('.masonary-menu').on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $grid.isotope({ filter: filterValue });
            });
            $('.masonary-menu button').on('click', function (event) {
                $(this).siblings('.active').removeClass('active');
                $(this).addClass('active');
                event.preventDefault();
            });
        });
    }

    function testimonialSlider() {
        $("[data-background").each(function() {
            $(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
        });
        let header3TopSlider = new Swiper(".testimonial__slider", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            navigation: {
                prevEl: ".testimonial__slider__arrow-prev",
                nextEl: ".testimonial__slider__arrow-next",
            },
            clickable: true,
            autoplay: {
                delay: 3000,
            }
        });
    
        /*client-testimonial__slider***/
        let clienttestimonial__slider = new Swiper(".client-testimonial__slider", {
            slidesPerView: 2,
            spaceBetween: 60,
            loop: true,
            clickable: true,
            autoplay: {
                delay: 3000,
            },
            breakpoints: {
                992: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                },
            }
        });
    
        /*client-feedback__slider***/
        let clientfeedback__slider = new Swiper(".client-feedback__slider", {
            slidesPerView: 2,
            spaceBetween: 24,
            loop: true,
            clickable: true,
            autoplay: {
                delay: 3000,
            },
            breakpoints: {
                992: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                },
            }
        });
    }

    $(window).on("elementor/frontend/init", function() {
        elementorFrontend.hooks.addAction("frontend/element_ready/delishs_hero.default", heroSection);
        elementorFrontend.hooks.addAction("frontend/element_ready/delishs_hero_slider.default", heroSlider);
        elementorFrontend.hooks.addAction("frontend/element_ready/delishs_gallery_slider.default", gallerySlider);
        elementorFrontend.hooks.addAction("frontend/element_ready/delishs_counter.default", counterSection);
        elementorFrontend.hooks.addAction("frontend/element_ready/delishs_cta.default", callTOAction);
        elementorFrontend.hooks.addAction("frontend/element_ready/delishs_discount.default", discountSection);
        elementorFrontend.hooks.addAction("frontend/element_ready/delishs_advanced_food_menu.default", advancedFoodMenu);
        elementorFrontend.hooks.addAction("frontend/element_ready/delishs_testimonial_slider.default", testimonialSlider);
    });


})(jQuery);