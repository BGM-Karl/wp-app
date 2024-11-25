<?php

/**
 * Template part for displaying header layout one
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package delishs
 */

// header right
$delishs_topbar_switch = get_theme_mod( 'delishs_topbar_switch', false );
$delishs_header_right = get_theme_mod( 'delishs_header_right', false );
$delishs_header_button_switch = get_theme_mod( 'delishs_header_button_switch', false );
$delishs_header_button_text = get_theme_mod( 'delishs_header_button_text', 'Book A Table' );
$delishs_header_button_link = get_theme_mod( 'delishs_header_button_link', '#' );
$delishs_open_hour = get_theme_mod( 'delishs_open_hour', 'Mon-Wed: 11am-9pm' );
$delishs_open_hour_two = get_theme_mod( 'delishs_open_hour_two', 'Thurs-Sat: 11am-10pm' );
$delishs_email_address = get_theme_mod( 'delishs_email_address', 'reservations@delish.com' );
$delishs_phone = get_theme_mod( 'delishs_phone', '123 456 7899' );
$delishs_phone_link = get_theme_mod( 'delishs_phone_link', '+1234567899' );
$delishs_address = get_theme_mod( 'delishs_address', '296 Ridao Avenie Mor Berlin 251584' );
$delishs_address_link = get_theme_mod( 'delishs_address_link', 'https://maps.app.goo.gl/V5BeTXNv6WAniBN58' );
$delishs_side_hide = get_theme_mod( 'delishs_side_hide', false );

?>

<header>
    <div id="header-sticky" class="header__area header-1">
        <div class="container">
            <?php if ( !empty( $delishs_topbar_switch ) ): ?>
               <div class="header__top d-none d-xl-block">
                  <div class="row g-24">
                     <div class="col-xxl-6 col-4">
                           <div class="last_no_bullet">
                              <ul class="header__top-menu d-flex">
                                 <li><?php print esc_html($delishs_open_hour); ?></li>
                                 <li><?php print esc_html($delishs_open_hour_two); ?></li>
                              </ul>
                           </div>
                     </div>
                     <div class="col-xxl-6 col-8">
                           <div class="last_no_bullet">
                              <ul class="header__top-menu d-flex justify-content-end">
                                 <li><a href="mailto:<?php print esc_attr($delishs_email_address); ?>"><?php print esc_html($delishs_email_address); ?></a></li>
                                 <li><a href="tel:<?php print esc_attr($delishs_phone_link); ?>"><?php print esc_html($delishs_phone); ?></a></li>
                                 <li><a href="<?php print esc_url($delishs_address_link); ?>"><?php print esc_html($delishs_address); ?></a></li>
                              </ul>
                           </div>
                     </div>
                  </div>
               </div>
            <?php endif; ?>
            <div class="mega__menu-wrapper p-relative">
               <div class="header__main">
                  <div class="header__logo">
                     <?php delishs_header_logo();?>
                  </div>

                  <div class="mean__menu-wrapper d-none d-lg-block">
                        <div class="main-menu">
                           <nav id="mobile-menu">
                                 <?php delishs_header_menu();?>
                           </nav>
                        </div>
                  </div>

                  <div class="header__right-wrapper">
                  <?php if ( !empty( $delishs_header_right ) ): ?>
                     <div class="header__right">
                           <div class="header__action d-flex align-items-center">
                                 <?php if ( !empty( $delishs_header_button_switch ) ): ?>
                                    <div class="header__btn-wrap d-none d-sm-inline-flex">
                                       <a href="<?php print esc_url( $delishs_header_button_link );?>" class="rr-btn__header">
                                             <span class="hover-rl"></span>
                                             <span class="fake_hover"></span>
                                             <span class="btn-wrap">
                                                <span class="text-one"><?php print esc_html( $delishs_header_button_text );?> <img src="<?php print get_template_directory_uri();?>/assets/imgs/icon/arrow-right.svg" alt="<?php print esc_attr( 'not found', 'delishs' );?>"></span>
                                                <span class="text-two"><?php print esc_html( $delishs_header_button_text );?> <img src="<?php print get_template_directory_uri();?>/assets/imgs/icon/arrow-right.svg" alt="<?php print esc_attr( 'not found', 'delishs' );?>"></span>
                                             </span>
                                       </a>
                                    </div>
                                 <?php endif;?>
                           </div>
                     </div>
                     <?php endif;?>

                     <div class="header__hamburger ml-20 d-xl-none">
                        <div class="sidebar__toggle">
                           <a class="bar-icon" href="javascript:void(0)">
                                 <span></span>
                                 <span></span>
                                 <span></span>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </div>
    </div>
</header>

<?php get_template_part( 'template-parts/header/header-side-info' );?>