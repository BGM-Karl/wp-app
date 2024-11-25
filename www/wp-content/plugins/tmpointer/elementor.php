<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class tmpointerElementor {

    protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
    }
    
    public function __construct() {
		$this->init_hooks();
	}

    public static function init_hooks() {
        add_action( 'elementor/element/section/section_advanced/after_section_end', [__CLASS__, 'add_section'] );
        add_action( 'elementor/element/column/section_advanced/after_section_end', [__CLASS__, 'add_section'] );
        add_action( 'elementor/frontend/section/before_render', [__CLASS__, 'before_render'] );
        add_action( 'elementor/frontend/column/before_render', [__CLASS__, 'before_render'] );
    }

    public static function before_render( Element_Base $element ) {
        $id = $element->get_id();
        $settings = $element->get_settings();
        if ($settings['tmp_custom_cursor'] == 'enable') {
            $element->add_render_attribute(
                '_wrapper', 'class', [
                    'tmpointer-elementor'
                ]
            );
            wp_enqueue_style('tmpointer');
            wp_enqueue_script('tmpointer'); 
            wp_enqueue_script('tmpointer-elementor');
        }
    }
    
    public static function add_section( Element_Base $element ) {

        $element->start_controls_section(
            '_section_tmpointer',
            [
                'label' => esc_html__( 'TM Pointer', 'tmpointer' ),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'tmp_custom_cursor',
            [
                'label' => esc_html__( 'Custom Cursor', 'tmpointer' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'frontend_available' => true,
                'options' => [
					'enable' => [
						'title' => esc_html__( 'Enable', 'tmpointer' ),
						'icon' => 'eicons eicon-check',
					],
					'disable' => [
						'title' => esc_html__( 'Disable', 'tmpointer' ),
						'icon' => 'eicons eicon-close',
					],
				],
				'default' => 'disable',
				'toggle' => false
            ]
        );

        $element->add_control(
			'tmp_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
                'condition' => ['tmp_custom_cursor' => 'enable'],
				'raw' => esc_html__( 'Please note! The custom cursor has been disabled on backend to avoid possible issues using Elementor. Please view the page on the frontend to test the cursor.', 'tmpointer' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

        $element->add_control(
			'tmp_cursor_style',
			[
				'label' => esc_html__( 'Cursor Style', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'frontend_available' => true,
				'default' => 'tm-pointer-simple',
                'condition' => ['tmp_custom_cursor' => 'enable'],
				'options' => tm_get_pointer_styles()
			]
		);

        // ICON
        $element->add_control(
			'tmp_icon_class',
			[
				'label' => esc_html__( 'Cursor Icon Class', 'tmpointer' ),
                'description' => esc_html__( 'You can use any icon class which is included to your site by your theme or a third party plugin.', 'tmpointer'),
				'type' => \Elementor\Controls_Manager::TEXT,
                'frontend_available' => true,
				'default' => 'fas fa-mouse-pointer',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-icon',
                        ]
                    ]
                ],
			]
		);

        $element->add_control(
			'tmp_icon_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 16,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-icon',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-icon.tm-cursor i' => 'font-size: {{VALUE}}px;',
                    '#tm-cursor-{{ID}}.tm-pointer-icon.tm-cursor' => 'width: {{VALUE}}px;height: {{VALUE}}px;',
				],
			]
		);

        $element->add_control(
			'tmp_icon_node_size',
			[
				'label' => esc_html__( 'Node Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 32,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-icon',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-icon.tm-node' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-icon',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-icon.tm-cursor i' => 'color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_icon_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-icon',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-icon.tm-node:before' => 'border-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_icon_bg_color',
			[
				'label' => esc_html__( 'Background', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-icon',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-icon.tm-node:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_icon_h_border_color',
			[
				'label' => esc_html__( 'Highlight Border Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-icon',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-icon.tm-node.tm-expand:before' => 'border-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_icon_h_bg_color',
			[
				'label' => esc_html__( 'Highlight Background', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0.2)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-icon',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-icon.tm-node.tm-expand:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        // IMG
        $element->add_control(
			'tmp_cursor_image',
			[
				'label' => esc_html__( 'Select File', 'tmpointer' ),
				'type'	=> 'tmp-file-select',
                'frontend_available' => true,
				'placeholder' => esc_html__( 'URL to File', 'tmpointer' ),
                'default' => plugin_dir_url( __FILE__ ) . 'images/cursor.png',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-img',
                        ]
                    ]
                ],
			]
        );

        $element->add_control(
			'tmp_img_size',
			[
				'label' => esc_html__( 'Image Width (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 500,
				'step' => 1,
				'default' => 32,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-img',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}, #tm-cursor-{{ID}} img' => 'width: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_img_position',
			[
				'label' => esc_html__( 'Image Position', 'tmpointer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'translateY(0) translateX(0) translateZ(0)' => esc_html__( 'Middle', 'tmpointer' ),
                    'translateY(45%) translateX(0) translateZ(0)'   => esc_html__( 'Bottom Center', 'tmpointer' ),
                    'translateY(45%) translateX(50%) translateZ(0)'   => esc_html__( 'Bottom Right', 'tmpointer' ),
                    'translateY(45%) translateX(-50%) translateZ(0)'   => esc_html__( 'Bottom Left', 'tmpointer' )
				],
				'default' => 'translateY(0) translateX(0) translateZ(0)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-img',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-img.tm-cursor img' => 'transform: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_img_node_size',
			[
				'label' => esc_html__( 'Node Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 96,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-img',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-img.tm-node' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_img_node_color',
			[
				'label' => esc_html__( 'Node Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0.2)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-img',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-img.tm-node.tm-expand:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        // SIMPLE
        $element->add_control(
			'tmp_simple_size',
			[
				'label' => esc_html__( 'Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 32,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-simple',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-simple.tm-cursor' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_simple_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-simple',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-simple.tm-cursor' => 'border-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_simple_background',
			[
				'label' => esc_html__( 'Background', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(255,255,255,0.1)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-simple',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-simple.tm-cursor' => 'background-color: {{VALUE}};'
				]
			]
		);

        // MIX BLEND
        $element->add_control(
			'tmp_mix_size',
			[
				'label' => esc_html__( 'Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 32,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-mix-blend',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-mix-blend.tm-cursor' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_mix_background',
			[
				'label' => esc_html__( 'Background', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#ffffff',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-mix-blend',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-mix-blend.tm-cursor' => 'background-color: {{VALUE}};'
				]
			]
		);

        // PULSE
        $element->add_control(
			'tmp_pulse_size',
			[
				'label' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 20,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-pulse',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-pulse.tm-cursor' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pulse_color',
			[
				'label' => esc_html__( 'Background', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-pulse',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-pulse.tm-cursor' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pulse_h_color',
			[
				'label' => esc_html__( 'Highlight Bg Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#cc0000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-pulse',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-pulse.tm-cursor.tm-expand' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pulse_shadow',
			[
				'label' => esc_html__( 'Shadow', 'tmpointer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'white' => esc_html__( 'Light', 'tmpointer' ),
					'black' => esc_html__( 'Dark', 'tmpointer' )
				],
				'default' => 'black',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-pulse',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-pulse.tm-cursor' => 'animation: tm-pulse-{{VALUE}} 2s infinite;'
				]
			]
		);

        // POINTER 1
        $element->add_control(
			'tmp_pointer1_cursor_size',
			[
				'label' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 10,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-1',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-1.tm-cursor' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer1_node_size',
			[
				'label' => esc_html__( 'Node Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 30,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-1',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-1.tm-node' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer1_color',
			[
				'label' => esc_html__( 'Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-1',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-1.tm-cursor:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer1_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-1',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-1.tm-node:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer1_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-1',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-1.tm-node:before' => 'border-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer1_h_bg_color',
			[
				'label' => esc_html__( 'Highlight Background Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0.2)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-1',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-1.tm-node.tm-expand:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        // POINTER 2
        $element->add_control(
			'tmp_pointer2_cursor_size',
			[
				'label' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 18,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-2',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-2.tm-cursor' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer2_node_size',
			[
				'label' => esc_html__( 'Node Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 9,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-2',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-2.tm-node' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer2_cursor_color',
			[
				'label' => esc_html__( 'Cursor Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-2',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-2.tm-cursor:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer2_cursor_h_color',
			[
				'label' => esc_html__( 'Highlight Cursor Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0.2)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-2',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-2.tm-cursor.tm-expand:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer2_node_color',
			[
				'label' => esc_html__( 'Node Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-2',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-2.tm-node:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer2_node_h_color',
			[
				'label' => esc_html__( 'Highlight Node Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-2',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-2.tm-node.tm-expand:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        // POINTER 3
        $element->add_control(
			'tmp_pointer3_cursor_size',
			[
				'label' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 8,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-3',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-3.tm-cursor' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer3_node_size',
			[
				'label' => esc_html__( 'Node Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 32,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-3',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-3.tm-node' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer3_cursor_color',
			[
				'label' => esc_html__( 'Cursor Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-3',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-3.tm-cursor:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer3_cursor_h_color',
			[
				'label' => esc_html__( 'Highlight Cursor Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-3',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-3.tm-cursor.tm-expand:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer3_node_color',
			[
				'label' => esc_html__( 'Node Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0.2)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-3',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-3.tm-node:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer3_node_h_color',
			[
				'label' => esc_html__( 'Highlight Node Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0.2)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-3',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-3.tm-node.tm-expand:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        // POINTER 4
        $element->add_control(
			'tmp_pointer4_cursor_size',
			[
				'label' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 10,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-4',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-4.tm-cursor' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer4_node_size',
			[
				'label' => esc_html__( 'Node Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 20,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-4',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-4.tm-node' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer4_cursor_color',
			[
				'label' => esc_html__( 'Cursor Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-4',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-4.tm-cursor:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer4_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-4',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-4.tm-node:before' => 'border-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer4_h_border_color',
			[
				'label' => esc_html__( 'Highlight Border Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-4',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-4.tm-node.tm-expand:before' => 'border-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer4_bg_color',
			[
				'label' => esc_html__( 'Background', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-4',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-4.tm-node:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer4_h_bg_color',
			[
				'label' => esc_html__( 'Highlight Background', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0.2)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-4',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-4.tm-node.tm-expand:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        // POINTER 5
        $element->add_control(
			'tmp_pointer5_cursor_size',
			[
				'label' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 18,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-5',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-5.tm-cursor' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer5_node_size',
			[
				'label' => esc_html__( 'Node Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 9,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-5',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-5.tm-node' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer5_cursor_color',
			[
				'label' => esc_html__( 'Cursor Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-5',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-5.tm-cursor:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer5_cursor_h_color',
			[
				'label' => esc_html__( 'Highlight Cursor Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-5',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-5.tm-cursor.tm-expand:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer5_node_color',
			[
				'label' => esc_html__( 'Node Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-5',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-5.tm-node:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer5_node_h_color',
			[
				'label' => esc_html__( 'Highlight Node Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0.2)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-5',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-5.tm-node.tm-expand:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        // POINTER 6
        $element->add_control(
			'tmp_pointer6_cursor_size',
			[
				'label' => esc_html__( 'Cursor Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 9,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-6',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-6.tm-cursor' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer6_node_size',
			[
				'label' => esc_html__( 'Node Size (px)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 36,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-6',
                        ]
                    ]
                ],
                'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-6.tm-node' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);

        $element->add_control(
			'tmp_pointer6_cursor_color',
			[
				'label' => esc_html__( 'Cursor Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-6',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-cursor-{{ID}}.tm-pointer-6.tm-cursor:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer6_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-6',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-6.tm-node:before' => 'border-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer6_h_border_color',
			[
				'label' => esc_html__( 'Highlight Border Color', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-6',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-6.tm-node.tm-expand:before' => 'border-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer6_bg_color',
			[
				'label' => esc_html__( 'Background', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-6',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-6.tm-node:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_pointer6_h_bg_color',
			[
				'label' => esc_html__( 'Highlight Background', 'tmpointer' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0,0,0,0.2)',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor_style',
                            'value' => 'tm-pointer-6',
                        ]
                    ]
                ],
				'selectors' => [
					'#tm-node-{{ID}}.tm-pointer-6.tm-node.tm-expand:before' => 'background-color: {{VALUE}};'
				]
			]
		);

        $element->add_control(
			'tmp_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
                'condition' => ['tmp_custom_cursor' => 'enable']
			]
		);

        $element->add_control(
            'tmp_highlight_element',
            [
                'label' => esc_html__( 'Highlight', 'tmpointer' ),
                'description'    => esc_html__( 'Highlight the selected elements on mouse hover.', 'tmpointer'), 
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'frontend_available' => true,
                'options' => [
					'enable' => [
						'title' => esc_html__( 'Enable', 'tmpointer' ),
						'icon' => 'eicons eicon-check',
					],
					'disable' => [
						'title' => esc_html__( 'Disable', 'tmpointer' ),
						'icon' => 'eicons eicon-close',
					],
				],
				'default' => 'disable',
                'condition' => ['tmp_custom_cursor' => 'enable'],
				'toggle' => false
            ]
        );

        $element->add_control(
			'tmp_highlight',
			[
				'label' => esc_html__( 'Elements to Highlight', 'tmpointer' ),
                'description' => esc_html__( 'Comma seperated elements. You can use HTML tag, id or class to target elements.', 'tmpointer' ),
				'type'	=> \Elementor\Controls_Manager::TEXT,
                'frontend_available' => true,
                'default' => 'a',
                'label_block' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_highlight_element',
                            'value' => 'enable',
                        ]
                    ]
                ],
			]
        );

        $element->add_control(
			'tmp_click_anim',
			[
				'label' => esc_html__( 'Click Animation', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'frontend_available' => true,
				'default' => 'none',
                'condition' => ['tmp_custom_cursor' => 'enable'],
				'options' => array(
                    'dark' => esc_html__( 'Dark', 'tmpointer' ),
                    'light'   => esc_html__( 'Light', 'tmpointer' ),
                    'none'   => esc_html__( 'None', 'tmpointer' )
                ),
			]
		);

        $element->add_control(
            'tmp_hide_mode',
            [
                'label' => esc_html__( 'Hide Mode', 'tmpointer' ),
                'description'    => esc_html__( 'Hide cursor if it does not move in the given period.', 'tmpointer'), 
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'frontend_available' => true,
                'options' => [
					'enable' => [
						'title' => esc_html__( 'Enable', 'tmpointer' ),
						'icon' => 'eicons eicon-check',
					],
					'disable' => [
						'title' => esc_html__( 'Disable', 'tmpointer' ),
						'icon' => 'eicons eicon-close',
					],
				],
				'default' => 'disable',
                'condition' => ['tmp_custom_cursor' => 'enable'],
				'toggle' => false
            ]
        );

        $element->add_control(
			'tmp_hide_timing',
			[
				'label' => esc_html__( 'Hide Timing (ms)', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
                'frontend_available' => true,
				'min' => 1000,
				'max' => 10000,
				'step' => 100,
				'default' => 3000,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_hide_mode',
                            'value' => 'enable',
                        ]
                    ]
                ],
			]
		);

        $element->add_control(
            'tmp_native',
            [
                'label' => esc_html__( 'Native Cursor', 'tmpointer' ),
                'description'    => esc_html__( 'Show/hide default browser cursor.', 'tmpointer'), 
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'frontend_available' => true,
                'options' => [
					'enable' => [
						'title' => esc_html__( 'Enable', 'tmpointer' ),
						'icon' => 'eicons eicon-check',
					],
					'disable' => [
						'title' => esc_html__( 'Disable', 'tmpointer' ),
						'icon' => 'eicons eicon-close',
					],
				],
				'default' => 'disable',
                'condition' => ['tmp_custom_cursor' => 'enable'],
				'toggle' => false
            ]
        );

        $element->add_control(
            'tmp_cursor',
            [
                'label' => esc_html__( 'Cursor', 'tmpointer' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'frontend_available' => true,
                'options' => [
					'enable' => [
						'title' => esc_html__( 'Enable', 'tmpointer' ),
						'icon' => 'eicons eicon-check',
					],
					'disable' => [
						'title' => esc_html__( 'Disable', 'tmpointer' ),
						'icon' => 'eicons eicon-close',
					],
				],
				'default' => 'enable',
                'condition' => ['tmp_custom_cursor' => 'enable'],
				'toggle' => false
            ]
        );

        $element->add_control(
			'tmp_cursor_velocity',
			[
				'label' => esc_html__( 'Cursor Velocity', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
                'frontend_available' => true,
				'min' => 0,
				'max' => 10,
				'step' => 0.1,
				'default' => 1,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_cursor',
                            'value' => 'enable',
                        ]
                    ]
                ],
			]
		);

        $element->add_control(
            'tmp_node',
            [
                'label' => esc_html__( 'Node', 'tmpointer' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'frontend_available' => true,
                'options' => [
					'enable' => [
						'title' => esc_html__( 'Enable', 'tmpointer' ),
						'icon' => 'eicons eicon-check',
					],
					'disable' => [
						'title' => esc_html__( 'Disable', 'tmpointer' ),
						'icon' => 'eicons eicon-close',
					],
				],
				'default' => 'enable',
                'condition' => ['tmp_custom_cursor' => 'enable'],
				'toggle' => false
            ]
        );

        $element->add_control(
			'tmp_node_velocity',
			[
				'label' => esc_html__( 'Node Velocity', 'tmpointer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
                'frontend_available' => true,
				'min' => 0,
				'max' => 10,
				'step' => 0.1,
				'default' => 0.1,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmp_custom_cursor',
                            'value' => 'enable',
                        ],
                        [
                            'name'  => 'tmp_node',
                            'value' => 'enable',
                        ]
                    ]
                ],
			]
		);

        $element->end_controls_section();
        
    }

}

/**
 * Returns the main instance of the class
 */

function tmpointerElementor() {  
	return tmpointerElementor::instance();
}
// Global for backwards compatibility.
$GLOBALS['tmpointerElementor'] = tmpointerElementor();