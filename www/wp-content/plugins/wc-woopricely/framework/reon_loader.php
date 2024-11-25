<?php

if (!defined('ABSPATH')) {
    exit;
}



//-------------------------
//These codes can be editted
//-------------------------

add_filter('load_reon', 'zcpri_get_framework');
if (!function_exists('zcpri_get_framework')) {

    function zcpri_get_framework($package) {
        $reon_version = 1.0; //this is editable
        $reon_file = dirname(__FILE__) . '/reon/framework.php';

        if (!isset($package['reon_version']) || $package['reon_version'] < $reon_version) {
            return array(
                'reon_version' => $reon_version,
                'reon_file' => $reon_file
            );
        }

        return $package;
    }

}


//------------------------------
//These codes SHOULD NOT be edited
//------------------------------
add_action('plugins_loaded', 'reon_loader');

if (!function_exists('reon_loader')) {

    function reon_loader() {
        $reon_package = apply_filters('load_reon', array());
        if (isset($reon_package['reon_version']) && isset($reon_package['reon_file'])) {
            $reon_version = $reon_package['reon_version'];
            require_once $reon_package['reon_file'];
        }
    }

}