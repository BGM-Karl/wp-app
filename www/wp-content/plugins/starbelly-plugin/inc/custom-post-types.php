<?php

/**
 * Register Custom Post Type: Header & Footer
 */
function starbelly_register_hf_templates() {
	$labels = array(
		'name'                  => esc_html__( 'Header & Footer', 'starbelly-plugin' ),
		'singular_name'         => esc_html__( 'Template', 'starbelly-plugin' ),
		'add_new_item'          => esc_html__( 'Add New Template', 'starbelly-plugin' ),
		'add_new'               => esc_html__( 'Add New', 'starbelly-plugin' ),
    	'new_item'              => esc_html__( 'Add New Template', 'starbelly-plugin' ),
    	'all_items'             => esc_html__( 'All Templates', 'starbelly-plugin' ),
		'edit_item'             => esc_html__( 'Edit Template', 'starbelly-plugin' ),
		'view_item'             => esc_html__( 'View Template', 'starbelly-plugin' ),
		'search_items'          => esc_html__( 'Search Template', 'starbelly-plugin' ),
		'not_found'             => esc_html__( 'No Templates Found', 'starbelly-plugin' ),
		'not_found_in_trash'    => esc_html__( 'No Templates Found in Trash', 'starbelly-plugin' ),
	);
	$args = array(
		'label'                 => esc_html__( 'Header & Footer', 'starbelly-plugin' ),
		'description'           => esc_html__( 'Add a Template', 'starbelly-plugin' ),
		'supports' 							=> array( 'title','editor','author','elementor' ),
		'hierarchical'          => false,
		'show_in_menu' 					=> true,
		'show_in_nav_menus'     => false,
		'show_in_admin_bar' 		=> true,
		'public'                => true,
		'show_ui'               => true,
		'exclude_from_search'   => true,
		'publicly_queryable' 		=> true,
		'has_archive' 					=> false,
		'menu_position'         => 58,
		'menu_icon'             => 'dashicons-editor-insertmore',
		'can_export'            => true,
    	'capability_type'       => 'post',
		'rewrite' 							=> array( 'slug' => 'hf_templates' ),
		'labels'                => $labels,
	);
	register_post_type( 'hf_templates', $args );
}
add_action( 'init', 'starbelly_register_hf_templates');

function starbelly_hf_default_page_template() {
  global $post;
  if ( 'hf_templates' == $post->post_type
      && 0 != count( get_page_templates( $post ) )
      && get_option( 'page_for_posts' ) != $post->ID // Not the page for listing posts
      && '' == $post->page_template // Only when page_template is not set
  ) {
		$post->page_template = "elementor_canvas";
  }
}
add_action( 'add_meta_boxes', 'starbelly_hf_default_page_template', 1 );

/**
 * Register Custom Post Type: Gallery
 */
function starbelly_register_gallery() {
	$labels = array(
		'name' => esc_html__( 'Gallery', 'starbelly-plugin' ),
		'singular_name' => esc_html__( 'Gallery', 'starbelly-plugin' ),
		'menu_name' => esc_html__( 'Gallery', 'starbelly-plugin' ),
		'parent_item_colon' => esc_html__( 'Parent Image:', 'starbelly-plugin' ),
		'all_items' => esc_html__( 'All Images', 'starbelly-plugin' ),
		'view_item' => esc_html__( 'View Image', 'starbelly-plugin' ),
		'add_new_item' => esc_html__( 'Add New Image', 'starbelly-plugin' ),
		'add_new' => esc_html__( 'New Image', 'starbelly-plugin' ),
		'edit_item' => esc_html__( 'Edit Image', 'starbelly-plugin' ),
		'update_item' => esc_html__( 'Update Image', 'starbelly-plugin' ),
		'search_items' => esc_html__( 'Search Images', 'starbelly-plugin' ),
		'not_found' => esc_html__( 'No images found', 'starbelly-plugin' ),
		'not_found_in_trash' => esc_html__( 'No images found in Trash', 'starbelly-plugin' ),
	);
	$args = array(
		'label' => esc_html__( 'Gallery', 'starbelly-plugin' ),
		'description' => esc_html__( 'Gallery', 'starbelly-plugin' ),
		'supports' => array( 'title','revisions','thumbnail','page-attributes' ),
		'taxonomies' => array( 'gallery_categories' ),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'show_in_admin_bar' => true,
		'menu_position' => 55,
		'menu_icon' => 'dashicons-images-alt2',
		'can_export' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'query_var'           => true,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'gallery/item', 'with_front' => true  ),
		'labels' => $labels,
	);
	register_post_type( 'gallery', $args );
}
add_action( 'init', 'starbelly_register_gallery' );

function starbelly_register_gallery_categories() {
	$labels = array(
		'name'              => esc_html__( 'Gallery Categories', 'starbelly-plugin' ),
		'singular_name'     => esc_html__( 'Gallery Categories', 'starbelly-plugin' ),
		'search_items'      => esc_html__( 'Search Gallery Categories', 'starbelly-plugin' ),
		'all_items'         => esc_html__( 'All Gallery Categories', 'starbelly-plugin' ),
		'parent_item'       => esc_html__( 'Parent Gallery Category', 'starbelly-plugin' ),
		'parent_item_colon' => esc_html__( 'Parent Gallery Category:', 'starbelly-plugin' ),
		'edit_item'         => esc_html__( 'Edit Gallery Category', 'starbelly-plugin' ),
		'update_item'       => esc_html__( 'Update Gallery Category', 'starbelly-plugin' ),
		'add_new_item'      => esc_html__( 'Add New Gallery Category', 'starbelly-plugin' ),
		'new_item_name'     => esc_html__( 'New Gallery Category Name', 'starbelly-plugin' ),
		'menu_name'         => esc_html__( 'Gallery Categories', 'starbelly-plugin' ),
	);
	$args = array(
		'label' => esc_html__( 'Gallery Categories', 'starbelly-plugin' ),
		'hierarchical' => true,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'show_admin_column' => true,
		'public' => false,
		'query_var' => true,
		'has_archive' => false,
		'rewrite' => array( 'slug' => 'gallery/category' ),
		'labels' => $labels,
	);
	register_taxonomy( 'gallery_categories', array ( 0 => 'gallery' ), $args );
}
add_action( 'init', 'starbelly_register_gallery_categories' );

/**
 * Register Custom Post Type: Restaurant Menu
 */
function starbelly_register_restaurant_menu() {
	$labels = array(
		'name' => esc_html__( 'Restaurant Menu', 'starbelly-plugin' ),
		'singular_name' => esc_html__( 'Restaurant Menu', 'starbelly-plugin' ),
		'menu_name' => esc_html__( 'Restaurant', 'starbelly-plugin' ),
		'parent_item_colon' => esc_html__( 'Parent Menu Item:', 'starbelly-plugin' ),
		'all_items' => esc_html__( 'All Menu Items', 'starbelly-plugin' ),
		'view_item' => esc_html__( 'View Menu Item', 'starbelly-plugin' ),
		'add_new_item' => esc_html__( 'Add New Menu Item', 'starbelly-plugin' ),
		'add_new' => esc_html__( 'Add New', 'starbelly-plugin' ),
		'edit_item' => esc_html__( 'Edit Menu Item', 'starbelly-plugin' ),
		'update_item' => esc_html__( 'Update Menu Item', 'starbelly-plugin' ),
		'search_items' => esc_html__( 'Search Menu Item', 'starbelly-plugin' ),
		'not_found' => esc_html__( 'No Menu Item found', 'starbelly-plugin' ),
		'not_found_in_trash' => esc_html__( 'No Menu Item found in Trash', 'starbelly-plugin' ),
	);
	$args = array(
		'label' => esc_html__( 'Restaurant Menu', 'starbelly-plugin' ),
		'description' => esc_html__( 'Restaurant Menu', 'starbelly-plugin' ),
		'supports' => array( 'title','revisions','thumbnail','page-attributes' ),
		'taxonomies' => array( 'restaurant_menu_categories', 'post_tag' ),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'show_in_admin_bar' => true,
		'menu_position' => 56,
		'menu_icon' => 'dashicons-image-filter',
		'can_export' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'restaurant/item', 'with_front' => true  ),
		'labels' => $labels,
	);
	register_post_type( 'restaurant_menu', $args );
}
add_action( 'init', 'starbelly_register_restaurant_menu' );

function starbelly_register_restaurant_menu_categories() {
	$labels = array(
		'name'              => esc_html__( 'Restaurant Menu Categories', 'starbelly-plugin' ),
		'singular_name'     => esc_html__( 'Restaurant Menu Categories', 'starbelly-plugin' ),
		'search_items'      => esc_html__( 'Search Menu Categories', 'starbelly-plugin' ),
		'all_items'         => esc_html__( 'All Menu Categories', 'starbelly-plugin' ),
		'parent_item'       => esc_html__( 'Parent Menu Category', 'starbelly-plugin' ),
		'parent_item_colon' => esc_html__( 'Parent Menu Category:', 'starbelly-plugin' ),
		'edit_item'         => esc_html__( 'Edit Menu Category', 'starbelly-plugin' ),
		'update_item'       => esc_html__( 'Update Menu Category', 'starbelly-plugin' ),
		'add_new_item'      => esc_html__( 'Add New Menu Category', 'starbelly-plugin' ),
		'new_item_name'     => esc_html__( 'New Menu Category Name', 'starbelly-plugin' ),
		'menu_name'         => esc_html__( 'Categories', 'starbelly-plugin' ),
	);
	$args = array(
		'label' => esc_html__( 'Restaurant Menu Categories', 'starbelly-plugin' ),
		'hierarchical' => true,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'show_admin_column' => true,
		'public' => false,
		'query_var' => true,
		'has_archive' => false,
		'rewrite' => array( 'slug' => 'restaurant/category' ),
		'labels' => $labels,
	);
	register_taxonomy( 'restaurant_menu_categories', array ( 0 => 'restaurant_menu' ), $args );
}
add_action( 'init', 'starbelly_register_restaurant_menu_categories' );
