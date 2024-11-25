<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Promo Video Widget.
 *
 * @since 1.0
 */
class Starbelly_Promo_Video_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-promo-video';
	}

	public function get_title() {
		return esc_html__( 'Promo Video', 'starbelly-plugin' );
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
			'description',
			[
				'label'       => esc_html__( 'Description', 'starbelly-plugin' ),
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Enter your description', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Type your description here', 'starbelly-plugin' ),
			]
		);

    $this->end_controls_section();

    $this->start_controls_section(
			'image_tab',
			[
				'label' => esc_html__( 'Image & Video', 'starbelly-plugin' ),
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
			'yt_video',
			[
				'label'       => esc_html__( 'Youtube Video (URL)', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'https://www.youtube.com/watch?v=F3zw1Gvn4Mk', 'starbelly-plugin' ),
				'default'     => esc_html__( 'https://www.youtube.com/watch?v=F3zw1Gvn4Mk', 'starbelly-plugin' ),
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
			'btn_tab',
			[
				'label' => esc_html__( 'Button', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button',
			[
				'label'       => esc_html__( 'Button', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter button', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Button', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter URL', 'starbelly-plugin' ),
				'default'     => '',
			]
		);

		$this->add_control(
			'button_yt',
			[
				'label' => esc_html__( 'Open Video Popup?', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
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
					'{{WRAPPER}} .sb-video h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-video h2',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-video .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .sb-video .sb-text',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-video .sb-suptitle' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sb-video .sb-suptitle' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Subtitle Typography', 'starbelly-plugin' ),
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .sb-video .sb-suptitle',
			]
		);

    $this->add_control(
			'btn_color',
			[
				'label'     => esc_html__( 'Button Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-video .sb-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_bgcolor',
			[
				'label'     => esc_html__( 'Button BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-video .sb-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Button Typography', 'starbelly-plugin' ),
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .sb-video .sb-btn',
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
		$this->add_inline_editing_attributes( 'subtitle', 'none' );
		$this->add_inline_editing_attributes( 'description', 'advanced' );
		$this->add_inline_editing_attributes( 'button', 'none' );

		?>

		<!-- video -->
		<section class="sb-video">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<div class="sb-mb-90">
							<?php if ( $settings['subtitle'] ) : ?>
							<span class="sb-suptitle sb-mb-15">
								<span <?php echo $this->get_render_attribute_string( 'subtitle' ); ?>>
	        				<?php echo wp_kses_post( $settings['subtitle'] ); ?>
	        			</span>
							</span>
							<?php endif; ?>
							<?php if ( $settings['title'] ) : ?>
							<h2 class="sb-mb-30">
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
							<?php if ( $settings['button'] ) :
								$link = $settings['link'];
								if ( $settings['button_yt'] == 'yes' ) {
									$link = $settings['yt_video'];
								}
							?>
							<!-- button -->
							<a data-magnific-video data-no-swup href="<?php echo esc_url( $link ); ?>" class="sb-btn">
								<span class="sb-icon">
									<span class="sb-icon-play"></span>
								</span>
								<span <?php echo $this->get_render_attribute_string( 'button' ); ?>>
	        				<?php echo wp_kses_post( $settings['button'] ); ?>
	        			</span>
							</a>
							<!-- button end -->
							<?php endif; ?>
						</div>
					</div>
					<div class="col-lg-6 align-self-center">
						<div class="sb-illustration-7 sb-mb-90">
							<div class="sb-interior-frame">
								<?php if ( $settings['image'] ) : $image = wp_get_attachment_image_url( $settings['image']['id'], 'starbelly_950xAuto' ); ?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $settings['subtitle'] ); ?>" class="sb-interior" />
								<?php endif; ?>
								<?php if ( $settings['yt_video'] ) : ?>
								<a data-magnific-video data-no-swup href="<?php echo esc_url( $settings['yt_video'] ); ?>" class="sb-video-play"><i class="fas fa-play"></i></a>
								<?php endif; ?>
							</div>

							<?php if ( $settings['image_circles'] == 'yes' ) : ?>
							<div class="sb-cirkle-1"></div>
							<div class="sb-cirkle-2"></div>
							<div class="sb-cirkle-3"></div>
							<div class="sb-cirkle-4"></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- video end -->

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
		view.addInlineEditingAttributes( 'subtitle', 'none' );
    view.addInlineEditingAttributes( 'button', 'none' );
		view.addInlineEditingAttributes( 'description', 'advanced' );
		#>

		<!-- video -->
		<section class="sb-video">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<div class="sb-mb-90">
							<# if ( settings.subtitle ) { #>
							<span class="sb-suptitle sb-mb-15">
								<span {{{ view.getRenderAttributeString( 'subtitle' ) }}}>
	                {{{ settings.subtitle }}}
	              </span>
							</span>
							<# } #>
							<# if ( settings.title ) { #>
							<h2 class="sb-mb-30">
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
							<# if ( settings.button ) {
									var link = settings.link;
									if ( settings.button_yt == 'yes' ) {
										link = settings.yt_video;
									}
							#>
							<!-- button -->
							<a data-fancybox="" data-no-swup href="{{{ link }}}" class="sb-btn">
								<span class="sb-icon">
									<span class="sb-icon-play"></span>
								</span>
								<span {{{ view.getRenderAttributeString( 'button' ) }}}>
	                {{{ settings.button }}}
	              </span>
							</a>
							<!-- button end -->
							<# } #>
						</div>
					</div>
					<div class="col-lg-6 align-self-center">
						<div class="sb-illustration-7 sb-mb-90">
							<div class="sb-interior-frame">
								<# if ( settings.image ) { #>
								<img src="{{{ settings.image.url }}}" alt="{{{ settings.subtitle }}}" class="sb-interior" />
								<# } #>
								<# if ( settings.yt_video ) { #>
								<a data-fancybox="" data-no-swup href="{{{ settings.yt_video }}}" class="sb-video-play"><i class="fas fa-play"></i></a>
								<# } #>
							</div>

							<# if ( settings.image_circles == 'yes' ) { #>
							<div class="sb-cirkle-1"></div>
							<div class="sb-cirkle-2"></div>
							<div class="sb-cirkle-3"></div>
							<div class="sb-cirkle-4"></div>
							<# } #>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- video end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Promo_Video_Widget() );
