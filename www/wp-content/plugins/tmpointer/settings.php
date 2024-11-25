<?php
defined( 'ABSPATH' ) || exit;

class tmpointerSettings {
    /* The single instance of the class */
	protected static $_instance = null;

    /* Main Instance */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

    /* Constructor */
    public function __construct() {
        add_action( 'cmb2_admin_init', array($this, 'register_metabox') );
        add_action( 'admin_enqueue_scripts',array($this, 'colorpicker_labels'), 99 );
    }

    /**
    * Hook in and register a metabox to handle a plugin options page and adds a menu item.
    */
    public function register_metabox() {
        $panel_title = esc_html__('TM Pointer', 'tmpointer');

        // GENERAL SETTINGS
        $args = array(
            'id'           => 'tmpointer_options',
            'title'        => $panel_title,
            'object_types' => array( 'options-page' ),
            'option_key'   => 'tmpointer_options',
            'tab_group'    => 'tmpointer_options',
            'tab_title'    => esc_html__('General', 'tmpointer')
        );
        
        // 'tab_group' property is supported in > 2.4.0.
        if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
            $args['display_cb'] = array($this, 'display_with_tabs');
        }
        
        $main_options = new_cmb2_box( $args );

        $main_options->add_field(
            array(
                'name' => esc_html__( 'Sitewide Custom Cursor', 'tmpointer'),
                'id' => 'sitewide',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => 'enable',
            )
        );

        $main_options->add_field(
            array(
                'name' => esc_html__( 'Elementor Support', 'tmpointer'),
                'description'    => esc_html__( 'Elementor plugin must be installed and activated.', 'tmpointer'), 
                'id' => 'elementor',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => 'enable',
            )
        );

        $main_options->add_field(
            array(
                'name'    => esc_html__( 'Metabox', 'tmpointer'), 
                'description'    => esc_html__( 'Add metabox to selected post types to be able to enable/disable custom cursor individually.', 'tmpointer'), 
                'id'      => 'metabox',
                'type' => 'multicheck_inline',
                'select_all_button' => false,
                'options' => get_post_types(array('public' => true)),
                'default' => array('page')
            )
        );

        $main_options->add_field(
            array(
                'name' => esc_html__( 'Pointer Style', 'tmpointer'), 
                'id' => 'cursor_style',
                'type' => 'select',
                'options' => tm_get_pointer_styles(),
                'default' => 'simple',
            )
        );

        $main_options->add_field(
            array(
                'name' => esc_html__( 'Cursor Icon Class', 'tmpointer'),
                'description' => esc_html__( 'You can use any icon class which is included to your site by your theme or a third party plugin.', 'tmpointer'),
                'id' => 'icon_class',
                'type' => 'text',
                'attributes' => array(
                    'autocomplete' => 'off',
                    'data-conditional-id' => 'cursor_style',
                    'data-conditional-value' => 'tm-pointer-icon'
                ),
                'default' => 'fas fa-mouse-pointer',
            )
        );

        $main_options->add_field( array(
            'name'    => esc_html__( 'Cursor Image', 'tmpointer'),
            'desc'    => esc_html__( 'Upload an image or enter an URL.', 'tmpointer'),
            'id'      => 'image',
            'type'    => 'file',
            'query_args' => array(
                'type' => array(
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                ),
            ),
            'attributes' => array(
                'autocomplete' => 'off',
                'data-conditional-id' => 'cursor_style',
                'data-conditional-value' => 'tm-pointer-img'
            ),
            'preview_size' => 'medium',
            'default' => plugin_dir_url( __FILE__ ) . 'images/cursor.png'
        ) );

        $main_options->add_field(
            array(
                'name' => esc_html__( 'Highlight', 'tmpointer'), 
                'description'    => esc_html__( 'Highlight the selected elements on mouse hover.', 'tmpointer'), 
                'id' => 'highlight_element',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => 'disable',
            )
        );

        $main_options->add_field( array(
            'name' => esc_html__( 'Elements to Highlight', 'tmpointer' ),
            'description' => esc_html__( 'You can use HTML tag, id or class to target elements.', 'tmpointer' ),
            'id'   => 'highlight',
            'type' => 'text',
            'attributes' => array(
                'autocomplete' => 'off',
                'class' => 'tagify',
                'data-conditional-id' => 'highlight_element',
                'data-conditional-value' => 'enable'
            ),
            'default' => 'a'
        ) );

        $main_options->add_field(
            array(
                'name' => esc_html__( 'Click Animation', 'tmpointer'),
                'id' => 'click_anim',
                'type' => 'radio_inline',
                'options' => array(
                    'dark' => esc_html__( 'Dark', 'tmpointer' ),
                    'light'   => esc_html__( 'Light', 'tmpointer' ),
                    'none'   => esc_html__( 'None', 'tmpointer' )
                ),
                'default' => 'none',
            )
        );

        $main_options->add_field(
            array(
                'name' => esc_html__( 'Hide Mode', 'tmpointer'), 
                'description'    => esc_html__( 'Hide cursor if it does not move in the given period.', 'tmpointer'), 
                'id' => 'hide_mode',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => 'disable',
            )
        );

        $main_options->add_field( array(
            'name' => esc_html__( 'Hide Timing (ms)', 'tmpointer' ),
            'id'   => 'hide_timing',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'data-conditional-id' => 'hide_mode',
                'data-conditional-value' => 'enable'
            ),
            'default' => 3000
        ) );

        $main_options->add_field(
            array(
                'name' => esc_html__( 'Native Cursor', 'tmpointer'), 
                'description'    => esc_html__( 'Show/hide default browser cursor.', 'tmpointer'), 
                'id' => 'native',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => 'disable',
            )
        );

        $main_options->add_field( array(
            'name' => esc_html__( 'Visibility & Velocity', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'cursor-node-title'
        ) );

        $main_options->add_field(
            array(
                'name' => esc_html__( 'Cursor', 'tmpointer'), 
                'id' => 'cursor',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => 'enable',
            )
        );

        $main_options->add_field( array(
            'name' => esc_html__( 'Cursor Velocity', 'tmpointer' ),
            'id'   => 'cursor_velocity',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'step' => '0.1'
            ),
            'default' => 1
        ) );

        $main_options->add_field(
            array(
                'name' => esc_html__( 'Node', 'tmpointer'), 
                'id' => 'node',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => 'enable',
            )
        );

        $main_options->add_field( array(
            'name' => esc_html__( 'Node Velocity', 'tmpointer' ),
            'id'   => 'node_velocity',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'step' => '0.1'
            ),
            'default' => 0.1
        ) );
        
        // SETTINGS 1
        $args = array(
            'id'           => 'tmpointer_options_1',
            'title'        => $panel_title,
            'menu_title'   => esc_html__('Style', 'tmpointer'),
            'object_types' => array( 'options-page' ),
            'option_key'   => 'tmpointer_options_1',
            'parent_slug'  => 'tmpointer_options',
            'tab_group'    => 'tmpointer_options',
            'tab_title'    => esc_html__('Style', 'tmpointer'),
        );
        
        // 'tab_group' property is supported in > 2.4.0.
        if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
            $args['display_cb'] = array($this, 'display_with_tabs');
        }
        
        $options_1 = new_cmb2_box( $args );

        $options_1->add_field( array(
            'name' => esc_html__( 'Simple', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'tm-pointer-simple-title'
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Size (px)', 'tmpointer' ),
            'id'   => 'simple_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 32
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Border Color', 'tmpointer' ),
            'id'   => 'simple_border_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Background Color', 'tmpointer' ),
            'id'   => 'simple_bg_color',
            'type' => 'colorpicker',
            'default' => 'rgba(255,255,255,0.1)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Icon', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'tm-pointer-icon-title'
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Icon Size (px)', 'tmpointer' ),
            'id'   => 'icon_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 16
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Size (px)', 'tmpointer' ),
            'id'   => 'icon_node_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 32
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Icon Color', 'tmpointer' ),
            'id'   => 'icon_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Border Color', 'tmpointer' ),
            'id'   => 'icon_border_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Background Color', 'tmpointer' ),
            'id'   => 'icon_bg_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Border Color', 'tmpointer' ),
            'id'   => 'icon_h_border_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Bg Color', 'tmpointer' ),
            'id'   => 'icon_h_bg_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0.2)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Image', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'tm-pointer-img-title'
        ) );
        
        $options_1->add_field( array(
            'name' => esc_html__( 'Image Width (px)', 'tmpointer' ),
            'id'   => 'img_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 32
        ) );
        
        $options_1->add_field(
            array(
                'name' => esc_html__( 'Position', 'tmpointer'),
                'id' => 'img_position',
                'type' => 'select',
                'options' => array(
                    'translateY(0) translateX(0) translateZ(0)' => esc_html__( 'Middle', 'tmpointer' ),
                    'translateY(45%) translateX(0) translateZ(0)'   => esc_html__( 'Bottom Center', 'tmpointer' ),
                    'translateY(45%) translateX(50%) translateZ(0)'   => esc_html__( 'Bottom Right', 'tmpointer' ),
                    'translateY(45%) translateX(-50%) translateZ(0)'   => esc_html__( 'Bottom Left', 'tmpointer' )
                ),
                'default' => 'translateY(0) translateX(0) translateZ(0)',
            )
        );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Size (px)', 'tmpointer' ),
            'id'   => 'img_node_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 96
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Color', 'tmpointer' ),
            'id'   => 'img_node_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0.2)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Mix Blend', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'mix_subtitle'
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
            'id'   => 'mix_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 32
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Background Color', 'tmpointer' ),
            'id'   => 'mix_color',
            'type' => 'colorpicker',
            'default' => '#ffffff',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Pulse', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'tm-pointer-pulse-title'
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
            'id'   => 'pulse_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 20
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Background Color', 'tmpointer' ),
            'id'   => 'pulse_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Bg Color', 'tmpointer' ),
            'id'   => 'pulse_h_color',
            'type' => 'colorpicker',
            'default' => '#cc0000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field(
            array(
                'name' => esc_html__( 'Shadow', 'tmpointer'), 
                'id' => 'pulse_shadow',
                'type' => 'radio_inline',
                'options' => array(
                    'white' => esc_html__( 'Light', 'tmpointer' ),
                    'black'   => esc_html__( 'Dark', 'tmpointer' )
                ),
                'default' => 'black',
            )
        );

        $options_1->add_field( array(
            'name' => esc_html__( 'Pointer 1', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'tm-pointer-1-title'
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
            'id'   => 'p1_cursor_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 10
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Size (px)', 'tmpointer' ),
            'id'   => 'p1_node_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 30
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Color', 'tmpointer' ),
            'id'   => 'p1_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Background Color', 'tmpointer' ),
            'id'   => 'p1_bg_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Border Color', 'tmpointer' ),
            'id'   => 'p1_border_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Background Color', 'tmpointer' ),
            'id'   => 'p1_h_bg_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0.2)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Pointer 2', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'tm-pointer-2-title'
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
            'id'   => 'p2_cursor_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 18
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Size (px)', 'tmpointer' ),
            'id'   => 'p2_node_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 9
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Color', 'tmpointer' ),
            'id'   => 'p2_cursor_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Cursor Color', 'tmpointer' ),
            'id'   => 'p2_h_cursor_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0.2)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Color', 'tmpointer' ),
            'id'   => 'p2_node_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Node Color', 'tmpointer' ),
            'id'   => 'p2_h_node_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Pointer 3', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'tm-pointer-3-title'
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
            'id'   => 'p3_cursor_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 8
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Size (px)', 'tmpointer' ),
            'id'   => 'p3_node_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 32
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Color', 'tmpointer' ),
            'id'   => 'p3_cursor_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Cursor Color', 'tmpointer' ),
            'id'   => 'p3_h_cursor_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Color', 'tmpointer' ),
            'id'   => 'p3_node_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0.2)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Node Color', 'tmpointer' ),
            'id'   => 'p3_h_node_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0.2)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Pointer 4', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'tm-pointer-4-title'
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
            'id'   => 'p4_cursor_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 10
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Size (px)', 'tmpointer' ),
            'id'   => 'p4_node_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 20
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Color', 'tmpointer' ),
            'id'   => 'p4_cursor_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Border Color', 'tmpointer' ),
            'id'   => 'p4_border_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Border Color', 'tmpointer' ),
            'id'   => 'p4_h_border_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Background Color', 'tmpointer' ),
            'id'   => 'p4_bg_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Bg Color', 'tmpointer' ),
            'id'   => 'p4_h_bg_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0.2)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Pointer 5', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'tm-pointer-5-title'
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
            'id'   => 'p5_cursor_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 18
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Size (px)', 'tmpointer' ),
            'id'   => 'p5_node_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 9
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Color', 'tmpointer' ),
            'id'   => 'p5_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Cursor Color', 'tmpointer' ),
            'id'   => 'p5_h_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Color', 'tmpointer' ),
            'id'   => 'p5_bg_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Node Color', 'tmpointer' ),
            'id'   => 'p5_h_bg_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0.2)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Pointer 6', 'tmpointer' ),
            'type' => 'title',
            'id'   => 'tm-pointer-6-title'
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
            'id'   => 'p6_cursor_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 9
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Node Size (px)', 'tmpointer' ),
            'id'   => 'p6_node_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*'
            ),
            'default' => 36
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Cursor Color', 'tmpointer' ),
            'id'   => 'p6_cursor_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Border Color', 'tmpointer' ),
            'id'   => 'p6_border_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Border Color', 'tmpointer' ),
            'id'   => 'p6_h_border_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Background Color', 'tmpointer' ),
            'id'   => 'p6_bg_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

        $options_1->add_field( array(
            'name' => esc_html__( 'Highlight Bg Color', 'tmpointer' ),
            'id'   => 'p6_h_bg_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0.2)',
            'options' => array(
                'alpha' => true
            ),
            'attributes' => array(
                'autocomplete' => 'off'
            ),
        ) );

    }

    /**
    * Gets navigation tabs array for CMB2 options pages which share the given
    * display_cb param.
    *
    * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
    *
    * @return array Array of tab information.
    */
    public function page_tabs( $cmb_options ) {
        $tab_group = $cmb_options->cmb->prop( 'tab_group' );
        $tabs      = array();
        
        foreach ( CMB2_Boxes::get_all() as $cmb_id => $cmb ) {
            if ( $tab_group === $cmb->prop( 'tab_group' ) ) {
                $tabs[ $cmb->options_page_keys()[0] ] = $cmb->prop( 'tab_title' )
                    ? $cmb->prop( 'tab_title' )
                    : $cmb->prop( 'title' );
            }
        }
        
        return $tabs;
    }

    /**
    * A CMB2 options-page display callback override which adds tab navigation among
    * CMB2 options pages which share this same display callback.
    *
    * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
    */
    public function display_with_tabs( $cmb_options ) {
        $tabs = $this->page_tabs( $cmb_options );
        ?>
        <div class="wrap cmb2-options-page option-<?php echo esc_attr($cmb_options->option_key); ?>">
            <?php if ( get_admin_page_title() ) : ?>
                <h2><?php echo wp_kses_post( get_admin_page_title() ); ?></h2>
            <?php endif; ?>
            <h2 class="nav-tab-wrapper">
                <?php foreach ( $tabs as $option_key => $tab_title ) : ?>
                    <a class="nav-tab<?php if ( isset( $_GET['page'] ) && $option_key === $_GET['page'] ) : ?> nav-tab-active<?php endif; ?>" href="<?php menu_page_url( $option_key ); ?>"><?php echo wp_kses_post( $tab_title ); ?></a>
                <?php endforeach; ?>
            </h2>
            <form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="<?php echo esc_attr($cmb_options->cmb->cmb_id); ?>" enctype="multipart/form-data" encoding="multipart/form-data">
                <input type="hidden" name="action" value="<?php echo esc_attr( $cmb_options->option_key ); ?>">
                <?php $cmb_options->options_page_metabox(); ?>
                <?php submit_button( esc_attr( $cmb_options->cmb->prop( 'save_button' ) ), 'primary', 'submit-cmb' ); ?>
            </form>
        </div>
    <?php
    }

    /* Colorpicker Labels */
    public function colorpicker_labels( $hook ) {
        global $wp_version;
        if( version_compare( $wp_version, '5.4.2' , '>=' ) ) {
            wp_localize_script(
            'wp-color-picker',
            'wpColorPickerL10n',
            array(
                'clear'            => esc_html__( 'Clear', 'tmpointer' ),
                'clearAriaLabel'   => esc_html__( 'Clear color', 'tmpointer' ),
                'defaultString'    => esc_html__( 'Default', 'tmpointer' ),
                'defaultAriaLabel' => esc_html__( 'Select default color', 'tmpointer' ),
                'pick'             => esc_html__( 'Select Color', 'tmpointer' ),
                'defaultLabel'     => esc_html__( 'Color value', 'tmpointer' )
            )
            );
        }
    }

}

/**
 * Returns the main instance of tmpointer.
 */
function tmpointerSettings() {  
	return tmpointerSettings::instance();
}
// Global for backwards compatibility.
$GLOBALS['tmpointerSettings'] = tmpointerSettings();


/**
* Custom Get option
*/

function tmpointer_get_option( $tab = 'tmpointer_options', $key = '', $default = false ) {
	if ( function_exists( 'cmb2_get_option' ) ) {
		return cmb2_get_option( $tab, $key, $default );
	}
	$opts = get_option( $tab, $default );
	$val = $default;
	if ( 'all' == $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}
	return $val;
}