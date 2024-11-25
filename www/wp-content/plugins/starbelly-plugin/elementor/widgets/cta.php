<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Call to Action Widget.
 *
 * @since 1.0
 */
class Starbelly_CTA_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-cta';
	}

	public function get_title() {
		return esc_html__( 'Call to Action', 'starbelly-plugin' );
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
					'div' => __( 'DIV', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'title_style',
			[
				'label'       => esc_html__( 'Title Style', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => [
					'h1'  => __( 'H1', 'starbelly-plugin' ),
					'h2' => __( 'H2', 'starbelly-plugin' ),
					'h3' => __( 'H3', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'starbelly-plugin' ),
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Enter your description', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Type your description here', 'starbelly-plugin' ),
			]
		);

    $this->add_control(
			'app1',
			[
				'label'       => esc_html__( 'Google Play Link', 'starbelly-plugin' ),
        'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    $this->add_control(
			'app1_link',
			[
				'label'       => esc_html__( 'Link', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter URL', 'starbelly-plugin' ),
				'default'     => esc_html__( 'https://bslthemes.com/', 'starbelly-plugin' ),
        'condition' => [
					'app1' => 'yes',
				],
			]
		);

    $this->add_control(
			'app2',
			[
				'label'       => esc_html__( 'App Store Link', 'starbelly-plugin' ),
        'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    $this->add_control(
			'app2_link',
			[
				'label'       => esc_html__( 'Link', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter URL', 'starbelly-plugin' ),
				'default'     => esc_html__( 'https://bslthemes.com/', 'starbelly-plugin' ),
        'condition' => [
					'app2' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'image_tab',
			[
				'label' => esc_html__( 'Image', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'starbelly-plugin' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

    $this->add_control(
			'circle_1',
			[
				'label'       => esc_html__( 'Circle #1', 'starbelly-plugin' ),
        'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    $this->add_control(
			'circle_2',
			[
				'label'       => esc_html__( 'Circle #2', 'starbelly-plugin' ),
        'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    $this->add_control(
			'circle_3',
			[
				'label'       => esc_html__( 'Circle #3', 'starbelly-plugin' ),
        'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    $this->add_control(
			'circle_4',
			[
				'label'       => esc_html__( 'Circle #4', 'starbelly-plugin' ),
        'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    $this->add_control(
			'ill_1',
			[
				'label'       => esc_html__( 'Illustration #1', 'starbelly-plugin' ),
        'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    $this->add_control(
			'ill_2',
			[
				'label'       => esc_html__( 'Illustration #2', 'starbelly-plugin' ),
        'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    $this->add_control(
			'ill_3',
			[
				'label'       => esc_html__( 'Illustration #3', 'starbelly-plugin' ),
        'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_styling',
			[
				'label'     => esc_html__( 'Content Styles', 'starbelly-plugin' ),
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
					'{{WRAPPER}} .sb-call-to-action .sb-title--h' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-call-to-action .sb-title--h',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-call-to-action .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .sb-call-to-action .sb-text',
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
		$this->add_inline_editing_attributes( 'description', 'advanced' );

		?>

    <!-- call to action -->
    <section class="sb-call-to-action">
      <div class="sb-bg-3"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-6 align-self-center">
            <div class="sb-cta-text">
              <?php if ( $settings['title'] ) : ?>
              <<?php echo esc_attr( $settings['title_tag'] ); ?> class="sb-<?php echo esc_attr( $settings['title_style'] ); ?> sb-title--h sb-mb-30">
                <span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
                  <?php echo wp_kses_post( $settings['title'] ); ?>
                </span>
              </<?php echo esc_attr( $settings['title_tag'] ); ?>>
              <?php endif; ?>
              <?php if ( $settings['description'] ) : ?>
              <div class="sb-text sb-mb-30">
                <div <?php echo $this->get_render_attribute_string( 'description' ); ?>>
                  <?php echo wp_kses_post( $settings['description'] ); ?>
                </div>
              </div>
              <?php endif; ?>
              <?php if ( $settings['app1'] == 'yes' ) : ?>
              <a href="<?php echo esc_url( $settings['app1_link'] ); ?>" target="_blank" data-no-swup class="sb-download-btn">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/buttons/1.svg" alt="img" />
              </a>
              <?php endif; ?>
              <?php if ( $settings['app2'] == 'yes' ) : ?>
              <a href="<?php echo esc_url( $settings['app2_link'] ); ?>" target="_blank" data-no-swup class="sb-download-btn">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/buttons/2.svg" alt="img" />
              </a>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="sb-illustration-3">
              <?php if ( $settings['image'] ) : $image = wp_get_attachment_image_url( $settings['image']['id'], 'starbelly_1920xAuto' ); ?>
              <img src="<?php echo esc_url( $image ); ?>" alt="img" class="sb-phones">
              <?php endif; ?>
              <?php if ( $settings['circle_1'] == 'yes' ) : ?>
              <div class="sb-cirkle-1"></div>
              <?php endif; ?>
              <?php if ( $settings['circle_2'] == 'yes' ) : ?>
              <div class="sb-cirkle-2"></div>
              <?php endif; ?>
              <?php if ( $settings['circle_3'] == 'yes' ) : ?>
              <div class="sb-cirkle-3"></div>
              <?php endif; ?>
              <?php if ( $settings['circle_4'] == 'yes' ) : ?>
              <div class="sb-cirkle-4"></div>
              <?php endif; ?>
              <?php if ( $settings['ill_1'] == 'yes' ) : ?>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/illustrations/1.svg" alt="img" class="sb-pik-1" />
              <?php endif; ?>
              <?php if ( $settings['ill_2'] == 'yes' ) : ?>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/illustrations/2.svg" alt="img" class="sb-pik-2" />
              <?php endif; ?>
              <?php if ( $settings['ill_3'] == 'yes' ) : ?>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/illustrations/3.svg" alt="img" class="sb-pik-3" />
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- call to action end -->

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
		view.addInlineEditingAttributes( 'description', 'advanced' );
		#>

    <!-- call to action -->
    <section class="sb-call-to-action">
      <div class="sb-bg-3"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-6 align-self-center">
            <div class="sb-cta-text">
              <# if ( settings.title ) { #>
              <{{{ settings.title_tag }}} class="sb-{{{ settings.title_style }}} sb-title--h sb-mb-30">
                <span {{{ view.getRenderAttributeString( 'title' ) }}}>
                  {{{ settings.title }}}
                </span>
              </{{{ settings.title_tag }}}>
              <# } #>
              <# if ( settings.description ) { #>
              <div class="sb-text sb-mb-30">
                <div {{{ view.getRenderAttributeString( 'description' ) }}}>
                  {{{ settings.description }}}
                </div>
              </div>
              <# } #>
              <# if ( settings.app1 == 'yes' ) { #>
              <a href="{{{ settings.app1_link }}}" target="_blank" data-no-swup class="sb-download-btn">

              </a>
              <# } #>
              <# if ( settings.app2 == 'yes' ) { #>
              <a href="{{{ settings.app2_link }}}" target="_blank" data-no-swup class="sb-download-btn">

              </a>
              <# } #>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="sb-illustration-3">
              <# if ( settings.image ) { #>
              <img src="{{{ settings.image.url }}}" alt="img" class="sb-phones">
              <# } #>
              <# if ( settings.circle_1 == 'yes' ) { #>
              <div class="sb-cirkle-1"></div>
              <# } #>
              <# if ( settings.circle_2 == 'yes' ) { #>
              <div class="sb-cirkle-2"></div>
              <# } #>
              <# if ( settings.circle_3 == 'yes' ) { #>
              <div class="sb-cirkle-3"></div>
              <# } #>
              <# if ( settings.circle_4 == 'yes' ) { #>
              <div class="sb-cirkle-4"></div>
              <# } #>
              <# if ( settings.ill_1 == 'yes' ) { #>

              <# } #>
              <# if ( settings.ill_2 == 'yes' ) { #>

              <# } #>
              <# if ( settings.ill_3 == 'yes' ) { #>

              <# } #>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- call to action end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_CTA_Widget() );
