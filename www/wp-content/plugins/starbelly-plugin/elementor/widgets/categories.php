<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Services Widget.
 *
 * @since 1.0
 */
class Starbelly_Categories_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-categories';
	}

	public function get_title() {
		return esc_html__( 'Categories', 'starbelly-plugin' );
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
			'icon', [
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
				'default'	=> esc_html__( 'Enter title', 'starbelly-plugin' ),
			]
		);

		$repeater->add_control(
			'text', [
				'label'       => esc_html__( 'Description', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter description', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Description', 'starbelly-plugin' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'starbelly-plugin' ),
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
			'settings_tab',
			[
				'label' => esc_html__( 'Settings', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'card_style',
			[
				'label'       => esc_html__( 'Card Style', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'style-2',
				'options' => [
					'style-1'  => __( 'Style 1', 'starbelly-plugin' ),
					'style-2' => __( 'Style 2', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'items_per_row',
			[
				'label'       => esc_html__( 'Items per Row', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => '6',
				'options' => [
					'6'  => __( '2', 'starbelly-plugin' ),
					'3' => __( '4', 'starbelly-plugin' ),
				],
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
					'{{WRAPPER}} .sb-categorie-card.sb-categorie-card-2 h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-categorie-card.sb-categorie-card-2 h3',
			]
		);

		$this->add_control(
			'item_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-categorie-card.sb-categorie-card-2 .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-categorie-card.sb-categorie-card-2 .sb-text',
			]
		);

		$this->add_control(
			'item_bgcolor',
			[
				'label'     => esc_html__( 'Item BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-categorie-card.sb-categorie-card-2 .sb-card-body' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_circle_bgcolor',
			[
				'label'     => esc_html__( 'Item Circle BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-categorie-card.sb-categorie-card-2 .sb-card-body .sb-category-icon:before' => 'background-color: {{VALUE}};',
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

		<!-- categories -->
		<section class="sb-p-0-60">
			<div class="container">
				<?php if ( $settings['title'] || $settings['description'] || $settings['button'] ) : ?>
				<div class="sb-group-title sb-mb-30">
					<?php if ( $settings['title'] || $settings['description'] ) : ?>
					<div class="sb-left sb-mb-30">
						<?php if ( $settings['title'] ) : ?>
						<<?php echo esc_attr( $settings['title_tag'] ); ?> class="sb-title--h sb-mb-30">
							<span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
								<?php echo wp_kses_post( $settings['title'] ); ?>
							</span>
						</<?php echo esc_attr( $settings['title_tag'] ); ?>>
						<?php endif; ?>
						<?php if ( $settings['description'] ) : ?>
						<p class="sb-text">
							<span <?php echo $this->get_render_attribute_string( 'description' ); ?>>
								<?php echo wp_kses_post( $settings['description'] ); ?>
							</span>
						</p>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<?php if ( $settings['button'] ) : ?>
					<div class="sb-right sb-mb-30">
						<!-- button -->
						<a<?php if ( $settings['link'] ) : if ( $settings['link']['is_external'] ) : ?> target="_blank"<?php endif; ?><?php if ( $settings['link']['nofollow'] ) : ?> rel="nofollow"<?php endif; ?> href="<?php echo esc_url( $settings['link']['url'] ); ?>"<?php endif; ?> class="sb-btn sb-m-0">
							<span class="sb-icon">
								<span class="sb-icon-arrow"></span>
							</span>
							<span <?php echo $this->get_render_attribute_string( 'button' ); ?>>
								<?php echo wp_kses_post( $settings['button'] ); ?>
							</span>
						</a>
						<!-- button end -->
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php if ( $settings['items'] ) : ?>
				<div class="row">
					<?php foreach ( $settings['items'] as $index => $item ) :
					  $item_title = $this->get_repeater_setting_key( 'title', 'items', $index );
					  $this->add_inline_editing_attributes( $item_title, 'basic' );

					  $item_text = $this->get_repeater_setting_key( 'text', 'items', $index );
					  $this->add_inline_editing_attributes( $item_text, 'basic' );
				  ?>
					<div class="col-lg-<?php echo esc_attr( $settings['items_per_row'] ); ?>">
						<a<?php if ( $item['link'] ) : if ( $item['link']['is_external'] ) : ?> target="_blank"<?php endif; ?><?php if ( $item['link']['nofollow'] ) : ?> rel="nofollow"<?php endif; ?> href="<?php echo esc_url( $item['link']['url'] ); ?>"<?php endif; ?> class="sb-categorie-card<?php if ( $settings['card_style'] == 'style-2' ) : ?> sb-categorie-card-2<?php endif; ?> sb-mb-30">
							<div class="sb-card-body">
								<?php if ( $item['icon'] ) : $image = wp_get_attachment_image_url( $item['icon']['id'], 'starbelly_950xAuto' ); ?>
								<div class="sb-category-icon">
									<img src="<?php echo esc_url( $image ); ?>" alt="icon" />
								</div>
								<?php endif; ?>
								<?php if ( $item['title'] || $item['text'] ) : ?>
								<div class="sb-card-descr">
									<?php if ( $item['title'] ) : ?>
									<h3 class="sb-mb-10">
										<span <?php echo $this->get_render_attribute_string( $item_title ); ?>>
					        		<?php echo wp_kses_post( $item['title'] ); ?>
					        	</span>
									</h3>
									<?php endif; ?>
									<?php if ( $item['text'] ) : ?>
									<p class="sb-text">
										<span <?php echo $this->get_render_attribute_string( $item_text ); ?>>
					        		<?php echo wp_kses_post( $item['text'] ); ?>
					        	</span>
									</p>
									<?php endif; ?>
									<?php if ( $settings['card_style'] == 'style-1' ) : ?>
									<!-- button -->
									<span class="sb-btn sb-btn-2 sb-btn-icon sb-mt-15 sb-m-0">
										<span class="sb-icon">
											<span class="sb-icon-arrow"></span>
										</span>
									</span>
									<!-- button end -->
									<?php endif; ?>
								</div>
								<?php endif; ?>
							</div>
						</a>
					</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</section>
		<!-- categories end -->

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

		<#
		view.addInlineEditingAttributes( 'title', 'basic' );
		view.addInlineEditingAttributes( 'description', 'basic' );
		view.addInlineEditingAttributes( 'button', 'none' );
		#>

		<!-- categories -->
		<section class="sb-p-0-60">
			<div class="container">
				<# if ( settings.title || settings.description || settings.button ) { #>
				<div class="sb-group-title sb-mb-30">
					<# if ( settings.title || settings.description ) { #>
					<div class="sb-left sb-mb-30">
						<# if ( settings.title ) { #>
						<{{{ settings.title_tag }}} class="sb-title--h sb-mb-30">
							<span {{{ view.getRenderAttributeString( 'title' ) }}}>
								{{{ settings.title }}}
							</span>
						</{{{ settings.title_tag }}}>
						<# } #>
						<# if ( settings.description ) { #>
						<p class="sb-text">
							<span {{{ view.getRenderAttributeString( 'description' ) }}}>
								{{{ settings.description }}}
							</span>
						</p>
						<# } #>
					</div>
					<# } #>
					<# if ( settings.button ) { #>
					<div class="sb-right sb-mb-30">
						<!-- button -->
						<a<# if ( settings.link ) { if ( settings.link.is_external ) { #> target="_blank"<# } #><# if ( settings.link.nofollow ) { #> rel="nofollow"<# } #> href="{{{ settings.link.url }}}"<# } #> class="sb-btn sb-m-0">
							<span class="sb-icon">
								<span class="sb-icon-arrow"></span>
							</span>
							<span {{{ view.getRenderAttributeString( 'button' ) }}}>
								{{{ settings.button }}}
							</span>
						</a>
						<!-- button end -->
					</div>
					<# } #>
				</div>
				<# } #>

				<# if ( settings.items ) { #>
				<div class="row">
					<# _.each( settings.items, function( item, index ) {
					var item_title = view.getRepeaterSettingKey( 'title', 'items', index );
					view.addInlineEditingAttributes( item_title, 'basic' );

					var item_text = view.getRepeaterSettingKey( 'text', 'items', index );
					view.addInlineEditingAttributes( item_text, 'basic' );
				  #>
					<div class="col-lg-{{{ settings.items_per_row }}}">
						<a<# if ( item.link ) { if ( item.link.is_external ) { #> target="_blank"<# } #><# if ( item.link.nofollow ) { #> rel="nofollow"<# } #> href="{{{ item.link.url }}}"<# } #> class="sb-categorie-card<# if ( settings.card_style == 'style-2' ) { #> sb-categorie-card-2<# } #> sb-mb-30">
							<div class="sb-card-body">
								<# if ( item.icon ) { #>
								<div class="sb-category-icon">
									<img src="{{{ item.icon.url }}}" alt="icon" />
								</div>
								<# } #>
								<# if ( item.title || item.text ) { #>
								<div class="sb-card-descr">
									<# if ( item.title ) { #>
									<h3 class="sb-mb-10">
										<span {{{ view.getRenderAttributeString( item_title ) }}}>
											{{{ item.title }}}
										</span>
									</h3>
									<# } #>
									<# if ( item.text ) { #>
									<p class="sb-text">
										<span {{{ view.getRenderAttributeString( item_text ) }}}>
											{{{ item.text }}}
										</span>
									</p>
									<# } #>
								</div>
								<# } #>
							</div>
						</a>
					</div>
					<# }); #>
				</div>
				<# } #>
			</div>
		</section>
		<!-- categories end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Categories_Widget() );
