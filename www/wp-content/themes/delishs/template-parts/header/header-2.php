<?php 

/**
 * Template part for displaying header layout one
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package delishs
*/

$delishs_topbar_switch = get_theme_mod( 'delishs_topbar_switch', false );
$delishs_address = get_theme_mod( 'delishs_address', '296 Ridao Avenie Mor Berlin 251584' );
$delishs_address_link = get_theme_mod( 'delishs_address_link', 'https://maps.app.goo.gl/V5BeTXNv6WAniBN58' );
$delishs_find_store = get_theme_mod( 'delishs_find_store', 'Find a Store' );
$delishs_find_store_link = get_theme_mod( 'delishs_find_store_link', '#' );
$delishs_order_tracking = get_theme_mod( 'delishs_order_tracking', 'Order Tracking' );
$delishs_order_tracking_link = get_theme_mod( 'delishs_order_tracking_link', '#' );

// header right
$delishs_header_right = get_theme_mod( 'delishs_header_right', false );
$delishs_header_button_switch = get_theme_mod( 'delishs_header_button_switch', false );
$delishs_header_button_link = get_theme_mod( 'delishs_header_button_link', '#' );
$delishs_header_button_text = get_theme_mod( 'delishs_header_button_text', 'Book a Table' );
$delishs_header_search = get_theme_mod( 'delishs_header_search', false );
$delishs_header_user = get_theme_mod( 'delishs_header_user', '#' );
$delishs_header_wishlist = get_theme_mod( 'delishs_header_wishlist', '#' );
$delishs_header_cart = get_theme_mod( 'delishs_header_cart', '#' );

?>

<header>
    <div id="header-sticky" class="header__area header-2">
        <div class="container">
            <div class="header__main-wrapper">
               <?php if ( !empty( $delishs_topbar_switch ) ): ?>
                  <div class="header__top d-none d-xl-block">
                     <div class="row g-24">
                           <div class="col-6">
                              <ul class="header__top-menu d-flex">
                                 <li>
                                    <a href="<?php print esc_url($delishs_address_link); ?>">
                                       <i class="fa-solid fa-location-dot"></i> <?php print esc_html($delishs_address); ?>
                                    </a>
                                 </li>
                              </ul>
                           </div>
                           <div class="col-6">
                              <ul class="header__top-menu header__top-menu-2 d-flex justify-content-end">
                                 <?php if ( !empty ($delishs_find_store) ) : ?>
                                    <li>
                                       <a href="<?php print esc_attr($delishs_find_store_link); ?>">
                                          <?php print esc_html($delishs_find_store); ?>
                                       </a>
                                    </li>
                                 <?php endif; ?>
                                 <?php if ( !empty ($delishs_order_tracking) ) : ?>
                                    <li>
                                       <a href="<?php print esc_url($delishs_order_tracking_link); ?>">
                                          <?php print esc_html($delishs_order_tracking); ?>
                                       </a>
                                    </li>
                                 <?php endif; ?>
                              </ul>
                           </div>
                     </div>
                  </div>
               <?php endif; ?>

                <div class="mega__menu-wrapper p-relative">
                    <div class="header__main">
                        <div class="header__left d-flex">
                            <div class="header__hamburger">
                                <div class="sidebar__toggle">
                                    <button class="bar-icon">
                                        <span></span>
                                        <span></span>
                                    </button>
                                </div>
                            </div>

                            <div class="header__lang__select header__lang">
                              <?php delishs_header_lang_default(); ?>
                            </div>
                        </div>

                        <div class="header__logo">
                           <?php delishs_header_logo_two();?>
                        </div>

                        <div class="header__right d-none d-sm-inline-flex">
                           <?php if ( !empty( $delishs_header_right ) ): ?>
                              <?php if ( !empty( $delishs_header_button_switch ) ): ?>
                                 <div class="header__action d-flex align-items-center">
                                    <div class="header__btn-wrap">
                                          <a href="<?php print esc_url( $delishs_header_button_link );?>" class="rr-btn-2__header">
                                             <span class="hover-rl"></span>
                                             <span class="fake_hover"></span>
                                             <span class="btn-wrap">
                                                <span class="text-one"><?php print esc_html( $delishs_header_button_text );?></span>
                                                <span class="text-two"><?php print esc_html( $delishs_header_button_text );?></span>
                                             </span>
                                          </a>
                                    </div>
                                 </div>
                              <?php endif;?>
                           <?php endif;?>
                        </div>
                    </div>
                </div>

                <div class="header__bottom d-none d-xl-block">
                    <div class="row g-24">
                        <div class="col-8">
                            <div class="mean__menu-wrapper d-none d-lg-block">
                                <div class="main-menu main-menu-2">
                                    <nav id="mobile-menu">
                                       <?php delishs_header_menu();?>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                           <ul class="header__bottom-menu d-flex justify-content-end">
                              <?php if ( !empty( $delishs_header_right ) ): ?>
                                 <?php if ( !empty( $delishs_header_search ) ): ?>
                                    <li>
                                       <button class="search-open-btn">
                                          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M13.7071 12.2929C13.3166 11.9024 12.6834 11.9024 12.2929 12.2929C11.9024 12.6834 11.9024 13.3166 12.2929 13.7071L13.7071 12.2929ZM18.2929 19.7071C18.6834 20.0976 19.3166 20.0976 19.7071 19.7071C20.0976 19.3166 20.0976 18.6834 19.7071 18.2929L18.2929 19.7071ZM8 14C4.68629 14 2 11.3137 2 8H0C0 12.4183 3.58172 16 8 16V14ZM2 8C2 4.68629 4.68629 2 8 2V0C3.58172 0 0 3.58172 0 8H2ZM8 2C11.3137 2 14 4.68629 14 8H16C16 3.58172 12.4183 0 8 0V2ZM14 8C14 11.3137 11.3137 14 8 14V16C12.4183 16 16 12.4183 16 8H14ZM12.2929 13.7071L18.2929 19.7071L19.7071 18.2929L13.7071 12.2929L12.2929 13.7071Z" fill="white"/>
                                          </svg>
                                       </button>
                                    </li>
                                 <?php endif; ?>
                                 <?php if ( !empty( $delishs_header_user ) ): ?>
                                    <li>
                                       <a href="<?php print esc_url($delishs_header_user); ?>">
                                          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M15.2166 17.3323C13.9349 15.9008 12.0727 15 10 15C7.92734 15 6.06492 15.9008 4.7832 17.3323M10 19C5.02944 19 1 14.9706 1 10C1 5.02944 5.02944 1 10 1C14.9706 1 19 5.02944 19 10C19 14.9706 14.9706 19 10 19ZM10 12C8.34315 12 7 10.6569 7 9C7 7.34315 8.34315 6 10 6C11.6569 6 13 7.34315 13 9C13 10.6569 11.6569 12 10 12Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                          </svg>
                                       </a>
                                    </li>
                                 <?php endif; ?>
                                 <?php if ( !empty( $delishs_header_wishlist ) ): ?>
                                    <li>
                                       <a href="<?php print esc_url($delishs_header_wishlist); ?>">
                                          <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M10 4.15428C8 -0.540161 1 -0.0401611 1 5.95987C1 11.9599 10 16.9598 10 16.9598C10 16.9598 19 11.9599 19 5.95987C19 -0.0401611 12 -0.540161 10 4.15428Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                          </svg>
                                       </a>
                                    </li>
                                 <?php endif; ?>
                                 <?php if ( !empty( $delishs_header_cart ) ): ?>
                                    <li>
                                       <a href="<?php print esc_url($delishs_header_cart); ?>">
                                          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M1 1H1.26835C1.74213 1 1.97922 1 2.17246 1.08548C2.34283 1.16084 2.48871 1.2823 2.59375 1.43616C2.71289 1.61066 2.75578 1.84366 2.8418 2.30957L5.00004 14L15.4195 14C15.8739 14 16.1016 14 16.2896 13.9198C16.4554 13.8491 16.5989 13.7348 16.7051 13.5891C16.8255 13.424 16.8763 13.2025 16.9785 12.7597L18.5477 5.95972C18.7022 5.29025 18.7796 4.95561 18.6946 4.69263C18.6201 4.46207 18.4639 4.26634 18.256 4.14192C18.0189 4 17.6758 4 16.9887 4H3.5M16 19C15.4477 19 15 18.5523 15 18C15 17.4477 15.4477 17 16 17C16.5523 17 17 17.4477 17 18C17 18.5523 16.5523 19 16 19ZM6 19C5.44772 19 5 18.5523 5 18C5 17.4477 5.44772 17 6 17C6.55228 17 7 17.4477 7 18C7 18.5523 6.55228 19 6 19Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                          </svg>
                                          <span>2</span>
                                       </a>
                                    </li>
                                 <?php endif; ?>
                              <?php endif;?>
                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<?php get_template_part( 'template-parts/header/header-side-info' ); ?>