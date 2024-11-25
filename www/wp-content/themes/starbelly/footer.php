<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package starbelly
 */

?>

<!-- footer -->
<footer class="footer">
  <?php
    $footer_template = get_field( 'footer_template', 'option' );
    $footer_layout = get_field( 'footer_layout', 'option' );
    if ( $footer_template && !\Elementor\Plugin::$instance->preview->is_preview_mode() ) :
      $args = array( 'post_type' => 'hf_templates', 'p' => $footer_template );
      $loop = new WP_Query( $args );
      while ( $loop->have_posts() ) : $loop->the_post();
        the_content();
      endwhile; wp_reset_postdata();
    else :
  ?>
  <div class="sb-footer-frame">
    <div class="container">
      <div class="sb-copy align-center">
        <?php echo esc_html__( '© Starbelly 2022. All rights reserved.', 'starbelly' ); ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
</footer>
<!-- footer end -->

</div>
<!-- dynamic content end -->

</div>
<!-- app wrapper end -->

<?php wp_footer(); ?>

</body>
</html>
