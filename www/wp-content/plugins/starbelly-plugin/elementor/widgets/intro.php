<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Intro Widget.
 *
 * @since 1.0
 */
class Starbelly_Intro_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-intro';
	}

	public function get_title() {
		return esc_html__( 'Intro', 'starbelly-plugin' );
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
			'layout',
			[
				'label'       => esc_html__( 'Layout', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'xs',
				'options' => [
					'xs'  => __( 'Minimal', 'starbelly-plugin' ),
					'sm' => __( 'Default', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'title_value',
			[
				'label'       => esc_html__( 'Title Value', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'dynamic',
				'options' => [
					'dynamic'  => __( 'Dynamic', 'starbelly-plugin' ),
					'static' => __( 'Static', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'subtitle_value',
			[
				'label'       => esc_html__( 'Subtitle Value', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'dynamic',
				'options' => [
					'dynamic'  => __( 'Dynamic', 'starbelly-plugin' ),
					'static' => __( 'Static', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'description_value',
			[
				'label'       => esc_html__( 'Description Value', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'dynamic',
				'options' => [
					'dynamic'  => __( 'Dynamic', 'starbelly-plugin' ),
					'static' => __( 'Static', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter subtitle', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Subtitle', 'starbelly-plugin' ),
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
				'default' => 'h1',
				'options' => [
					'h1'  => __( 'H1', 'starbelly-plugin' ),
					'h2' => __( 'H2', 'starbelly-plugin' ),
					'h3' => __( 'H3', 'starbelly-plugin' ),
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

		$this->end_controls_section();

		$this->start_controls_section(
			'breadcrumbs_tab',
			[
				'label' => esc_html__( 'Breadcrumbs', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'breadcrumbs',
			[
				'label'       => esc_html__( 'Breadcrumbs', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'background_styling',
			[
				'label'     => esc_html__( 'Section Background', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_bg_color',
			[
				'label'     => esc_html__( 'BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-banner.sb-banner-color' => 'background-color: {{VALUE}};',
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
			'subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-banner .sb-suptitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtitle_bgcolor',
			[
				'label'     => esc_html__( 'Subtitle BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-banner .sb-suptitle' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'label'     => esc_html__( 'Subtitle Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-banner .sb-suptitle',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-banner .sb-title-el' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-banner .sb-title-el',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-banner .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-banner .sb-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'breadcrumbs_styling',
			[
				'label'     => esc_html__( 'Breadcrumbs', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'breadcrumbs_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-breadcrumbs' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'breadcrumbs_link_color',
			[
				'label'     => esc_html__( 'Background Link Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-breadcrumbs li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'breadcrumbs_link_typography',
				'label'     => esc_html__( 'Background Link Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-breadcrumbs li a',
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

		$this->add_inline_editing_attributes( 'subtitle', 'basic' );
		$this->add_inline_editing_attributes( 'title', 'basic' );
		$this->add_inline_editing_attributes( 'description', 'basic' );

		$page_id = get_queried_object_id();

		if ( $page_id ) {
			$intro_title = get_field( 'intro_title', $page_id );
			if ( !$intro_title ) {
				$intro_title = get_the_title( $page_id );
			}

			$intro_sub = get_field( 'intro_subtitle', $page_id );
			$intro_text = get_field( 'intro_description', $page_id );

			if ( $intro_title && $settings['title_value'] == 'dynamic'  ) {
				$settings['title'] = $intro_title;
			}
			if ( $intro_sub && $settings['subtitle_value'] == 'dynamic' ) {
				$settings['subtitle'] = $intro_sub;
			}
			if ( $intro_text && $settings['description_value'] == 'dynamic' ) {
				$settings['description'] = $intro_text;
			}
		}

		?>

		<!-- banner -->
		<section class="sb-banner sb-banner-<?php echo esc_attr( $settings['layout'] ); ?> sb-banner-color">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<!-- main title -->
						<div class="sb-main-title-frame">
							<div class="sb-main-title<?php if ( $settings['layout'] == 'sm' ) : ?> text-center<?php endif; ?>">
								<?php if ( $settings['subtitle'] && $settings['layout'] == 'sm' ) : ?>
								<span class="sb-suptitle sb-mb-30">
									<span <?php echo $this->get_render_attribute_string( 'subtitle' ); ?>>
					          <?php echo wp_kses_post( $settings['subtitle'] ); ?>
					        </span>
								</span>
								<?php endif; ?>
								<?php if ( $settings['title'] ) : ?>
								<<?php echo esc_attr( $settings['title_tag'] ); ?> class="sb-title-el <?php if ( $settings['layout'] == 'sm' ) : ?>sb-mb-30<?php else : ?>sb-h2<?php endif; ?>">
									<span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
					          <?php echo wp_kses_post( $settings['title'] ); ?>
					        </span>
								</<?php echo esc_attr( $settings['title_tag'] ); ?>>
								<?php endif; ?>
								<?php if ( $settings['description'] && $settings['layout'] == 'sm' ) : ?>
								<p class="sb-text sb-text-lg sb-mb-30">
									<span <?php echo $this->get_render_attribute_string( 'description' ); ?>>
					          <?php echo wp_kses_post( $settings['description'] ); ?>
					        </span>
								</p>
								<?php endif; ?>
								<?php if ( $settings['breadcrumbs'] == 'yes' ) : ?>
								<?php starbelly_breadcrumbs( $page_id ); ?>
								<?php endif; ?>
							</div>
						</div>
						<!-- main title end -->
					</div>
				</div>
			</div>
		</section>
		<!-- banner end -->

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
		view.addInlineEditingAttributes( 'subtitle', 'basic' );
		view.addInlineEditingAttributes( 'title', 'basic' );
		view.addInlineEditingAttributes( 'description', 'basic' );
		#>

		<!-- banner -->
		<section class="sb-banner sb-banner-{{{ settings.layout }}} sb-banner-color">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<!-- main title -->
						<div class="sb-main-title-frame">
							<div class="sb-main-title<# if ( settings.layout == 'sm' ) { #> text-center<# } #>">
								<# if ( settings.subtitle && settings.layout == 'sm' ) { #>
								<span class="sb-suptitle sb-mb-30">
									<span {{{ view.getRenderAttributeString( 'subtitle' ) }}}>
					          	{{{ settings.subtitle }}}
					        </span>
								</span>
								<# } #>
								<# if ( settings.title ) { #>
								<{{{ settings.title_tag }}} class="sb-title-el <# if ( settings.layout == 'sm' ) { #>sb-mb-30<# } else { #>sb-h2<# } #>">
									<span {{{ view.getRenderAttributeString( 'title' ) }}}>
											{{{ settings.title }}}
									</span>
								</{{{ settings.title_tag }}}>
								<# } #>
								<# if ( settings.description && settings.layout == 'sm' ) { #>
								<p class="sb-text sb-text-lg sb-mb-30">
									<span {{{ view.getRenderAttributeString( 'description' ) }}}>
					          	{{{ settings.description }}}
					        </span>
								</p>
								<# } #>
								<# if ( settings.breadcrumbs == 'yes' ) { #>
								<ul class="sb-breadcrumbs">
                  <li><a href="#.">Home</a></li>
                  <li><a href="#.">{Title}</a></li>
                </ul>
								<# } #>
							</div>
						</div>
						<!-- main title end -->
					</div>
				</div>
			</div>
		</section>
		<!-- banner end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Intro_Widget() );
