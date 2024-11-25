<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Header Buttons Widget.
 *
 * @since 1.0
 */
class Starbelly_Header_Buttons_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-header-buttons';
	}

	public function get_title() {
		return esc_html__( 'Header Buttons', 'starbelly-plugin' );
	}

	public function get_icon() {
		return 'eicon-parallax';
	}

	public function get_categories() {
		return [ 'starbelly-category' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_tab',
			[
				'label' => esc_html__( 'Content', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'info_show',
			[
				'label' => esc_html__( 'Shop Info Button', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'cart_show',
			[
				'label' => esc_html__( 'Show Shopping Cart', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'starbelly-plugin' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'starbelly-plugin' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'starbelly-plugin' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'starbelly-plugin' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
				'default'	=> 'left',
			]
		);

		$this->end_controls_section();

	}


	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		?>

    <div class="sb-buttons-frame">
      <?php if ( $settings['cart_show'] == 'yes' ) : ?>
      <?php if ( class_exists( 'WooCommerce' ) ) : ?>
  		<?php if ( true == get_theme_mod( 'cart_shop', true ) ) : $cart_total = 0; if ( is_object( WC()->cart ) ) : $cart_total = WC()->cart->get_cart_contents_count(); endif; ?>
      <!-- button -->
      <div class="sb-btn sb-btn-2 sb-btn-gray sb-btn-icon sb-m-0 sb-btn-cart">
        <span class="sb-icon">
          <i class="sb-icon-svg sb-icon-svg-cart"></i>
        </span>
        <i class="sb-cart-number">
          <span class="cart-count"><?php echo sprintf (_n( '%d', '%d', $cart_total, 'starbelly' ), $cart_total ); ?></span>
        </i>
      </div>
      <!-- button end -->
      <?php endif; ?>
      <?php endif; ?>
      <?php endif; ?>

      <!-- menu btn -->
      <div class="sb-menu-btn"><span></span></div>

			<?php if ( $settings['info_show'] == 'yes' ) : ?>
      <!-- info btn -->
      <div class="sb-info-btn"><span></span></div>
			<?php endif; ?>
    </div>

		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
    <?php if ( is_object( WC()->cart ) ) : ?>
    <!-- minicart -->
    <div class="sb-minicart">
      <?php woocommerce_mini_cart(); ?>
    </div>
    <!-- minicart end -->
    <?php endif; ?>
		<?php endif; ?>

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Header_Buttons_Widget() );
