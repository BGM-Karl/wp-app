<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Map Widget.
 *
 * @since 1.0
 */
class Starbelly_Mapbox_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-mapbox';
	}

	public function get_title() {
		return esc_html__( 'Map (mapbox)', 'starbelly-plugin' );
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
			'map_tab',
			[
				'label' => esc_html__( 'Map', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'map_long',
			[
				'label'       => esc_html__( 'Long', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter long value', 'starbelly-plugin' ),
				'default'     => esc_html__( '70.123', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'map_lat',
			[
				'label'       => esc_html__( 'Lat', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter lat value', 'starbelly-plugin' ),
				'default'     => esc_html__( '50.123', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'map_zoom',
			[
				'label'       => esc_html__( 'Zoom', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::NUMBER,
				'default'     => 15,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'map_styling',
			[
				'label'     => esc_html__( 'Map Styling', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_control(
			'lock_btn_color',
			[
				'label'     => esc_html__( 'Lock Button Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-lock' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lock_btn_bgcolor',
			[
				'label'     => esc_html__( 'Lock Button BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-lock' => 'background-color: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'marker_bgcolor',
			[
				'label'     => esc_html__( 'Marker BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .mapboxgl-marker svg g' => 'fill: {{VALUE}};',
				],
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

		$map_key = get_field( 'mapbox_key', 'options' );

		?>

    <!-- map -->
    <div class="sb-map-frame">
      <div id="map" class="sb-map" data-key="<?php echo esc_attr( $map_key ); ?>" data-long="<?php echo esc_attr( $settings['map_long'] ); ?>" data-lat="<?php echo esc_attr( $settings['map_lat'] ); ?>" data-zoom="<?php echo esc_attr( $settings['map_zoom'] ); ?>"></div>
      <div class="sb-lock"><i class="fas fa-lock"></i></div>
    </div>
    <!-- map end -->

		<?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>

    <!-- map -->
    <div class="sb-map-frame">
      <div id="map" class="sb-map" data-long="{{{ settings.map_long }}}" data-lat="{{{ settings.map_lat }}}" data-zoom="{{{ settings.map_zoom }}}"></div>
      <div class="sb-lock"><i class="fas fa-lock"></i></div>
    </div>
    <!-- map end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Mapbox_Widget() );
