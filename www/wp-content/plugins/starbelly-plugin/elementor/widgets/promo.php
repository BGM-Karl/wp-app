<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Promo Widget.
 *
 * @since 1.0
 */
class Starbelly_Promo_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-promo';
	}

	public function get_title() {
		return esc_html__( 'Promo', 'starbelly-plugin' );
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
			'image', [
				'label' => esc_html__( 'Image', 'starbelly-plugin' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'image_orientation', [
				'label'       => esc_html__( 'Image Orientation', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'burger',
				'options' => [
					'burger'  => __( 'Horizontal', 'starbelly-plugin' ),
					'cup' => __( 'Vertical', 'starbelly-plugin' ),
				],
			]
		);

		$repeater->add_control(
			'image_circles', [
				'label'       => esc_html__( 'Image Circles', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes'  => __( 'Yes', 'starbelly-plugin' ),
					'no' => __( 'No', 'starbelly-plugin' ),
				],
			]
		);

		$repeater->add_control(
			'title', [
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Enter title', 'starbelly-plugin' ),
			]
		);

		$repeater->add_control(
			'description', [
				'label'       => esc_html__( 'Description', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter description', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Description', 'starbelly-plugin' ),
			]
		);

		$repeater->add_control(
			'button', [
				'label'       => esc_html__( 'Button (label)', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Button', 'starbelly-plugin' ),
			]
		);

		$repeater->add_control(
			'link', [
				'label'       => esc_html__( 'Button (link)', 'starbelly-plugin' ),
				'type' => Controls_Manager::URL,
				'show_external' => true,
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
				'label'     => esc_html__( 'Items', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_control(
			'item_bgcolor',
			[
				'label'     => esc_html__( 'Item BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-promo-frame' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .sb-promo-frame h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-promo-frame h3',
			]
		);

		$this->add_control(
			'item_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-promo-frame .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-promo-frame .sb-text',
			]
		);

		$this->add_control(
			'item_btn_color',
			[
				'label'     => esc_html__( 'Button Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-promo-frame .sb-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_btn_bgcolor',
			[
				'label'     => esc_html__( 'Button Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-promo-frame .sb-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_btn_typography',
				'label'     => esc_html__( 'Button Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-promo-frame .sb-btn',
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

		<?php if ( $settings['items'] ) : ?>
		<!-- promo -->
		<section class="sb-p-0-60">
			<div class="container">
				<div class="row">
					<?php foreach ( $settings['items'] as $index => $item ) :
					$item_title = $this->get_repeater_setting_key( 'title', 'items', $index );
					$this->add_inline_editing_attributes( $item_title, 'basic' );

					$item_button = $this->get_repeater_setting_key( 'button', 'items', $index );
					$this->add_inline_editing_attributes( $item_button, 'none' );

					$item_desc = $this->get_repeater_setting_key( 'description', 'items', $index );
					$this->add_inline_editing_attributes( $item_desc, 'basic' );
					?>
					<div class="col-lg-6">
						<div class="sb-promo-frame sb-mb-30">
							<div class="sb-promo-content">
								<div class="sb-text-frame">
									<?php if ( $item['title'] ) : ?>
									<h3 class="sb-mb-15">
										<span <?php echo $this->get_render_attribute_string( $item_title ); ?>>
		                  <?php echo wp_kses_post( $item['title'] ); ?>
		                </span>
									</h3>
									<?php endif; ?>
									<?php if ( $item['description'] ) : ?>
									<p class="sb-text sb-text-sm sb-mb-15">
										<span <?php echo $this->get_render_attribute_string( $item_desc ); ?>>
		                  <?php echo wp_kses_post( $item['description'] ); ?>
		                </span>
									</p>
									<?php endif; ?>
									<?php if ( $item['button'] ) : ?>
									<!-- button -->
									<a<?php if ( $item['link'] ) : if ( $item['link']['is_external'] ) : ?> target="_blank"<?php endif; ?><?php if ( $item['link']['nofollow'] ) : ?> rel="nofollow"<?php endif; ?> href="<?php echo esc_url( $item['link']['url'] ); ?>"<?php endif; ?> class="sb-btn sb-ppc">
										<span class="sb-icon">
											<span class="sb-icon-arrow"></span>
										</span>
										<span <?php echo $this->get_render_attribute_string( $item_button ); ?>>
		                  <?php echo wp_kses_post( $item['button'] ); ?>
		                </span>
									</a>
									<!-- button end -->
									<?php endif; ?>
								</div>
								<div class="sb-image-frame">
									<div class="sb-illustration-<?php if ( $item['image_orientation'] == 'burger' ) : ?>4<?php else : ?>5<?php endif; ?>">
										<?php if ( $item['image'] ) : $image = wp_get_attachment_image_url( $item['image']['id'], 'starbelly_950xAuto' ); ?>
										<img src="<?php echo esc_url( $image ); ?>" alt="burger" class="sb-<?php echo esc_attr( $item['image_orientation'] ); ?>" />
										<?php endif; ?>

										<?php if ( $item['image_circles'] == 'yes' ) : ?>
										<div class="sb-cirkle-1"></div>
										<div class="sb-cirkle-2"></div>
										<div class="sb-cirkle-3"></div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<!-- promo end -->
		<?php endif; ?>

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

		<# if ( settings.items ) { #>
		<!-- promo -->
		<section class="sb-p-0-60">
			<div class="container">
				<div class="row">
					<# _.each( settings.items, function( item, index ) {
					var item_title = view.getRepeaterSettingKey( 'title', 'items', index );
					view.addInlineEditingAttributes( item_title, 'basic' );

					var item_button = view.getRepeaterSettingKey( 'button', 'items', index );
					view.addInlineEditingAttributes( item_button, 'none' );

					var item_desc = view.getRepeaterSettingKey( 'description', 'items', index );
					view.addInlineEditingAttributes( item_desc, 'basic' );
					#>
					<div class="col-lg-6">
						<div class="sb-promo-frame sb-mb-30">
							<div class="sb-promo-content">
								<div class="sb-text-frame">
									<# if ( item.title ) { #>
									<h3 class="sb-mb-15">
										<span {{{ view.getRenderAttributeString( item_title ) }}}>
            					{{{ item.title }}}
            				</span>
									</h3>
									<# } #>
									<# if ( item.description ) { #>
									<p class="sb-text sb-text-sm sb-mb-15">
										<span {{{ view.getRenderAttributeString( item_desc ) }}}>
            					{{{ item.description }}}
            				</span>
									</p>
									<# } #>
									<# if ( item.button ) { #>
									<!-- button -->
									<a<# if ( item.link ) { if ( item.link.is_external ) { #> target="_blank"<# } #><# if ( item.link.nofollow ) { #> rel="nofollow"<# } #> href="{{{ item.link.url }}}"<# } #> class="sb-btn sb-ppc">
										<span class="sb-icon">
											<span class="sb-icon-arrow"></span>
										</span>
										<span {{{ view.getRenderAttributeString( item_button ) }}}>
            					{{{ item.button }}}
            				</span>
									</a>
									<!-- button end -->
									<# } #>
								</div>
								<div class="sb-image-frame">
									<div class="sb-illustration-<# if ( item.image_orientation == 'burger' ) { #>4<# } else { #>5<# } #>">
										<# if ( item.image ) { #>
										<img src="{{{ item.image.url }}}" alt="burger" class="sb-{{{ item.image_orientation }}}" />
										<# } #>

										<# if ( item.image_circles == 'yes' ) { #>
										<div class="sb-cirkle-1"></div>
										<div class="sb-cirkle-2"></div>
										<div class="sb-cirkle-3"></div>
										<# } #>
									</div>
								</div>
							</div>
						</div>
					</div>
					<# }); #>
				</div>
			</div>
		</section>
		<!-- promo end -->
		<# } #>

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Promo_Widget() );
