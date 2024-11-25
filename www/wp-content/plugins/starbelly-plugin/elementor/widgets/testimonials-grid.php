<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Testimonials Grid Widget.
 *
 * @since 1.0
 */
class Starbelly_Testimonials_Grid_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-testimonials-grid';
	}

	public function get_title() {
		return esc_html__( 'Testimonials Grid', 'starbelly-plugin' );
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
			'title_tab',
			[
				'label' => esc_html__( 'Title', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Title', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'       => esc_html__( 'Title Tag', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'  => __( 'H1', 'starbelly-plugin' ),
					'h2' => __( 'H2', 'starbelly-plugin' ),
					'h3' => __( 'H3', 'starbelly-plugin' ),
					'h4' => __( 'H4', 'starbelly-plugin' ),
					'div' => __( 'DIV', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter description', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Description', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'button',
			[
				'label'       => esc_html__( 'Button (label)', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Button', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Button (link)', 'starbelly-plugin' ),
				'type' => Controls_Manager::URL,
				'show_external' => true,
			]
		);

		$this->end_controls_section();

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
			'title', [
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Title', 'starbelly-plugin' ),
			]
		);

		$repeater->add_control(
			'desc', [
				'label'       => esc_html__( 'Description', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter description', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Description', 'starbelly-plugin' ),
			]
		);

		$repeater->add_control(
			'name', [
				'label'       => esc_html__( 'Name', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter name', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Name', 'starbelly-plugin' ),
			]
		);

    $repeater->add_control(
			'rating', [
				'label'       => esc_html__( 'Rating', 'starbelly-plugin' ),
				'type'        => Controls_Manager::NUMBER,
				'min' 		  => 0,
				'max' 		  => 5,
				'step' 		  => 1,
				'default' 	  => 5,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Testimonials Items', 'starbelly-plugin' ),
				'type' => Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
			'title_styling',
			[
				'label'     => esc_html__( 'Title', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-group-title .sb-title--h' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-group-title .sb-title--h',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-group-title .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-group-title .sb-text',
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Button Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-group-title .sb-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bgcolor',
			[
				'label'     => esc_html__( 'Button BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-group-title .sb-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'     => esc_html__( 'Button Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-group-title .sb-btn',
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
			'item_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-review-card h4' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-review-card h4',
			]
		);

		$this->add_control(
			'item_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-review-card .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-review-card .sb-text',
			]
		);

		$this->add_control(
			'item_name_color',
			[
				'label'     => esc_html__( 'Name Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-review-card .sb-author-frame h4' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_name_typography',
				'label'     => esc_html__( 'Name Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-review-card .sb-author-frame h4',
			]
		);

		$this->add_control(
			'item_rating_color',
			[
				'label'     => esc_html__( 'Rating Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-review-card .sb-stars li' => 'color: {{VALUE}};',
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

    $this->add_inline_editing_attributes( 'title', 'basic' );
		$this->add_inline_editing_attributes( 'description', 'basic' );
		$this->add_inline_editing_attributes( 'button', 'none' );

		?>

		<!-- reviews -->
		<section class="sb-reviews sb-p-90-90">
			<div class="sb-bg-2" style="margin-top: 190px;">
				<div></div>
			</div>
			<div class="container">
				<?php if ( $settings['items'] ) : ?>
				<div class="sb-masonry-grid">
					<div class="sb-grid-sizer"></div>

					<?php foreach ( $settings['items'] as $index => $item ) :
						$item_title = $this->get_repeater_setting_key( 'title', 'items', $index );
						$this->add_inline_editing_attributes( $item_title, 'basic' );

						$item_desc = $this->get_repeater_setting_key( 'desc', 'items', $index );
						$this->add_inline_editing_attributes( $item_desc, 'advanced' );

						$item_name = $this->get_repeater_setting_key( 'name', 'items', $index );
						$this->add_inline_editing_attributes( $item_name, 'basic' );

						$item_date = $this->get_repeater_setting_key( 'date', 'items', $index );
						$this->add_inline_editing_attributes( $item_date, 'basic' );
					?>
					<div class="sb-grid-item sb-item-50">
						<div class="sb-review-card sb-mb-60">
							<div class="sb-review-header sb-mb-15">
								<?php if ( $item['title'] ) : ?>
								<h4 class="sb-mb-15">
									<span <?php echo $this->get_render_attribute_string( $item_title ); ?>>
										<?php echo wp_kses_post( $item['title'] ); ?>
									</span>
								</h4>
								<?php endif; ?>
								<?php if ( $item['rating'] ) : ?>
								<ul class="sb-stars">
									<?php for ( $i=0; $i<=5; $i++ ) : ?>
									<li<?php if ( $item['rating']<$i || $item['rating'] == 0 ) : ?> class="sb-empty"<?php endif; ?>><i class="fas fa-star"></i></li>
									<?php endfor; ?>
								</ul>
								<?php endif; ?>
							</div>
							<?php if ( $item['desc'] ) : ?>
							<p class="sb-text sb-mb-15">
								<span <?php echo $this->get_render_attribute_string( $item_desc ); ?>>
									<?php echo wp_kses_post( $item['desc'] ); ?>
								</span>
							</p>
							<?php endif; ?>
							<div class="sb-author-frame">
								<?php if ( $item['image'] ) : $image = wp_get_attachment_image_url( $item['image']['id'], 'starbelly_140x140' ); ?>
								<div class="sb-avatar-frame">
									<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" />
								</div>
								<?php endif; ?>
								<?php if ( $item['name'] ) : ?>
								<h4>
									<span <?php echo $this->get_render_attribute_string( $item_name ); ?>>
										<?php echo wp_kses_post( $item['name'] ); ?>
									</span>
								</h4>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endforeach; ?>

				</div>
				<?php endif; ?>
			</div>
		</section>
		<!-- reviews end -->

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

		<!-- reviews -->
		<section class="sb-reviews sb-p-90-90">
			<div class="sb-bg-2" style="margin-top: 190px;">
				<div></div>
			</div>
			<div class="container">
				<# if ( settings.items ) { #>
				<div class="sb-masonry-grid">
					<div class="sb-grid-sizer"></div>

					<# _.each( settings.items, function( item, index ) {

					var item_title = view.getRepeaterSettingKey( 'title', 'items', index );
					view.addInlineEditingAttributes( item_title, 'basic' );

					var item_desc = view.getRepeaterSettingKey( 'desc', 'items', index );
					view.addInlineEditingAttributes( item_desc, 'advanced' );

					var item_name = view.getRepeaterSettingKey( 'name', 'items', index );
					view.addInlineEditingAttributes( item_name, 'basic' );

					var item_date = view.getRepeaterSettingKey( 'date', 'items', index );
					view.addInlineEditingAttributes( item_date, 'basic' );

					#>
					<div class="sb-grid-item sb-item-50">
						<div class="sb-review-card sb-mb-60">
							<div class="sb-review-header sb-mb-15">
								<# if ( item.title ) { #>
								<h4 class="sb-mb-15">
									<span {{{ view.getRenderAttributeString( item_title ) }}}>
										{{{ item.title }}}
									</span>
								</h4>
								<# } #>
								<# if ( item.rating ) { #>
								<ul class="sb-stars">
									<# for ( var i=0; i<=5; i++ ) { #>
									<li<# if ( item.rating<i || item.rating == 0 ) { #> class="sb-empty"<# } #>><i class="fas fa-star"></i></li>
									<# } #>
								</ul>
								<# } #>
							</div>
							<# if ( item.desc ) { #>
							<p class="sb-text sb-mb-15">
								<span {{{ view.getRenderAttributeString( item_desc ) }}}>
									{{{ item.desc }}}
								</span>
							</p>
							<# } #>
							<div class="sb-author-frame">
								<# if ( item.image ) { #>
								<div class="sb-avatar-frame">
									<img src="{{{ item.image.url }}}" alt="{{{ item.name }}}" />
								</div>
								<# } #>
								<# if ( item.name ) { #>
								<h4>
									<span {{{ view.getRenderAttributeString( item_name ) }}}>
										{{{ item.name }}}
									</span>
								</h4>
								<# } #>
							</div>
						</div>
					</div>
					<# }); #>

				</div>
				<# } #>
			</div>
		</section>
		<!-- reviews end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Testimonials_Grid_Widget() );
