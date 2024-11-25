<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Footer Social Links Widget.
 *
 * @since 1.0
 */
class Starbelly_Footer_Social_Links_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-footer-social-links';
	}

	public function get_title() {
		return esc_html__( 'Footer Social Links', 'starbelly-plugin' );
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
			'social',
			[
				'label' => esc_html__( 'Social Links', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
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

		$this->start_controls_section(
			'content_styling',
			[
				'label' => esc_html__( 'Footer Social Links', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'link_color',
			[
				'label' => esc_html__( 'Link Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-social a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_active_color',
			[
				'label' => esc_html__( 'Link Hover Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-social a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'label' => esc_html__( 'Link Typography:', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-social a',
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

		$social_links = get_field( 'social_links', 'option' );

		?>

		<?php if ( $settings['social'] == 'yes' ) : ?>
    <ul class="sb-social">
      <?php foreach ( $social_links as $index => $item ) : ?>
      <li>
        <a<?php if ( $item['url'] ) : ?> target="_blank" href="<?php echo esc_url( $item['url'] ); ?>"<?php endif; ?> title="<?php echo esc_attr( $item['title'] ); ?>">
          <?php echo wp_kses_post( $item['icon'] ); ?>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Footer_Social_Links_Widget() );
