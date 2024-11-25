<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package delishs
 */

get_header();

$delishs_error_image = get_theme_mod('delishs_error_image',get_template_directory_uri() . '/assets/imgs/404/404.png');
$delishs_error_title = get_theme_mod('delishs_error_title', __('Page Not Found', 'delishs'));
$delishs_error_description = get_theme_mod('delishs_error_description', __('Sorry, we couldnt find the page you where looking for. We suggest that you return to homepage.', 'delishs'));
$delishs_error_link_text = get_theme_mod('delishs_error_link_text', __('Back To Homepage', 'delishs'));
              
?>

<section class="error section-space">
   <div class="container">
      <div class="row">
            <div class="col-12 g-24 text-center">
               <?php if ( !empty ($delishs_error_image) ) : ?>
                  <div class="error__media">
                     <img class="img-fluid" src="<?php print esc_html($delishs_error_image);?>" alt="icon not found">
                  </div>
               <?php endif; ?>
               <div class="error__content mt-65 mt-md-55 mt-sm-50 mt-xs-40">
                  <?php if ( !empty ($delishs_error_title) ) : ?>
                     <h1 class="error__content-title mb-10 title-animation">
                        <?php print delishs_kses($delishs_error_title);?>
                     </h1>
                  <?php endif; ?>
                  <?php if ( !empty ($delishs_error_description) ) : ?>
                     <p class="mb-35 mb-xs-30">
                        <?php print delishs_kses($delishs_error_description);?>
                     </p>
                  <?php endif; ?>

                  <?php if ( !empty ($delishs_error_link_text) ) : ?>
                     <a href="<?php print esc_url(home_url('/'));?>" class="rr-btn-solid rr-btn-solid-2 d-inline-flex wow clip-a-z">
                           <span class="btn-wrap">
                              <span class="text-one"><?php print esc_html($delishs_error_link_text); ?></span>
                              <span class="text-two"><?php print esc_html($delishs_error_link_text); ?></span>
                           </span>
                     </a>
                  <?php endif; ?>
               </div>
            </div>
      </div>
   </div>
</section>

<?php
get_footer();