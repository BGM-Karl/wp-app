<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

$blog_column = 'col-xl-12';
if(is_active_sidebar('product-sidebar') ){ 
  	$blog_column = 'col-xl-8';
}

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<?php

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>


  	<div class="row">
		<?php if ( is_active_sidebar( 'product-sidebar' ) ): ?>
		<div class="col-xl-4">
			<div class="blog-4__right sidebar-rr-sticky">
				<?php dynamic_sidebar('product-sidebar');?>
			</div>
		</div>
		<?php endif;?>

  		<div class="<?php print esc_attr( $blog_column );?> ">
			<div class="blog-4__right">
				<?php
				/**
				 * Hook: woocommerce_archive_description.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				do_action( 'woocommerce_archive_description' );
				?>
					<?php
					if ( woocommerce_product_loop() ) {

				?>
				<div class="row mb-30 align-items-center">
					<div class="col-xl-7 col-lg-6 col-md-6">
						<div class="product__result">
							<?php
							/**
							 * Hook: woocommerce_before_shop_loop.
							 *
							 * @hooked woocommerce_output_all_notices - 10
							 * @hooked woocommerce_result_count - 20
							 * @hooked woocommerce_catalog_ordering - 30
							 */
							do_action( 'woocommerce_before_shop_loop' );
							?>
						</div>
					</div>
					<div class="col-xl-5 col-lg-6 col-md-6">
						<div class="product__filter-wrapper d-flex align-items-center justify-content-md-end">
							<div class="product__filter-count d-flex align-items-center">
								<?php woocommerce_catalog_ordering();?>
							</div>
						</div>
					</div>
				</div>
				<?php

				woocommerce_product_loop_start();

				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();

						print '<div class="col">';

						/**
						 * Hook: woocommerce_shop_loop.
						 */
						do_action( 'woocommerce_shop_loop' );

						wc_get_template_part( 'content', 'product' );
						print '</div>';
					}
				}

				woocommerce_product_loop_end();

				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
					} else {
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
					do_action( 'woocommerce_no_products_found' );
				}
				?>
			</div>
		</div>

		<?php
		/**
		 * Hook: woocommerce_after_main_content.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
		?>

		<?php

		?>
	</div>
	<?php

get_footer( 'shop' );
