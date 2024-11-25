<?php 

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function delishs_widgets_init() {

    $footer_style_2_switch = get_theme_mod( 'footer_style_2_switch', true );

    // blog sidebar
    register_sidebar( [
        'name'          => esc_html__( 'Blog Sidebar', 'delishs' ),
        'id'            => 'blog-sidebar',
        'description'   => esc_html__( 'Set Your Blog Widget', 'delishs' ),
        'before_widget' => '<div id="%1$s" class="sidebar__single sidebar__widget section-bg-2 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="sidebar__widget-title">',
        'after_title'   => '</h4>',
    ] );

    // product sidebar
    register_sidebar( [
        'name'          => esc_html__( 'Product Sidebar', 'delishs' ),
        'id'            => 'product-sidebar',
        'description'   => esc_html__( 'Set Your Blog Widget', 'delishs' ),
        'before_widget' => '<div id="%1$s" class="sidebar__single sidebar__widget product__widget section-bg-2 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="sidebar__widget-title">',
        'after_title'   => '</h4>',
    ] );


    $footer_widgets = get_theme_mod( 'footer_widget_number', 4 );

    // footer default
    for ( $num = 1; $num <= $footer_widgets; $num++ ) {
        register_sidebar( [
            'name'          => sprintf( esc_html__( 'Footer %1$s', 'delishs' ), $num ),
            'id'            => 'footer-' . $num,
            'description'   => sprintf( esc_html__( 'Footer column %1$s', 'delishs' ), $num ),
            'before_widget' => '<div id="%1$s" class="footer-widget footer-2__widget footer_lists footer-col-1-'.$num.' footer-2__widget-item-'.$num.' %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="footer-2__widget-title"><h4>',
            'after_title'   => '</h4></div>',
        ] );
    }

    // footer 2
    if ( $footer_style_2_switch ) {
        for ( $num = 1; $num <= $footer_widgets; $num++ ) {

            register_sidebar( [
                'name'          => sprintf( esc_html__( 'Footer Style 2 : %1$s', 'delishs' ), $num ),
                'id'            => 'footer-2-' . $num,
                'description'   => sprintf( esc_html__( 'Footer Style 2 : %1$s', 'delishs' ), $num ),
                'before_widget' => '<div id="%1$s" class="footer-widget footer__widget mb-30 footer__widget-2 footer-col-2-'.$num.' %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<div class="footer__widget-title"><h4>',
                'after_title'   => '</h4></div>',
            ] );
        }
    }
}
add_action( 'widgets_init', 'delishs_widgets_init' );