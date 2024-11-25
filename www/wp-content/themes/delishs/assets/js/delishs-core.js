(function ($) {
    "use strict";
    var windowOn = $(window);

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
    
   /*======================================
   Data Css js
   ========================================*/
    $("[data-background]").each(function() {
        $(this).css(
            "background-image",
            "url( " + $(this).attr("data-background") + "  )"
        );
    });

    $("[data-width]").each(function() {
        $(this).css("width", $(this).attr("data-width"));
    });

    // prelaoder
    let span = $('.letter'),
        tlSmell = new TimelineMax({repeat : -1});
    tlSmell
        .staggerFromTo($('svg .smell'), 3, {y: 50, autoAlpha: 0.5}, {y: -20, autoAlpha: 1}, 1);
    TweenMax.fromTo($('svg #body'), 3, {x: -1, repeat : -1, yoyo : true}, {x: 1, repeat : -1, yoyo : true});

    class GSAPAnimation {
        static Init() {
            /*title-animation*/
            $('.title-animation').length && this.sectionTitleAnimation('.title-animation'); 
        }
        
        static sectionTitleAnimation(activeClass) {
            let sectionTitleLines = gsap.utils.toArray(activeClass);

            sectionTitleLines.forEach(sectionTextLine => {
                const tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: sectionTextLine,
                        start: 'top 90%',
                        end: 'bottom 60%',
                        scrub: false,
                        markers: false,
                        toggleActions: 'play none none none'
                    }
                });

                const itemSplitted = new SplitText(sectionTextLine, { type: "chars, words" });
                gsap.set(sectionTextLine, { perspective: 100 });
                itemSplitted.split({ type: "words" })
                tl.from(itemSplitted.words, {
                    opacity: 0, 
                    autoAlpha: 0, 
                    transformOrigin: "top center -50",
                    y: "10px",
                    duration: 0.9,
                    stagger: 0.1,
                    ease: "power2.out",
                });
            });
        }
    }

    class RRDEVS {
        static LoadedAfter() {
            $('#preloader').delay(1).fadeOut(0);

            $('.odometer').waypoint(function(direction) {
                if (direction === 'down') {
                    let countNumber = $(this.element).attr("data-count");
                    $(this.element).html(countNumber);
                }
            }, {
                offset: '80%'
            });

            /*Wow Js*/
            if ($('.wow').length) {
                var wow = new WOW({
                    boxClass: 'wow',
                    animateClass: 'animated',
                    offset: 0,
                    mobile: false,
                    live: true
                });
                wow.init();
            }

            /*GSAPAnimation*/
            GSAPAnimation.Init();
        }
    }

    /*======================================
      Preloader activation
      ========================================*/
    $(window).on('load', RRDEVS.LoadedAfter);
    $(".preloader-close").on("click",  RRDEVS.LoadedAfter)

    window.addEventListener('resize', function() {
        gsap.globalTimeline.clear();
    });

    /*======================================
      Mobile Menu Js
      ========================================*/
    $("#mobile-menu").meanmenu({
        meanMenuContainer: ".mobile-menu",
        meanScreenWidth: "1199",
        meanExpand: ['<i class="fa-regular fa-angle-right"></i>'],
    });

    /*======================================
      Sidebar Toggle
      ========================================*/
    $(".offcanvas__close,.offcanvas__overlay").on("click", function () {
        $(".offcanvas__area").removeClass("info-open");
        $(".offcanvas__overlay").removeClass("overlay-open");
    });
    // Scroll to bottom then close navbar
    $(window).scroll(function(){
        if($("body").scrollTop() > 0 || $("html").scrollTop() > 0) {
            $(".offcanvas__area").removeClass("info-open");
            $(".offcanvas__overlay").removeClass("overlay-open");
        }
    });
    $(".sidebar__toggle").on("click", function () {
        $(".offcanvas__area").addClass("info-open");
        $(".offcanvas__overlay").addClass("overlay-open");
    });

    /*======================================
      Body overlay Js
      ========================================*/
    $(".body-overlay").on("click", function () {
        $(".offcanvas__area").removeClass("opened");
        $(".body-overlay").removeClass("opened");
    });

    /*======================================
      Sticky Header Js
      ========================================*/
    $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
            $("#header-sticky").addClass("rr-sticky");
        } else {
            $("#header-sticky").removeClass("rr-sticky");
        }
    });

    /*======================================
      MagnificPopup image view
      ========================================*/
    $(".popup-image").magnificPopup({
        type: "image",
        gallery: {
            enabled: true,
        },
    });

    /*======================================
      MagnificPopup video view
      ========================================*/
    $(".popup-video").magnificPopup({
        type: "iframe",
    });

    /*======================================
      Page Scroll Percentage
      ========================================*/
    const scrollTopPercentage = ()=> {
        const scrollPercentage = () => {
            const scrollTopPos = document.documentElement.scrollTop;
            const calcHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollValue = Math.round((scrollTopPos / calcHeight) * 100);
            const scrollElementWrap = $("#scroll-percentage");

            scrollElementWrap.css("background", `conic-gradient( var(--rr-theme-primary) ${scrollValue}%, var(--rr-theme-secondary) ${scrollValue}%)`);

            if ( scrollTopPos > 100 ) {
                scrollElementWrap.addClass("active");
            } else {
                scrollElementWrap.removeClass("active");
            }

            if( scrollValue < 96 ) {
                $("#scroll-percentage-value").text(`${scrollValue}%`);
            } else {
                $("#scroll-percentage-value").html('<i class="fa-solid fa-angle-up"></i>');
            }
        }
        window.onscroll = scrollPercentage;
        window.onload = scrollPercentage;

        // Back to Top
        function scrollToTop() {
            document.documentElement.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }

        $("#scroll-percentage").on("click", scrollToTop);
    }
    scrollTopPercentage();

    /*======================================
	One Page Scroll Js
	========================================*/
    var link = $('.onepagenav #mobile-menu ul li a, .onepagenav .mean-nav ul li a');
    link.on('click', function(e) {
        var target = $($(this).attr('href'));
        $('html, body').animate({
            scrollTop: target.offset().top - 76
        }, 600);
        $(this).parent().addClass('active');
        e.preventDefault();
    });
    $(window).on('scroll', function(){
        scrNav();
    });

    function scrNav() {
        var sTop = $(window).scrollTop();
        $('section').each(function() {
            var id = $(this).attr('id'),
                offset = $(this).offset().top-1,
                height = $(this).height();
            if(sTop >= offset && sTop < offset + height) {
                link.parent().removeClass('active');
                $('.main-menu').find('[href="#' + id + '"]').parent().addClass('active');
            }
        });
    }
    scrNav();

    /*======================================
	Smoth animatio Js
	========================================*/
    $(document).on('click', '.smoth-animation', function (event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top - 50
        }, 300);
    });

    /*testimonial__slider***/
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

    $('.footer-2__widget select, .checkout-form__item-input-select select, .contact-us-message__form-input-select select, .book-a-table-3__select select, .book-a-table-3__input.time select, .book-a-table__content-form__select select, .banner-3__book-a-table__select select, .banner-3__book-a-table__input select, .book-a-table-2__form__select select, .contact-us-message__form-input-select select').niceSelect();

    $(".search-open-btn").on("click", function () {
        $(".search__popup").addClass("search-opened");
    });

    $(".search-close-btn").on("click", function () {
        $(".search__popup").removeClass("search-opened");
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

    /*our-project__slider***/
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

    /*blog-4__item__thumb-slider***/
    let blog4ItemThumbSlider = new Swiper(".blog-4__item__thumb-slider", {
        slidesPerView: 1,
        loop: true,
        autoplay: {
            delay: 3000,
        },
        navigation: {
            prevEl: ".blog-4__item__thumb-slider__arrow-prev",
            nextEl: ".blog-4__item__thumb-slider__arrow-next",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
        },
    });

    function lastNobullet() {
        $(".last_no_bullet ul").each(function() {
            var $listItems = $(this).find("li");

            if ($listItems.length > 1) {
                $listItems.last().addClass("no_bullet");
            }
        });
    }

    lastNobullet();

    $(window).resize(function() {
        lastNobullet();
    });

    function handleQuantityButtons() {
        $('.product__quantity__group .minus').click(function() {
            var input = $(this).closest('.product__quantity__group').find('input.qty');
            var currentValue = parseInt(input.val());
            if (currentValue > 1) {
                input.val(currentValue - 1).change();
            }
        });

        $('.product__quantity__group .plus').click(function() {
            var input = $(this).closest('.product__quantity__group').find('input.qty');
            var currentValue = parseInt(input.val());
            input.val(currentValue + 1).change();
        });
    }

    handleQuantityButtons();

    function handleServiceQuantityButtons() {
        $('.shop-details__quantity-group .minus').click(function() {
            var input = $(this).closest('.shop-details__quantity-group').find('input.qty');
            var currentValue = parseInt(input.val());
            if (currentValue > 1) {
                input.val(currentValue - 1).change();
            }
        });
        $('.shop-details__quantity-group .plus').click(function() {
            var input = $(this).closest('.shop-details__quantity-group').find('input.qty');
            var currentValue = parseInt(input.val());
            input.val(currentValue + 1).change();
        });
    }
    handleServiceQuantityButtons();

    $('#showlogin').on('click', function () {
        $('#checkout-login').slideToggle(400);
    });
    $('#showcoupon').on('click', function () {
        $('#checkout_coupon').slideToggle(400);
    });

    $('#contact-us-message__form').submit(function(event) {
        event.preventDefault();
        var form = $(this);
        var valid = true;

        form.find('.error-message').remove();
        form.find('.success-message').remove();

        form.find('input, textarea, select').each(function() {
            if ($(this).val().trim() === '') {
                valid = false;
                $(this).parent().after('<p class="error-message  mt-3 mb-0">This field is required.</p>');
            }
        });

        if (!valid) {
            return;
        }

        $('.loading-form').show();

        setTimeout(function() {
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize()
            }).done(function(data) {
                $('.loading-form').hide();
                form.append('<p class="success-message mt-3 mb-0">Your message has been sent successfully.</p>');
            }).fail(function(data) {
                $('.loading-form').hide();
                form.append('<p class="error-message mt-3 mb-0">Something went wrong. Please try again later.</p>');
            });
        }, 1000);
    });


})(jQuery);

