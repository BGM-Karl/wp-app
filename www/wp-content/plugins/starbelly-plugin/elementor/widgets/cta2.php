<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Call to Action 2 Widget.
 *
 * @since 1.0
 */
class Starbelly_CTA2_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-cta2';
	}

	public function get_title() {
		return esc_html__( 'Call to Action 2', 'starbelly-plugin' );
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

		$this->end_controls_section();

		$this->start_controls_section(
			'buttons_tab',
			[
				'label' => esc_html__( 'Buttons', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

    	$repeater = new \Elementor\Repeater();

    	$repeater->add_control(
			'label', [
				'label' => esc_html__( 'Label', 'starbelly-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Label', 'starbelly-plugin' ),
				'default' => esc_html__( 'Label', 'starbelly-plugin' ),
			]
		);

		$repeater->add_control(
			'link', [
				'label' => esc_html__( 'Link', 'starbelly-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::URL,
				'show_external' => true,
			]
		);

    	$repeater->add_control(
			'icon', [
				'label' => esc_html__( 'Icon', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    	$repeater->add_control(
			'icon_el', [
				'label' => esc_html__( 'Icon Element', 'starbelly-plugin' ),
				'type' => Controls_Manager::SELECT,
        		'default' => 'file',
				'options' => [
					'file'  => __( 'File', 'starbelly-plugin' ),
					'fa' => __( 'Font Awesome', 'starbelly-plugin' ),
				],
				'condition' => [
				'icon'  => 'yes',
				],
			]
		);

    	$repeater->add_control(
			'icon_fa', [
				'label' => esc_html__( 'Font Awesome Icon', 'starbelly-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::ICONS,
				'condition' => [
					'icon'  => 'yes',
					'icon_el' => 'fa',
				],
			]
		);

    	$repeater->add_control(
			'icon_file', [
        		'label'       => esc_html__( 'Icon File', 'starbelly-plugin' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon'  => 'yes',
					'icon_el' => 'file',
				],
			]
		);

		$repeater->add_control(
			'transparent', [
				'label' => esc_html__( 'Transparent', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    	$repeater->add_control(
			'second', [
				'label' => esc_html__( 'Second Style', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    	$this->add_control(
			'buttons',
			[
				'label' => esc_html__( 'Buttons', 'starbelly-plugin' ),
				'type' => Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
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
			'image_style',
			[
				'label'       => esc_html__( 'Image Style', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'reserved',
				'options' => [
					'reserved'  => __( 'Reserved', 'starbelly-plugin' ),
					'burger' => __( 'Burger', 'starbelly-plugin' ),
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
			'circle_5',
			[
				'label'       => esc_html__( 'Circle #5', 'starbelly-plugin' ),
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

		$this->start_controls_section(
			'button_styling',
			[
				'label'     => esc_html__( 'Button', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button1_color',
			[
				'label'     => esc_html__( 'Button 1 Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-banner .sb-btn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sb-banner .sb-btn .sb-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button1_bgcolor',
			[
				'label'     => esc_html__( 'Button 1 BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-banner .sb-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button2_color',
			[
				'label'     => esc_html__( 'Button 2 Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-banner .sb-btn.sb-btn-gray' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sb-banner .sb-btn.sb-btn-gray .sb-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

    	$this->add_control(
			'button2_bgcolor',
			[
				'label'     => esc_html__( 'Button 2 BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-banner .sb-btn.sb-btn-gray' => 'background-color: {{VALUE}};',
				],
			]
		);

    	$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'     => esc_html__( 'Button Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-banner .sb-btn',
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
							<<?php echo esc_attr( $settings['title_tag'] ); ?> class="sb-<?php echo esc_attr( $settings['title_style'] ); ?> sb-title--h sb-mb-15">
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

							<?php
							if ( $settings['buttons'] ) :
								foreach ( $settings['buttons'] as $index => $button ) :
									$button_label = $this->get_repeater_setting_key( 'label', 'buttons', $index );
									$this->add_inline_editing_attributes( $button_label, 'none' );
							?>
							<!-- button -->
							<a <?php if ( $button['link'] ) : ?><?php if ( $button['link']['is_external'] ) : ?> target="_blank"<?php endif; ?><?php if ( $button['link']['nofollow'] ) : ?> rel="nofollow"<?php endif; ?> href="<?php echo esc_url( $button['link']['url'] ); ?>"<?php endif; ?> class="sb-btn<?php if ( $button['transparent'] == 'yes' ) : ?> sb-btn-2<?php endif; ?><?php if ( $button['second'] == 'yes' ) : ?> sb-btn-gray<?php endif; ?>">
								<?php if ( $button['icon'] == 'yes' ) : ?>
								<span class="sb-icon">
									<?php if ( $button['icon_el'] == 'fa' ) : ?>
										<?php \Elementor\Icons_Manager::render_icon( $button['icon_fa'], [ 'aria-hidden' => 'true' ] ); ?>
									<?php else : ?>
										<img src="<?php echo esc_url( $button['icon_file']['url'] ); ?>" alt="<?php echo esc_attr__( 'icon', 'starbelly' ); ?>" />
									<?php endif; ?>
								</span>
								<?php endif; ?>
								<span <?php echo $this->get_render_attribute_string( $button_label ); ?>>
									<?php echo wp_kses_post( $button['label'] ); ?>
								</span>
							</a>
							<!-- button end -->
							<?php
								endforeach;
							endif;
							?>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="sb-illustration-<?php if ( $settings['image_style'] == 'reserved' ) : ?>8<?php else : ?>6<?php endif; ?>">
							<?php if ( $settings['image'] ) : $image = wp_get_attachment_image_url( $settings['image']['id'], 'starbelly_1920xAuto' ); ?>
							<img src="<?php echo esc_url( $image ); ?>" alt="img" class="sb-<?php echo esc_attr( $settings['image_style'] ); ?>">
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
							<?php if ( $settings['circle_5'] == 'yes' ) : ?>
							<div class="sb-cirkle-5"></div>
							<?php endif; ?>

							<?php if ( $settings['ill_1'] == 'yes' ) : ?>
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/illustrations/2.svg" alt="icon" class="sb-pik-2">
							<?php endif; ?>
							<?php if ( $settings['ill_2'] == 'yes' ) : ?>
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/illustrations/3.svg" alt="icon" class="sb-pik-3">
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- call to action end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_CTA2_Widget() );
