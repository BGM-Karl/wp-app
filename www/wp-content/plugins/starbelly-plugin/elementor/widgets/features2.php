<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Features 2 Widget.
 *
 * @since 1.0
 */
class Starbelly_Features2_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-features-2';
	}

	public function get_title() {
		return esc_html__( 'Features 2', 'starbelly-plugin' );
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
			'items_tab',
			[
				'label' => esc_html__( 'Items', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'num', [
				'label'       => esc_html__( 'Num', 'oblo-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter num', 'oblo-plugin' ),
				'default' => esc_html__( '01', 'oblo-plugin' ),
			]
		);

    $repeater->add_control(
			'title', [
				'label'       => esc_html__( 'Title', 'oblo-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title', 'oblo-plugin' ),
				'default' => esc_html__( 'Title', 'oblo-plugin' ),
			]
		);

    $repeater->add_control(
			'desc', [
				'label'       => esc_html__( 'Description', 'oblo-plugin' ),
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Enter description', 'oblo-plugin' ),
				'default' => esc_html__( 'Description', 'oblo-plugin' ),
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'starbelly-plugin' ),
				'type' => Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
			'items_styling',
			[
				'label'     => esc_html__( 'Items Styles', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_control(
			'item_num_color',
			[
				'label'     => esc_html__( 'Num Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-features-item .sb-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-features-item h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-features-item h3',
			]
		);

    $this->add_control(
			'item_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-features-item .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-features-item .sb-text',
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

		<!-- features -->
		<section class="sb-features sb-p-0-30">
			<div class="container">
				<?php if ( $settings['items'] ) : ?>
				<div class="row">
					<?php foreach ( $settings['items'] as $index => $item ) :
						$item_num = $this->get_repeater_setting_key( 'num', 'items', $index );
						$this->add_inline_editing_attributes( $item_num, 'none' );

						$item_title = $this->get_repeater_setting_key( 'title', 'items', $index );
						$this->add_inline_editing_attributes( $item_title, 'basic' );

						$item_desc = $this->get_repeater_setting_key( 'desc', 'items', $index );
						$this->add_inline_editing_attributes( $item_desc, 'advanced' );
					?>
					<div class="col-lg-4">
						<div class="sb-features-item sb-mb-60">
							<?php if ( $item['num'] ) : ?>
							<div class="sb-number">
								<span <?php echo $this->get_render_attribute_string( $item_num ); ?>>
									<?php echo wp_kses_post( $item['num'] ); ?>
								</span>
							</div>
							<?php endif; ?>
							<div class="sb-feature-text">
								<?php if ( $item['title'] ) : ?>
								<h3 class="sb-mb-15">
									<span <?php echo $this->get_render_attribute_string( $item_title ); ?>>
										<?php echo wp_kses_post( $item['title'] ); ?>
									</span>
								</h3>
								<?php endif; ?>
								<?php if ( $item['desc'] ) : ?>
								<div class="sb-text">
									<div <?php echo $this->get_render_attribute_string( $item_desc ); ?>>
										<?php echo wp_kses_post( $item['desc'] ); ?>
									</div>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</section>
		<!-- features end -->

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

		<!-- features -->
		<section class="sb-features sb-p-0-30">
			<div class="container">
				<# if ( settings.items ) { #>
				<div class="row">
					<# _.each( settings.items, function( item, index ) {
						var item_num = view.getRepeaterSettingKey( 'num', 'items', index );
						view.addInlineEditingAttributes( item_num, 'none' );

						var item_title = view.getRepeaterSettingKey( 'title', 'items', index );
						view.addInlineEditingAttributes( item_title, 'basic' );

						var item_desc = view.getRepeaterSettingKey( 'desc', 'items', index );
						view.addInlineEditingAttributes( item_desc, 'advanced' );
					#>
					<div class="col-lg-4">
						<div class="sb-features-item sb-mb-60">
							<# if ( item.num ) { #>
							<div class="sb-number">
								<span {{{ view.getRenderAttributeString( item_num ) }}}>
									{{{ item.num }}}
								</span>
							</div>
							<# } #>
							<div class="sb-feature-text">
								<# if ( item.title ) { #>
								<h3 class="sb-mb-15">
									<span {{{ view.getRenderAttributeString( item_title ) }}}>
										{{{ item.title }}}
									</span>
								</h3>
								<# } #>
								<# if ( item.desc ) { #>
								<div class="sb-text">
									<div {{{ view.getRenderAttributeString( item_desc ) }}}>
										{{{ item.desc }}}
									</div>
								</div>
								<# } #>
							</div>
						</div>
					</div>
					<# }); #>
				</div>
				<# } #>
			</div>
		</section>
		<!-- features end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Features2_Widget() );
