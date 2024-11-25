<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Hero Banner Widget.
 *
 * @since 1.0
 */
class Starbelly_Hero_Banner_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-hero-banner';
	}

	public function get_title() {
		return esc_html__( 'Hero Banner', 'starbelly-plugin' );
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
			'image_tab',
			[
				'label' => esc_html__( 'Image', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'type',
			[
				'label'       => esc_html__( 'Layout', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'layout-1',
				'options' => [
					'layout-1'  => __( 'Layout 1', 'starbelly-plugin' ),
					'layout-2' => __( 'Layout 2', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label'       => esc_html__( 'Image', 'starbelly-plugin' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'image2_1',
			[
				'label'       => esc_html__( 'Image #1', 'starbelly-plugin' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'type' => 'layout-2',
 				],
			]
		);

		$this->add_control(
			'image2_2',
			[
				'label'       => esc_html__( 'Image #2', 'starbelly-plugin' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'type' => 'layout-2',
 				],
			]
		);

		$this->add_control(
			'image2_3',
			[
				'label'       => esc_html__( 'Image #3', 'starbelly-plugin' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'type' => 'layout-2',
 				],
			]
		);

		$this->add_control(
			'dialogs',
			[
				'label'       => esc_html__( 'Dialogs', 'starbelly-plugin' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'type' => 'layout-2',
 				],
			]
		);

		$this->add_control(
			'dialog_smile',
			[
				'label'       => esc_html__( 'Smile #1', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter smile', 'starbelly-plugin' ),
				'default'     => esc_html__( ':)', 'starbelly-plugin' ),
				'condition' => [
					'type' => 'layout-2',
 				],
			]
		);

		$this->add_control(
			'dialog_title1',
			[
				'label'       => esc_html__( 'Title #1', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Title', 'starbelly-plugin' ),
				'condition' => [
					'type' => 'layout-2',
 				],
			]
		);

		$this->add_control(
			'dialog_smile2',
			[
				'label'       => esc_html__( 'Smile #2', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Title', 'starbelly-plugin' ),
				'condition' => [
					'type' => 'layout-2',
 				],
			]
		);

		$this->add_control(
			'dialog_title2',
			[
				'label'       => esc_html__( 'Title #2', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Title', 'starbelly-plugin' ),
				'condition' => [
					'type' => 'layout-2',
 				],
			]
		);

    	$this->add_control(
			'image_icons',
			[
				'label' => esc_html__( 'Image Icons', 'starbelly-plugin' ),
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
			'content_styling',
			[
				'label'     => esc_html__( 'Content', 'starbelly-plugin' ),
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
					'{{WRAPPER}} .sb-banner .sb-el-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-banner .sb-el-title',
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

		$this->add_control(
			'dialogs_color',
			[
				'label'     => esc_html__( 'Dialogs Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-illustration-1-2 .sb-illu-dialog-1, {{WRAPPER}} .sb-illustration-1-2 .sb-illu-dialog-2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'dialogs_typography',
				'label'     => esc_html__( 'Dialogs Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-illustration-1-2 .sb-illu-dialog-1, {{WRAPPER}} .sb-illustration-1-2 .sb-illu-dialog-2',
			]
		);

		$this->add_control(
			'dialogs_bgcolor',
			[
				'label'     => esc_html__( 'Dialogs BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-illustration-1-2 .sb-illu-dialog-1, {{WRAPPER}} .sb-illustration-1-2 .sb-illu-dialog-2' => 'background-color: {{VALUE}};',
				],
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

		$this->add_inline_editing_attributes( 'subtitle', 'basic' );
		$this->add_inline_editing_attributes( 'title', 'basic' );
		$this->add_inline_editing_attributes( 'description', 'basic' );

		?>

    <!-- banner -->
    <section class="sb-banner">
			<?php if ( $settings['bg_type'] == 'rect' ) : ?>
			<div class="sb-bg-1">
        <div></div>
      </div>
			<?php endif; ?>
			<?php if ( $settings['bg_type'] == 'circle' ) : ?>
			<div class="sb-bg-2">
				<div></div>
			</div>
			<?php endif; ?>

      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <!-- main title -->
            <div class="sb-main-title-frame">
              <div class="sb-main-title">
                <?php if ( $settings['subtitle'] ) : ?>
                <span class="sb-suptitle sb-mb-30">
                  <span <?php echo $this->get_render_attribute_string( 'subtitle' ); ?>>
                      <?php echo wp_kses_post( $settings['subtitle'] ); ?>
                  </span>
                </span>
                <?php endif; ?>
                <?php if ( $settings['title'] ) : ?>
                <<?php echo esc_attr( $settings['title_tag'] ); ?> class="sb-mb-30 sb-el-title">
                  <span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
                      <?php echo wp_kses_post( $settings['title'] ); ?>
                  </span>
                </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                <?php endif; ?>
                <?php if ( $settings['description'] ) : ?>
                <p class="sb-text sb-text-lg sb-mb-30">
                  <span <?php echo $this->get_render_attribute_string( 'description' ); ?>>
                      <?php echo wp_kses_post( $settings['description'] ); ?>
                  </span>
                </p>
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
            <!-- main title end -->
          </div>
          <div class="col-lg-6">
						<?php if ( $settings['type'] == 'layout-1' ) : ?>
						<?php if ( $settings['image'] ) : $image = wp_get_attachment_image_url( $settings['image']['id'], 'starbelly_1920xAuto' ); ?>
            <div class="sb-illustration-1">
              <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr__( 'image', 'starbelly' ); ?>" class="sb-girl" />

              <?php if ( $settings['image_circles'] == 'yes' ) : ?>
              <div class="sb-cirkle-1"></div>
              <div class="sb-cirkle-2"></div>
              <div class="sb-cirkle-3"></div>
              <div class="sb-cirkle-4"></div>
              <div class="sb-cirkle-5"></div>
              <?php endif; ?>

              <?php if ( $settings['image_icons'] == 'yes' ) : ?>
              <img src="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/img/illustrations/3.svg" alt="<?php echo esc_attr( 'icon', 'starbelly' ); ?>" class="sb-pik-1" />
              <img src="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/img/illustrations/1.svg" alt="<?php echo esc_attr( 'icon', 'starbelly' ); ?>" class="sb-pik-2" />
              <img src="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/img/illustrations/2.svg" alt="<?php echo esc_attr( 'icon', 'starbelly' ); ?>" class="sb-pik-3" />
              <?php endif; ?>
            </div>
            <?php endif; ?>
						<?php endif; ?>
						<?php if ( $settings['type'] == 'layout-2' ) : ?>
						<div class="sb-ilustration-fix">
							<div class="sb-illustration-1-2">
								<?php if ( $settings['image2_1'] ) : $image = wp_get_attachment_image_url( $settings['image2_1']['id'], 'starbelly_950xAuto' ); ?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr__( 'image', 'starbelly' ); ?>" class="sb-food-1" />
								<?php endif; ?>
								<?php if ( $settings['image2_2'] ) : $image = wp_get_attachment_image_url( $settings['image2_2']['id'], 'starbelly_950xAuto' ); ?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr__( 'image', 'starbelly' ); ?>" class="sb-food-2" />
								<?php endif; ?>
								<?php if ( $settings['image2_3'] ) : $image = wp_get_attachment_image_url( $settings['image2_3']['id'], 'starbelly_950xAuto' ); ?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr__( 'image', 'starbelly' ); ?>" class="sb-food-3" />
								<?php endif; ?>

								<?php if ( $settings['dialogs'] == 'yes' ) : ?>
								<?php if ( $settings['dialog_title1'] ) : ?>
								<div class="sb-illu-dialog-1">
									<?php if ( $settings['dialog_smile'] ) : ?>
									<span class="smile">
										<span <?php echo $this->get_render_attribute_string( 'dialog_smile' ); ?>>
	                    <?php echo wp_kses_post( $settings['dialog_smile'] ); ?>
	                  </span>
									</span>
									<?php endif; ?>
									<span <?php echo $this->get_render_attribute_string( 'dialog_title1' ); ?>>
                    <?php echo wp_kses_post( $settings['dialog_title1'] ); ?>
                  </span>
								</div>
								<?php endif; ?>
								<?php if ( $settings['dialog_title2'] ) : ?>
								<div class="sb-illu-dialog-2">
									<?php if ( $settings['dialog_smile2'] ) : ?>
									<span class="smile">
										<span <?php echo $this->get_render_attribute_string( 'dialog_smile2' ); ?>>
	                    <?php echo wp_kses_post( $settings['dialog_smile2'] ); ?>
	                  </span>
									</span>
									<?php endif; ?>
									<span <?php echo $this->get_render_attribute_string( 'dialog_title2' ); ?>>
                    <?php echo wp_kses_post( $settings['dialog_title2'] ); ?>
                  </span>
								</div>
								<?php endif; ?>
								<?php endif; ?>

								<?php if ( $settings['image_circles'] == 'yes' ) : ?>
								<div class="sb-cirkle-1"></div>
								<div class="sb-cirkle-2"></div>
								<div class="sb-cirkle-3"></div>
								<div class="sb-cirkle-4"></div>
								<div class="sb-cirkle-5"></div>
								<?php endif; ?>

								<?php if ( $settings['image_icons'] == 'yes' ) : ?>
								<img src="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/img/illustrations/3.svg" alt="<?php echo esc_attr( 'icon', 'starbelly' ); ?>" class="sb-pik-1">
								<img src="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/img/illustrations/1.svg" alt="<?php echo esc_attr( 'icon', 'starbelly' ); ?>" class="sb-pik-2">
								<img src="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/img/illustrations/2.svg" alt="<?php echo esc_attr( 'icon', 'starbelly' ); ?>" class="sb-pik-3">
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
          </div>
        </div>
      </div>
    </section>
    <!-- banner end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Hero_Banner_Widget() );
