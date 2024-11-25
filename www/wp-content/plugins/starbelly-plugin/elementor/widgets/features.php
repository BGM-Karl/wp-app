<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Features Widget.
 *
 * @since 1.0
 */
class Starbelly_Features_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-features';
	}

	public function get_title() {
		return esc_html__( 'Features', 'starbelly-plugin' );
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
					'h4' => __( 'H4', 'starbelly-plugin' ),
					'div' => __( 'DIV', 'starbelly-plugin' ),
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

    $this->add_control(
			'image_label',
			[
				'label' => esc_html__( 'Image Label', 'starbelly-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'starbelly-plugin' ),
				'label_off' => __( 'No', 'starbelly-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

    $this->add_control(
			'image_label_num',
			[
				'label'       => esc_html__( 'Label (num)', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter num', 'starbelly-plugin' ),
        'condition' => [
          'image_label'  => 'yes',
        ],
			]
		);

    $this->add_control(
			'image_label_text',
			[
				'label'       => esc_html__( 'Label (text)', 'starbelly-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter text', 'starbelly-plugin' ),
        'condition' => [
          'image_label'  => 'yes',
        ],
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
			'num', [
				'label'       => esc_html__( 'Num', 'oblo-plugin' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter num', 'oblo-plugin' ),
				'default' => esc_html__( '01', 'oblo-plugin' ),
			]
		);

    $repeater->add_control(
			'title', [
				'label'       => esc_html__( 'Title', 'oblo-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title', 'oblo-plugin' ),
				'default' => esc_html__( 'Title', 'oblo-plugin' ),
			]
		);

    $repeater->add_control(
			'desc', [
				'label'       => esc_html__( 'Description', 'oblo-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter description', 'oblo-plugin' ),
				'default' => esc_html__( 'Description', 'oblo-plugin' ),
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
					'{{WRAPPER}} .row .sb-el-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .row .sb-el-title',
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
			'items_styling',
			[
				'label'     => esc_html__( 'Items Styles', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_control(
			'item_num_color',
			[
				'label'     => esc_html__( 'Num Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-features-item .sb-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-features-item h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'label'     => esc_html__( 'Title Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-features-item h3',
			]
		);

    $this->add_control(
			'item_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-features-item .sb-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'label'     => esc_html__( 'Description Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-features-item .sb-text',
			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
			'image_styling',
			[
				'label'     => esc_html__( 'Image Styles', 'starbelly-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_control(
			'image_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'starbelly-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .sb-illustration-2 .sb-experience .sb-exp-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'image_label_typography',
				'label'     => esc_html__( 'Label Typography', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-illustration-2 .sb-experience .sb-exp-content .sb-h3',
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
		$this->add_inline_editing_attributes( 'image_label_num', 'none' );
    $this->add_inline_editing_attributes( 'image_label_text', 'none' );

		?>

    <!-- features -->
    <section class="sb-p-60-0">
      <div class="container">
        <div class="row flex-md-row-reverse">
          <div class="col-lg-6 align-self-center sb-mb-30">
            <?php if ( $settings['title'] ) : ?>
            <<?php echo esc_attr( $settings['title_tag'] ); ?> class="sb-el-title sb-mb-60">
              <span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
        			  <?php echo wp_kses_post( $settings['title'] ); ?>
        			</span>
            </<?php echo esc_attr( $settings['title_tag'] ); ?>>
            <?php endif; ?>
            <?php if ( $settings['items'] ) : ?>
            <ul class="sb-features">
              <?php foreach ( $settings['items'] as $index => $item ) :
          		  $item_num = $this->get_repeater_setting_key( 'num', 'items', $index );
          		  $this->add_inline_editing_attributes( $item_num, 'none' );

          		  $item_title = $this->get_repeater_setting_key( 'title', 'items', $index );
          		  $this->add_inline_editing_attributes( $item_title, 'basic' );

          		  $item_desc = $this->get_repeater_setting_key( 'desc', 'items', $index );
          		  $this->add_inline_editing_attributes( $item_desc, 'basic' );
        		  ?>
              <li class="sb-features-item sb-mb-60">
                <?php if ( $item['num'] ) : ?>
                <div class="sb-number">
                  <span <?php echo $this->get_render_attribute_string( $item_num ); ?>>
      	        		<?php echo wp_kses_post( $item['num'] ); ?>
      	        	</span>
                </div>
                <?php endif; ?>
                <?php if ( $item['title'] || $item['desc'] ) : ?>
                <div class="sb-feature-text">
                  <?php if ( $item['title'] ) : ?>
                  <h3 class="sb-mb-15">
                    <span <?php echo $this->get_render_attribute_string( $item_title ); ?>>
        	        		<?php echo wp_kses_post( $item['title'] ); ?>
        	        	</span>
                  </h3>
                  <?php endif; ?>
                  <?php if ( $item['desc'] ) : ?>
                  <p class="sb-text">
                    <span <?php echo $this->get_render_attribute_string( $item_desc ); ?>>
        	        		<?php echo wp_kses_post( $item['desc'] ); ?>
        	        	</span>
                  </p>
                  <?php endif; ?>
                </div>
                <?php endif; ?>
              </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
          </div>
          <div class="col-lg-6 align-self-center">
            <div class="sb-illustration-2 sb-mb-90">
              <?php if ( $settings['image'] ) : $image = wp_get_attachment_image_url( $settings['image']['id'], 'starbelly_1920xAuto' ); ?>
              <div class="sb-interior-frame">
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr__( 'image', 'starbelly' ); ?>" class="sb-interior" />
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

              <?php if ( $settings['image_label'] == 'yes' ) : ?>
              <div class="sb-experience">
                <div class="sb-exp-content">
                  <?php if ( $settings['image_label_num'] ) : ?>
                  <p class="sb-h1 sb-mb-10">
                    <span <?php echo $this->get_render_attribute_string( 'image_label_num' ); ?>>
              			  <?php echo wp_kses_post( $settings['image_label_num'] ); ?>
              			</span>
                  </p>
                  <?php endif; ?>
                  <?php if ( $settings['image_label_text'] ) : ?>
                  <p class="sb-h3">
                    <span <?php echo $this->get_render_attribute_string( 'image_label_text' ); ?>>
              			  <?php echo wp_kses_post( $settings['image_label_text'] ); ?>
              			</span>
                  </p>
                  <?php endif; ?>
                </div>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- features end -->

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
		view.addInlineEditingAttributes( 'image_label_num', 'none' );
    view.addInlineEditingAttributes( 'image_label_text', 'none' );
		#>

    <!-- features -->
    <section class="sb-p-60-0">
      <div class="container">
        <div class="row flex-md-row-reverse">
          <div class="col-lg-6 align-self-center sb-mb-30">
            <# if ( settings.title ) { #>
            <{{{ settings.title_tag }}} class="sb-el-title sb-mb-60">
              <span {{{ view.getRenderAttributeString( 'title' ) }}}>
                 {{{ settings.title }}}
              </span>
            </{{{ settings.title_tag }}}>
            <# } #>
            <# if ( settings.items ) { #>
            <ul class="sb-features">
              <# _.each( settings.items, function( item, index ) {
              var item_num = view.getRepeaterSettingKey( 'num', 'items', index );
          		view.addInlineEditingAttributes( item_num, 'none' );

        			var item_title = view.getRepeaterSettingKey( 'title', 'items', index );
        			view.addInlineEditingAttributes( item_title, 'basic' );

        			var item_desc = view.getRepeaterSettingKey( 'desc', 'items', index );
        			view.addInlineEditingAttributes( item_desc, 'basic' );
        		  #>
              <li class="sb-features-item sb-mb-60">
                <# if ( item.num ) { #>
                <div class="sb-number">
                  <span {{{ view.getRenderAttributeString( item_num ) }}}>
                    {{{ item.num }}}
                  </span>
                </div>
                <# } #>
                <# if ( item.title || item.desc ) { #>
                <div class="sb-feature-text">
                  <# if ( item.title ) { #>
                  <h3 class="sb-mb-15">
                    <span {{{ view.getRenderAttributeString( item_title ) }}}>
            					{{{ item.title }}}
            				</span>
                  </h3>
                  <# } #>
                  <# if ( item.desc ) { #>
                  <p class="sb-text">
                    <span {{{ view.getRenderAttributeString( item_desc ) }}}>
            					{{{ item.desc }}}
            				</span>
                  </p>
                  <# } #>
                </div>
                <# } #>
              </li>
              <# }); #>
            </ul>
            <# } #>
          </div>
          <div class="col-lg-6 align-self-center">
            <div class="sb-illustration-2 sb-mb-90">
              <# if ( settings.image ) { #>
              <div class="sb-interior-frame">
                <img src="{{{ settings.image.url }}}" alt="" class="sb-interior" />
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

              <# if ( settings.image_label == 'yes' ) { #>
              <div class="sb-experience">
                <div class="sb-exp-content">
                  <# if ( settings.image_label_num ) { #>
                  <p class="sb-h1 sb-mb-10">
                    <span {{{ view.getRenderAttributeString( 'image_label_num' ) }}}>
            	         {{{ settings.image_label_num }}}
            	      </span>
                  </p>
                  <# } #>
                  <# if ( settings.image_label_text ) { #>
                  <p class="sb-h3">
                    <span {{{ view.getRenderAttributeString( 'image_label_text' ) }}}>
            	         {{{ settings.image_label_text }}}
            	      </span>
                  </p>
                  <# } #>
                </div>
              </div>
              <# } #>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- features end -->

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Starbelly_Features_Widget() );
