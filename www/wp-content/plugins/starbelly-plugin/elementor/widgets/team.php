<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Team Widget.
 *
 * @since 1.0
 */

class Starbelly_Team_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-team';
	}

	public function get_title() {
		return esc_html__( 'Team', 'starbelly-plugin' );
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
			'name', [
				'label'       => esc_html__( 'Name', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter name', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Name', 'starbelly-plugin' ),
			]
		);

		$repeater->add_control(
			'role', [
				'label'       => esc_html__( 'Role', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter role', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Role', 'starbelly-plugin' ),
			]
		);

		$repeater->add_control(
			'social',
			[
				'label' => esc_html__( 'Social', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$repeater->add_control(
			'social1',
			[
				'label' => esc_html__( 'Social Link #1', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'social1_icon',
			[
				'label'       => esc_html__( 'Icon', 'starbelly-plugin' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'condition' => [
					'social1' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social1_title', [
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Title', 'starbelly-plugin' ),
				'condition' => [
					'social1' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social1_link', [
				'label'       => esc_html__( 'URL', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter URL', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'https://bslthemes.com/', 'starbelly-plugin' ),
				'condition' => [
					'social1' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social2',
			[
				'label' => esc_html__( 'Social Link #2', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'social2_icon',
			[
				'label'       => esc_html__( 'Icon', 'starbelly-plugin' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'condition' => [
					'social2' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social2_title', [
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Title', 'starbelly-plugin' ),
				'condition' => [
					'social2' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social2_link', [
				'label'       => esc_html__( 'URL', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter URL', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'https://bslthemes.com/', 'starbelly-plugin' ),
				'condition' => [
					'social2' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social3',
			[
				'label' => esc_html__( 'Social Link #3', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'social3_icon',
			[
				'label'       => esc_html__( 'Icon', 'starbelly-plugin' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'condition' => [
					'social3' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social3_title', [
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Title', 'starbelly-plugin' ),
				'condition' => [
					'social3' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social3_link', [
				'label'       => esc_html__( 'URL', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter URL', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'https://bslthemes.com/', 'starbelly-plugin' ),
				'condition' => [
					'social3' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social4',
			[
				'label' => esc_html__( 'Social Link #4', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'social4_icon',
			[
				'label'       => esc_html__( 'Icon', 'starbelly-plugin' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'condition' => [
					'social4' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social4_title', [
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Title', 'starbelly-plugin' ),
				'condition' => [
					'social4' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social4_link', [
				'label'       => esc_html__( 'URL', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter URL', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'https://bslthemes.com/', 'starbelly-plugin' ),
				'condition' => [
					'social4' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social5',
			[
				'label' => esc_html__( 'Social Link #5', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'social5_icon',
			[
				'label'       => esc_html__( 'Icon', 'starbelly-plugin' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'condition' => [
					'social5' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social5_title', [
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Title', 'starbelly-plugin' ),
				'condition' => [
					'social5' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social5_link', [
				'label'       => esc_html__( 'URL', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter URL', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'https://bslthemes.com/', 'starbelly-plugin' ),
				'condition' => [
					'social5' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social6',
			[
				'label' => esc_html__( 'Social Link #6', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'starbelly-plugin' ),
				'label_off' => __( 'Hide', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'social6_icon',
			[
				'label'       => esc_html__( 'Icon', 'starbelly-plugin' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'condition' => [
					'social6' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social6_title', [
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'Title', 'starbelly-plugin' ),
				'condition' => [
					'social6' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'social6_link', [
				'label'       => esc_html__( 'URL', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter URL', 'starbelly-plugin' ),
				'default'	=> esc_html__( 'https://bslthemes.com/', 'starbelly-plugin' ),
				'condition' => [
					'social6' => 'yes',
				],
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'starbelly-plugin' ),
				'type' => Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
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
			'items_per_row',
			[
				'label'       => esc_html__( 'Items per Row', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'3'  => __( '3 Items', 'starbelly-plugin' ),
					'4' => __( '4 Items', 'starbelly-plugin' ),
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
			'item_name_color',
			[
				'label'     => esc_html__( 'Name Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-team-member h4' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_name_typography',
				'label'     => esc_html__( 'Name Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-team-member h4',
			]
		);

		$this->add_control(
			'item_role_color',
			[
				'label'     => esc_html__( 'Role Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-team-member .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_role_typography',
				'label'     => esc_html__( 'Role Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-team-member .sb-text',
			]
		);

		$this->add_control(
			'item_social_color',
			[
				'label'     => esc_html__( 'Social Link Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-team-member .sb-social li a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sb-team-member .sb-social li a svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_social_hover_color',
			[
				'label'     => esc_html__( 'Social Hover Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-team-member .sb-social li a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sb-team-member .sb-social li a:hover svg' => 'fill: {{VALUE}};',
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

		<!-- team -->
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
					  $item_name = $this->get_repeater_setting_key( 'name', 'items', $index );
					  $this->add_inline_editing_attributes( $item_name, 'basic' );

					  $item_role = $this->get_repeater_setting_key( 'role', 'items', $index );
					  $this->add_inline_editing_attributes( $item_role, 'basic' );
				  ?>
					<div class="<?php if ( $settings['items_per_row'] == '3' ) : ?>col-lg-4<?php else : ?>col-lg-3<?php endif; ?>">
						<div class="sb-team-member sb-mb-30">
							<?php if ( $item['image'] ) : $image = wp_get_attachment_image_url( $item['image']['id'], 'starbelly_950xAuto' ); ?>
							<div class="sb-photo-frame sb-mb-15">
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>">
							</div>
							<?php endif; ?>
							<div class="sb-member-description">
								<?php if ( $item['name'] ) : ?>
								<h4 class="sb-mb-10">
									<span <?php echo $this->get_render_attribute_string( $item_name ); ?>>
										<?php echo wp_kses_post( $item['name'] ); ?>
									</span>
								</h4>
								<?php endif; ?>
								<?php if ( $item['role'] ) : ?>
								<p class="sb-text sb-text-sm sb-mb-10">
									<span <?php echo $this->get_render_attribute_string( $item_role ); ?>>
										<?php echo wp_kses_post( $item['role'] ); ?>
									</span>
								</p>
								<?php endif; ?>
								<?php if ( $item['social'] == 'yes' ) : ?>
								<ul class="sb-social">
									<?php if ( $item['social1'] == 'yes' ) : ?>
									<li>
										<a href="<?php echo esc_url( $item['social1_link'] ); ?>" target="_blank" title="<?php echo esc_attr( $item['social1_title'] ); ?>">
											<?php \Elementor\Icons_Manager::render_icon( $item['social1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</a>
									</li>
									<?php endif; ?>
									<?php if ( $item['social2'] == 'yes' ) : ?>
									<li>
										<a href="<?php echo esc_url( $item['social2_link'] ); ?>" target="_blank" title="<?php echo esc_attr( $item['social2_title'] ); ?>">
											<?php \Elementor\Icons_Manager::render_icon( $item['social2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</a>
									</li>
									<?php endif; ?>
									<?php if ( $item['social3'] == 'yes' ) : ?>
									<li>
										<a href="<?php echo esc_url( $item['social3_link'] ); ?>" target="_blank" title="<?php echo esc_attr( $item['social3_title'] ); ?>">
											<?php \Elementor\Icons_Manager::render_icon( $item['social3_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</a>
									</li>
									<?php endif; ?>
									<?php if ( $item['social4'] == 'yes' ) : ?>
									<li>
										<a href="<?php echo esc_url( $item['social4_link'] ); ?>" target="_blank" title="<?php echo esc_attr( $item['social4_title'] ); ?>">
											<?php \Elementor\Icons_Manager::render_icon( $item['social4_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</a>
									</li>
									<?php endif; ?>
									<?php if ( $item['social5'] == 'yes' ) : ?>
									<li>
										<a href="<?php echo esc_url( $item['social5_link'] ); ?>" target="_blank" title="<?php echo esc_attr( $item['social5_title'] ); ?>">
											<?php \Elementor\Icons_Manager::render_icon( $item['social5_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</a>
									</li>
									<?php endif; ?>
									<?php if ( $item['social6'] == 'yes' ) : ?>
									<li>
										<a href="<?php echo esc_url( $item['social6_link'] ); ?>" target="_blank" title="<?php echo esc_attr( $item['social6_title'] ); ?>">
											<?php \Elementor\Icons_Manager::render_icon( $item['social6_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</a>
									</li>
									<?php endif; ?>
								</ul>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</section>
		<!-- team end -->

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
	protected function content_template() { ?>

		<#
		view.addInlineEditingAttributes( 'title', 'basic' );
		view.addInlineEditingAttributes( 'description', 'basic' );
		view.addInlineEditingAttributes( 'button', 'none' );
		#>

		<!-- team -->
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
					var item_name = view.getRepeaterSettingKey( 'name', 'items', index );
					view.addInlineEditingAttributes( item_name, 'basic' );

					var item_role = view.getRepeaterSettingKey( 'role', 'items', index );
					view.addInlineEditingAttributes( item_role, 'basic' );
				  #>
					<div class="<# if ( settings.items_per_row == '3' ) { #>col-lg-4<# } else { #>col-lg-3<# } #>">
						<div class="sb-team-member sb-mb-30">
							<# if ( item.image ) { #>
							<div class="sb-photo-frame sb-mb-15">
								<img src="{{{ item.image.url }}}" alt="{{{ item.name }}}" />
							</div>
							<# } #>
							<div class="sb-member-description">
								<# if ( item.name ) { #>
								<h4 class="sb-mb-10">
									<span {{{ view.getRenderAttributeString( item_name ) }}}>
										{{{ item.name }}}
									</span>
								</h4>
								<# } #>
								<# if ( item.role ) { #>
								<p class="sb-text sb-text-sm sb-mb-10">
									<span {{{ view.getRenderAttributeString( item_role ) }}}>
										{{{ item.role }}}
									</span>
								</p>
								<# } #>
								<# if ( item.social == 'yes' ) { #>
								<ul class="sb-social">
									<# if ( item.social1 == 'yes' ) { var iconHTML = elementor.helpers.renderIcon( view, item.social1_icon, { 'aria-hidden': true }, 'i' , 'object' ); #>
									<li>
										<a href="{{{ item.social1_link }}}" target="_blank" title="{{{ item.social1_title }}}">
											{{{ iconHTML.value }}}
										</a>
									</li>
									<# } #>
									<# if ( item.social2 == 'yes' ) { var iconHTML = elementor.helpers.renderIcon( view, item.social2_icon, { 'aria-hidden': true }, 'i' , 'object' ); #>
									<li>
										<a href="{{{ item.social2_link }}}" target="_blank" title="{{{ item.social2_title }}}">
											{{{ iconHTML.value }}}
										</a>
									</li>
									<# } #>
									<# if ( item.social3 == 'yes' ) { var iconHTML = elementor.helpers.renderIcon( view, item.social3_icon, { 'aria-hidden': true }, 'i' , 'object' ); #>
									<li>
										<a href="{{{ item.social3_link }}}" target="_blank" title="{{{ item.social3_title }}}">
											{{{ iconHTML.value }}}
										</a>
									</li>
									<# } #>
									<# if ( item.social4 == 'yes' ) { var iconHTML = elementor.helpers.renderIcon( view, item.social4_icon, { 'aria-hidden': true }, 'i' , 'object' ); #>
									<li>
										<a href="{{{ item.social4_link }}}" target="_blank" title="{{{ item.social4_title }}}">
											{{{ iconHTML.value }}}
										</a>
									</li>
									<# } #>
									<# if ( item.social5 == 'yes' ) { var iconHTML = elementor.helpers.renderIcon( view, item.social5_icon, { 'aria-hidden': true }, 'i' , 'object' ); #>
									<li>
										<a href="{{{ item.social5_link }}}" target="_blank" title="{{{ item.social5_title }}}">
											{{{ iconHTML.value }}}
										</a>
									</li>
									<# } #>
									<# if ( item.social6 == 'yes' ) { var iconHTML = elementor.helpers.renderIcon( view, item.social6_icon, { 'aria-hidden': true }, 'i' , 'object' ); #>
									<li>
										<a href="{{{ item.social6_link }}}" target="_blank" title="{{{ item.social6_title }}}">
											{{{ iconHTML.value }}}
										</a>
									</li>
									<# } #>

								</ul>
								<# } #>
							</div>
						</div>
					</div>
					<# }); #>
				</div>
				<# } #>
			</div>
		</section>
		<!-- team end -->

	<?php }
}

Plugin::instance()->widgets_manager->register( new Starbelly_Team_Widget() );
