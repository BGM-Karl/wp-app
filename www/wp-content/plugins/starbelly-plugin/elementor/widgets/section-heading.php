<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Section Heading Widget.
 *
 * @since 1.0
 */
class Starbelly_Section_Heading_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-section-heading';
	}

	public function get_title() {
		return esc_html__( 'Section Heading', 'starbelly-plugin' );
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
			'heading_tab',
			[
				'label' => esc_html__( 'Heading', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'       => esc_html__( 'Title Tag', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'h3',
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
			'title',
			[
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Title', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your subtitle', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Subtitle', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your description', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Description', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Content', 'starbelly-plugin' ),
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Enter your content', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Content', 'starbelly-plugin' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'heading_styling',
			[
				'label' => esc_html__( 'Heading', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .row .tst-title--h' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography:', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .row .tst-title--h',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Subtitle Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .row .tst-suptitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Subtitle Typography:', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .row .tst-suptitle',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .row .tst-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'label' => esc_html__( 'Description Typography:', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .row .tst-text',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Content Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .row .single-post-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => esc_html__( 'Content Typography:', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .row .single-post-text',
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
		$this->add_inline_editing_attributes( 'subtitle', 'basic' );
		$this->add_inline_editing_attributes( 'description', 'basic' );
		$this->add_inline_editing_attributes( 'content', 'advanced' );

		?>

		<!-- section heading -->
		<div class="container">

		<div class="row">
		  <?php if ( $settings['title'] || $settings['subtitle'] || $settings['description'] ) : ?>
          <div class="col-lg-12">

            <!-- title -->
            <div class="text-center">
              <?php if ( $settings['subtitle'] ) : ?>
              <div class="tst-suptitle tst-suptitle-center tst-mb-15">
              	<span <?php echo $this->get_render_attribute_string( 'subtitle' ); ?>>
		          	<?php echo wp_kses_post( $settings['subtitle'] ); ?>
		        </span>
              </div>
              <?php endif; ?>
              <?php if ( $settings['title'] ) : ?>
              <<?php echo esc_attr( $settings['title_tag'] ); ?> class="tst-title--h tst-mb-30">
              	<span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
		          	<?php echo wp_kses_post( $settings['title'] ); ?>
		        </span>
              </<?php echo esc_attr( $settings['title_tag'] ); ?>>
              <?php endif; ?>
              <?php if ( $settings['description'] ) : ?>
              <p class="tst-text tst-title--desc tst-mb-60">
              	<span <?php echo $this->get_render_attribute_string( 'description' ); ?>>
		          	<?php echo wp_kses_post( $settings['description'] ); ?>
		        </span>
              </p>
              <?php endif; ?>
            </div>
            <!-- title end -->

          </div>
          <?php endif; ?>

          <?php if ( $settings['content'] ) : ?>
          <div class="single-post-text">
          	<div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
	          	<?php echo wp_kses_post( $settings['content'] ); ?>
	        </div>
          </div>
          <?php endif; ?>
        </div>

		</div>

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
		view.addInlineEditingAttributes( 'subtitle', 'basic' );
		view.addInlineEditingAttributes( 'description', 'basic' );
		view.addInlineEditingAttributes( 'content', 'advanced' );
		#>

		<!-- section heading -->
		<div class="container">

		<div class="row">
		  <# if ( settings.subtitle || settings.title || settings.description ) { #>
          <div class="col-lg-12">

            <!-- title -->
            <div class="text-center">
              <# if ( settings.subtitle ) { #>
              <div class="tst-suptitle tst-suptitle-center tst-mb-15">
              	<span {{{ view.getRenderAttributeString( 'subtitle' ) }}}>
	    			{{{ settings.subtitle }}}
	    		</span>
              </div>
              <# } #>
              <# if ( settings.title ) { #>
              <{{{ settings.title_tag }}} class="tst-title--h tst-mb-30">
              	<span {{{ view.getRenderAttributeString( 'title' ) }}}>
	    			{{{ settings.title }}}
	    		</span>
              </{{{ settings.title_tag }}}>
              <# } #>
              <# if ( settings.description ) { #>
              <p class="tst-text tst-title--desc tst-mb-60">
              	<span {{{ view.getRenderAttributeString( 'description' ) }}}>
	    			{{{ settings.description }}}
	    		</span>
              </p>
              <# } #>
            </div>
            <!-- title end -->

          </div>
          <# } #>

          <# if ( settings.content ) { #>
          <div class="single-post-text">
          	<div {{{ view.getRenderAttributeString( 'content' ) }}}>
    			{{{ settings.content }}}
    		</div>
          </div>
          <# } #>
        </div>

		</div>

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Section_Heading_Widget() );
