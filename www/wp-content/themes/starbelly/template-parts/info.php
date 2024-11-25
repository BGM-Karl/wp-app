<?php

// Check value exists.
if ( have_rows( 'info_bar', 'options' ) ) :

    // Loop through rows.
    while ( have_rows( 'info_bar', 'options' ) ) : the_row(); ?>

    <?php if ( get_row_layout() == 'contact' ) :
      $title = get_sub_field( 'title' );
      $list = get_sub_field( 'list' );
      ?>

      <?php if ( !empty( $title ) ) : ?>
      <div class="sb-ib-title-frame sb-mb-30">
        <h4><?php echo esc_html( $title ); ?></h4><i class="fas fa-arrow-down"></i>
      </div>
      <?php endif; ?>
      <?php if ( !empty( $list ) ) : ?>
      <ul class="sb-list sb-mb-30">
        <?php foreach ( $list as $item ) : ?>
        <li>
          <b><?php echo esc_html( $item['label'] ); ?></b>
          <?php if ( !empty($item['link']) ) : ?>
          <a href="<?php echo esc_url( $item['link'] ); ?>" target="_blank">
          <?php endif; ?>
          <span><?php echo esc_html( $item['value'] ); ?></span>
          <?php if ( !empty($item['link']) ) : ?>
          </a>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    <?php elseif ( get_row_layout() == 'instagram' ) :
      $title = get_sub_field( 'title' );
      $access_token = get_sub_field( 'access_token' );
      $number_of_images = get_sub_field( 'number_of_images' );
      ?>

      <?php if ( !empty( $title ) ) : ?>
      <div class="sb-ib-title-frame sb-mb-30">
        <h4><?php echo esc_html( $title ); ?></h4><i class="fas fa-arrow-down"></i>
      </div>
      <?php endif; ?>
      <?php if ( !empty( $access_token ) ) :
        if ( function_exists( 'starbelly_get_instagram_data' ) ) :
        $stories = starbelly_get_instagram_data( $number_of_images, $access_token );
        ?>
        <?php if ( !empty( $stories ) ) : ?>
        <ul class="sb-instagram sb-mb-30">
          <?php foreach ( $stories as $item ) : ?>
          <li>
            <a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank">
              <img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr__( 'photo', 'starbelly' ); ?>" />
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php endif; ?>
        <hr>
      <?php else : ?>
        <?php echo '<p class="text-center sb-mb-30">' . esc_html__( 'Wrong Access Token', 'starbelly' ) . '</p><hr>';?>
      <?php endif; ?>

    <?php elseif ( get_row_layout() == 'latest-posts' ) :
      $title = get_sub_field( 'title' );
      $number_of_items = get_sub_field( 'number_of_items' );
      ?>

      <?php if ( !empty( $title ) ) : ?>
      <div class="sb-ib-title-frame sb-mb-30">
        <h4><?php echo esc_html( $title ); ?></h4><i class="fas fa-arrow-down"></i>
      </div>
      <?php endif; ?>
      <?php
      $args = array(
        'post_type'			  => 'post',
        'post_status'		  => 'publish',
        'orderby'         => 'date',
        'order'           => 'DESC',
        'posts_per_page'	=> $number_of_items
      );

      $the_query = new WP_Query( $args );

      if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post(); set_query_var( 'items_excerpt_custom', 10 );
      ?>
      <div class="sb-blog-card sb-blog-card-sm sb-mb-30">
        <div class="sb-cover-frame">
          <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail(); ?>
          </a>
        </div>
        <div class="sb-blog-card-descr">
          <h5 class="sb-mb-5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
          <div class="sb-text sb-text-sm"><?php the_excerpt(); ?></div>
        </div>
      </div>
      <?php endwhile; ?>
    <?php endif; wp_reset_postdata(); ?>

    <?php endif; ?>

    <?php
    // End loop.
    endwhile;

// No value.
else :
  echo '<p class="text-center sb-mb-30">' . esc_html__( 'No rows to show', 'starbelly' ) . '</p>';
endif;
