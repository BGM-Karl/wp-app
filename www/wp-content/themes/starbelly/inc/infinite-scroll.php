<?php
/**
 * Ajax Infinite Scroll for Gallery & Posts
 */

function starbelly_ajax_infinite_scroll_el() {
	$post_type = $_POST['post_type'];

	if ( $post_type == 'gallery' ) {
		//load gallery posts

		$page_id = $_POST['page_id'];
		$paged = $_POST['page_no'];

		$orderby = $_POST['order_by'];
		$per_page = $_POST['per_page'];
		$order = $_POST['order'];
		$source = $_POST['source'];
		$temp = $_POST['temp'];
		$cat_ids = $_POST['cat_ids'];
		$show_per_row = $_POST['show_per_row'];

		$args = array(
			'post_type'		 => 'gallery',
			'post_status'	   => 'publish',
			'orderby'			=> $orderby,
			'order'				=> $order,
			'posts_per_page'	=> $per_page,
			'paged' 			=> $paged
		);

		if( $source == 'categories' ) {
			$tax_array = array(
				array(
					'taxonomy' => 'gallery_categories',
					'field'    => 'id',
					'terms'    => $cat_ids
				)
			);

			$args += array('tax_query' => $tax_array);
		}

		$q = new WP_Query($args);

		if( $q->have_posts() ) :
			while( $q->have_posts() ) : $q->the_post();
				set_query_var( 'show_per_row', $show_per_row );

				get_template_part( 'template-parts/content-' . $temp );
			endwhile;

			wp_reset_postdata();
		endif;

		exit;

	} else {
		//load blog posts

		$page_id = $_POST['page_id'];
		$paged = $_POST['page_no'];

		$orderby = $_POST['order_by'];
		$per_page = $_POST['per_page'];
		$order = $_POST['order'];
		$source = $_POST['source'];
		$cat_ids = $_POST['cat_ids'];

		$items_per_row = $_POST['items_per_row'];
		$masonry = $_POST['masonry'];
		$sidebar = $_POST['sidebar'];

		$args = array(
			'post_type'		 => 'post',
			'post_status'	   => 'publish',
			'orderby'			=> $orderby,
			'order'				=> $order,
			'posts_per_page'	=> $per_page,
			'paged' 			=> $paged
		);

		if( $source == 'categories' ) {
			$tax_array = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => $cat_ids
				)
			);

			$args += array('tax_query' => $tax_array);
		}

		$q = new WP_Query($args);

		if( $q->have_posts() ) :
			while( $q->have_posts() ) : $q->the_post();
				set_query_var( 'items_per_row', $items_per_row );
				set_query_var( 'masonry', $masonry );
				set_query_var( 'sidebar', $sidebar );

				get_template_part( 'template-parts/content' );
			endwhile;

			wp_reset_postdata();
		endif;

		exit;

	}
}
add_action( 'wp_ajax_infinite_scroll_el', 'starbelly_ajax_infinite_scroll_el' );
add_action( 'wp_ajax_nopriv_infinite_scroll_el', 'starbelly_ajax_infinite_scroll_el' );
