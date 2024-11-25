<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly About Us Widget.
 *
 * @since 1.0
 */
class Starbelly_About_Us_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-about-us';
	}

	public function get_title() {
		return esc_html__( 'About Us', 'starbelly-plugin' );
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
			'description',
			[
				'label'       => esc_html__( 'Description', 'starbelly-plugin' ),
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Enter your description', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Type your description here', 'starbelly-plugin' ),
			]
		);

    $this->add_control(
			'signature',
			[
				'label' => esc_html__( 'Signature', 'starbelly-plugin' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
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
			'years_num',
			[
				'label'       => esc_html__( 'Years (Num)', 'starbelly-plugin' ),
        'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter num', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Num', 'starbelly-plugin' ),
			]
		);

    $this->add_control(
			'years_label',
			[
				'label'       => esc_html__( 'Years (Label)', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter label', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Label', 'starbelly-plugin' ),
			]
		);

    $this->add_control(
			'image_square',
			[
				'label' => esc_html__( 'Image Square', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

    $this->add_control(
			'image_circles',
			[
				'label' => esc_html__( 'Image Circles', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'bg_tab',
			[
				'label' => esc_html__( 'Background', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'bg_type',
			[
				'label'       => esc_html__( 'Background Figures', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'rect',
				'options' => [
					'circle'  => __( 'Circle', 'starbelly-plugin' ),
					'rect' => __( 'Rect', 'starbelly-plugin' ),
					'none' => __( 'None', 'starbelly-plugin' ),
				],
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
					'{{WRAPPER}} .sb-about-text h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-about-text h2',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-about-text .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .sb-about-text .sb-text',
			]
		);

		$this->add_control(
			'years_num_color',
			[
				'label'     => esc_html__( 'Years Num Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-about-text .sb-illustration-2 .sb-experience .sb-exp-content .sb-h1' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Years Num Typography', 'starbelly-plugin' ),
				'name'     => 'years_num_typography',
				'selector' => '{{WRAPPER}} .sb-about-text .sb-illustration-2 .sb-experience .sb-exp-content .sb-h1',
			]
		);

    $this->add_control(
			'years_label_color',
			[
				'label'     => esc_html__( 'Years Label Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-about-text .sb-illustration-2 .sb-experience .sb-exp-content .sb-h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Years Label Typography', 'starbelly-plugin' ),
				'name'     => 'years_label_typography',
				'selector' => '{{WRAPPER}} .sb-about-text .sb-illustration-2 .sb-experience .sb-exp-content .sb-h3',
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
		$this->add_inline_editing_attributes( 'years_num', 'none' );
    $this->add_inline_editing_attributes( 'years_label', 'basic' );
		$this->add_inline_editing_attributes( 'description', 'advanced' );

		?>

    <!-- About text -->
    <section class="sb-about-text sb-p-90-0">
			<?php if ( $settings['bg_type'] == 'rect' ) : ?>
			<div class="sb-bg-1" style="margin-top: 90px">
        <div></div>
      </div>
			<?php endif; ?>
			<?php if ( $settings['bg_type'] == 'circle' ) : ?>
			<div class="sb-bg-2" style="margin-top: 90px">
				<div></div>
			</div>
			<?php endif; ?>

			<div class="container">
        <div class="row">
          <div class="col-lg-6 align-self-center">
            <div class="sb-illustration-2 sb-mb-90">
              <?php if ( $settings['image'] ) : $image = wp_get_attachment_image_url( $settings['image']['id'], 'starbelly_950xAuto' ); ?>
              <div class="sb-interior-frame">
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr__( 'image', 'starbelly-plugin' );?>" class="sb-interior" style="object-position: center">
              </div>
              <?php endif; ?>

              <?php if ( $settings['image_square'] == 'yes' ) : ?>
              <div class="sb-square"></div>
              <?php endif; ?>

              <?php if ( $settings['image_circles'] == 'yes' ) : ?>
              <div class="sb-cirkle-1"></div>
              <div class="sb-cirkle-2"></div>
              <div class="sb-cirkle-3"></div>
              <div class="sb-cirkle-4"></div>
              <?php endif; ?>

              <?php if ( $settings['years_num'] ) : ?>
              <div class="sb-experience">
                <div class="sb-exp-content">
                  <p class="sb-h1 sb-mb-10">
                    <span <?php echo $this->get_render_attribute_string( 'years_num' ); ?>>
              				<?php echo wp_kses_post( $settings['years_num'] ); ?>
              			</span>
                  </p>
                  <?php if ( $settings['years_label'] ) : ?>
                  <p class="sb-h3">
                    <span <?php echo $this->get_render_attribute_string( 'years_label' ); ?>>
              				<?php echo wp_kses_post( $settings['years_label'] ); ?>
              			</span>
                  </p>
                  <?php endif; ?>
                </div>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-lg-6 align-self-center sb-mb-60">
            <?php if ( $settings['title'] ) : ?>
            <h2 class="sb-mb-60">
              <span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
        				<?php echo wp_kses_post( $settings['title'] ); ?>
        			</span>
            </h2>
            <?php endif; ?>
            <?php if ( $settings['description'] ) : ?>
            <div class="sb-text sb-mb-30">
              <div <?php echo $this->get_render_attribute_string( 'description' ); ?>>
        			  <?php echo wp_kses_post( $settings['description'] ); ?>
        			</div>
            </div>
            <?php endif; ?>
            <?php if ( $settings['signature'] ) : $signature = wp_get_attachment_image_url( $settings['signature']['id'], 'starbelly_950xAuto' ); ?>
            <img src="<?php echo esc_url( $signature ); ?>" alt="<?php echo esc_attr__( 'image', 'starbelly-plugin' ); ?>" class="sb-signature sb-mb-30">
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
    <!-- About text end -->

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
		view.addInlineEditingAttributes( 'years_num', 'none' );
    view.addInlineEditingAttributes( 'years_label', 'basic' );
		view.addInlineEditingAttributes( 'description', 'advanced' );
		#>

    <!-- About text -->
    <section class="sb-about-text sb-p-90-0">
      <div class="sb-bg-1" style="margin-top: 90px">
        <div></div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-6 align-self-center">
            <div class="sb-illustration-2 sb-mb-90">
              <# if ( settings.image ) { #>
              <div class="sb-interior-frame">
                <img src="{{{ settings.image.url }}}" alt="image" class="sb-interior" style="object-position: center" />
              </div>
              <# } #>

              <# if ( settings.image_square == 'yes' ) { #>
              <div class="sb-square"></div>
              <# } #>

              <# if ( settings.image_circles == 'yes' ) { #>
              <div class="sb-cirkle-1"></div>
              <div class="sb-cirkle-2"></div>
              <div class="sb-cirkle-3"></div>
              <div class="sb-cirkle-4"></div>
              <# } #>

              <# if ( settings.years_num ) { #>
              <div class="sb-experience">
                <div class="sb-exp-content">
                  <p class="sb-h1 sb-mb-10">
                    <span {{{ view.getRenderAttributeString( 'years_num' ) }}}>
                      {{{ settings.years_num }}}
                    </span>
                  </p>
                  <# if ( settings.years_label ) { #>
                  <p class="sb-h3">
                    <span {{{ view.getRenderAttributeString( 'years_label' ) }}}>
                      {{{ settings.years_label }}}
                    </span>
                  </p>
                  <# } #>
                </div>
              </div>
              <# } #>
            </div>
          </div>
          <div class="col-lg-6 align-self-center sb-mb-60">
            <# if ( settings.title ) { #>
            <h2 class="sb-mb-60">
              <span {{{ view.getRenderAttributeString( 'title' ) }}}>
                {{{ settings.title }}}
              </span>
            </h2>
            <# } #>
            <# if ( settings.description ) { #>
            <div class="sb-text sb-mb-30">
              <div {{{ view.getRenderAttributeString( 'description' ) }}}>
        				{{{ settings.description }}}
        			</div>
            </div>
            <# } #>
            <# if ( settings.signature ) { #>
            <img src="{{{ settings.signature.url }}}" alt="image" class="sb-signature sb-mb-30" />
            <# } #>
          </div>
        </div>
      </div>
    </section>
    <!-- About text end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_About_Us_Widget() );
