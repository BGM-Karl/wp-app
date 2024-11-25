<?php
/**
 * Plugin Name: TM Pointer
 * Plugin URI: https://codecanyon.net/user/egemenerd/portfolio
 * Description: WordPress Custom Cursor Plugin
 * Version: 1.1
 * Author: egemenerd
 * Author URI: http://codecanyon.net/user/egemenerd
 * License: http://codecanyon.net/licenses
 * Text Domain: tmpointer
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) || exit;

/* ---------------------------------------------------------
Custom Metaboxes - github.com/WebDevStudios/CMB2
----------------------------------------------------------- */

// Check for PHP version
$tmpointerdir = ( version_compare( PHP_VERSION, '5.3.0' ) >= 0 ) ? __DIR__ : dirname( __FILE__ );

if ( file_exists(  $tmpointerdir . '/cmb2/init.php' ) ) {
    require_once($tmpointerdir . '/cmb2/init.php');
} elseif ( file_exists(  $tmpointerdir . '/CMB2/init.php' ) ) {
    require_once($tmpointerdir . '/CMB2/init.php');
}

/* ---------------------------------------------------------
Get Pointer Styles
----------------------------------------------------------- */
function tm_get_pointer_styles(){
    $styles = apply_filters('tm_pointer_styles',array(
        'tm-pointer-simple' => esc_html__( 'Simple', 'tmpointer' ),
        'tm-pointer-icon' => esc_html__( 'Icon', 'tmpointer' ),
        'tm-pointer-img' => esc_html__( 'Image', 'tmpointer' ),
        'tm-pointer-mix-blend' => esc_html__( 'Mix Blend', 'tmpointer' ),
        'tm-pointer-pulse' => esc_html__( 'Pulse', 'tmpointer' ),
        'tm-pointer-1' => esc_html__( 'Pointer 1', 'tmpointer' ),
        'tm-pointer-2' => esc_html__( 'Pointer 2', 'tmpointer' ),
        'tm-pointer-3' => esc_html__( 'Pointer 3', 'tmpointer' ),
        'tm-pointer-4' => esc_html__( 'Pointer 4', 'tmpointer' ),
        'tm-pointer-5' => esc_html__( 'Pointer 5', 'tmpointer' ),
        'tm-pointer-6' => esc_html__( 'Pointer 6', 'tmpointer' )
    ));
    return $styles;
}

/* ---------------------------------------------------------
Include Required Files
----------------------------------------------------------- */

// CMB2 Conditionals
require_once('cmb2-conditionals.php');

// Settings
require_once('settings.php');

// Main Class
require_once('tmpointer-class.php');

/* ---------------------------------------------------------
Elementor
----------------------------------------------------------- */

function tmpointer_elementor_file(){
    $elementor = tmpointer_get_option('tmpointer_options','elementor','enable');
    if (did_action('elementor/loaded') && $elementor == 'enable') {
        include_once('elementor.php');
    }
}

add_action('plugins_loaded', 'tmpointer_elementor_file');

/* Include Custom Elementor Controls */

function tmpointer_elementor_controls() {
    require_once( 'controls/fileselect-control.php' );
    \Elementor\Plugin::$instance->controls_manager->register_control( 'tmp-file-select', new \TMP_FileSelect_Control() );
}

add_action( 'elementor/controls/controls_registered', 'tmpointer_elementor_controls' );