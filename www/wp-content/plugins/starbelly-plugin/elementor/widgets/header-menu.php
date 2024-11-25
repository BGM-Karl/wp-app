<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Header Menu Widget.
 *
 * @since 1.0
 */

class Starbelly_Header_Menu_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-header-menu';
	}

	public function get_title() {
		return esc_html__( 'Header Menu', 'starbelly-plugin' );
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
			'layout',
			[
				'label'       => esc_html__( 'Select Layout', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 2,
				'options' => [
					1  => __( 'Horizontal', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'menu',
			[
				'label' => esc_html__( 'Select Menu', 'starbelly-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => $this->nav_menu_list(),
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
				'label' => esc_html__( 'Header Menu', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'menu1_item_color',
			[
				'label' => esc_html__( 'Menu Item Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-navigation li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu1_item_hover_color',
			[
				'label' => esc_html__( 'Menu Item Hover Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-navigation li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu1_item_typography',
				'label' => esc_html__( 'Menu Item Typography:', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-navigation li a',
			]
		);

		$this->add_control(
			'menu1_sub_bgcolor',
			[
				'label' => esc_html__( 'Submenu BG Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-navigation li ul' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu1_sub_brcolor',
			[
				'label' => esc_html__( 'Submenu Border Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-navigation li ul' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu1_sub_item_color',
			[
				'label' => esc_html__( 'Submenu Item Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-navigation li ul li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu1_sub_item_hover_color',
			[
				'label' => esc_html__( 'Submenu Item Hover Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-navigation li ul li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu1_sub_item_typography',
				'label' => esc_html__( 'Submenu Item Typography:', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-navigation li ul li a',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Contact Form List.
	 *
	 * @since 1.0
	 */
	protected function nav_menu_list() {
		$menus = wp_get_nav_menus();
		$items = array();
		$i = 0;

		foreach ( $menus as $menu ) {
			if ( $i == 0 ) {
				$default = $menu->slug;
				$i ++;
			}
			$items[ $menu->slug ] = $menu->name;
		}

		return $items;
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
		<nav id="sb-dynamic-menu" class="sb-menu-transition">
			<?php starbelly_get_topmenu( $settings['menu'] ); ?>
		</nav>

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Header_Menu_Widget() );
