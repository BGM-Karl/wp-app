<?php
/**
 * starbelly functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package starbelly
 */

define( 'STARBELLY_EXTRA_PLUGINS_DIRECTORY', 'https://bslthemes.com/plugins-latest/starbelly/' );
define( 'STARBELLY_EXTRA_PLUGINS_PREFIX', 'Starbelly' );

if ( ! function_exists( 'starbelly_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function starbelly_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on starbelly, use a find and replace
		 * to change 'starbelly' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'starbelly', get_template_directory() . '/languages' );

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
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'starbelly' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Image Sizes
		add_image_size( 'starbelly_140x140', 280, 280, true );
		add_image_size( 'starbelly_256x256', 512, 512, true );
		add_image_size( 'starbelly_700x456', 700, 456, true );
		add_image_size( 'starbelly_950xAuto', 950, 9999, false );
		add_image_size( 'starbelly_1280x768', 1280, 768, true );
		add_image_size( 'starbelly_1920xAuto', 1920, 9999, false );
	}
endif;
add_action( 'after_setup_theme', 'starbelly_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function starbelly_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'starbelly_content_width', 900 );
}
add_action( 'after_setup_theme', 'starbelly_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function starbelly_widgets_init() {
	register_sidebar( array(
		'name'		  => esc_html__( 'Sidebar', 'starbelly' ),
		'id'			=> 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'starbelly' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="sb-ib-title-frame sb-mb-30"><h4 class="widget-title">',
		'after_title'   => '</h4><i class="fas fa-arrow-down"></i></div>',
	) );
	if ( class_exists( 'WooCommerce' ) ) :
		register_sidebar( array(
			'name'          => esc_html__( 'Shop Sidebar', 'starbelly' ),
			'id'            => 'shop-sidebar',
			'description'   => esc_html__( 'Sidebar that appears on the shop.', 'starbelly' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="sb-ib-title-frame sb-mb-30"><h4 class="widget-title">',
			'after_title'   => '</h4><i class="fas fa-arrow-down"></i></div>',
		) );
	endif;
}
add_action( 'widgets_init', 'starbelly_widgets_init' );

/**
 * Register Default Fonts
 */
function starbelly_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lora, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$rubik = _x( 'on', 'Rubik: on or off', 'starbelly' );

	if ( 'off' !== $rubik ) {
		$font_families = array();


		$font_families[] = 'Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
		$font_families[] = 'Monoton';

		$query_args = array(
			'family' => implode( '&family=', $font_families ),
			'display' => 'swap',
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css2' );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function starbelly_stylesheets() {
	// Web fonts
	wp_enqueue_style( 'starbelly-fonts', starbelly_fonts_url(), array(), null );

	$headingsFont =  get_field( 'heading_font_family', 'options' );
	$paragraphsFont =  get_field( 'text_font_family', 'options' );

	// Custom fonts
	if ( $headingsFont ) {
		wp_enqueue_style( 'starbelly-heading-font', $headingsFont['url'] , array(), null );
	}
	if ( $paragraphsFont ) {
		wp_enqueue_style( 'starbelly-paragraph-font', $paragraphsFont['url'] , array(), null );
	}

	/*Styles*/
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', '1.0' );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.css', '1.0' );
	wp_enqueue_style( 'datepicker', get_template_directory_uri() . '/assets/css/datepicker.css', '1.0' );
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/assets/css/swiper.css', '1.0' );
	wp_enqueue_style( 'starbelly-mapbox', get_template_directory_uri() . '/assets/css/mapbox-style.css', '1.0' );
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css', '1.0' );
	wp_enqueue_style( 'starbelly-style', get_stylesheet_uri(), array( 'bootstrap', 'fontawesome', 'datepicker', 'swiper', 'starbelly-mapbox', 'magnific-popup' ) );
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'starbelly-wc-custom', get_template_directory_uri() . '/assets/css/wc-custom.css', array( 'starbelly-style' ), '1.0' );
	}
}
add_action( 'wp_enqueue_scripts', 'starbelly_stylesheets' );

function starbelly_scripts() {
	/*Datepicker Localizations*/
	$monthNames = array( esc_attr__( 'January', 'starbelly' ), esc_attr__( 'February', 'starbelly' ), esc_attr__( 'March', 'starbelly' ), esc_attr__( 'April', 'starbelly' ), esc_attr__( 'May', 'starbelly' ), esc_attr__( 'June', 'starbelly' ), esc_attr__( 'July', 'starbelly' ), esc_attr__( 'August', 'starbelly' ), esc_attr__( 'September', 'starbelly' ), esc_attr__( 'October', 'starbelly' ), esc_attr__( 'November', 'starbelly' ), esc_attr__( 'December', 'starbelly' ) );
	$monthNamesShort = array( esc_attr__( 'Jan', 'starbelly' ), esc_attr__( 'Feb', 'starbelly' ), esc_attr__( 'Mar', 'starbelly' ), esc_attr__( 'Apr', 'starbelly' ), esc_attr__( 'May', 'starbelly' ), esc_attr__( 'Jun', 'starbelly' ), esc_attr__( 'Jul', 'starbelly' ), esc_attr__( 'Aug', 'starbelly' ), esc_attr__( 'Sep', 'starbelly' ), esc_attr__( 'Oct', 'starbelly' ), esc_attr__( 'Nov', 'starbelly' ), esc_attr__( 'Dec', 'starbelly' ) );
	$dayNames = array( esc_attr__( 'Sunday', 'starbelly' ), esc_attr__( 'Monday', 'starbelly' ), esc_attr__( 'Tuesday', 'starbelly' ), esc_attr__( 'Wednesday', 'starbelly' ), esc_attr__( 'Thursday', 'starbelly' ), esc_attr__( 'Friday', 'starbelly' ), esc_attr__( 'Saturday', 'starbelly' ) );
	$dayNamesShort = array( esc_attr__( 'Sun', 'starbelly' ), esc_attr__( 'Mon', 'starbelly' ), esc_attr__( 'Tue', 'starbelly' ), esc_attr__( 'Wed', 'starbelly' ), esc_attr__( 'Thu', 'starbelly' ), esc_attr__( 'Fri', 'starbelly' ), esc_attr__( 'Sat', 'starbelly' ) );
	$dayNamesMin = array( esc_attr__( 'Su', 'starbelly' ), esc_attr__( 'Mo', 'starbelly' ), esc_attr__( 'Tu', 'starbelly' ), esc_attr__( 'We', 'starbelly' ), esc_attr__( 'Th', 'starbelly' ), esc_attr__( 'Fr', 'starbelly' ), esc_attr__( 'Sa', 'starbelly' ) );

	$datepicker_localize_data = array(
	  'closeText' => esc_attr__( 'Clear', 'starbelly' ),
	  'currentText' => esc_attr__( 'Today', 'starbelly' ),
	  'monthNames' => $monthNames,
	  'monthNamesShort' => $monthNamesShort,
	  'dayNames' => $dayNames,
	  'dayNamesShort' => $dayNamesShort,
	  'dayNamesMin' => $dayNamesMin,
	  'dateFormat' => esc_attr__( 'dd/mm/yy', 'starbelly' ),
	  'firstDay' => 0,
	  'isRTL' => is_rtl()
	);

	/*Default Scripts*/
	wp_enqueue_script( 'starbelly-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/*Datepicker Init*/
	wp_enqueue_script( 'starbelly-datepicker', get_template_directory_uri() . '/assets/js/datepicker.js', array('jquery'), '1.0.0', true );
	/*Datepicker Data*/
	wp_localize_script( 'starbelly-datepicker', 'datepicker_localize_data', $datepicker_localize_data );

	if ( get_field( 'theme_scrolling', 'option' ) ) {
		wp_enqueue_script( 'smooth-scroll', get_template_directory_uri() . '/assets/js/smooth-scroll.js', array('jquery'), '1.0.0', true );
	}
	wp_enqueue_script( 'mapbox', get_template_directory_uri() . '/assets/js/mapbox.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/js/magnific-popup.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'sticky', get_template_directory_uri() . '/assets/js/sticky.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'imagesloaded-pkgd', get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.js', array(), '1.0.0', true );
	wp_enqueue_script( 'starbelly-isotope', get_template_directory_uri() . '/assets/js/isotope.pkgd.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'starbelly-jquery-cookie', get_template_directory_uri() . '/assets/js/jquery.cookie.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'starbelly-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'starbelly_scripts' );

/**
 * Extra Prefix
 */
function starbelly_extra_dir() {
	$extra_dir = get_option( STARBELLY_EXTRA_PLUGINS_PREFIX . '_lic_Ren' );
	if ( empty( $extra_dir ) ) {
			$extra_dir = 'normal';
	}
	return $extra_dir;
}
add_action( 'init', 'starbelly_extra_dir' );

/**
 * TGM
 */
require get_template_directory() . '/inc/plugins/plugins.php';

/**
 * ACF Options
 */

function starbelly_acf_fa_version( $version ) {
 $version = 5;
 return $version;
}
add_filter( 'ACFFA_override_major_version', 'starbelly_acf_fa_version' );

function starbelly_acf_json_load_point( $paths ) {
	$paths = array( get_template_directory() . '/inc/acf-json' );
	if( is_child_theme() ) {
		$paths[] = get_stylesheet_directory() . '/inc/acf-json';
	}

	return $paths;
}

add_filter('acf/settings/load_json', 'starbelly_acf_json_load_point');

if ( function_exists( 'acf_add_options_page' ) ) {
	// Hide ACF field group menu item
	add_filter( 'acf/settings/show_admin', '__return_false' );
	add_filter( 'acf/settings/show_updates', '__return_false', 100 );

	// Add ACF Options Page
	acf_add_options_page( array(
		'page_title' 	=> esc_html__( 'Starbelly Theme Options', 'starbelly' ),
		'menu_title'	=> esc_html__( 'Starbelly Options', 'starbelly' ),
		'menu_slug' 	=> 'theme-options',
		'capability'	=> 'edit_theme_options',
		'icon_url'		=> 'dashicons-bslthemes',
		'position' 		=> 3,
		'redirect'		=> true
	) );

	acf_add_options_sub_page(array(
		'page_title' 	=> esc_html__( 'General Options', 'starbelly' ),
		'menu_title'	=> esc_html__( 'General', 'starbelly' ),
		'menu_slug' 	=> 'general-theme-options',
		'parent_slug'	=> 'theme-options',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> esc_html__( 'Header & Footer Options', 'starbelly' ),
		'menu_title'	=> esc_html__( 'Header & Footer', 'starbelly' ),
		'menu_slug' 	=> 'header-and-footer-theme-options',
		'parent_slug'	=> 'theme-options',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> esc_html__( 'Styling Options', 'starbelly' ),
		'menu_title'	=> esc_html__( 'Styling', 'starbelly' ),
		'menu_slug' 	=> 'styling-theme-options',
		'parent_slug'	=> 'theme-options',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> esc_html__( 'Blog Options', 'starbelly' ),
		'menu_title'	=> esc_html__( 'Blog', 'starbelly' ),
		'menu_slug' 	=> 'blog-theme-options',
		'parent_slug'	=> 'theme-options',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> esc_html__( 'Restaurant Options', 'starbelly' ),
		'menu_title'	=> esc_html__( 'Restaurant', 'starbelly' ),
		'menu_slug' 	=> 'restaurant-theme-options',
		'parent_slug'	=> 'theme-options',
	));

	if ( class_exists( 'WooCommerce' ) ) {
		acf_add_options_sub_page(array(
			'page_title' 	=> esc_html__( 'Shop Options', 'starbelly' ),
			'menu_title'	=> esc_html__( 'Shop', 'starbelly' ),
			'menu_slug' 	=> 'store-theme-options',
			'parent_slug'	=> 'theme-options',
		));
	}
}

function starbelly_acf_json_save_point( $path ) {
	// update path
	$path = get_stylesheet_directory() . '/inc/acf-json';

	// return
	return $path;
}
add_filter( 'acf/settings/save_json', 'starbelly_acf_json_save_point' );

function starbelly_acf_fallback() {
	// ACF Plugin fallback
	if ( ! is_admin() && ! function_exists( 'get_field' ) ) {
		function get_field( $field = '', $id = false ) {
			return false;
		}
		function the_field( $field = '', $id = false ) {
			return false;
		}
		function have_rows( $field = '', $id = false ) {
			return false;
		}
		function has_sub_field( $field = '', $id = false ) {
			return false;
		}
		function get_sub_field( $field = '', $id = false ) {
			return false;
		}
		function the_sub_field( $field = '', $id = false ) {
			return false;
		}
	}
}
add_action( 'init', 'starbelly_acf_fallback' );

/**
 * OCDI
 */
require get_template_directory() . '/inc/ocdi-setup.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Include Skin Options
 */
require get_template_directory() . '/inc/skin-options.php';

/**
 * Include Infinite Scroll
 */
require get_template_directory() . '/inc/infinite-scroll.php';

/**
 * Include Custom Breadcrumbs
 */
require get_template_directory() . '/inc/custom-breadcrumbs.php';

/**
 * Include WooCommerce Support
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/wc-functions.php';
}

/**
 * Get Archive Title
 */

function starbelly_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_post_type_archive( 'portfolio' ) ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( esc_html__( 'Tag: ', 'starbelly' ), false );
	} elseif ( is_author() ) {
		$title = esc_html__( 'Author: ', 'starbelly' ) . get_the_author();
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'starbelly_archive_title' );

/**
 * Excerpt
 */
function starbelly_custom_excerpt_length( $length ) {
	$items_per_row = get_query_var( 'items_per_row' );
	$excerpt_custom = get_query_var( 'items_excerpt_custom' );

	if ( $items_per_row == '3' || $items_per_row == '4' ) {
		$length = 15;
	} elseif ( $items_per_row == '2' ) {
		$length = 30;
	} elseif ( $items_per_row == '1' ) {
		$length = 60;
	} else {
		$length = 20;
	}

	if ( !empty( $excerpt_custom ) && empty($items_per_row) ) {
		$length = $excerpt_custom;
	}

	return $length;
}
add_filter( 'excerpt_length', 'starbelly_custom_excerpt_length' );

function starbelly_new_excerpt_more( $more ) {
	return '.. <span class="sb-el-more"><a href="' . esc_url( get_permalink() ) . '" class="sb-btn"><span class="sb-icon"><span class="sb-icon-arrow"></span></span><span>' . esc_html__( 'Read more', 'starbelly' ) . '</span></a></span>';
}
add_filter( 'excerpt_more', 'starbelly_new_excerpt_more' );

/**
 * Disable CF7 Auto Paragraph
 */
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Top Menu Horizontal
 */
class Starbelly_Topmenu_Walker extends Walker_Nav_menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = '';
		if ( isset( $args->link_after ) ) {
			$args->link_after = '';
		}

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		if ( $depth == 0 ) {
			if ( in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-parent', $classes ) ) {
				$classes[] = 'sb-active';
			}
			if ( in_array( 'menu-item-has-children', $classes ) ) {
				$classes[] = 'sb-has-children';
			}
		}

		$class_names = join(' ', $classes);

	 	$class_names = ' class="'. esc_attr( $class_names ) . '"';
		$attributes = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';

		if ( has_nav_menu( 'primary' ) ) {
			$output .= $indent . '<li id="menu-item-'. esc_attr( $item->ID ) . '"' . $class_names . '>';

			$attributes .= ! empty( $item->url && $item->url != '#.' && $item->url != '#' ) ? ' href="' . esc_url( $item->url ) . '"' : '';

			$item_output = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}

/**
 * Comments
 */
if ( ! function_exists( 'starbelly_comment' ) ) {
	function starbelly_comment( $comment, $args, $depth ) {
		?>
			<li <?php comment_class( 'post-comment' ); ?> id="li-comment-<?php comment_ID(); ?>" >
				<div id="comment-<?php comment_ID(); ?>" class="comment">
					<div class="sb-comment-avatar">
                      <?php $avatar_size = 80;
						if ( '0' != $comment->comment_parent ) : $avatar_size = 80; endif;
						echo get_avatar( $comment, $avatar_size );
					  ?>
                    </div>
                    <div class="sb-comment-box">
                      <div class="sb-comment-head">
                        <h6><?php comment_author_link(); ?></h6>
                        <div class="sb-date">
                        	<span><?php comment_time(); ?></span>
                        	<span><?php comment_date(); ?></span>
                        </div>
                      </div>
                      <div class="sb-comment-content sb-text single-post-text">
                        <?php comment_text(); ?>
                      </div>
                      <div class="comment-reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					  </div>
                    </div>
				</div>

		<?php
	}
}

function starbelly_add_no_swap( $link, $args, $comment, $post ) {
  return str_replace( "rel='nofollow'", "rel='nofollow' data-no-swup", $link );
}
add_filter( 'comment_reply_link', 'starbelly_add_no_swap', 420, 4 );

function starbelly_customize_the_password_form() {
	global $post;

	$loginurl = site_url() . '/wp-login.php?action=postpass';
	$label = 'pwbox-' . ( ! empty( $post->ID ) ? $post->ID : rand() );

	$custom_form = '<form action="' . esc_url( $loginurl ) . '" class="post-password-form" method="post">
		<p>' . esc_html__( 'This content is password protected. To view it please enter your password below:', 'starbelly' ) . '</p>
		<div class="sb-group-input">
			<label for="' . esc_attr( $label ) . '">'. esc_html__( 'Password:', 'starbelly' ) . '</label>
			<input name="post_password" id="' . esc_attr( $label ) . '" type="password" size="20" placeholder="' . esc_attr__( 'Enter a password', 'starbelly' ) . '" />
		</div>
		<button type="submit" name="submit" class="sb-btn sb-btn-text"><span>' . esc_html__( 'Submit', 'starbelly' ) . '</span></button>
	</form>';

	return $custom_form;
}
add_filter( 'the_password_form', 'starbelly_customize_the_password_form', 10, 3 );
