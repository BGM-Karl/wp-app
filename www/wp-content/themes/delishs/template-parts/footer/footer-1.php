<?php 

/**
 * Template part for displaying footer layout one
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package delishs
*/

$delishs_footer_shape_switch = get_theme_mod( 'delishs_footer_shape_switch', false );
$delishs_footer_bg_color_from_page = function_exists( 'get_field' ) ? get_field( 'delishs_footer_bg_color' ) : '';
$footer_bg_color = get_theme_mod( 'delishs_footer_bg_color', '#111111' );

$delishs_footer_bottom_menu = get_theme_mod( 'delishs_footer_bottom_menu', false );
$footer_copyright_center = $delishs_footer_bottom_menu ? 'col-xl-6 col-lg-6 col-md-12 text-center text-xl-start text-lg-start text-md-center' : 'col-lg-12 text-center';

// bg color
$bg_color = !empty( $delishs_footer_bg_color_from_page ) ? $delishs_footer_bg_color_from_page : $footer_bg_color;

// footer_columns
$footer_columns = 0;
$footer_widgets = get_theme_mod( 'footer_widget_number', 4 );

for ( $num = 1; $num <= $footer_widgets; $num++ ) {
    if ( is_active_sidebar( 'footer-' . $num ) ) {
        $footer_columns++;
    }
}

switch ( $footer_columns ) {
case '1':
    $footer_class[1] = 'col-lg-12';
    break;
case '2':
    $footer_class[1] = 'col-lg-6 col-md-6';
    $footer_class[2] = 'col-lg-6 col-md-6';
    break;
case '3':
    $footer_class[1] = 'col-xl-4 col-lg-6 col-md-6';
    $footer_class[2] = 'col-xl-4 col-lg-6 col-md-6';
    $footer_class[3] = 'col-xl-4 col-lg-6 col-md-6';
    break;
case '4':
    $footer_class[1] = 'col-lg-3 col-md-6 col-sm-7';
    $footer_class[2] = 'col-lg-3 col-md-6 col-sm-5';
    $footer_class[3] = 'col-lg-3 col-md-6 col-sm-5';
    $footer_class[4] = 'col-lg-3 col-md-6 col-sm-7';
    break;
default:
    $footer_class = 'col-lg-3 col-md-6';
    break;
}

?>

<footer>
    <section class="footer-2__area-common footer-2__overlay theme-bg-secondary overflow-hidden">
        <?php if ( is_active_sidebar('footer-1') OR is_active_sidebar('footer-2') OR is_active_sidebar('footer-3') OR is_active_sidebar('footer-4') ): ?>
            <?php if ( !empty ($delishs_footer_shape_switch) ): ?>
                <div class="footer-2__background leftRight" data-background="<?php print get_template_directory_uri(); ?>/assets/imgs/footer-2/bg.png"></div>
            <?php endif; ?>
            <div class="footer-2__main-wrapper footer-2__bottom-border position-relative z-2 pb-100 pb-xs-80">
                <div class="container">
                    <div class="row g-24 mb-minus-50">
                        <?php if ( $footer_columns > 4 ) {
                            print '<div class="col-lg-3 col-md-6">';
                            dynamic_sidebar( 'footer-1' );
                            print '</div>';

                            print '<div class="col-lg-3 col-md-6">';
                            dynamic_sidebar( 'footer-2' );
                            print '</div>';

                            print '<div class="col-lg-3 col-md-6">';
                            dynamic_sidebar( 'footer-3' );
                            print '</div>';

                            print '<div class="col-lg-3 col-md-6">';
                            dynamic_sidebar( 'footer-4' );
                            print '</div>';
                            } else {
                                for ( $num = 1; $num <= $footer_columns; $num++ ) {
                                    if ( !is_active_sidebar( 'footer-' . $num ) ) {
                                        continue;
                                    }
                                    print '<div class="' . esc_attr( $footer_class[$num] ) . '">';
                                    dynamic_sidebar( 'footer-' . $num );
                                    print '</div>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="footer-2__bottom-wrapper position-relative z-2">
            <div class="container">
                <div class="footer-2__bottom">
                    <div class="row g-24">
                        <div class="<?php print esc_attr($footer_copyright_center); ?>">
                            <div class="footer-2__copyright">
                                <p class="mb-0"><?php print delishs_copyright_text(); ?></p>
                            </div>
                        </div>

                        <?php if (!empty($delishs_footer_bottom_menu)) : ?>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-center text-xl-end text-lg-end text-md-center">
                                <div class="footer-2__copyright-menu">
                                    <?php delishs_footer_bottom_menu(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>