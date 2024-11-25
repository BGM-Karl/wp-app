<?php

/**
 * delishs functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package delishs
 */

if ( !function_exists( 'delishs_setup' ) ):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function delishs_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on delish, use a find and replace
         * to change 'delishs' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'delishs', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( [
            'main-menu' => esc_html__( 'Main Menu', 'delishs' ),
            'footer-bottom-menu' => esc_html__( 'Footer Bottom Menu', 'delishs' ),
        ] );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ] );

        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'delishs_custom_background_args', [
            'default-color' => 'ffffff',
            'default-image' => '',
        ] ) );

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        //Enable custom header
        add_theme_support( 'custom-header' );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support( 'custom-logo', [
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ] );

        /**
         * Enable suporrt for Post Formats
         *
         * see: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', [
            'image',
            'audio',
            'video',
            'gallery',
            'quote',
        ] );

        // Add support for Block Styles.
        add_theme_support( 'wp-block-styles' );

        // Add support for full and wide align images.
        add_theme_support( 'align-wide' );

        // Add support for editor styles.
        add_theme_support( 'editor-styles' );

        // Add support for responsive embedded content.
        add_theme_support( 'responsive-embeds' );


        // Add support for woocommerce.
        add_theme_support('woocommerce');
        // Remove woocommerce defauly styles
        add_filter('woocommerce_enqueue_styles', '__return_false');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        remove_theme_support( 'widgets-block-editor' );
        add_image_size( 'delishs-case-details', 1170, 600, [ 'center', 'center' ] );
    }
endif;
add_action( 'after_setup_theme', 'delishs_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function delishs_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters( 'delishs_content_width', 640 );
}
add_action( 'after_setup_theme', 'delishs_content_width', 0 );



/**
 * Enqueue scripts and styles.
 */

define( 'DELISHS_THEME_DIR', get_template_directory() );
define( 'DELISHS_THEME_URI', get_template_directory_uri() );
define( 'DELISHS_THEME_ASSETS', DELISHS_THEME_URI . '/assets/' );
define( 'DELISHS_THEME_CSS_DIR', DELISHS_THEME_URI . '/assets/css/' );
define( 'DELISHS_THEME_JS_DIR', DELISHS_THEME_URI . '/assets/js/' );
define( 'DELISHS_THEME_INC', DELISHS_THEME_DIR . '/inc/' );



// wp_body_open
if ( !function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

/**
 * Implement the Custom Header feature.
 */
require DELISHS_THEME_INC . 'custom-header.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require DELISHS_THEME_INC . 'template-functions.php';

/**
 * Custom template helper function for this theme.
 */
require DELISHS_THEME_INC . 'template-helper.php';

/**
 * initialize kirki customizer class.
 */
include_once DELISHS_THEME_INC . 'kirki-customizer.php';
include_once DELISHS_THEME_INC . 'class-delishs-kirki.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require DELISHS_THEME_INC . 'jetpack.php';
}

/**
 * include delishs_ functions file
 */
require_once DELISHS_THEME_INC . 'class-navwalker.php';
require_once DELISHS_THEME_INC . 'class-tgm-plugin-activation.php';
require_once DELISHS_THEME_INC . 'add_plugin.php';
require_once DELISHS_THEME_INC . '/common/delishs-breadcrumb.php';
require_once DELISHS_THEME_INC . '/common/delishs-scripts.php';
require_once DELISHS_THEME_INC . '/common/delishs-widgets.php';

if (class_exists('WooCommerce')) {
    require_once DELISHS_THEME_INC . '/woocommerce/woo-hooks-functions.php';
}


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function delishs_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'delishs_pingback_header' );

// change textarea position in comment form
// ----------------------------------------------------------------------------------------
function delishs_move_comment_textarea_to_bottom( $fields ) {
    $comment_field       = $fields[ 'comment' ];
    unset( $fields[ 'comment' ] );
    $fields[ 'comment' ] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'delishs_move_comment_textarea_to_bottom' );


// delishs_comment 
if ( !function_exists( 'delishs_comment' ) ) {
    function delishs_comment( $comment, $args, $depth ) {
        $GLOBAL['comment'] = $comment;
        extract( $args, EXTR_SKIP );
        $args['reply_text'] = 'Reply';
        $replayClass = 'comment-depth-' . esc_attr( $depth );
        ?>
            <li id="comment-<?php comment_ID();?>">
                <div class="comment-item">
                    <?php if ( get_avatar( $comment, 110 ) ) : ?>
                        <div class="comment-item__media">
                            <?php print get_avatar( $comment, 110, null, null, [ 'class' => [] ] ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="comment-item__content comments-text">
                        <div class="comment-item__header">
                            <div class="comment-item__header-left">
                                <span class="date"><?php comment_time( get_option( 'date_format' ) );?></span>
                                <h5 class="name"><?php print get_comment_author_link();?></h5>
                            </div>
                            <div class="comment-item__header-right">
                                <?php comment_reply_link( array_merge( $args, [ 'reply_text' => __( 'Reply <i class="fa-solid fa-reply"></i>', 'delishs' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ] ) );?>  
                            </div>
                        </div>
                        <?php comment_text();?>
                    </div>
                </div>
        <?php
    }
    function delishs_comment_reply_link_class( $class ) {
        $class = str_replace( "class='comment-reply-link", "class='comment-one__btn", $class );
        return $class;
    }
    
    add_filter( 'comment_reply_link', 'delishs_comment_reply_link_class' );
}


/**
 * shortcode supports for removing extra p, spance etc
 *
 */
add_filter( 'the_content', 'delishs_shortcode_extra_content_remove' );
/**
 * Filters the content to remove any extra paragraph or break tags
 * caused by shortcodes.
 *
 * @since 1.0.0
 *
 * @param string $content  String of HTML content.
 * @return string $content Amended string of HTML content.
 */
function delishs_shortcode_extra_content_remove( $content ) {

    $array = [
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']',
    ];
    return strtr( $content, $array );

}

// delishs_search_filter_form
if ( !function_exists( 'delishs_search_filter_form' ) ) {
    function delishs_search_filter_form( $form ) {

        $form = sprintf(
            '<div class="search-box"><form class="search-form" action="%s" method="get">
      	<input type="search" value="%s" required name="s" placeholder="%s" class="form-control">
      	<button type="submit" class="search-btn"> <i class="fa-light fa-magnifying-glass"></i></button>
		</form></div>',
            esc_url( home_url( '/' ) ),
            esc_attr( get_search_query() ),
            esc_html__( 'Search', 'delishs' )
        );

        return $form;
    }
    add_filter( 'get_search_form', 'delishs_search_filter_form' );
}

add_action( 'admin_enqueue_scripts', 'delishs_admin_custom_scripts' );

function delishs_admin_custom_scripts() {
    wp_enqueue_media();
    wp_enqueue_style( 'customizer-style', get_template_directory_uri() . '/inc/css/customizer-style.css',array());
    wp_enqueue_script( 'delishs_-admin-custom', get_template_directory_uri() . '/inc/js/admin_custom.js', [ 'jquery' ], '', true );
    wp_enqueue_script( 'delishs_-admin-custom' );
}

// Color Scheme
add_action('wp_footer', 'delishs_color_scheme_switcher');

function delishs_color_scheme_switcher(){
    ?>
        
    <?php
};