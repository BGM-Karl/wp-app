<?php
/**
* Template for theme dashboard plugins page
*/
?>
<div class="starbelly-dashboard-plugins">
  <div class="image-container">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_amiibtte.json"  background="transparent"  speed="1"  style="width: 100%; height: auto;"  loop  autoplay></lottie-player>
  </div>
  <div class="content-container">
    <div class="notice notice-error">
      <p><?php echo sprintf( __( 'The following premium plugins are available for installation / update only with <strong>activated theme</strong>!', 'starbelly-plugin' ) );?></p>
    </div>
    <h2><?php echo esc_html__( 'Plugins Status', 'starbelly-plugin' ); ?></h2>
    <div class="starbelly-dashboard-list">
      <ul>
        <li>
           <strong><span class="dashicons dashicons-no" title="<?php echo esc_attr__( 'Disabled! Need activate theme.', 'starbelly-plugin' ); ?>"></span></strong>
           <?php echo esc_html__( 'Advanced Custom Fields Pro', 'starbelly-plugin' ); ?>
        </li>
      </ul>
    </div>
    <div class="buttons">
      <p>
        <a href="" class="button button-primary button-primary-disabled"><?php echo esc_html__( 'Install / Update', 'starbelly-plugin' ); ?></a>
        <?php echo sprintf( __( '<a href="%s" class="button button-primary">Activate Theme</a>', 'starbelly-plugin' ), admin_url( 'admin.php?page=starbelly-theme-activation' ) ); ?>
      </p>
    </div>
  </div>
</div>
