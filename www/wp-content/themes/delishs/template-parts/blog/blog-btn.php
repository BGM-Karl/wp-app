<?php

/**
 * Template part for displaying post btn
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package delishs
 */

$delishs_blog_btn = get_theme_mod( 'delishs_blog_btn', 'Read More' );
$delishs_blog_btn_switch = get_theme_mod( 'delishs_blog_btn_switch', true );

?>

<?php if ( !empty( $delishs_blog_btn_switch ) ): ?>
    <a href="<?php the_permalink();?>" class="readmore">
        <?php print esc_html( $delishs_blog_btn );?> <i class="fa-regular fa-angles-right"></i>
    </a>
<?php endif;?>