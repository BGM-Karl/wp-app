<?php

if ( class_exists( 'StarbellyPlugin' ) && class_exists( 'ACF' ) && class_exists( 'OCDI_Plugin' ) ) {

function starbelly_ocdi_import_files() {
    return array(
        array(
            'import_file_name'           => 'restaurant',
            'categories'                 => array( esc_attr__( 'Main', 'starbelly' ) ),
            'import_file_url'            => STARBELLY_EXTRA_PLUGINS_DIRECTORY . '/normal/ocdi-import/demo/01/content.xml',
            'preview_url'                => 'https://1.envato.market/c/1790164/275988/4415?u=https://themeforest.net/item/starbelly-restaurant-wordpress-theme/full_screen_preview/39126188',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'starbelly_ocdi_import_files' );

function starbelly_ocdi_after_import_setup( $selected_import ) {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'posts_per_page', 6 );

    $acf_options = array();

    if ( $selected_import['import_file_name'] ) {
      $json_file = get_template_directory_uri() . '/inc/acf-options/' . $selected_import['import_file_name']  . '.json';
      $response = wp_remote_get( $json_file, array() );
      $response_body = wp_remote_retrieve_body( $response );

      if ( $response_body ) {
        $response_data = json_decode( $response_body );
        $acf_options = $response_data->data;
      }
    }

    if ( !empty( $acf_options ) ) {
      global $wpdb;
      foreach ( $acf_options as $item ) {
        if ( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->options WHERE option_name = %s", $item->option_name ) ) == 0 ) {
            $wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->options ( option_name, option_value, autoload ) VALUES (%s, %s, 'no')", $item->option_name, $item->option_value ) );
        } else {
          $wpdb->query( $wpdb->prepare( "UPDATE $wpdb->options SET option_value = %s WHERE option_name = %s", $item->option_value, $item->option_name ) );
        }
      }
    }

}
add_action( 'pt-ocdi/after_import', 'starbelly_ocdi_after_import_setup' );

}
