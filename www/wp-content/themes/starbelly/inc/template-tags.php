<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package starbelly
 */

if ( ! function_exists( 'starbelly_after_content' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function starbelly_after_content() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'starbelly' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'starbelly' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'starbelly' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tags: %1$s', 'starbelly' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'starbelly' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		// Show share buttons in blog post and portfolio
		if ( function_exists( 'starbelly_add_social_share' ) ) :
			echo starbelly_add_social_share( get_the_ID() );
		endif;

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'starbelly' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'starbelly_before_title' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function starbelly_before_title() {
		echo '<span class="sb-author">' . esc_html( get_the_author() ) . '</span>';
		echo esc_html__( ' - ', 'starbelly' );
		echo '<span class="sb-date">' . esc_html( get_the_date() ) . '</span>';
	}
endif;

if ( ! function_exists( 'starbelly_single_navigantion' ) ) :
	/**
	 * Displays an optional prev/next/all nagigations.
	 */
	function starbelly_single_navigantion() {
		if ( is_singular() ) :

			$prev_post = get_adjacent_post( false, '', true );
			$next_post = get_adjacent_post( false, '', false );
			$archive_url = false;
			$archive_page_id = get_field( get_post_type() . '_page', 'option' );
			if ( ! $archive_page_id ) {
				$archive_url = get_post_type_archive_link( get_post_type() );
			} else {
				$archive_url = get_permalink( $archive_page_id );
			}

			$prev_str = esc_html__( 'Previous', 'starbelly' );
			$next_str = esc_html__( 'Next', 'starbelly' );
			$all_str = esc_html__( 'All posts', 'starbelly' );

			?>

	    <!-- navigation -->
	    <div class="sb-post-navigation">
	      <?php if ( is_a( $prev_post, 'WP_Post' ) ) : ?>
	      <!-- button -->
	      <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="sb-link">
					<i class="fas fa-chevron-left"></i>
					<span><?php echo esc_html( $prev_str ); ?></span>
				</a>
				<?php else : ?>
				<span class="sb-link">
					<i class="fas fa-chevron-left"></i>
					<span><?php echo esc_html( $prev_str ); ?></span>
				</span>
				<?php endif; ?>
				<?php if ( $archive_url ) : ?>
	      <div class="sb-post-navigation-center sb-m-hidden">
	        <a class="sb-link" href="<?php echo esc_url( $archive_url ); ?>"><?php echo esc_html( $all_str ); ?></a>
	      </div>
	      <?php endif; ?>
	      <?php if ( is_a( $next_post, 'WP_Post' ) ) : ?>
	      <!-- button -->
	      <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="sb-link">
					<span><?php echo esc_html( $next_str ); ?></span>
					<i class="fas fa-chevron-right"></i>
				</a>
				<?php else : ?>
				<span class="sb-link">
					<span><?php echo esc_html( $next_str ); ?></span>
					<i class="fas fa-chevron-right"></i>
				</span>
				<?php endif; ?>
	    </div>
	    <!-- projects navigation end -->

		<?php
		endif; // End is_singular().
	}
endif;
