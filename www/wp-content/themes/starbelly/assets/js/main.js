/* -------------------------------------------

Name: 		Starbelly
Version:  1.0
Author:		Nazar Miller (millerDigitalDesign)
Portfolio:  https://themeforest.net/user/millerdigitaldesign/portfolio?ref=MillerDigitalDesign

p.s. I am available for Freelance hire (UI design, web development). mail: miller.themes@gmail.com

------------------------------------------- */

( function( $ ) {
  'use strict';

  var elementor = 0;
  if ( window.location.href.indexOf('/?elementor-preview=') > -1 ) {
      elementor = 1;
  }

  /***************************

  preloader

  ***************************/

  if ( $.cookie('preloaderHide') == 'yes' ) {
    $('.sb-preloader').addClass('sb-hidden');
  }

  $(document).ready(function() {
    $(".sb-loading").animate({
      opacity: 1
    }, {
      duration: 500,
    });
    setTimeout(function() {
      $('.sb-preloader-number').each(function() {
        var $this = $(this),
          countTo = $this.attr('data-count');
        $({
          countNum: $this.text()
        }).animate({
          countNum: countTo
        }, {
          duration: 1000,
          easing: 'swing',
          step: function() {
            $this.text(Math.floor(this.countNum));
          },
        });
      });
      $(".sb-bar").animate({
        height: '100%'
      }, {
        duration: 1000,
        complete: function() {

          $(".sb-preloader").addClass('sb-hidden');
          $.cookie('preloaderHide', 'yes', { expires: 7, path: '/' });
        }
      });
    }, 400);
  });

  /***************************

  faq

  ***************************/
  $('.sb-faq li .sb-question').on('click', function() {
    $(this).find('.sb-plus-minus-toggle').toggleClass('sb-collapsed');
    $(this).parent().toggleClass('sb-active');
  });
  /***************************

  isotope

  ***************************/
  $('.sb-filter a').on('click', function() {
    $('.sb-filter .sb-active').removeClass('sb-active');
    $(this).addClass('sb-active');

    var selector = $(this).data('filter');
    $('.sb-masonry-grid').isotope({
      filter: selector
    });
    return false;
  });
  $(document).ready(function() {
    $('.sb-masonry-grid').isotope({
      itemSelector: '.sb-grid-item',
      percentPosition: true,
      masonry: {
        columnWidth: '.sb-grid-sizer'
      }
    });
  });
  if ( $('.sb-tabs').length ) {
    var firstTab = $('.sb-filter a:first').data('filter');

    $('.sb-tabs').isotope({
      filter: firstTab
    });
  }
  /***************************

  discount popup

  ***************************/
  function showPopup() {
    $('.sb-popup-frame').addClass('sb-active');
  }
  if ( $.cookie('discountPopupClosed') != 'yes' ) {
    setTimeout(showPopup, 10000);
  }
  $('.sb-close-popup , .sb-ppc').on('click', function() {
    $('.sb-popup-frame').removeClass('sb-active');
    $.cookie('discountPopupClosed', 'yes', { expires: 7, path: '/' });
  });
  /***************************

  click effect

  ***************************/
  const cursor = document.querySelector('.sb-click-effect')
  document.addEventListener('mousemove', (e) => {
    cursor.setAttribute('style', "top:" + (e.pageY - 15) + "px; left:" + (e.pageX - 15) + "px;")
  });
  document.addEventListener('click', () => {
    cursor.classList.add('sb-click')
    setTimeout(() => {
      cursor.classList.remove('sb-click')
    }, 600)
  });

  /***************************

  menu

  ***************************/
  $('.sb-menu-btn').on('click', function() {
    $('.sb-menu-btn , .sb-navigation').toggleClass('sb-active');
    $('.sb-info-btn , .sb-info-bar , .sb-minicart').removeClass('sb-active');
  });
  $('.sb-info-btn').on('click', function() {
    $('.sb-info-btn , .sb-info-bar').toggleClass('sb-active');
    $('.sb-menu-btn , .sb-navigation , .sb-minicart').removeClass('sb-active');
  });
  $('.sb-btn-cart').on('click', function() {
    $('.sb-minicart').toggleClass('sb-active');
    $('.sb-info-btn , .sb-info-bar , .sb-navigation , .sb-menu-btn , .sb-info-btn').removeClass('sb-active');
  });
  $(window).on("scroll", function() {
    var scroll = $(window).scrollTop();
    if (scroll >= 10) {
      $('.sb-top-bar-frame').addClass('sb-scroll');
    } else {
      $('.sb-top-bar-frame').removeClass('sb-scroll');
    }
    if (scroll >= 10) {
      $('.sb-info-bar , .sb-minicart').addClass('sb-scroll');
    } else {
      $('.sb-info-bar , .sb-minicart').removeClass('sb-scroll');
    }
  });
  $(document).on('click', function(e) {
    var el = '.sb-minicart , .sb-btn-cart , .sb-menu-btn , .sb-navigation , .sb-info-btn , .sb-info-bar';
    if (jQuery(e.target).closest(el).length) return;
    $('.sb-minicart , .sb-btn-cart , .sb-menu-btn , .sb-navigation , .sb-info-btn , .sb-info-bar').removeClass('sb-active');
  });

  if ($(window).width() < 992) {
    $(".sb-has-children > a").attr("href", "#.")
  }
  $(window).resize(function() {
    if ($(window).width() < 992) {
      $(".sb-has-children > a").attr("href", "#.")
    }
  });
  /***************************

  quantity

  ***************************/
  $('.sb-add').on('click', function() {
    var input_el = $(this).prev().find('input[type="number"]');
    var input_number = parseInt( input_el.val() ) | 0;
    var input_min = parseInt( input_el.attr('min') );
    var input_max = parseInt( input_el.attr('max') );
    var input_step = parseInt( input_el.attr('step') );
    if ( !input_max ) { input_max = 999999; }

    if ( input_number < input_max ) {
      input_el.val( input_number + input_step );

      input_el.trigger('change');
    }
  });
  $('.sb-sub').on('click', function() {
    var input_el = $(this).next().find('input[type="number"]');
    var input_number = parseInt( $(this).next().find('input[type="number"]').val() );
    var input_min = parseInt( input_el.attr('min') );
    var input_max = parseInt( input_el.attr('max') );
    var input_step = parseInt( input_el.attr('step') );

    if ( !input_min ) { input_min = 1; }

    if ( input_number > input_min ) {
      input_el.val( input_number - input_step );

      input_el.trigger('change');
    }
  });
  /***************************

  sticky

  ***************************/
  var sticky = new Sticky('.sb-sticky');
  if ($(window).width() < 992) {
    sticky.destroy();
  }
  /***************************

  sliders

  ***************************/
  $('.sb-short-menu-slider-3i').each(function() {
  var swiper_1_el = $(this)[0];
  var swiper_1 = new Swiper(swiper_1_el, {
    slidesPerView: 3,
    spaceBetween: 30,
    parallax: true,
    speed: 1000,
    preventClicks: false,
    preventClicksPropagation: false,
    navigation: {
      prevEl: '.sb-short-menu-prev',
      nextEl: '.sb-short-menu-next',
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      }
    }
  });
  });
  $('.sb-short-menu-slider-2-3i').each(function() {
  var swiper_2_el = $(this)[0];
  var swiper_2 = new Swiper(swiper_2_el, {
    slidesPerView: 3,
    spaceBetween: 30,
    parallax: true,
    speed: 1000,
    preventClicks: false,
    preventClicksPropagation: false,
    navigation: {
      prevEl: '.sb-short-menu-prev-2',
      nextEl: '.sb-short-menu-next-2',
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      }
    }
  });
  });
  $('.sb-short-menu-slider-4i').each(function() {
  var swiper_3_el = $(this)[0];
  var swiper_3 = new Swiper(swiper_3_el, {
    slidesPerView: 4,
    spaceBetween: 30,
    parallax: true,
    speed: 1000,
    preventClicks: false,
    preventClicksPropagation: false,
    navigation: {
      prevEl: '.sb-short-menu-prev',
      nextEl: '.sb-short-menu-next',
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 4,
      }
    }
  });
  });
  $('.sb-short-menu-slider-2-4i').each(function() {
  var swiper_4_el = $(this)[0];
  var swiper_4 = new Swiper(swiper_4_el, {
    slidesPerView: 4,
    spaceBetween: 30,
    parallax: true,
    speed: 1000,
    preventClicks: false,
    preventClicksPropagation: false,
    navigation: {
      prevEl: '.sb-short-menu-prev-2',
      nextEl: '.sb-short-menu-next-2',
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 4,
      }
    }
  });
  });
  var swiper_5 = new Swiper('.sb-reviews-slider', {
    slidesPerView: 2,
    spaceBetween: 30,
    parallax: true,
    speed: 1000,
    preventClicks: false,
    preventClicksPropagation: false,
    navigation: {
      prevEl: '.sb-reviews-prev',
      nextEl: '.sb-reviews-next',
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 2,
      }
    }
  });
  var swiper_6 = new Swiper('.sb-blog-slider-2i', {
    slidesPerView: 2,
    spaceBetween: 30,
    parallax: true,
    speed: 1000,
    preventClicks: false,
    preventClicksPropagation: false,
    navigation: {
      prevEl: '.sb-blog-prev',
      nextEl: '.sb-blog-next',
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 2,
      }
    }
  });
  var swiper_7 = new Swiper('.sb-blog-slider-3i', {
    slidesPerView: 3,
    spaceBetween: 30,
    parallax: true,
    speed: 1000,
    preventClicks: false,
    preventClicksPropagation: false,
    navigation: {
      prevEl: '.sb-blog-prev',
      nextEl: '.sb-blog-next',
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      }
    }
  });
  var swiper_8 = new Swiper('.sb-blog-slider-4i', {
    slidesPerView: 4,
    spaceBetween: 30,
    parallax: true,
    speed: 1000,
    preventClicks: false,
    preventClicksPropagation: false,
    navigation: {
      prevEl: '.sb-blog-prev',
      nextEl: '.sb-blog-next',
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 4,
      }
    }
  });
  /***************************

  map

  ***************************/
  if ($("div").is("#map")) {
    var map_long = $('#map').data('long');
    var map_lat = $('#map').data('lat');
    var map_zoom = $('#map').data('zoom');
    var map_key = $('#map').data('key');
    var map_style_ui = 'mapbox://styles/mapbox/light-v11';


    mapboxgl.accessToken = map_key;

    var map = new mapboxgl.Map({
      container: 'map',
      style: map_style_ui,
      center: [map_long, map_lat],
      zoom: map_zoom
    });

    var marker = new mapboxgl.Marker()
      .setLngLat([map_long, map_lat])
      .addTo(map);
  }
  $(".sb-lock").on('click', function() {
    $('.sb-map').toggleClass('sb-active');
    $('.sb-lock').toggleClass('sb-active');
    $('.sb-lock .fas').toggleClass('fa-unlock');
  });

  /*-------------------------
  datepicker
  -------------------------*/

  $('.sb-datepicker, .datepicker-here').datepicker({
    minDate: new Date(),
    language: 'en',
  });

  $.fn.datepicker.language['en'] = {
    days: datepicker_localize_data.dayNames,
    daysShort: datepicker_localize_data.dayNamesShort,
    daysMin: datepicker_localize_data.dayNamesMin,
    months: datepicker_localize_data.monthNames,
    monthsShort: datepicker_localize_data.monthNamesShort,
    today: datepicker_localize_data.currentText,
    clear: datepicker_localize_data.closeText,
    dateFormat: datepicker_localize_data.dateFormat,
    timeFormat: 'hh:ii aa'
  };

  /*-------------------------
  Magnific Popups
  -------------------------*/
  if(/\.(?:jpg|jpeg|gif|png)$/i.test($('.wp-block-gallery .blocks-gallery-item:first a').attr('href'))){
    $('.wp-block-gallery a').magnificPopup({
      gallery: {
          enabled: true
      },
      type: 'image',
      closeOnContentClick: false,
      fixedContentPos: false,
      closeBtnInside: false,
      callbacks: {
        beforeOpen: function() {
          // just a hack that adds mfp-anim class to markup
           this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
           this.st.mainClass = 'mfp-zoom-in';
        }
      },
    });
  }
  $('[data-magnific-inline]').magnificPopup({
    type: 'inline',
    overflowY: 'auto',
    preloader: false,
    callbacks: {
      beforeOpen: function() {
         this.st.mainClass = 'mfp-zoom-in';
      }
    },
  });
  $('[data-magnific-image]').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    fixedContentPos: false,
    closeBtnInside: false,
    callbacks: {
      beforeOpen: function() {
        // just a hack that adds mfp-anim class to markup
         this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
         this.st.mainClass = 'mfp-zoom-in';
      }
    },
  });
  if (!$('body').hasClass('elementor-page')) {
    $("a").each(function(i, el) {
      var href_value = el.href;
      if (/\.(jpg|png|gif)$/.test(href_value)) {
         $(el).magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            fixedContentPos: false,
            closeBtnInside: false,
            callbacks: {
              beforeOpen: function() {
                // just a hack that adds mfp-anim class to markup
                 this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                 this.st.mainClass = 'mfp-zoom-in';
              }
            },
          });
      }
    });
  }
  $('[data-magnific-video]').magnificPopup({
    type: 'iframe',
    iframe: {
        patterns: {
            youtube_short: {
              index: 'youtu.be/',
              id: 'youtu.be/',
              src: 'https://www.youtube.com/embed/%id%?autoplay=1'
            }
        }
    },
    preloader: false,
    fixedContentPos: false,
    callbacks: {
      markupParse: function(template, values, item) {
        template.find('iframe').attr('allow', 'autoplay');
      },
      beforeOpen: function() {
        // just a hack that adds mfp-anim class to markup
         this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
         this.st.mainClass = 'mfp-zoom-in';
      }
    },
  });
  $('[data-magnific-music]').magnificPopup({
    type: 'iframe',
    preloader: false,
    fixedContentPos: false,
    closeBtnInside: true,
    callbacks: {
      beforeOpen: function() {
        // just a hack that adds mfp-anim class to markup
         this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
         this.st.mainClass = 'mfp-zoom-in';
      }
    },
  });
  $('[data-magnific-gallery]').magnificPopup({
    gallery: {
        enabled: true
    },
    type: 'image',
    closeOnContentClick: false,
    fixedContentPos: false,
    closeBtnInside: false,
    callbacks: {
      beforeOpen: function() {
        // just a hack that adds mfp-anim class to markup
         this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
         this.st.mainClass = 'mfp-zoom-in';
      }
    },
  });

} )( jQuery );
