<?php 

/**
 * Template part for displaying header layout three
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package delishs
*/

// Top info
$delishs_topbar_switch = get_theme_mod( 'delishs_topbar_switch', true );
$delishs_open_hour = get_theme_mod( 'delishs_open_hour', 'Mon-Wed: 11am-9pm' );
$delishs_open_hour_two = get_theme_mod( 'delishs_open_hour_two', 'Thurs-Sat: 11am-10pm' );
$delishs_email_address = get_theme_mod( 'delishs_email_address', 'reservations@delish.com' );
$delishs_phone = get_theme_mod( 'delishs_phone', '123 456 7899' );
$delishs_phone_link = get_theme_mod( 'delishs_phone_link', '+1234567899' );
$delishs_address = get_theme_mod( 'delishs_address', '296 Ridao Avenie Mor Berlin 251584' );
$delishs_address_link = get_theme_mod( 'delishs_address_link', 'https://maps.app.goo.gl/V5BeTXNv6WAniBN58' );

// header right
$delishs_header_right = get_theme_mod( 'delishs_header_right', false );
$delishs_header_button_switch = get_theme_mod( 'delishs_header_button_switch', false );
$delishs_header_button_text = get_theme_mod( 'delishs_header_button_text', 'Book A Table' );
$delishs_header_button_link = get_theme_mod( 'delishs_header_button_link', '#' );
$delishs_header_button_text_two = get_theme_mod( 'delishs_header_button_text_two', 'Order Online' );
$delishs_header_button_link_two = get_theme_mod( 'delishs_header_button_link_two', '#' );

?>

<header>
    <div id="header-sticky" class="header__area header-3">
      <?php if ( !empty( $delishs_topbar_switch ) ): ?>
        <div class="header__top d-none d-xl-block">
            <div class="container">
                <div class="row g-24">
                    <div class="col-xxl-6 col-4">
                        <div class="last_no_bullet">
                            <ul class="header__top-menu d-flex">
                              <?php if ( !empty ($delishs_open_hour) ) : ?>
                                <li><?php print esc_html($delishs_open_hour); ?></li>
                              <?php endif; ?>
                              <?php if ( !empty ($delishs_open_hour_two) ) : ?>
                                <li><?php print esc_html($delishs_open_hour_two); ?></li>
                              <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-8">
                        <div class="last_no_bullet">
                            <ul class="header__top-menu d-flex justify-content-end">
                              <?php if ( !empty ($delishs_email_address) ) : ?>
                                 <li>
                                    <a href="mailto:<?php print esc_attr($delishs_email_address); ?>">
                                       <?php print esc_html($delishs_email_address); ?>
                                    </a>
                                 </li>
                              <?php endif; ?>
                              <?php if ( !empty ($delishs_phone) ) : ?>
                                 <li>
                                    <a href="tel:<?php print esc_attr($delishs_phone_link); ?>">
                                       <?php print esc_html($delishs_phone); ?>
                                    </a>
                                 </li>
                              <?php endif; ?>
                              <?php if ( !empty ($delishs_address) ) : ?>
                                 <li>
                                    <a href="<?php print esc_attr($delishs_address_link); ?>">
                                       <?php print esc_html($delishs_address); ?>
                                    </a>
                                 </li>
                              <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <?php endif; ?>

        <div class="container">
            <div class="mega__menu-wrapper p-relative">
                <div class="header__main">
                    <div class="header__logo">
                        <?php delishs_header_logo();?>
                    </div>

                    <div class="mean__menu-wrapper d-none d-lg-block">
                        <div class="main-menu main-menu-3">
                            <nav id="mobile-menu">
                              <?php delishs_header_menu();?>
                            </nav>
                        </div>
                    </div>

                    <?php if ( !empty( $delishs_header_right ) ): ?>
                        <div class="header__right">
                            <div class="header__action d-flex align-items-center">
                                <?php if ( !empty( $delishs_header_button_switch ) ): ?>
                                    <div class="header__btn-wrap d-none d-lg-inline-flex">
                                        <?php if ( !empty( $delishs_header_button_text_two ) ): ?>
                                        <a href="<?php print esc_url( $delishs_header_button_link_two );?>" class="rr-btn-3__header rr-btn-3__header-white">
                                                <span class="btn-wrap">
                                                    <span class="text-one"><?php print esc_html( $delishs_header_button_text_two );?></span>
                                                    <span class="text-two"><?php print esc_html( $delishs_header_button_text_two );?></span>
                                                </span>
                                        </a>
                                        <?php endif;?>
                                        <?php if ( !empty( $delishs_header_button_text ) ): ?>
                                        <a href="<?php print esc_url( $delishs_header_button_link );?>" class="rr-btn-3__header">
                                            <span class="btn-wrap">
                                                <span class="text-one"><?php print esc_html( $delishs_header_button_text );?></span>
                                                <span class="text-two"><?php print esc_html( $delishs_header_button_text );?></span>
                                            </span>
                                        </a>
                                        <?php endif;?>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    <?php endif;?>
                    <div class="header__hamburger ml-20 d-xl-none">
                        <div class="sidebar__toggle">
                            <button class="bar-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<?php get_template_part( 'template-parts/header/header-side-info' ); ?>