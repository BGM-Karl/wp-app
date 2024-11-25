<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package starbelly
 */

get_header();
?>

<?php

$error_title = esc_html__( '404', 'starbelly' );

$title = get_field( 'p404_title', 'option' );
if ( ! $title ) {
	$title = esc_html__( 'Page not found...', 'starbelly' );
}

$content = get_field( 'p404_content', 'option' );
if ( ! $content ) {
	$content = esc_html__( 'We are unable to find the page you are looking for.', 'starbelly' );
}

$image_id = get_field( 'p404_image', 'options' );
$image = false;
if ( $image_id ) {
	$image = wp_get_attachment_image_url( $image_id, 'starbelly_1920xAuto' );
}
?>

<!-- banner -->
<section class="sb-banner">
	<div class="sb-bg-1">
		<div></div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<!-- main title -->
				<div class="sb-main-title-frame">
					<div class="sb-main-title">
						<span class="sb-404"><?php echo wp_kses_post( $error_title ); ?></span>
						<h1 class="sb-mb-30"><?php echo wp_kses_post( $title ); ?></h1>
						<p class="sb-text sb-text-lg sb-mb-30">
							<?php echo wp_kses_post( $content ); ?>
						</p>
						<!-- button -->
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sb-btn sb-btn-2">
							<span class="sb-icon">
								<span class="sb-icon-arrow-2"></span>
							</span>
							<span><?php echo esc_html__( 'Back to homepage', 'starbelly' ); ?></span>
						</a>
						<!-- button end -->
					</div>
				</div>
				<!-- main title end -->
			</div>
			<div class="col-lg-6">
				<?php if ( $image ) : ?>
				<div class="sb-illustration-1-404">
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $error_title ); ?>" class="sb-man" />

					<div class="sb-cirkle-1"></div>
					<div class="sb-cirkle-2"></div>
					<div class="sb-cirkle-3"></div>
					<div class="sb-cirkle-4"></div>
					<div class="sb-cirkle-5"></div>

					<img src="<?php echo get_template_directory_uri(); ?>assets/img/illustrations/3.svg" alt="<?php echo esc_attr__( 'icon', 'starbelly' ); ?>" class="sb-pik-1" />
					<img src="<?php echo get_template_directory_uri(); ?>img/illustrations/1.svg" alt="<?php echo esc_attr__( 'icon', 'starbelly' ); ?>" class="sb-pik-2" />
					<img src="<?php echo get_template_directory_uri(); ?>img/illustrations/2.svg" alt="<?php echo esc_attr__( 'icon', 'starbelly' ); ?>" class="sb-pik-3" />
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<!-- banner end -->

<?php
get_footer();
