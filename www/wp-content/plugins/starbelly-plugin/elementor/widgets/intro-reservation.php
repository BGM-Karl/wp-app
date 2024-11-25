<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Reservation Form Widget.
 *
 * @since 1.0
 */

class Starbelly_Intro_Reservation_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-intro-reservation';
	}

	public function get_title() {
		return esc_html__( 'Reservation Intro', 'starbelly-plugin' );
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
				'label' => esc_html__( 'Title', 'starbelly-plugin' ),
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
			'description',
			[
				'label'       => esc_html__( 'Description', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter description', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Description', 'starbelly-plugin' ),
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
			'image_tab',
			[
				'label' => esc_html__( 'Image', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

    $this->add_control(
			'image_show',
			[
				'label' => esc_html__( 'Image Show', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
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
        'condition' => [
          'image_show' => 'yes',
        ],
			]
		);

		$this->add_control(
			'image2_show',
			[
				'label' => esc_html__( 'Image #2 Show', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    $this->add_control(
			'image2',
			[
				'label' => esc_html__( 'Image #2', 'starbelly-plugin' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
        'condition' => [
          'image2_show' => 'yes',
        ],
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
			'form_tab',
			[
				'label' => esc_html__( 'Form', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

    $this->add_control(
			'form_title',
			[
				'label'       => esc_html__( 'Form Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default'     => esc_html__( 'Title', 'starbelly-plugin' ),
			]
		);

		$this->add_control(
			'reservation_type',
			[
				'label'       => esc_html__( 'Reservation Type', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default' => 'cf7',
				'options' => [
					'cf7'  => __( 'Contact Form 7', 'starbelly-plugin' ),
					'opentable' => __( 'OpenTable Form', 'starbelly-plugin' ),
				],
			]
		);

		$this->add_control(
			'reservation_form',
			[
				'label' => esc_html__( 'Select CF7 Form', 'starbelly-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT,
				'default' => 1,
				'options' => $this->contact_form_list(),
				'condition' => [
					'reservation_type' => 'cf7',
				],
			]
		);

		$this->add_control(
			'opentable_id',
			[
				'label' => esc_html__( 'OpenTable ID', 'starbelly-plugin' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter OpenTable ID', 'starbelly-plugin' ),
				'default' => '412810',
				'condition' => [
					'reservation_type' => 'opentable',
				],
			]
		);

		$this->add_control(
			'opentable_lang',
			[
				'label'       => esc_html__( 'OpenTable Language', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default' => 'en-US',
				'options' => [
					'en-US'  => __( 'English-US', 'starbelly-plugin' ),
					'fr-CA' => __( 'Français-CA', 'starbelly-plugin' ),
					'de-DE' => __( 'Deutsch-DE', 'starbelly-plugin' ),
					'es-MX' => __( 'Español-MX', 'starbelly-plugin' ),
					'ja-JP' => __( '日本語-JP', 'starbelly-plugin' ),
					'nl-NL' => __( 'Nederlands-NL', 'starbelly-plugin' ),
					'it-IT' => __( 'Italiano-IT', 'starbelly-plugin' ),
				],
				'condition' => [
					'reservation_type' => 'opentable',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'heading_styling',
			[
				'label'     => esc_html__( 'Heading', 'starbelly-plugin' ),
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
					'{{WRAPPER}} .sb-main-title .sb-suptitle' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .sb-main-title .sb-suptitle' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'label'     => esc_html__( 'Subtitle Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-main-title .sb-suptitle',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-main-title .sb-title-el' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-main-title .sb-title-el',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-main-title .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-main-title .sb-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'form_styling',
			[
				'label'     => esc_html__( 'Form', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_control(
			'form_bg_color',
			[
				'label'     => esc_html__( 'Form Background Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-contact-form-frame' => 'background-color: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'form_border_color',
			[
				'label'     => esc_html__( 'Form Border Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-contact-form-frame .sb-form-content' => 'border-color: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'form_title_color',
			[
				'label'     => esc_html__( 'Form Title Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-form-content h3' => 'color: {{VALUE}};',
				],
			]
		);

    $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'form_title_typography',
				'label'     => esc_html__( 'Form Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-form-content h3',
			]
		);

    $this->add_control(
			'form_input_color',
			[
				'label'     => esc_html__( 'Form Input Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-group-input input, .sb-group-input textarea, .sb-group-input select' => 'color: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'form_input_bgcolor',
			[
				'label'     => esc_html__( 'Form Input BG Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-group-input input, .sb-group-input textarea, .sb-group-input select' => 'background-color: {{VALUE}};',
				],
			]
		);

    $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'form_input_typography',
				'label'     => esc_html__( 'Form Input Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-group-input input, .sb-group-input textarea, .sb-group-input select',
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Button Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-form-content .sb-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Button Background Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-form-content .sb-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'     => esc_html__( 'Button Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-form-content .sb-btn',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Contact Form List.
	 *
	 * @since 1.0
	 */
	protected function contact_form_list() {
		$cf7_posts = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );

		$cf7_forms = array();

		if ( $cf7_posts ) {
			foreach ( $cf7_posts as $cf7_form ) {
				$cf7_forms[ $cf7_form->ID ] = $cf7_form->post_title;
			}
		} else {
			$cf7_forms[ esc_html__( 'No contact forms found', 'starbelly-plugin' ) ] = 0;
		}

		return $cf7_forms;
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

    $page_id = get_queried_object_id();

		$this->add_inline_editing_attributes( 'title', 'basic' );
		$this->add_inline_editing_attributes( 'subtitle', 'basic' );
		$this->add_inline_editing_attributes( 'description', 'basic' );
    $this->add_inline_editing_attributes( 'form_title', 'basic' );

		?>

    <!-- banner -->
    <section class="sb-banner sb-banner-color">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7">
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
                <<?php echo esc_attr( $settings['title_tag'] ); ?> class="sb-title-el sb-mb-30">
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
                <?php if ( $settings['breadcrumbs'] == 'yes' ) : ?>
                <?php starbelly_breadcrumbs( $page_id ); ?>
                <?php endif; ?>
              </div>
            </div>
            <!-- main title end -->
          </div>
          <div class="col-lg-5">
            <div class="sb-contact-form-frame">
              <div class="sb-illustration-9">
                <?php if ( $settings['image_show'] == 'yes' ) : ?>
                <?php if ( $settings['image'] ) : $image = wp_get_attachment_image_url( $settings['image']['id'], 'starbelly_950xAuto' ); ?>
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $settings['subtitle'] ); ?>" class="sb-envelope-1" />
                <?php endif; ?>
                <?php endif; ?>
								<?php if ( $settings['image2_show'] == 'yes' ) : ?>
                <?php if ( $settings['image2'] ) : $image = wp_get_attachment_image_url( $settings['image2']['id'], 'starbelly_950xAuto' ); ?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $settings['subtitle'] ); ?>" class="sb-envelope-2" />
								<?php endif; ?>
								<?php endif; ?>
                <?php if ( $settings['image_circles'] == 'yes' ) : ?>
                <div class="sb-cirkle-1"></div>
                <div class="sb-cirkle-2"></div>
                <div class="sb-cirkle-3"></div>
                <?php endif; ?>
              </div>
              <div class="sb-form-content">
                <div class="sb-main-content">
                  <?php if ( $settings['form_title'] ) : ?>
                  <h3 class="sb-mb-30">
                    <span <?php echo $this->get_render_attribute_string( 'form_title' ); ?>>
                      <?php echo wp_kses_post( $settings['form_title'] ); ?>
                    </span>
                  </h3>
                  <?php endif; ?>
                  <?php if ( $settings['reservation_type'] == 'cf7' ) : ?>
    	          	  <?php if ( $settings['reservation_form'] ) : ?>
    	                	<?php echo do_shortcode( '[contact-form-7 id="'. $settings['reservation_form'] .'"]' ); ?>
    	              <?php endif; ?>
      	          <?php else : ?>
                    <?php if ( $settings['opentable_id'] ) : ?>
                    <form method="get" class="sb-opentable-form" action="//www.opentable.com/restaurant-search.aspx" target="_blank">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="sb-group-input">
                            <select id="reservation_party" name="partySize">
              								<option value="1">1 <?php echo esc_html__( 'Person', 'starbelly-plugin' ); ?></option>
              								<option value="2" selected="selected">2 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="3">3 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="4">4 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="5">5 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="6">6 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="7">7 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="8">8 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="9">9 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="10">10 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="11">11 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="12">12 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="13">13 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="14">14 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="15">15 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="16">16 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="17">17 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="18">18 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="19">19 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="20">20 <?php echo esc_html__( 'People', 'starbelly-plugin' ); ?></option>
              								<option value="21"><?php echo esc_html__( 'Larger party', 'starbelly-plugin' ); ?></option>
              							</select>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="sb-group-input">
                            <div class="datepicker__container">
            						      <input id="reservation_date" name="startDate" class="datepicker-here" type="text" value="" placeholder="<?php echo esc_attr__( 'Date', 'starbelly-plugin' ); ?>" autocomplete="off" readonly="readonly">
            						    </div>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="sb-group-input">
                            <select id="reservation_time" name="ResTime">
              								<?php
              								//Time Loop
              								$inc = 30 * 60;
              								$start = ( strtotime( '8AM' ) ); // 6  AM
              								$end = ( strtotime( '11:59PM' ) ); // 10 PM


              								for ( $i = $start; $i <= $end; $i += $inc ) {
              									// to the standart format
              									$time      = date( 'g:i a', $i );
              									$timeValue = date( 'g:ia', $i );
              									$default   = "7:00pm";
              									echo "<option value=\"$timeValue\" " . ( ( $timeValue == $default ) ? ' selected="selected" ' : "" ) . ">$time</option>" . PHP_EOL;
              								}

              								?>
              							</select>
                          </div>
                        </div>
                      </div>
                      <!-- button -->
                      <button class="sb-btn sb-cf-submit sb-show-success" type="submit">
                        <span class="sb-icon">
                          <span class="sb-icon-arrow"></span>
                        </span>
                        <span><?php echo esc_attr( 'Reserve', 'starbelly-plugin' ); ?></span>
                      </button>
                      <!-- button end -->
                      <p class="sb-powered"><?php echo wp_kses_post( '* Powered by <img src="' . home_url() . '/wp-content/themes/starbelly/assets/images/opentable.svg" alt="" />', 'starbelly-plugin' ); ?></p>

                      <input type="hidden" name="RestaurantID" class="RestaurantID" value="<?php echo esc_attr( $settings['opentable_id'] ); ?>">
          						<input type="hidden" name="rid" class="rid" value="<?php echo esc_attr( $settings['opentable_id'] ); ?>">
          						<input type="hidden" name="GeoID" class="GeoID" value="15">
          						<input type="hidden" name="txtDateFormat" class="txtDateFormat" value="MM/dd/yyyy">
          						<input type="hidden" name="RestaurantReferralID" class="RestaurantReferralID" value="<?php echo esc_attr( $settings['opentable_id'] ); ?>">
          						<input type="hidden" name="lang" class="lang" value="<?php echo esc_attr( $settings['opentable_lang'] ); ?>">
                    </form>
                    <?php else : ?>
                    <p class="d-center"><?php echo esc_html__( 'You haven\'t added OpenTable ID', 'starbelly-plugin' ); ?></p>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- banner end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Intro_Reservation_Widget() );
