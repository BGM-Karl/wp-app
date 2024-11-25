<?php

/**
 * delishs_scripts description
 * @return [type] [description]
 */
function delishs_scripts() {

    /**
     * all css files
    */

    wp_enqueue_style( 'delishs-fonts', delishs_fonts_url(), array(), time() );
    wp_enqueue_style( 'bootstrap', DELISHS_THEME_ASSETS . 'css/bootstrap.min.css', array() );
    wp_enqueue_style( 'animate', DELISHS_THEME_ASSETS . 'css/animate.min.css', [] );
    wp_enqueue_style( 'fontawesome-pro', DELISHS_THEME_ASSETS . 'css/fontawesome-pro.css', [] );
    wp_enqueue_style( 'magnific-popup', DELISHS_THEME_ASSETS . 'css/magnific-popup.css', [] );
    wp_enqueue_style( 'odometer', DELISHS_THEME_ASSETS . 'css/odometer-theme-default.css', [] );
    wp_enqueue_style( 'nice-select', DELISHS_THEME_ASSETS . 'css/nice-select.css', [] );
    wp_enqueue_style( 'delishs-spacing', DELISHS_THEME_ASSETS . 'css/spacing.css', [] );
    wp_enqueue_style( 'swiper', DELISHS_THEME_ASSETS . 'css/swiper.min.css', [] );
    wp_enqueue_style( 'woocommerce-shop', DELISHS_THEME_ASSETS . 'css/woocommerce-shop.css', [] );
    wp_enqueue_style( 'delishs-core', DELISHS_THEME_ASSETS . 'css/delishs-core.css', [], time() );
    wp_enqueue_style( 'delishs-unit', DELISHS_THEME_ASSETS . 'css/delishs-unit.css', [], time() );
    wp_enqueue_style( 'delishs-update', DELISHS_THEME_ASSETS . 'css/delishs-update.css', [], time() );
    wp_enqueue_style( 'delishs-custom', DELISHS_THEME_ASSETS . 'css/delishs-custom.css', [] );
    wp_enqueue_style( 'delishs-style', get_stylesheet_uri() );

    // all js
    wp_enqueue_script( 'bootstrap', DELISHS_THEME_ASSETS . 'js/bootstrap.bundle.min.js', [ 'jquery' ], '', true );
    wp_enqueue_script( 'draggable', DELISHS_THEME_ASSETS . 'js/draggable.min.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'gsap', DELISHS_THEME_ASSETS . 'js/gsap.min.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'isotope', DELISHS_THEME_ASSETS . 'js/isotope.pkgd.min.js', [ 'imagesloaded' ], false, true );
    wp_enqueue_script( 'appear', DELISHS_THEME_ASSETS . 'js/jquery.appear.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'magnific-popup', DELISHS_THEME_ASSETS . 'js/magnific-popup.min.js', [ 'jquery' ], '', true );
    wp_enqueue_script( 'meanmenu', DELISHS_THEME_ASSETS . 'js/meanmenu.min.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'nice-select', DELISHS_THEME_ASSETS . 'js/nice-select.min.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'odometer', DELISHS_THEME_ASSETS . 'js/odometer.min.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'parallax-scroll', DELISHS_THEME_ASSETS . 'js/parallax-scroll.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'ScrollTrigger', DELISHS_THEME_ASSETS . 'js/ScrollTrigger.min.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'smoothscroll', DELISHS_THEME_ASSETS . 'js/smoothscroll.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'SplitText', DELISHS_THEME_ASSETS . 'js/SplitText.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'swiper', DELISHS_THEME_ASSETS . 'js/swiper.min.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'tween-max', DELISHS_THEME_ASSETS . 'js/tween-max.min.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'type', DELISHS_THEME_ASSETS . 'js/type.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'waypoints', DELISHS_THEME_ASSETS . 'js/waypoints.min.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'wow', DELISHS_THEME_ASSETS . 'js/wow.js', [ 'jquery' ], false, true );
    wp_enqueue_script( 'delishs-core', DELISHS_THEME_ASSETS . 'js/delishs-core.js', [ 'jquery' ], time(), true );
    wp_enqueue_script( 'delishs-unit', DELISHS_THEME_ASSETS . 'js/delishs-unit.js', [ 'jquery' ], time(), true );
    wp_enqueue_script( 'delishs-elementor', DELISHS_THEME_ASSETS . 'js/delishs-elementor.js', [ 'jquery' ], time(), true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'delishs_scripts' );

/*
Register Fonts
 */
function delishs_fonts_url() {
    $font_url = '';

    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ('off' !== _x('on', 'Google font: on or off', 'delishs')) {
        $font_url = 'https://fonts.googleapis.com/css2?' . urlencode('family=Jost:wght@300;400;500;600;700;800;900&display=swap');
    }
    return $font_url;
}