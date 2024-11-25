<?php 

/**
 * Template part for displaying header side information
   *
   * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
   *
   * @package delishs
*/

$delishs_side_hide = get_theme_mod( 'delishs_side_hide', false );
$delishs_side_logo = get_theme_mod( 'delishs_side_logo', get_template_directory_uri() . '/assets/imgs/logo/logo.png' );
$delishs_side_about_heading = get_theme_mod( 'delishs_side_about_heading', __( 'Subscribe & Follow', 'delishs' ) );
$delishs_side_about_description = get_theme_mod( 'delishs_side_about_description', __( 'The scallops were perfectly cooked, tender, and flavorful, paired beautifully with a creamy risotto and seasonal vegetables. The presentation was artful, showcasing the chefs attention to detail.', 'delishs' ) );

// contact button
$delishs_order_button_text = get_theme_mod( 'delishs_order_button_text', __( 'Order Online', 'delishs' ) );
$delishs_order_button_link = get_theme_mod( 'delishs_order_button_link', __( '#', 'delishs' ) );
$delishs_book_table_button_text = get_theme_mod( 'delishs_book_table_button_text', __( 'Book Table', 'delishs' ) );
$delishs_book_table_button_link = get_theme_mod( 'delishs_book_table_button_link', __( '#', 'delishs' ) );
$delishs_purchase_button_text = get_theme_mod( 'delishs_purchase_button_text', __( 'Purchase', 'delishs' ) );
$delishs_purchase_button_link = get_theme_mod( 'delishs_purchase_button_link', __( '#', 'delishs' ) );

?>

<!-- Offcanvas area start -->
<div class="fix">
    <div class="offcanvas__area">
        <div class="offcanvas__wrapper">
            <div class="offcanvas__content">
               <?php if ( !empty( $delishs_side_logo ) ): ?>
                  <div class="offcanvas__top d-flex justify-content-between align-items-center">
                     <div class="offcanvas__logo">
                        <a href="<?php print esc_url( home_url( '/' ) );?>">
                           <img src="<?php print esc_url($delishs_side_logo); ?>" alt="<?php echo esc_attr__('logo','delishs'); ?>">
                        </a>
                     </div>
                     <div class="offcanvas__close">
                        <button class="offcanvas-close-icon animation--flip">
                                 <span class="offcanvas-m-lines">
                              <span class="offcanvas-m-line line--1"></span><span class="offcanvas-m-line line--2"></span><span class="offcanvas-m-line line--3"></span>
                                 </span>
                        </button>
                     </div>
                  </div>
               <?php endif;?>
               <div class="mobile-menu fix"></div>
               <?php if ( !empty( $delishs_side_hide ) ): ?>
                  <div class="offcanvas__social">
                     <h4 class="offcanvas__title mb-20"><?php print esc_html($delishs_side_about_heading); ?></h4>
                     <p class="mb-30"><?php print esc_html($delishs_side_about_description); ?></p>
                     <ul class="header-top-socail-menu d-flex">
                        <?php delishs_header_social_profiles(); ?>
                     </ul>
                  </div>
                  <div class="offcanvas__btn">
                     <div class="header__btn-wrap">
                        <?php if ( !empty ($delishs_order_button_text) ) : ?>
                           <a href="<?php print esc_url($delishs_order_button_link); ?>" class="rr-btn-3__header rr-btn-3__header-white w-100 mb-10">
                              <span class="btn-wrap">
                                 <span class="text-one"><?php print esc_html($delishs_order_button_text); ?></span>
                                 <span class="text-two"><?php print esc_html($delishs_order_button_text); ?></span>
                              </span>
                           </a>
                        <?php endif; ?>
                        <?php if ( !empty ($delishs_book_table_button_text) ) : ?>
                           <a href="<?php print esc_url($delishs_book_table_button_link); ?>" class="rr-btn__header d-sm-none mb-10 w-100">
                                 <span class="hover-rl"></span>
                                 <span class="fake_hover"></span>
                                 <span class="btn-wrap">
                                    <span class="text-one"><?php print esc_html($delishs_book_table_button_text); ?> <img src="<?php print get_template_directory_uri(); ?>/assets/imgs/icon/arrow-right.svg" alt="<?php print esc_attr( 'icon', 'delishs' ); ?>"></span>
                                    <span class="text-two"><?php print esc_html($delishs_book_table_button_text); ?> <img src="<?php print get_template_directory_uri(); ?>/assets/imgs/icon/arrow-right.svg" alt="<?php print esc_attr( 'icon', 'delishs' ); ?>"></span>
                                 </span>
                           </a>
                        <?php endif; ?>
                        <?php if ( !empty ($delishs_purchase_button_text) ) : ?>
                           <a href="<?php print esc_url($delishs_purchase_button_link); ?>" class="rr-btn__header w-100">
                                 <span class="hover-rl"></span>
                                 <span class="fake_hover"></span>
                                 <span class="btn-wrap">
                                    <span class="text-one"><?php print esc_html($delishs_purchase_button_text); ?> <img src="<?php print get_template_directory_uri(); ?>/assets/imgs/icon/arrow-right.svg" alt="<?php print esc_attr( 'icon', 'delishs' ); ?>"></span>
                                    <span class="text-two"><?php print esc_html($delishs_purchase_button_text); ?> <img src="<?php print get_template_directory_uri(); ?>/assets/imgs/icon/arrow-right.svg" alt="<?php print esc_attr( 'icon', 'delishs' ); ?>"></span>
                                 </span>
                           </a>
                        <?php endif; ?>
                     </div>
                  </div>
               <?php endif;?>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas__overlay"></div>
<div class="offcanvas__overlay-white"></div>
<!-- Offcanvas area start -->