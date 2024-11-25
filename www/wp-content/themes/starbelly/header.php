<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package starbelly
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Meta Data -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<!-- app wrapper -->
  <div class="sb-app">
    <!-- preloader -->
    <div class="sb-preloader">
      <div class="sb-preloader-bg"></div>
      <div class="sb-preloader-body">
        <div class="sb-loading">
          <div class="sb-percent"><span class="sb-preloader-number" data-count="101">00</span><span>%</span></div>
        </div>
        <div class="sb-loading-bar">
          <div class="sb-bar"></div>
        </div>
      </div>
    </div>
    <!-- preloader end -->

    <!-- click effect -->
    <div class="sb-click-effect"></div>
    <!-- loader -->
    <div class="sb-load"></div>

    <!-- top bar -->
    <div class="sb-top-bar-frame">
      <div class="sb-top-bar-bg"></div>
      <div class="container">
        <div class="sb-top-bar">
					<?php
            $header_template = get_field( 'header_template', 'option' );

            if ( $header_template && !\Elementor\Plugin::$instance->preview->is_preview_mode() ) :
              $args = array( 'post_type' => 'hf_templates', 'p' => $header_template );
              $loop = new WP_Query( $args );
              while ( $loop->have_posts() ) : $loop->the_post();
                the_content();
              endwhile; wp_reset_postdata();
            else :
          ?>

					<a href="<?php echo esc_url( home_url() ); ?>" class="sb-logo-frame">
						<span class="logotype__title"><?php echo esc_html( bloginfo('name') ); ?></span>
						<span class="logotype__sub"><?php echo esc_html( bloginfo('description') ); ?></span>
          </a>

          <!-- menu -->
          <div class="sb-right-side">
            <nav id="sb-dynamic-menu" class="sb-menu-transition">
							<?php
	            if ( has_nav_menu( 'primary' ) ) :
	              wp_nav_menu( array(
	                'theme_location' => 'primary',
	                'container' => '',
	                'container_class' => '',
	                'menu_class' => 'sb-navigation sb-navigation-default',
	                'walker' => new Starbelly_Topmenu_Walker(),
	              ) );
	            endif; ?>
            </nav>
            <div class="sb-buttons-frame">
							<?php if ( class_exists( 'WooCommerce' ) ) : ?>
              <?php if ( true == get_theme_mod( 'cart_shop', true ) ) : ?>
							<!-- button -->
              <div class="sb-btn sb-btn-2 sb-btn-gray sb-btn-icon sb-m-0 sb-btn-cart">
                <span class="sb-icon">
									<span class="sb-icon-svg sb-icon-svg-cart"></span>
								</span>
                <i class="sb-cart-number">
									<span class="cart-count"><?php echo sprintf (_n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'starbelly' ), WC()->cart->get_cart_contents_count() ); ?></span>
								</i>
              </div>
              <!-- button end -->
							<?php endif; ?>
							<?php endif; ?>

              <!-- menu btn -->
              <div class="sb-menu-btn"><span></span></div>
            </div>
          </div>
					<?php endif; ?>
        </div>
      </div>

			<!-- info bar -->
      <div class="sb-info-bar">
        <div class="sb-infobar-content">
					<?php get_template_part( 'template-parts/info' ); ?>
				</div>
				<?php $social_links = get_field( 'social_links', 'options' ); ?>
				<?php if ( !empty( $social_links ) ) : ?>
				<div class="sb-info-bar-footer">
          <ul class="sb-social">
						<?php foreach ( $social_links as $index => $item ) : ?>
            <li>
							<a<?php if ( $item['url'] ) : ?> target="_blank" href="<?php echo esc_url( $item['url'] ); ?>"<?php endif; ?> title="<?php echo esc_attr( $item['title'] ); ?>">
			          <?php echo wp_kses_post( $item['icon'] ); ?>
			        </a>
						</li>
						<?php endforeach; ?>
          </ul>
        </div>
				<?php endif; ?>
      </div>
      <!-- info bar end -->

			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
	    <?php if ( is_object( WC()->cart ) ) : ?>
      <!-- minicart -->
      <div class="sb-minicart">
				<div class="cart-widget">
					<?php woocommerce_mini_cart(); ?>
				</div>
      </div>
      <!-- minicart end -->
			<?php endif; ?>
			<?php endif; ?>
    </div>
    <!-- top bar end -->

    <!-- dynamic content -->
    <div id="sb-dynamic-content" class="sb-transition-fade">
