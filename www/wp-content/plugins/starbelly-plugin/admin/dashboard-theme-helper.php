<?php

/* Theme Info Class */
if ( ! function_exists( 'starbelly_theme_info' ) ) {
  function starbelly_theme_info() {
    $data = array();

    $theme = wp_get_theme();
    $theme_parent = $theme->parent();
    if ( !empty( $theme_parent ) ) {
      $theme = $theme_parent;
    }
    $data['slug'] = $theme->get_stylesheet();
    $data['name'] = $theme[ 'Name' ];
    $data['version'] = $theme[ 'Version' ];
    $data['author'] = $theme[ 'Author' ];
    $data['is_child'] = ! empty( $theme_parent );

    return $data;
  }
}
if ( ! class_exists( 'StarbellyThemeInfo' ) ) {
  class StarbellyThemeInfo {

    private static $_instance = null;

    public $slug;

    public $name;

    public $version;

    public $author;

    public $is_child;

    public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
				self::$_instance->init();
			}
			return self::$_instance;
		}

    public function __construct() {

		}

    public function init() {
      $theme = wp_get_theme();
      $theme_parent = $theme->parent();
      if ( !empty( $theme_parent ) ) {
        $theme = $theme_parent;
      }

      $this->slug = $theme->get_stylesheet();
      $this->name = $theme[ 'Name' ];
      $this->version = $theme[ 'Version' ];
      $this->author = $theme[ 'Author' ];
      $this->is_child = ! empty( $theme_parent );
    }
  }
}

function starbelly_theme_info() {
  return StarbellyThemeInfo::instance();
}
add_action( 'plugins_loaded', 'starbelly_theme_info' );

/* Plugin Info Class */
if ( ! class_exists( 'StarbellyPluginInfo' ) ) {
  class StarbellyPluginInfo {

    private static $_instance = null;

    public $name;

    public $version;

    public $author;

    public $slug;

    public $capability;

    public $dashboard_uri;

    public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
				self::$_instance->init();
			}
			return self::$_instance;
		}

    public function __construct() {

		}

    public function init() {
      $plugin = StarbellyPlugin::get_plugin_info();
      $status = get_option( 'Starbelly_lic_Status' );

      $this->name = $plugin['Name'];
      $this->version = $plugin['Version'];
      $this->author = $plugin[ 'Author' ];
      $this->slug = 'starbelly-plugin';
      $this->capability = ( $status == 'active' ) ? 'extended' : 'normal';
      $this->dashboard_uri = plugin_dir_url( __FILE__ );
    }
  }
}

function starbelly_plugin_info() {
  return StarbellyPluginInfo::instance();
}
add_action( 'plugins_loaded', 'starbelly_plugin_info' );

/* Activation Notice */
if ( ! function_exists( 'starbelly_theme_activation_notice' ) ) {
	function starbelly_theme_activation_notice() {
    // Return early if the nag message has been dismissed or user < author.
    if ( get_user_meta( get_current_user_id(), 'starbelly_dismissed_notice', true ) || ! current_user_can( apply_filters( 'starbelly_show_admin_notice_capability', 'publish_posts' ) ) ) {
      return;
    }

	?>
		<div class="notice notice-warning is-dismissible">
			<p><?php echo wp_kses_post( 'Please activate Starbelly theme to unlock all features: premium support from author and receive all future theme updates automatically!', 'starbelly-plugin' ); ?></p>
			<p>
        <a href="<?php echo admin_url( 'admin.php?page=starbelly-theme-activation' ); ?>" class="button button-primary"><?php echo esc_html__( 'Activate Now', 'starbelly-plugin' ); ?></a>
        <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'starbelly-dismiss', 'dismiss_admin_notices' ), 'starbelly-dismiss-' . get_current_user_id() ) ); ?>" class="dismiss-notice" target="_parent"><?php echo esc_html__( 'Dismiss this notice', 'starbelly-plugin' ); ?></a>
      </p>
		</div>
	<?php
	}
}

/* Activation Filter */
if ( ! function_exists( 'starbelly_is_theme_activated' ) ) {
	function starbelly_is_theme_activated() {
		return apply_filters( 'starbelly/is_theme_activated', false );
	}
}
