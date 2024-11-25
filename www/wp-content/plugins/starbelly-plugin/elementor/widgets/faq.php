<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Starbelly Faq Widget.
 *
 * @since 1.0
 */

class Starbelly_Faq_Widget extends Widget_Base {

	public function get_name() {
		return 'starbelly-faq';
	}

	public function get_title() {
		return esc_html__( 'Faq', 'starbelly-plugin' );
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

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label'       => esc_html__( 'Title', 'starbelly-plugin' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title', 'starbelly-plugin' ),
				'default' => esc_html__( 'Enter title', 'starbelly-plugin' ),
			]
		);

		$repeater->add_control(
			'description', [
				'label'       => esc_html__( 'Description', 'starbelly-plugin' ),
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Enter text', 'starbelly-plugin' ),
				'default' => esc_html__( 'Enter text', 'starbelly-plugin' ),
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
			'items_styling',
			[
				'label' => esc_html__( 'Description', 'starbelly-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label' => esc_html__( 'Title Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-faq .sb-question h4' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'item_title_typography',
				'label' => esc_html__( 'Title Typography:', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-faq .sb-question h4',
			]
		);

		$this->add_control(
			'item_description_color',
			[
				'label' => esc_html__( 'Description Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-faq .sb-answer' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'item_description_typography',
				'label' => esc_html__( 'Description Typography:', 'starbelly-plugin' ),
				'selector' => '{{WRAPPER}} .sb-faq .sb-answer',
			]
		);

    $this->add_control(
			'item_icon_color',
			[
				'label' => esc_html__( 'Title Icon Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-faq .sb-plus-minus-toggle:after, {{WRAPPER}} .sb-faq .sb-plus-minus-toggle:before' => 'background-color: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'item_icon_bgcolor',
			[
				'label' => esc_html__( 'Title Icon BG Color', 'starbelly-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sb-faq .sb-plus-minus-toggle' => 'background-color: {{VALUE}};',
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

		?>

    <?php if ( $settings['items'] ) : ?>
    <ul class="sb-faq">
      <?php foreach ( $settings['items'] as $index => $item ) :
	    	$item_title = $this->get_repeater_setting_key( 'title', 'items', $index );
	    	$this->add_inline_editing_attributes( $item_title, 'basic' );

	    	$item_description = $this->get_repeater_setting_key( 'description', 'items', $index );
	    	$this->add_inline_editing_attributes( $item_description, 'advanced' );
	    ?>
      <li>
        <?php if ( $item['title'] ) : ?>
        <div class="sb-question">
          <h4>
            <span <?php echo $this->get_render_attribute_string( $item_title ); ?>>
  						<?php echo wp_kses_post( $item['title'] ); ?>
  					</span>
          </h4>
          <span class="sb-plus-minus-toggle sb-collapsed"></span>
        </div>
        <?php endif; ?>
        <?php if ( $item['description'] ) : ?>
        <div class="sb-answer sb-text">
          <div <?php echo $this->get_render_attribute_string( $item_description ); ?>>
						<?php echo wp_kses_post( $item['description'] ); ?>
					</div>
        </div>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>

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

    <# if ( settings.items ) { #>
    <ul class="sb-faq">
      <# _.each( settings.items, function( item, index ) {
				var item_title = view.getRepeaterSettingKey( 'title', 'items', index );
		    view.addInlineEditingAttributes( item_title, 'basic' );

		    var item_description = view.getRepeaterSettingKey( 'description', 'items', index );
		    view.addInlineEditingAttributes( item_description, 'advanced' );
		  #>
      <li>
        <# if ( item.title ) { #>
        <div class="sb-question">
          <h4>
            <span {{{ view.getRenderAttributeString( item_title ) }}}>
  						{{{ item.title }}}
  					</span>
          </h4>
          <span class="sb-plus-minus-toggle sb-collapsed"></span>
        </div>
        <# } #>
        <# if ( item.description ) { #>
        <div class="sb-answer sb-text">
          <div {{{ view.getRenderAttributeString( item_description ) }}}>
						{{{ item.description }}}
					</div>
        </div>
        <# } #>
      </li>
      <# }); #>
    </ul>
    <# } #>

	<?php }
}

Plugin::instance()->widgets_manager->register( new Starbelly_Faq_Widget() );
