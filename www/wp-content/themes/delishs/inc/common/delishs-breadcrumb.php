<?php
/**
 * Breadcrumbs for delishs theme.
 *
 * @package     delishs
 * @author      RRdevs
 * @copyright   Copyright (c) 2024, RRdevs
 * @link        https://rrdevs.net
 * @since       delishs 1.0.0
 */


function delishs_breadcrumb_func() {
    global $post;  
    $breadcrumb_class = '';
    $breadcrumb_show = 1;


    if ( is_front_page() && is_home() ) {
        $title = get_theme_mod('breadcrumb_blog_title', __('Blog', 'delishs'));
        $breadcrumb_class = 'home_front_page';
    }
    elseif ( is_front_page() ) {
        $title = get_theme_mod('breadcrumb_blog_title', __('Blog','delishs'));
        $breadcrumb_show = 0;
    }
    elseif ( is_home() ) {
        if ( get_option( 'page_for_posts' ) ) {
            $title = get_the_title( get_option( 'page_for_posts') );
        }
    }

    elseif ( is_single() && 'post' == get_post_type() ) {
      $title = get_the_title();
    } 
    elseif ( is_single() && 'product' == get_post_type() ) {
        $title = get_theme_mod( 'breadcrumb_product_details', __( 'Shop', 'delishs' ) );
    } 
    elseif ( is_single() && 'courses' == get_post_type() ) {
      $title = esc_html__( 'Course Details', 'delishs' );
    } 
    elseif ( 'courses' == get_post_type() ) {
      $title = esc_html__( 'Courses', 'delishs' );
    } 
    elseif ( is_search() ) {
        $title = esc_html__( 'Search Results for : ', 'delishs' ) . get_search_query();
    } 
    elseif ( is_404() ) {
        $title = esc_html__( 'Page Not Found', 'delishs' );
    } 
    elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
        $title = get_theme_mod( 'breadcrumb_shop', __( 'Shop', 'delishs' ) );
    } 
    elseif ( is_archive() ) {
        $title = get_the_archive_title();
    } 
    else {
        $title = get_the_title();
    }

    $_id = get_the_ID();

    if ( is_single() && 'product' == get_post_type() ) { 
        $_id = $post->ID;
    } 
    elseif ( function_exists("is_shop") AND is_shop()  ) { 
        $_id = wc_get_page_id('shop');
    } 
    elseif ( is_home() && get_option( 'page_for_posts' ) ) {
        $_id = get_option( 'page_for_posts' );
    }

    $is_breadcrumb = function_exists( 'get_field' ) ? get_field( 'is_it_invisible_breadcrumb', $_id ) : '';
    if( !empty($_GET['s']) ) {
      $is_breadcrumb = null;
    }

      if ( empty( $is_breadcrumb ) && $breadcrumb_show == 1 ) {

        $bg_img_from_page = function_exists('get_field') ? get_field('breadcrumb_background_image',$_id) : '';
        $hide_bg_img = function_exists('get_field') ? get_field('hide_breadcrumb_background_image',$_id) : '';
        $breadcrumb_bg_color = get_theme_mod( 'delishs_breadcrumb_bg_color', '#f6f3fc' );

        // get_theme_mod
        $breadcrumb_img = get_template_directory_uri() . '/assets/imgs/breadcrumb/page-header-1.jpg';
        $bg_img = get_theme_mod( 'breadcrumb_bg_img', $breadcrumb_img );
        $breadcrumb_info_switch = get_theme_mod( 'breadcrumb_info_switch', true );
        $breadcrumb_switch = get_theme_mod( 'breadcrumb_switch', true );

        if ( $hide_bg_img && empty($_GET['s']) ) {
            $bg_img = '';
        } else {
            $bg_img = !empty( $bg_img_from_page ) ? $bg_img_from_page['url'] : $bg_img;
        }?>

        <!-- ./ Page Header -->
        <?php if($breadcrumb_switch): ?>
            <div class="breadcrumb__area breadcrumb-space overly theme-bg-secondary overflow-hidden">
                <div class="breadcrumb__background" data-background="<?php print esc_attr($bg_img);?>"></div>
                <?php if($breadcrumb_info_switch): ?>
                    <div class="container">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-12">
                                <div class="breadcrumb__content text-center">
                                    <h2 class="breadcrumb__title color-white title-animation">
                                        <?php echo wp_kses_post( $title ); ?>
                                    </h2>

                                    <div class="breadcrumb__menu">
                                        <?php if(function_exists('bcn_display')) {
                                            bcn_display();
                                        } ?>
                                    </div>
                                </div>

                                <span class="breadcrumb__big-title"><?php echo wp_kses_post( $title ); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <!-- ./ Page Header -->
        <?php
      }
}

add_action( 'delishs_before_main_content', 'delishs_breadcrumb_func' );

function delishs_search_form() {
    ?>
    <div class="search__popup">
        <div class="container">
            <div class="row gx-30">
                <div class="col-xxl-12">
                    <div class="search__wrapper">
                        <div class="search__top d-flex justify-content-between align-items-center">
                            <div class="search__logo">
                                <?php delishs_search_logo(); ?>
                            </div>
                            <div class="search__close">
                                <button type="button" class="search__close-btn search-close-btn">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                        <path d="M17 1L1 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M1 1L17 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="search__form">
                            <form action="<?php print esc_url( home_url( '/' ) );?>">
                                <div class="search__input">
                                    <input class="search-input-field" type="search" name="s" value="<?php print esc_attr( get_search_query() )?>" placeholder="<?php print esc_attr__( 'Type here to search...', 'delishs' );?>">
                                    <span class="search-focus-border"></span>
                                    <button type="submit">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path
                                                    d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            <path d="M19.0002 19.0002L17.2002 17.2002" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="search-wrapper p-relative transition-3 d-none">
         <div class="search-form transition-3">
             <form method="get" action="<?php print esc_url( home_url( '/' ) );?>" >
                 <input type="search" name="s" value="<?php print esc_attr( get_search_query() )?>" placeholder="<?php print esc_attr__( 'Enter Your Keyword', 'delishs' );?>" >
                 <button type="submit" class="search-btn"><i class="far fa-search"></i></button>
             </form>
             <a href="javascript:void(0);" class="search-close"><i class="far fa-times"></i></a>
         </div>
     </div>
   <?php
}

add_action( 'delishs_before_main_content', 'delishs_search_form' );

