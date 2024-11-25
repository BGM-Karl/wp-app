<?php
defined( 'ABSPATH' ) || exit;

class tmpointer {
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
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_filter('cmb2_admin_init', array($this, 'register_meta_boxes'));
    }

    /* Register Metaboxes */
    public function register_meta_boxes( $meta_boxes ) {
        $prefix = 'tmpointer_cmb2_'; // Prefix for all fields
        $metabox = tmpointer_get_option('tmpointer_options','metabox',array('page'));

        // Get default values
        $sitewide = tmpointer_get_option('tmpointer_options','sitewide','disable');
        $cursor_style = tmpointer_get_option('tmpointer_options','cursor_style','simple');
        $click_anim = tmpointer_get_option('tmpointer_options','click_anim','none');
        $highlight_element = tmpointer_get_option('tmpointer_options','highlight_element','disable');
        $hide_mode = tmpointer_get_option('tmpointer_options','hide_mode','disable');
        $icon_class = tmpointer_get_option('tmpointer_options','icon_class','fas fa-mouse-pointer');
        $image = tmpointer_get_option('tmpointer_options','image',plugin_dir_url( __FILE__ ) . 'images/cursor.png');
        $native = tmpointer_get_option('tmpointer_options','native','disable');
        $hide_timing = tmpointer_get_option('tmpointer_options','hide_timing',3000);
        $highlight = tmpointer_get_option('tmpointer_options','highlight','');
        $cursor = tmpointer_get_option('tmpointer_options','cursor','enable');
        $cursor_velocity = tmpointer_get_option('tmpointer_options','cursor_velocity',1);
        $node = tmpointer_get_option('tmpointer_options','node','enable');
        $node_velocity = tmpointer_get_option('tmpointer_options','node_velocity',0.1);
        $img_size = tmpointer_get_option('tmpointer_options_1','img_size',32);
        $img_position = tmpointer_get_option('tmpointer_options','img_position','translateY(0) translateX(0) translateZ(0)');
        $icon_size = tmpointer_get_option('tmpointer_options_1','icon_size',16);

        /* Form Fields Metabox */
        $fields_metabox = new_cmb2_box( 
            array(
                'id' => $prefix . 'metabox',
                'title' => esc_html__( 'TM Pointer', 'tmpointer'),
                'object_types' => $metabox,
                'context' => 'side',
                'priority' => 'high',
                'show_names' => true, // Show field names on the left
            ) 
        );

        /* Fields */
        $fields_metabox->add_field(
            array(
                'name' => esc_html__( 'Custom Cursor', 'tmpointer'),
                'id' => $prefix . 'activation',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => $sitewide
            )
        );

        $fields_metabox->add_field(
            array(
                'name' => esc_html__( 'Pointer Style', 'tmpointer'), 
                'id' => $prefix . 'cursor_style',
                'type' => 'select',
                'options' => tm_get_pointer_styles(),
                'default' => $cursor_style
            )
        );

        $fields_metabox->add_field(
            array(
                'name' => esc_html__( 'Cursor Icon Class', 'tmpointer'),
                'id' => $prefix . 'icon_class',
                'type' => 'text',
                'attributes' => array(
                    'autocomplete' => 'off',
                    'data-conditional-id' => $prefix . 'cursor_style',
                    'data-conditional-value' => 'tm-pointer-icon'
                ),
                'default' => $icon_class
            )
        );

        $fields_metabox->add_field( array(
            'name' => esc_html__( 'Icon Size (px)', 'tmpointer' ),
            'id'   => $prefix . 'icon_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'data-conditional-id' => $prefix . 'cursor_style',
                'data-conditional-value' => 'tm-pointer-icon'
            ),
            'default' => $icon_size
        ) );

        $fields_metabox->add_field( array(
            'name'    => esc_html__( 'Cursor Image', 'tmpointer'),
            'id'      => $prefix . 'image',
            'type'    => 'file',
            'query_args' => array(
                'type' => array(
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                ),
            ),
            'options' => array(
                'url' => false,
            ),
            'attributes' => array(
                'autocomplete' => 'off',
                'data-conditional-id' => $prefix . 'cursor_style',
                'data-conditional-value' => 'tm-pointer-img'
            ),
            'preview_size' => false,
            'default' => $image
        ) );

        $fields_metabox->add_field( array(
            'name' => esc_html__( 'Image Width (px)', 'tmpointer' ),
            'id'   => $prefix . 'img_size',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'data-conditional-id' => $prefix . 'cursor_style',
                'data-conditional-value' => 'tm-pointer-img'
            ),
            'default' => $img_size
        ) );

        $fields_metabox->add_field(
            array(
                'name' => esc_html__( 'Position', 'tmpointer'),
                'id' => $prefix . 'img_position',
                'attributes' => array(
                    'data-conditional-id' => $prefix . 'cursor_style',
                    'data-conditional-value' => 'tm-pointer-img'
                ),
                'type' => 'select',
                'options' => array(
                    'translateY(0) translateX(0) translateZ(0)' => esc_html__( 'Middle', 'tmpointer' ),
                    'translateY(45%) translateX(0) translateZ(0)'   => esc_html__( 'Bottom Center', 'tmpointer' ),
                    'translateY(45%) translateX(50%) translateZ(0)'   => esc_html__( 'Bottom Right', 'tmpointer' ),
                    'translateY(45%) translateX(-50%) translateZ(0)'   => esc_html__( 'Bottom Left', 'tmpointer' )
                ),
                'default' => $img_position
            )
        );

        $fields_metabox->add_field(
            array(
                'name' => esc_html__( 'Highlight', 'tmpointer'),
                'id' => $prefix . 'highlight_element',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => $highlight_element
            )
        );

        $fields_metabox->add_field( array(
            'name' => esc_html__( 'Elements to Highlight', 'tmpointer' ),
            'id'   => $prefix . 'highlight',
            'type' => 'text',
            'attributes' => array(
                'autocomplete' => 'off',
                'class' => 'tagify',
                'data-conditional-id' => $prefix . 'highlight_element',
                'data-conditional-value' => 'enable'
            ),
            'default' => $highlight
        ) );

        $fields_metabox->add_field(
            array(
                'name' => esc_html__( 'Click Animation', 'tmpointer'),
                'id' => $prefix . 'click_anim',
                'type' => 'radio_inline',
                'options' => array(
                    'dark' => esc_html__( 'Dark', 'tmpointer' ),
                    'light'   => esc_html__( 'Light', 'tmpointer' ),
                    'none'   => esc_html__( 'None', 'tmpointer' )
                ),
                'default' => $click_anim
            )
        );

        $fields_metabox->add_field(
            array(
                'name' => esc_html__( 'Hide Mode', 'tmpointer'),
                'id' => $prefix . 'hide_mode',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => $hide_mode
            )
        );

        $fields_metabox->add_field( array(
            'name' => esc_html__( 'Hide Timing (ms)', 'tmpointer' ),
            'id'   => $prefix . 'hide_timing',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'data-conditional-id' => $prefix . 'hide_mode',
                'data-conditional-value' => 'enable'
            ),
            'default' => $hide_timing
        ) );

        $fields_metabox->add_field(
            array(
                'name' => esc_html__( 'Native Cursor', 'tmpointer'),
                'id' => $prefix . 'native',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => $native
            )
        );

        $fields_metabox->add_field(
            array(
                'name' => esc_html__( 'Cursor', 'tmpointer'), 
                'id' => $prefix . 'cursor',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => $cursor
            )
        );

        $fields_metabox->add_field( array(
            'name' => esc_html__( 'Cursor Velocity', 'tmpointer' ),
            'id'   => $prefix . 'cursor_velocity',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'step' => '0.1',
                'data-conditional-id' => $prefix . 'cursor',
                'data-conditional-value' => 'enable'
            ),
            'default' => $cursor_velocity
        ) );

        $fields_metabox->add_field(
            array(
                'name' => esc_html__( 'Node', 'tmpointer'), 
                'id' => $prefix . 'node',
                'type' => 'radio_inline',
                'options' => array(
                    'enable' => esc_html__( 'Enable', 'tmpointer' ),
                    'disable'   => esc_html__( 'Disable', 'tmpointer' )
                ),
                'default' => $node
            )
        );

        $fields_metabox->add_field( array(
            'name' => esc_html__( 'Node Velocity', 'tmpointer' ),
            'id'   => $prefix . 'node_velocity',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
                'step' => '0.1',
                'data-conditional-id' => $prefix . 'node',
                'data-conditional-value' => 'enable'
            ),
            'default' => $node_velocity
        ) );
        
    }

    /* Admin scripts */
    public function admin_scripts($hook){
        if (( 'post.php' == $hook ) || ( 'post-new.php' == $hook ) || ( 'toplevel_page_tmpointer_options' == $hook ) || ( 'tm-pointer_page_tmpointer_options_1' == $hook )) {
            wp_enqueue_style('tmpointer-dashboard', plugin_dir_url( __FILE__ ) . 'css/dashboard.css', false, '1.0');
            wp_enqueue_style('tmpointer-tagify', plugin_dir_url( __FILE__ ) . 'css/tagify.css', false, '1.0');
            wp_enqueue_script( 'tmpointer-tagify', plugin_dir_url( __FILE__ ) . 'js/tagify.js', array( 'jquery' ), '1.0', true ); 
            wp_enqueue_script( 'cmb2-conditionals', plugin_dir_url( __FILE__ ) . 'js/cmb2-conditionals.js', array( 'jquery' ), '1.0', true ); 
        }

        if (( 'toplevel_page_tmpointer_options' == $hook ) || ( 'tm-pointer_page_tmpointer_options_1' == $hook )) {
            wp_enqueue_style('tmpointer-admin', plugin_dir_url( __FILE__ ) . 'css/admin.css', false, '1.0');
            wp_enqueue_script( 'tmpointer-admin', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), '1.0', true );

            $cursor_style = tmpointer_get_option('tmpointer_options','cursor_style','tm-pointer-simple');
            $param = array(
                "cursorstyle" => $cursor_style
            );
            
            wp_localize_script('tmpointer-admin', 'tmpointer_admin_vars', $param);
        } else {
            return;
        }
    }

    /* Front End Styles & Scripts */
    public function enqueue_scripts(){
        // Register Styles & Scripts
        wp_register_style('tmpointer', plugin_dir_url( __FILE__ ) . 'css/style.css', false, '1.0');
        wp_register_script( 'tmpointer', plugin_dir_url( __FILE__ ) . 'js/tmpointer-min.js', array( 'jquery' ), '1.0', true ); 
        wp_register_script( 'tmpointer-custom', plugin_dir_url( __FILE__ ) . 'js/custom.js', array( 'jquery','tmpointer' ), '1.0', true );
        wp_register_script( 'tmpointer-elementor', plugin_dir_url( __FILE__ ) . 'js/elementor.js', array( 'jquery','tmpointer' ), '1.0', true );

        $sitewide = tmpointer_get_option('tmpointer_options','sitewide','disable');
        $metabox = tmpointer_get_option('tmpointer_options','metabox',array('page'));

        // Check if custom cursor has been enabled
        if ($sitewide != 'enable' && !is_singular($metabox)) {
            return;
        } elseif (is_singular($metabox)) {
            $activation = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_activation', true );
            if (!empty($activation) && $activation == 'disable') {
                return;
            }
        }

        // Get General Settings
        $icon_class = tmpointer_get_option('tmpointer_options','icon_class','fas fa-mouse-pointer');
        $image = tmpointer_get_option('tmpointer_options','image',plugin_dir_url( __FILE__ ) . 'images/cursor.png');
        $native = tmpointer_get_option('tmpointer_options','native','disable');
        $hide_timing = tmpointer_get_option('tmpointer_options','hide_timing',3000);
        $highlight = tmpointer_get_option('tmpointer_options','highlight','');
        $cursor_style = tmpointer_get_option('tmpointer_options','cursor_style','tm-pointer-simple');
        $click_anim = tmpointer_get_option('tmpointer_options','click_anim','none');
        $highlight_element = tmpointer_get_option('tmpointer_options','highlight_element','disable');
        $hide_mode = tmpointer_get_option('tmpointer_options','hide_mode','disable');
        $cursor = tmpointer_get_option('tmpointer_options','cursor','enable');
        $cursor_velocity = tmpointer_get_option('tmpointer_options','cursor_velocity',1);
        $node = tmpointer_get_option('tmpointer_options','node','enable');
        $node_velocity = tmpointer_get_option('tmpointer_options','node_velocity',0.1);
        $img_size = tmpointer_get_option('tmpointer_options_1','img_size',32);
        $img_position = tmpointer_get_option('tmpointer_options_1','img_position','translateY(0) translateX(0) translateZ(0)');
        $icon_size = tmpointer_get_option('tmpointer_options_1','icon_size',16);

        // Check Post Meta
        if (is_singular($metabox)) {
            $icon_class_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_icon_class', true );
            $image_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_image', true );
            $native_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_native', true );
            $hide_timing_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_hide_timing', true );
            $highlight_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_highlight', true );
            $cursor_style_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_cursor_style', true );
            $click_anim_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_click_anim', true );
            $highlight_element_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_highlight_element', true );
            $hide_mode_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_hide_mode', true );
            $cursor_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_cursor', true );
            $cursor_velocity_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_cursor_velocity', true );
            $node_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_node', true );
            $node_velocity_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_node_velocity', true );
            $img_size_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_img_size', true );
            $img_position_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_img_position', true );
            $icon_size_meta = get_post_meta( get_queried_object_id(), 'tmpointer_cmb2_icon_size', true );

            if (!empty($cursor_style_meta)) { $cursor_style = $cursor_style_meta; }
            if (!empty($icon_class_meta)) { $icon_class = $icon_class_meta; }
            if (!empty($image_meta)) { $image = $image_meta; }
            if (!empty($native_meta)) { $native = $native_meta; }
            if (!empty($hide_timing_meta)) { $hide_timing = $hide_timing_meta; }
            if (!empty($highlight_meta)) { $highlight = $highlight_meta; }
            if (!empty($click_anim_meta)) { $click_anim = $click_anim_meta; }
            if (!empty($highlight_element_meta)) { $highlight_element = $highlight_element_meta; }
            if (!empty($hide_mode_meta)) { $hide_mode = $hide_mode_meta; }
            if (!empty($cursor_meta)) { $cursor = $cursor_meta; }
            if (!empty($cursor_velocity_meta)) { $cursor_velocity = $cursor_velocity_meta; }
            if (!empty($node_meta)) { $node = $node_meta; }
            if (!empty($node_velocity_meta)) { $node_velocity = $node_velocity_meta; }
            if (!empty($img_size_meta)) { $img_size = $img_size_meta; }
            if (!empty($img_position_meta)) { $img_position = $img_position_meta; }
            if (!empty($icon_size_meta)) { $icon_size = $icon_size_meta; }
        }

        // Get Style Settings
        $icon_node_size = tmpointer_get_option('tmpointer_options_1','icon_node_size',32);
        $icon_color = tmpointer_get_option('tmpointer_options_1','icon_color','#000000');
        $icon_border_color = tmpointer_get_option('tmpointer_options_1','icon_border_color','#000000');
        $icon_bg_color = tmpointer_get_option('tmpointer_options_1','icon_bg_color','rgba(0,0,0,0)');
        $icon_h_border_color = tmpointer_get_option('tmpointer_options_1','icon_h_border_color','rgba(0,0,0,0)');
        $icon_h_bg_color = tmpointer_get_option('tmpointer_options_1','icon_h_bg_color','rgba(0,0,0,0.2)');
        $simple_size = tmpointer_get_option('tmpointer_options_1','simple_size',32);
        $simple_border_color = tmpointer_get_option('tmpointer_options_1','simple_border_color','#000000');
        $simple_bg_color = tmpointer_get_option('tmpointer_options_1','simple_bg_color','rgba(255,255,255,0.1)');
        $img_node_size = tmpointer_get_option('tmpointer_options_1','img_node_size',96);
        $img_node_color = tmpointer_get_option('tmpointer_options_1','img_node_color','rgba(0,0,0,0.2)');
        $mix_size = tmpointer_get_option('tmpointer_options_1','mix_size',32);
        $mix_color = tmpointer_get_option('tmpointer_options_1','mix_color','#ffffff');
        $pulse_size = tmpointer_get_option('tmpointer_options_1','pulse_size',20);
        $pulse_color = tmpointer_get_option('tmpointer_options_1','pulse_color','#000000');
        $pulse_h_color = tmpointer_get_option('tmpointer_options_1','pulse_h_color','#cc0000');
        $pulse_shadow = tmpointer_get_option('tmpointer_options_1','pulse_shadow','black');
        $p1_cursor_size = tmpointer_get_option('tmpointer_options_1','p1_cursor_size',10);
        $p1_node_size = tmpointer_get_option('tmpointer_options_1','p1_node_size',30);
        $p1_color = tmpointer_get_option('tmpointer_options_1','p1_color','#000000');
        $p1_bg_color = tmpointer_get_option('tmpointer_options_1','p1_bg_color','rgba(0,0,0,0)');
        $p1_border_color = tmpointer_get_option('tmpointer_options_1','p1_border_color','#000000');
        $p1_h_bg_color = tmpointer_get_option('tmpointer_options_1','p1_h_bg_color','rgba(0,0,0,0.2)');
        $p2_cursor_size = tmpointer_get_option('tmpointer_options_1','p2_cursor_size',18);
        $p2_node_size = tmpointer_get_option('tmpointer_options_1','p2_node_size',9);
        $p2_cursor_color = tmpointer_get_option('tmpointer_options_1','p2_cursor_color','#000000');
        $p2_h_cursor_color = tmpointer_get_option('tmpointer_options_1','p2_h_cursor_color','rgba(0,0,0,0.2)');
        $p2_node_color = tmpointer_get_option('tmpointer_options_1','p2_node_color','#000000');
        $p2_h_node_color = tmpointer_get_option('tmpointer_options_1','p2_h_node_color','#000000');
        $p3_cursor_size = tmpointer_get_option('tmpointer_options_1','p3_cursor_size',8);
        $p3_node_size = tmpointer_get_option('tmpointer_options_1','p3_node_size',32);
        $p3_cursor_color = tmpointer_get_option('tmpointer_options_1','p3_cursor_color','#000000');
        $p3_h_cursor_color = tmpointer_get_option('tmpointer_options_1','p3_h_cursor_color','#000000');
        $p3_node_color = tmpointer_get_option('tmpointer_options_1','p3_node_color','rgba(0,0,0,0.2)');
        $p3_h_node_color = tmpointer_get_option('tmpointer_options_1','p3_h_node_color','rgba(0,0,0,0.2)');
        $p4_cursor_size = tmpointer_get_option('tmpointer_options_1','p4_cursor_size',10);
        $p4_node_size = tmpointer_get_option('tmpointer_options_1','p4_node_size',20);
        $p4_cursor_color = tmpointer_get_option('tmpointer_options_1','p4_cursor_color','#000000');
        $p4_border_color = tmpointer_get_option('tmpointer_options_1','p4_border_color','#000000');
        $p4_h_border_color = tmpointer_get_option('tmpointer_options_1','p4_h_border_color','rgba(0,0,0,0)');
        $p4_bg_color = tmpointer_get_option('tmpointer_options_1','p4_bg_color','rgba(0,0,0,0)');
        $p4_h_bg_color = tmpointer_get_option('tmpointer_options_1','p4_h_bg_color','rgba(0,0,0,0.2)');
        $p5_cursor_size = tmpointer_get_option('tmpointer_options_1','p5_cursor_size',18);
        $p5_node_size = tmpointer_get_option('tmpointer_options_1','p5_node_size',9);
        $p5_color = tmpointer_get_option('tmpointer_options_1','p5_color','#000000');
        $p5_h_color = tmpointer_get_option('tmpointer_options_1','p5_h_color','#000000');
        $p5_bg_color = tmpointer_get_option('tmpointer_options_1','p5_bg_color','#000000');
        $p5_h_bg_color = tmpointer_get_option('tmpointer_options_1','p5_h_bg_color','rgba(0,0,0,0.2)');
        $p6_cursor_size = tmpointer_get_option('tmpointer_options_1','p6_cursor_size',9);
        $p6_node_size = tmpointer_get_option('tmpointer_options_1','p6_node_size',36);
        $p6_cursor_color = tmpointer_get_option('tmpointer_options_1','p6_cursor_color','#000000');
        $p6_border_color = tmpointer_get_option('tmpointer_options_1','p6_border_color','#000000');
        $p6_h_border_color = tmpointer_get_option('tmpointer_options_1','p6_h_border_color','rgba(0,0,0,0)');
        $p6_bg_color = tmpointer_get_option('tmpointer_options_1','p6_bg_color','rgba(0,0,0,0)');
        $p6_h_bg_color = tmpointer_get_option('tmpointer_options_1','p6_h_bg_color','rgba(0,0,0,0.2)');
    
        // Enqueue Styles
        wp_enqueue_style('tmpointer');

        // Custom Styles
        $inline_style = '';

        if (!empty($icon_size) && $icon_size != 16) {
            $inline_style .= '.tm-pointer-icon.tm-cursor i {font-size:' . $icon_size . 'px}.tm-pointer-icon.tm-cursor {width:' . $icon_size . 'px;height:' . $icon_size . 'px}';
        }

        if (!empty($icon_node_size) && $icon_node_size != 32) {
            $inline_style .= '.tm-pointer-icon.tm-node {width:' . $icon_node_size . 'px;height:' . $icon_node_size . 'px}';
        }

        if (!empty($icon_color) && $icon_color != '#000000') {
            $inline_style .= '.tm-pointer-icon.tm-cursor i {color:' . $icon_color . '}';
        }

        if (!empty($icon_border_color) && $icon_border_color != '#000000') {
            $inline_style .= '.tm-pointer-icon.tm-node:before {border-color:' . $icon_border_color . '}';
        }

        if (!empty($icon_bg_color) && $icon_bg_color != 'rgba(0,0,0,0)') {
            $inline_style .= '.tm-pointer-icon.tm-node:before {background-color:' . $icon_bg_color . '}';
        }

        if (!empty($icon_h_border_color) && $icon_h_border_color != 'rgba(0,0,0,0)') {
            $inline_style .= '.tm-pointer-icon.tm-node.tm-expand:before {border-color:' . $icon_h_border_color . '}';
        }

        if (!empty($icon_h_bg_color) && $icon_h_bg_color != 'rgba(0,0,0,0.2)') {
            $inline_style .= '.tm-pointer-icon.tm-node.tm-expand:before {background-color:' . $icon_h_bg_color . '}';
        }

        if (!empty($simple_size) && $simple_size != 32) {
            $inline_style .= '.tm-pointer-simple.tm-cursor {width:' . $simple_size . 'px;height:' . $simple_size . 'px}';
        }

        if (!empty($simple_border_color) && $simple_border_color != '#000000') {
            $inline_style .= '.tm-pointer-simple.tm-cursor {border-color:' . $simple_border_color . '}';
        }

        if (!empty($simple_bg_color) && $simple_bg_color != 'rgba(255,255,255,0.1)') {
            $inline_style .= '.tm-pointer-simple.tm-cursor {background-color:' . $simple_bg_color . '}';
        }

        if (!empty($img_size) && $img_size != 36) {
            $inline_style .= '.tm-pointer-img.tm-cursor,.tm-pointer-img.tm-cursor img {width:' . $img_size . 'px}';
        }

        if (!empty($img_position) && $img_position != 'translateY(0) translateX(0) translateZ(0)') {
            $inline_style .= '.tm-pointer-img.tm-cursor img {transform:' . $img_position . '}';
        }

        if (!empty($img_node_size) && $img_node_size != 96) {
            $inline_style .= '.tm-pointer-img.tm-node {width:' . $img_node_size . 'px;height:' . $img_node_size . 'px}';
        }

        if (!empty($img_node_color) && $img_node_color != 'rgba(0,0,0,0.2)') {
            $inline_style .= '.tm-pointer-img.tm-node.tm-expand:before {background-color:' . $img_node_color . '}';
        }

        if (!empty($mix_size) && $mix_size != 32) {
            $inline_style .= '.tm-pointer-mix-blend.tm-cursor {width:' . $mix_size . 'px;height:' . $mix_size . 'px}';
        }

        if (!empty($mix_color) && $mix_color != '#ffffff') {
            $inline_style .= '.tm-pointer-mix-blend.tm-cursor {background-color:' . $mix_color . '}';
        }

        if (!empty($pulse_size) && $pulse_size != 20) {
            $inline_style .= '.tm-pointer-pulse.tm-cursor {width:' . $pulse_size . 'px;height:' . $pulse_size . 'px}';
        }

        if (!empty($pulse_color) && $pulse_color != '#000000') {
            $inline_style .= '.tm-pointer-pulse.tm-cursor {background-color:' . $pulse_color . '}';
        }

        if (!empty($pulse_h_color) && $pulse_h_color != '#cc0000') {
            $inline_style .= '.tm-pointer-pulse.tm-cursor.tm-expand {background-color:' . $pulse_h_color . '}';
        }

        if (!empty($pulse_shadow) && $pulse_shadow != 'black') {
            $inline_style .= '.tm-pointer-pulse.tm-cursor {animation: tm-pulse-white 2s infinite}';
        }

        if (!empty($p1_cursor_size) && $p1_cursor_size != 10) {
            $inline_style .= '.tm-pointer-1.tm-cursor {width:' . $p1_cursor_size . 'px;height:' . $p1_cursor_size . 'px}';
        }

        if (!empty($p1_node_size) && $p1_node_size != 30) {
            $inline_style .= '.tm-pointer-1.tm-node {width:' . $p1_node_size . 'px;height:' . $p1_node_size . 'px}';
        }

        if (!empty($p1_color) && $p1_color != '#000000') {
            $inline_style .= '.tm-pointer-1.tm-cursor:before {background-color:' . $p1_color . '}';
        }

        if (!empty($p1_bg_color) && $p1_bg_color != 'rgba(0,0,0,0)') {
            $inline_style .= '.tm-pointer-1.tm-node:before {background-color:' . $p1_bg_color . '}';
        }

        if (!empty($p1_border_color) && $p1_border_color != '#000000') {
            $inline_style .= '.tm-pointer-1.tm-node:before {border-color:' . $p1_border_color . '}';
        }

        if (!empty($p1_h_bg_color) && $p1_h_bg_color != 'rgba(0,0,0,0.2)') {
            $inline_style .= '.tm-pointer-1.tm-node.tm-expand:before {background-color:' . $p1_h_bg_color . '}';
        }

        if (!empty($p2_cursor_size) && $p2_cursor_size != 18) {
            $inline_style .= '.tm-pointer-2.tm-cursor {width:' . $p2_cursor_size . 'px;height:' . $p2_cursor_size . 'px}';
        }

        if (!empty($p2_node_size) && $p2_node_size != 9) {
            $inline_style .= '.tm-pointer-2.tm-node {width:' . $p2_node_size . 'px;height:' . $p2_node_size . 'px}';
        }

        if (!empty($p2_cursor_color) && $p2_cursor_color != '#000000') {
            $inline_style .= '.tm-pointer-2.tm-cursor:before {background-color:' . $p2_cursor_color . '}';
        }

        if (!empty($p2_h_cursor_color) && $p2_h_cursor_color != 'rgba(0,0,0,0.2)') {
            $inline_style .= '.tm-pointer-2.tm-cursor.tm-expand:before {background-color:' . $p2_h_cursor_color . '}';
        }

        if (!empty($p2_node_color) && $p2_node_color != '#000000') {
            $inline_style .= '.tm-pointer-2.tm-node:before {background-color:' . $p2_node_color . '}';
        }

        if (!empty($p2_h_node_color) && $p2_h_node_color != '#000000') {
            $inline_style .= '.tm-pointer-2.tm-node.tm-expand:before {background-color:' . $p2_h_node_color . '}';
        }

        if (!empty($p3_cursor_size) && $p3_cursor_size != 8) {
            $inline_style .= '.tm-pointer-3.tm-cursor {width:' . $p3_cursor_size . 'px;height:' . $p3_cursor_size . 'px}';
        }

        if (!empty($p3_node_size) && $p3_node_size != 32) {
            $inline_style .= '.tm-pointer-3.tm-node {width:' . $p3_node_size . 'px;height:' . $p3_node_size . 'px}';
        }

        if (!empty($p3_cursor_color) && $p3_cursor_color != '#000000') {
            $inline_style .= '.tm-pointer-3.tm-cursor:before {background-color:' . $p3_cursor_color . '}';
        }

        if (!empty($p3_h_cursor_color) && $p3_h_cursor_color != '#000000') {
            $inline_style .= '.tm-pointer-3.tm-cursor.tm-expand:before {background-color:' . $p3_h_cursor_color . '}';
        }

        if (!empty($p3_node_color) && $p3_node_color != 'rgba(0,0,0,0.2)') {
            $inline_style .= '.tm-pointer-3.tm-node:before {background-color:' . $p3_node_color . '}';
        }

        if (!empty($p3_h_node_color) && $p3_h_node_color != 'rgba(0,0,0,0.2)') {
            $inline_style .= '.tm-pointer-3.tm-node.tm-expand:before {background-color:' . $p3_h_node_color . '}';
        }

        if (!empty($p4_cursor_size) && $p4_cursor_size != 10) {
            $inline_style .= '.tm-pointer-4.tm-cursor {width:' . $p4_cursor_size . 'px;height:' . $p4_cursor_size . 'px}';
        }

        if (!empty($p4_node_size) && $p4_node_size != 20) {
            $inline_style .= '.tm-pointer-4.tm-node {width:' . $p4_node_size . 'px;height:' . $p4_node_size . 'px}';
        }

        if (!empty($p4_cursor_color) && $p4_cursor_color != '#000000') {
            $inline_style .= '.tm-pointer-4.tm-cursor:before {background-color:' . $p4_cursor_color . '}';
        }

        if (!empty($p4_border_color) && $p4_border_color != '#000000') {
            $inline_style .= '.tm-pointer-4.tm-node:before {border-color:' . $p4_border_color . '}';
        }

        if (!empty($p4_h_border_color) && $p4_h_border_color != 'rgba(0,0,0,0)') {
            $inline_style .= '.tm-pointer-4.tm-node.tm-expand:before {border-color:' . $p4_h_border_color . '}';
        }

        if (!empty($p4_bg_color) && $p4_bg_color != 'rgba(0,0,0,0)') {
            $inline_style .= '.tm-pointer-4.tm-node:before {background-color:' . $p4_bg_color . '}';
        }

        if (!empty($p4_h_bg_color) && $p4_h_bg_color != 'rgba(0,0,0,0.2)') {
            $inline_style .= '.tm-pointer-4.tm-node.tm-expand:before {background-color:' . $p4_h_bg_color . '}';
        }

        if (!empty($p5_cursor_size) && $p5_cursor_size != 18) {
            $inline_style .= '.tm-pointer-5.tm-cursor {width:' . $p5_cursor_size . 'px;height:' . $p5_cursor_size . 'px}';
        }

        if (!empty($p5_node_size) && $p5_node_size != 9) {
            $inline_style .= '.tm-pointer-5.tm-node {width:' . $p5_node_size . 'px;height:' . $p5_node_size . 'px}';
        }

        if (!empty($p5_color) && $p5_color != '#000000') {
            $inline_style .= '.tm-pointer-5.tm-cursor:before {background-color:' . $p5_color . '}';
        }

        if (!empty($p5_h_color) && $p5_h_color != '#000000') {
            $inline_style .= '.tm-pointer-5.tm-cursor.tm-expand:before {background-color:' . $p5_h_color . '}';
        }

        if (!empty($p5_bg_color) && $p5_bg_color != '#000000') {
            $inline_style .= '.tm-pointer-5.tm-node:before {background-color:' . $p5_bg_color . '}';
        }

        if (!empty($p5_h_bg_color) && $p5_h_bg_color != 'rgba(0,0,0,0.2)') {
            $inline_style .= '.tm-pointer-5.tm-node.tm-expand:before {background-color:' . $p5_h_bg_color . '}';
        }

        if (!empty($p6_cursor_size) && $p6_cursor_size != 9) {
            $inline_style .= '.tm-pointer-6.tm-cursor {width:' . $p6_cursor_size . 'px;height:' . $p6_cursor_size . 'px}';
        }

        if (!empty($p6_node_size) && $p6_node_size != 36) {
            $inline_style .= '.tm-pointer-6.tm-node {width:' . $p6_node_size . 'px;height:' . $p6_node_size . 'px}';
        }

        if (!empty($p6_cursor_color) && $p6_cursor_color != '#000000') {
            $inline_style .= '.tm-pointer-6.tm-cursor:before {background-color:' . $p6_cursor_color . '}';
        }

        if (!empty($p6_border_color) && $p6_border_color != '#000000') {
            $inline_style .= '.tm-pointer-6.tm-node:before {border-color:' . $p6_border_color . '}';
        }

        if (!empty($p6_h_border_color) && $p6_h_border_color != 'rgba(0,0,0,0)') {
            $inline_style .= '.tm-pointer-6.tm-node.tm-expand:before {border-color:' . $p6_h_border_color . '}';
        }

        if (!empty($p6_bg_color) && $p6_bg_color != 'rgba(0,0,0,0)') {
            $inline_style .= '.tm-pointer-6.tm-node:before {background-color:' . $p6_bg_color . '}';
        }

        if (!empty($p6_h_bg_color) && $p6_h_bg_color != 'rgba(0,0,0,0.2)') {
            $inline_style .= '.tm-pointer-6.tm-node.tm-expand:before {background-color:' . $p6_h_bg_color . '}';
        }

        wp_add_inline_style( 'tmpointer', $inline_style );

        // Enqueue Scripts
        wp_enqueue_script('tmpointer'); 
        wp_enqueue_script('tmpointer-custom');

        $tmpointer_param = array(
            "cursorstyle" => $cursor_style,
            "iconclass" => $icon_class,
            "image" => $image,
            "cursor" => $cursor,
            "cursorvelocity" => $cursor_velocity,
            "node" => $node,
            "nodevelocity" => $node_velocity,
            "native" => $native,
            "hidemode" => $hide_mode,
            "hidetiming" => $hide_timing,
            "highlightelement" => $highlight_element,
            "highlight" => $highlight,
            "clickanim" => $click_anim,
        );
        
        wp_localize_script('tmpointer-custom', 'tmpointer_vars', $tmpointer_param); 
    }
}

/**
 * Returns the main instance of the class
 */

function tmpointer() {  
	return tmpointer::instance();
}
// Global for backwards compatibility.
$GLOBALS['tmpointer'] = tmpointer();