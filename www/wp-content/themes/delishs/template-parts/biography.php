<?php
    $author_data = get_the_author_meta( 'description', get_query_var( 'author' ) );
    $author_role = get_the_author_meta( 'delishs_author_role' );
    $facebook_url = get_the_author_meta( 'delishs_facebook' );
    $twitter_url = get_the_author_meta( 'delishs_twitter' );
    $linkedin_url = get_the_author_meta( 'delishs_linkedin' );
    $instagram_url = get_the_author_meta( 'delishs_instagram' );
    $youtube_url = get_the_author_meta( 'delishs_youtube' );
    $delishs_write_by = get_the_author_meta( 'delishs_write_by' );
    $author_bio_avatar_size = 180;
    if ( $author_data != '' ):
    
    ?>

    <div class="author-widget mt-60 mt-xs-50 mb-60 mb-xs-45 d-flex flex-column flex-sm-row align-items-center section-bg-2">
        <div class="author-widget-media">
            <?php print get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size, '', '', [ 'class' => 'img-responsive' ] );?> 
        </div>
        <div class="author-widget-text">
            <h5 class="author-widget-text__title"><?php print esc_html($delishs_write_by); ?></h5>
            <span><?php print esc_html($author_role); ?></span>
            <p class="mb-0"><?php the_author_meta( 'description' );?></p>
            <ul class="social-list">
                <?php if ( !empty( $facebook_url ) ): ?>
                    <li><a href="<?php print esc_url($facebook_url); ?>" class="facebook"><i class="fab fa-facebook-f"></i></a></li>
                <?php endif; ?>
                <?php if ( !empty( $twitter_url ) ): ?>
                    <li><a href="<?php print esc_url($twitter_url); ?>" class="twitter"><i class="fab fa-twitter"></i></a></li>
                <?php endif; ?>
                <?php if ( !empty( $linkedin_url ) ): ?>
                    <li><a href="<?php print esc_url($linkedin_url); ?>" class="linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                <?php endif; ?>
                <?php if ( !empty( $instagram_url ) ): ?>
                    <li><a href="<?php print esc_url($instagram_url); ?>" class="instagram"><i class="fab fa-instagram"></i></a></li>
                <?php endif; ?>
                <?php if ( !empty( $youtube_url ) ): ?>
                    <li><a href="<?php print esc_url($youtube_url); ?>" class="youtube"><i class="fab fa-youtube"></i></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

<?php endif;?>
