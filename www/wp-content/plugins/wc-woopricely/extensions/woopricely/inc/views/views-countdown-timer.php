<div class="zc_zri_countdown_timer">
    <?php
    if ( $countdown_timer[ 'title' ] != '' ) {
        ?>
        <h5 class="zc_zri_countdown_timer_title"><?php echo wp_kses_post( $timer_title ); ?></h5>
        <?php
    }
    ?>                
    <div class="zc_zri_countdown_timer_clock" data-zcpri_datetime="<?php echo esc_attr( $time_left ); ?>" data-zcpri_days="<?php echo esc_attr( $pri_days ); ?>" data-zcpri_hours="<?php echo esc_attr( $pri_hours ); ?>" data-zcpri_minutes="<?php echo esc_attr( $pri_minutes ); ?>" data-zcpri_seconds="<?php echo esc_attr( $pri_seconds ); ?>"></div>
</div>