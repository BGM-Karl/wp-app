<?php
/**
 * delishs customizer
 *
 * @package delishs
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Added Panels & Sections
 */
function delishs_customizer_panels_sections( $wp_customize ) {

    //Add panel
    $wp_customize->add_panel( 'delishs_customizer', [
        'priority' => 10,
        'title'    => esc_html__( 'Delishs Customizer', 'delishs' ),
    ] );

    /**
     * Customizer Section
     */
    $wp_customize->add_section( 'header_top_setting', [
        'title'       => esc_html__( 'Header Info Setting', 'delishs' ),
        'description' => '',
        'priority'    => 10,
        'capability'  => 'edit_theme_options',
        'panel'       => 'delishs_customizer',
    ] );

    $wp_customize->add_section( 'header_social', [
        'title'       => esc_html__( 'Header Social', 'delishs' ),
        'description' => '',
        'priority'    => 11,
        'capability'  => 'edit_theme_options',
        'panel'       => 'delishs_customizer',
    ] );

    $wp_customize->add_section( 'section_header_logo', [
        'title'       => esc_html__( 'Header Setting', 'delishs' ),
        'description' => '',
        'priority'    => 12,
        'capability'  => 'edit_theme_options',
        'panel'       => 'delishs_customizer',
    ] );

    $wp_customize->add_section( 'blog_setting', [
        'title'       => esc_html__( 'Blog Setting', 'delishs' ),
        'description' => '',
        'priority'    => 13,
        'capability'  => 'edit_theme_options',
        'panel'       => 'delishs_customizer',
    ] );

    $wp_customize->add_section( 'header_side_setting', [
        'title'       => esc_html__( 'Side Info', 'delishs' ),
        'description' => '',
        'priority'    => 14,
        'capability'  => 'edit_theme_options',
        'panel'       => 'delishs_customizer',
    ] );

    $wp_customize->add_section( 'breadcrumb_setting', [
        'title'       => esc_html__( 'Breadcrumb Setting', 'delishs' ),
        'description' => '',
        'priority'    => 15,
        'capability'  => 'edit_theme_options',
        'panel'       => 'delishs_customizer',
    ] );

    $wp_customize->add_section( 'blog_setting', [
        'title'       => esc_html__( 'Blog Setting', 'delishs' ),
        'description' => '',
        'priority'    => 16,
        'capability'  => 'edit_theme_options',
        'panel'       => 'delishs_customizer',
    ] );

    $wp_customize->add_section( 'footer_setting', [
        'title'       => esc_html__( 'Footer Settings', 'delishs' ),
        'description' => '',
        'priority'    => 16,
        'capability'  => 'edit_theme_options',
        'panel'       => 'delishs_customizer',
    ] );

    $wp_customize->add_section( 'color_setting', [
        'title'       => esc_html__( 'Color Setting', 'delishs' ),
        'description' => '',
        'priority'    => 17,
        'capability'  => 'edit_theme_options',
        'panel'       => 'delishs_customizer',
    ] );

    $wp_customize->add_section( '404_page', [
        'title'       => esc_html__( '404 Page', 'delishs' ),
        'description' => '',
        'priority'    => 18,
        'capability'  => 'edit_theme_options',
        'panel'       => 'delishs_customizer',
    ] );

    $wp_customize->add_section( 'typo_setting', [
        'title'       => esc_html__( 'Typography Setting', 'delishs' ),
        'description' => '',
        'priority'    => 21,
        'capability'  => 'edit_theme_options',
        'panel'       => 'delishs_customizer',
    ] );

}

add_action( 'customize_register', 'delishs_customizer_panels_sections' );

function _header_top_fields( $fields ) {

    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_topbar_switch',
        'label'    => esc_html__( 'Header Topbar', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ]; 

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_open_hour',
        'label'    => esc_html__( 'Office Hours', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( 'Mon-Wed: 11am-9pm', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_topbar_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_open_hour_two',
        'label'    => esc_html__( 'Office Hours Two', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( 'Mon-Wed: 11am-9pm', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_topbar_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_email_address',
        'label'    => esc_html__( 'Email Address', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( 'reservations@Delish.com', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_topbar_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_phone',
        'label'    => esc_html__( 'Phone', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( '123 456 7899', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_topbar_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_phone_link',
        'label'    => esc_html__( 'Phone Link', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( '+1234567899', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_topbar_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_address',
        'label'    => esc_html__( 'Address', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( '296 Ridao Avenie Mor Berlin 251584', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_topbar_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_address_link',
        'label'    => esc_html__( 'Address URL', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( 'https://maps.app.goo.gl/V5BeTXNv6WAniBN58', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_topbar_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_preloader',
        'label'    => esc_html__( 'Preloader On/Off', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_preloader_text',
        'label'    => esc_html__( 'Preloader Text', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( 'Loading...', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_preloader',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_backtotop',
        'label'    => esc_html__( 'Back To Top On/Off', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => '1',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];  

    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_header_lang',
        'label'    => esc_html__( 'Header Languages', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_header_right',
        'label'    => esc_html__( 'Header Right On/Off', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_find_store',
        'label'    => esc_html__( 'Find a Store', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( 'Find a Store', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_find_store_link',
        'label'    => esc_html__( 'Find a Store URL', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( '#', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_order_tracking',
        'label'    => esc_html__( 'Order Tracking', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( 'Order Tracking', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_order_tracking_link',
        'label'    => esc_html__( 'Order Tracking URL', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( '#', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_header_user',
        'label'    => esc_html__( 'User URL', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( '#', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_header_wishlist',
        'label'    => esc_html__( 'Wishlist URL', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( '#', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_header_cart',
        'label'    => esc_html__( 'Cart URL', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( '#', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];
    
    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_header_search',
        'label'    => esc_html__( 'Header Search On/Off', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_header_button_switch',
        'label'    => esc_html__( 'Header Button On/Off', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    // Contact button
    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_header_button_text',
        'label'    => esc_html__( 'Header Button', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( 'Book A Table', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'delishs_header_button_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'link',
        'settings' => 'delishs_header_button_link',
        'label'    => esc_html__( 'Header Button URL', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => esc_html__( '#', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'delishs_header_button_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];
    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_header_button_text_two',
        'label'    => esc_html__( 'Header Button Two', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => __( 'Order Online', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'delishs_header_button_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'link',
        'settings' => 'delishs_header_button_link_two',
        'label'    => esc_html__( 'Header Button Two URL', 'delishs' ),
        'section'  => 'header_top_setting',
        'default'  => esc_html__( '#', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_header_right',
                'operator' => '==',
                'value'    => true,
            ],
            [
                'setting'  => 'delishs_header_button_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    return $fields;

}
add_filter( 'kirki/fields', '_header_top_fields' );

/*
Header Social
 */
function _header_social_fields( $fields ) {
    // header section social
    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_topbar_fb_url',
        'label'    => esc_html__( 'Facebook Url', 'delishs' ),
        'section'  => 'header_social',
        'default'  => esc_html__( '#', 'delishs' ),
        'priority' => 10,
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_topbar_twitter_url',
        'label'    => esc_html__( 'Twitter Url', 'delishs' ),
        'section'  => 'header_social',
        'default'  => esc_html__( '#', 'delishs' ),
        'priority' => 10,
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_topbar_instagram_url',
        'label'    => esc_html__( 'Instagram Url', 'delishs' ),
        'section'  => 'header_social',
        'default'  => esc_html__( '#', 'delishs' ),
        'priority' => 10,
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_topbar_pinterest_url',
        'label'    => esc_html__( 'Pinterest Url', 'delishs' ),
        'section'  => 'header_social',
        'default'  => esc_html__( '#', 'delishs' ),
        'priority' => 10,
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_topbar_linkedin_url',
        'label'    => esc_html__( 'Linkedin Url', 'delishs' ),
        'section'  => 'header_social',
        'default'  => esc_html__( '#', 'delishs' ),
        'priority' => 10,
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_topbar_youtube_url',
        'label'    => esc_html__( 'Youtube Url', 'delishs' ),
        'section'  => 'header_social',
        'default'  => esc_html__( '#', 'delishs' ),
        'priority' => 10,
    ];

    return $fields;
}
add_filter( 'kirki/fields', '_header_social_fields' );

/*
Header Settings
 */
function _header_header_fields( $fields ) {
    $fields[] = [
        'type'     => 'switch',
        'settings' => 'header_elementor_switch',
        'label'    => esc_html__( 'Header Custom/Elementor Switch', 'delishs' ),
        'section'  => 'section_header_logo',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'        => 'radio-image',
        'settings'    => 'choose_default_header',
        'label'       => esc_html__( 'Select Header Style', 'delishs' ),
        'section'     => 'section_header_logo',
        'placeholder' => esc_html__( 'Select an option...', 'delishs' ),
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => [
            'header-style-1'   => get_template_directory_uri() . '/inc/img/header/header-1.png',
            'header-style-2'   => get_template_directory_uri() . '/inc/img/header/header-2.png',
            'header-style-3'   => get_template_directory_uri() . '/inc/img/header/header-3.png',
        ],
        'default'     => 'header-style-1',
        'active_callback' => [
            [
                'setting' => 'header_elementor_switch',
                'operator' => '==',
                'value' => false
            ]
        ],
    ];

    $header_post_type = array(
        'post_type'      => 'delishs-header'
    );
    $header_post_type_loop = get_posts($header_post_type);
    $header_post_obj_arr = array();
    foreach($header_post_type_loop as $post){
        $header_post_obj_arr[$post->ID] = $post->post_title;
    }
    $fields[] = [
        'type'        => 'select',
        'settings'    => 'header_templates',
        'label'       => esc_html__( 'Select Header Style', 'delishs' ),
        'section'     => 'section_header_logo',
        'placeholder' => esc_html__( 'Choose an option', 'delishs' ),
        'choices'     => $header_post_obj_arr,
        'active_callback' => [
            [
                'setting' => 'header_elementor_switch',
                'operator' => '==',
                'value' => true
            ]
        ],
    ];

    $fields[] = [
        'type'        => 'image',
        'settings'    => 'logo',
        'label'       => esc_html__( 'Header Logo', 'delishs' ),
        'description' => esc_html__( 'Upload Your Logo.', 'delishs' ),
        'section'     => 'section_header_logo',
        'default'     => get_template_directory_uri() . '/assets/imgs/logo/logo.png',
    ];

    $fields[] = [
        'type'        => 'image',
        'settings'    => 'secondary_logo',
        'label'       => esc_html__( 'Header Secondary Logo', 'delishs' ),
        'description' => esc_html__( 'Header Logo Black', 'delishs' ),
        'section'     => 'section_header_logo',
        'default'     => get_template_directory_uri() . '/assets/imgs/logo/logo-white.png',
    ];

    $fields[] = [
        'type'        => 'image',
        'settings'    => 'third_logo',
        'label'       => esc_html__( 'Header Secondary Logo', 'delishs' ),
        'description' => esc_html__( 'Header Logo Black', 'delishs' ),
        'section'     => 'section_header_logo',
        'default'     => get_template_directory_uri() . '/assets/imgs/logo/logo-white-2.png',
    ];

    $fields[] = [
        'type'        => 'slider',
        'settings'    => 'logo_size',
        'label'       => esc_html__('Header Logo Size', 'delishs'),
        'description' => esc_html__('Header Logo Size', 'delishs'),
        'section'     => 'section_header_logo',
        'default' => '170px',
        'choices'     => [
            'min'  => 100,
            'max'  => 600,
            'step' => 4,
        ],
    ];

    return $fields;
}
add_filter( 'kirki/fields', '_header_header_fields' );

/*
Header Side Info
 */
function _header_side_fields( $fields ) {
    $fields[] = [
        'type'        => 'image',
        'settings'    => 'delishs_side_logo',
        'label'       => esc_html__( 'Logo Side', 'delishs' ),
        'description' => esc_html__( 'Logo Side', 'delishs' ),
        'section'     => 'header_side_setting',
        'default'     => get_template_directory_uri() . '/assets/imgs/logo/logo.png',
    ];
    
    // side info settings
    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_side_hide',
        'label'    => esc_html__( 'Side Info On/Off', 'delishs' ),
        'section'  => 'header_side_setting',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];
    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_side_about_heading',
        'label'    => esc_html__( 'Sidebar About headeing', 'delishs' ),
        'section'  => 'header_side_setting',
        'default'  => esc_html__( 'About Us', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_side_hide',
                'operator' => '==',
                'value'    => true,
            ]
        ],
    ];
    $fields[] = [
        'type'     => 'textarea',
        'settings' => 'delishs_side_about_description',
        'label'    => esc_html__( 'Sidebar About Description', 'delishs' ),
        'section'  => 'header_side_setting',
        'default'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud nisi ut aliquip ex ea commodo consequat.', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_side_hide',
                'operator' => '==',
                'value'    => '1',
            ]
        ],
    ];
    // contact button
    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_order_button_text',
        'label'    => esc_html__( 'Order Button Text', 'delishs' ),
        'section'  => 'header_side_setting',
        'default'  => esc_html__( 'Order Now', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_side_hide',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];
    $fields[] = [
        'type'     => 'link',
        'settings' => 'delishs_order_button_link',
        'label'    => esc_html__( 'Order Button URL', 'delishs' ),
        'section'  => 'header_side_setting',
        'default'  => esc_html__( '#', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_side_hide',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];
    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_book_table_button_text',
        'label'    => esc_html__( 'Booking Button Text', 'delishs' ),
        'section'  => 'header_side_setting',
        'default'  => esc_html__( 'Order Now', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_side_hide',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];
    $fields[] = [
        'type'     => 'link',
        'settings' => 'delishs_book_table_button_link',
        'label'    => esc_html__( 'Booking Button URL', 'delishs' ),
        'section'  => 'header_side_setting',
        'default'  => esc_html__( '#', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_side_hide',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];
    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_purchase_button_text',
        'label'    => esc_html__( 'Purchase Button Text', 'delishs' ),
        'section'  => 'header_side_setting',
        'default'  => esc_html__( 'Order Now', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_side_hide',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];
    $fields[] = [
        'type'     => 'link',
        'settings' => 'delishs_purchase_button_link',
        'label'    => esc_html__( 'Purchase Button URL', 'delishs' ),
        'section'  => 'header_side_setting',
        'default'  => esc_html__( '#', 'delishs' ),
        'priority' => 10,
        'active_callback' => [
            [
                'setting'  => 'delishs_side_hide',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];
    
    return $fields;
}
add_filter( 'kirki/fields', '_header_side_fields' );

/*
_header_page_title_fields
 */
function _header_page_title_fields( $fields ) {
    // Breadcrumb Setting
    $fields[] = [
        'type'     => 'switch',
        'settings' => 'breadcrumb_switch',
        'label'    => esc_html__( 'Breadcrumb Hide', 'delishs' ),
        'section'  => 'breadcrumb_setting',
        'default'  => '1',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];
    $fields[] = [
        'type'        => 'image',
        'settings'    => 'breadcrumb_bg_img',
        'label'       => esc_html__( 'Breadcrumb Background Image', 'delishs' ),
        'description' => esc_html__( 'Breadcrumb Background Image', 'delishs' ),
        'section'     => 'breadcrumb_setting',
        'default'     => get_template_directory_uri() . '/assets/imgs/breadcrumb/page-header-1.jpg',
        'active_callback' => [
            [
                'setting'  => 'breadcrumb_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_breadcrumb_bg_color',
        'label'       => __( 'Breadcrumb BG Color', 'delishs' ),
        'description' => esc_html__( 'This is a Breadcrumb bg color control.', 'delishs' ),
        'section'     => 'breadcrumb_setting',
        'default'     => '#0A0A0A',
        'priority'    => 10,
        'active_callback' => [
            [
                'setting'  => 'breadcrumb_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $fields[] = [
        'type'     => 'switch',
        'settings' => 'breadcrumb_info_switch',
        'label'    => esc_html__( 'Breadcrumb Info switch', 'delishs' ),
        'section'  => 'breadcrumb_setting',
        'default'  => '1',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
        'active_callback' => [
            [
                'setting'  => 'breadcrumb_switch',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    return $fields;
}
add_filter( 'kirki/fields', '_header_page_title_fields' );

/*
Header Social
 */
function _header_blog_fields( $fields ) {
// Blog Setting
    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_blog_btn_switch',
        'label'    => esc_html__( 'Blog BTN On/Off', 'delishs' ),
        'section'  => 'blog_setting',
        'default'  => '1',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_blog_cat',
        'label'    => esc_html__( 'Blog Category Meta On/Off', 'delishs' ),
        'section'  => 'blog_setting',
        'default'  => '1',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_blog_author',
        'label'    => esc_html__( 'Blog Author Meta On/Off', 'delishs' ),
        'section'  => 'blog_setting',
        'default'  => '1',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];
    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_blog_date',
        'label'    => esc_html__( 'Blog Date Meta On/Off', 'delishs' ),
        'section'  => 'blog_setting',
        'default'  => '1',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];
    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_blog_comments',
        'label'    => esc_html__( 'Blog Comments Meta On/Off', 'delishs' ),
        'section'  => 'blog_setting',
        'default'  => '1',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_blog_btn',
        'label'    => esc_html__( 'Blog Button text', 'delishs' ),
        'section'  => 'blog_setting',
        'default'  => esc_html__( 'Read More', 'delishs' ),
        'priority' => 10,
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'breadcrumb_blog_title',
        'label'    => esc_html__( 'Blog Title', 'delishs' ),
        'section'  => 'blog_setting',
        'default'  => esc_html__( 'Blog', 'delishs' ),
        'priority' => 10,
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'breadcrumb_blog_title_details',
        'label'    => esc_html__( 'Blog Details Title', 'delishs' ),
        'section'  => 'blog_setting',
        'default'  => esc_html__( 'Blog Details', 'delishs' ),
        'priority' => 10,
    ];
    return $fields;
}
add_filter( 'kirki/fields', '_header_blog_fields' );

/*
Footer
 */
function _header_footer_fields( $fields ) {
    $fields[] = [
        'type'     => 'switch',
        'settings' => 'footer_elementor_switch',
        'label'    => esc_html__( 'Footer Custom/Elementor Switch', 'delishs' ),
        'section'  => 'footer_setting',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'        => 'radio-image',
        'settings'    => 'choose_default_footer',
        'label'       => esc_html__( 'Choose Footer Style', 'delishs' ),
        'section'     => 'footer_setting',
        'default'     => '5',
        'placeholder' => esc_html__( 'Select an option...', 'delishs' ),
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => [
            'footer-style-1'   => get_template_directory_uri() . '/inc/img/footer/footer-1.png',
            'footer-style-2'   => get_template_directory_uri() . '/inc/img/footer/footer-2.png',
        ],
        'default'     => 'footer-style-1',
        'active_callback' => [
            [
                'setting' => 'footer_elementor_switch',
                'operator' => '==',
                'value' => false
            ]
        ],
    ];

    $footer_post_type = array(
        'post_type'      => 'delishs-footer'
    );
    $footer_post_type_loop = get_posts($footer_post_type);
    $footer_post_obj_arr = array();
    foreach($footer_post_type_loop as $post){
        $footer_post_obj_arr[$post->ID] = $post->post_title;
    }
    $fields[] = [
        'type'        => 'select',
        'settings'    => 'footer_templates',
        'label'       => esc_html__( 'Select Footer Style', 'delishs' ),
        'section'     => 'footer_setting',
        'placeholder' => esc_html__( 'Choose an option', 'delishs' ),
        'choices'     => $footer_post_obj_arr,
        'active_callback' => [
            [
                'setting' => 'footer_elementor_switch',
                'operator' => '==',
                'value' => true
            ]
        ],
    ];

    $fields[] = [
        'type'        => 'select',
        'settings'    => 'footer_widget_number',
        'label'       => esc_html__( 'Widget Number', 'delishs' ),
        'section'     => 'footer_setting',
        'default'     => '4',
        'placeholder' => esc_html__( 'Select an option...', 'delishs' ),
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => [
            '4' => esc_html__( 'Widget Number 4', 'delishs' ),
            '3' => esc_html__( 'Widget Number 3', 'delishs' ),
            '2' => esc_html__( 'Widget Number 2', 'delishs' ),
            '1' => esc_html__( 'Widget Number 1', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_footer_bg_color',
        'label'       => __( 'Footer BG Color', 'delishs' ),
        'description' => esc_html__( 'This is a Footer bg color control.', 'delishs' ),
        'section'     => 'footer_setting',
        'default'     => '#11151c',
        'priority'    => 10,
        'choices'     => [
			'alpha' => true,
		],
        'output' => array(
            array(
                'element'  => '.footer-overlay-common::before',
                'property' => 'background-color',
            ),
        ),
    ];
    
    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_footer_shape_switch',
        'label'    => esc_html__( 'Footer Shape On/Off', 'delishs' ),
        'section'  => 'footer_setting',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'     => 'switch',
        'settings' => 'footer_style_2_switch',
        'label'    => esc_html__( 'Footer Style 2 On/Off', 'delishs' ),
        'section'  => 'footer_setting',
        'default'  => '1',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_copyright',
        'label'    => esc_html__( 'Copyright', 'delishs' ),
        'section'  => 'footer_setting',
        'default'  => esc_html__( 'Copyright ©2024 Delishs. All Rights Reserved.', 'delishs' ),
        'priority' => 10,
    ];
    
    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_footer_bottom_menu',
        'label'    => esc_html__( 'Footer Bottom Menu On/Off', 'delishs' ),
        'section'  => 'footer_setting',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];
      
    return $fields;
}
add_filter( 'kirki/fields', '_header_footer_fields' );

// color
function delishs_color_fields( $fields ) {
    // Color Settings
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_color_option_prim',
        'label'       => __( 'Primary Color', 'delishs' ),
        'description' => __( 'Site main color.', 'delishs' ),
        'section'     => 'color_setting',
        'default'     => '#3F5AF3',
        'priority'    => 10,
    ];
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_color_option_sec',
        'label'       => __( 'Secondary Color', 'delishs' ),
        'description' => __( 'Site secondary color.', 'delishs' ),
        'section'     => 'color_setting',
        'default'     => '#ffc226',
        'priority'    => 10,
    ];
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_color_option_body',
        'label'       => __( 'Body Color', 'delishs' ),
        'description' => __( 'Site body color.', 'delishs' ),
        'section'     => 'color_setting',
        'default'     => '#B0B2B7',
        'priority'    => 10,
    ];
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_color_option_heading',
        'label'       => __( 'Heading Color', 'delishs' ),
        'description' => __( 'Site heading color.', 'delishs' ),
        'section'     => 'color_setting',
        'default'     => '#171717',
        'priority'    => 10,
    ];
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_color_option_white',
        'label'       => __( 'White Color', 'delishs' ),
        'description' => __( 'Site white color.', 'delishs' ),
        'section'     => 'color_setting',
        'default'     => '#ffffff',
        'priority'    => 10,
    ];
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_color_option_black',
        'label'       => __( 'Black Color', 'delishs' ),
        'description' => __( 'Site black color.', 'delishs' ),
        'section'     => 'color_setting',
        'default'     => '#000000',
        'priority'    => 10,
    ];
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_color_option_dark',
        'label'       => __( 'Pink Color', 'delishs' ),
        'description' => __( 'Site pink color.', 'delishs' ),
        'section'     => 'color_setting',
        'default'     => '#232323',
        'priority'    => 10,
    ];
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_color_option_theme_bg',
        'label'       => __( 'Theme BG Color', 'delishs' ),
        'description' => __( 'Site theme bg color.', 'delishs' ),
        'section'     => 'color_setting',
        'default'     => '#11151C',
        'priority'    => 10,
    ];
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_color_option_grey_1',
        'label'       => __( 'Grey 1 Color', 'delishs' ),
        'description' => __( 'Site grey 1 color.', 'delishs' ),
        'section'     => 'color_setting',
        'default'     => '#F8F8F8',
        'priority'    => 10,
    ];
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_color_option_grey_2',
        'label'       => __( 'Grey 2 Color', 'delishs' ),
        'description' => __( 'Site grey 2 color.', 'delishs' ),
        'section'     => 'color_setting',
        'default'     => '#2D343E',
        'priority'    => 10,
    ];
    $fields[] = [
        'type'        => 'color',
        'settings'    => 'delishs_color_option_border_1',
        'label'       => __( 'Border 1 Color', 'delishs' ),
        'description' => __( 'Site border 1 color.', 'delishs' ),
        'section'     => 'color_setting',
        'default'     => '#1E2228',
        'priority'    => 10,
    ];

    

    $fields[] = [
        'type'     => 'switch',
        'settings' => 'delishs_theme_toggle',
        'label'    => esc_html__( 'Dark/Light Mode Frontend Switch', 'delishs' ),
        'section'  => 'color_setting',
        'default'  => '0',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'delishs' ),
            'off' => esc_html__( 'Disable', 'delishs' ),
        ],
    ];

    $fields[] = [
        'type'        => 'select',
        'settings'    => 'delishs_color_mode',
		'label'       => esc_html__( 'Theme Color Mode', 'delishs' ),
		'section'     => 'color_setting',
		'default'     => 'dark',
		'choices'     => [
			'dark' => esc_html__( 'Dark', 'delishs' ),
			'light' => esc_html__( 'Light', 'delishs' ),
		],
        'active_callback' => [
            [
                'setting'  => 'delishs_theme_toggle',
                'operator' => '==',
                'value'    => false,
            ],
        ],
    ];

    return $fields;
}
add_filter( 'kirki/fields', 'delishs_color_fields' );

// 404
function delishs_404_fields( $fields ) {
    // 404 settings
    $fields[] = [
        'type'        => 'image',
        'settings'    => 'delishs_error_image',
        'label'       => esc_html__( '404 Image', 'delishs' ),
        'description' => esc_html__( '404 Image', 'delishs' ),
        'section'     => '404_page',
        'default'     => get_template_directory_uri() . '/assets/imgs/404/404.png',
    ];
    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_error_title',
        'label'    => esc_html__( 'Page can’t be found', 'delishs' ),
        'section'  => '404_page',
        'default'  => __( 'Page Not Found', 'delishs' ),
        'priority' => 10,
    ];
    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_error_description',
        'label'    => esc_html__( '404 description', 'delishs' ),
        'section'  => '404_page',
        'default'  => __( 'Sorry, we couldnt find the page you where looking for. We suggest that you return to homepage.', 'delishs' ),
        'priority' => 10,
    ];
    $fields[] = [
        'type'     => 'text',
        'settings' => 'delishs_error_link_text',
        'label'    => esc_html__( '404 Link Text', 'delishs' ),
        'section'  => '404_page',
        'default'  => esc_html__( 'Go Back to Home', 'delishs' ),
        'priority' => 10,
    ];
    return $fields;
}
add_filter( 'kirki/fields', 'delishs_404_fields' );

/**
 * Added Fields
 */
function delishs_typo_fields( $fields ) {
    // typography settings
    $fields[] = [
        'type'        => 'typography',
        'settings'    => 'typography_body_setting',
        'label'       => esc_html__( 'Body Font', 'delishs' ),
        'section'     => 'typo_setting',
        'default'     => [
            'font-family'    => '',
            'variant'        => '',
            'font-size'      => '',
            'line-height'    => '',
            'letter-spacing' => '0',
            'color'          => '',
        ],
        'priority'    => 10,
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => 'body',
            ],
        ],
    ];

    $fields[] = [
        'type'        => 'typography',
        'settings'    => 'typography_h_setting',
        'label'       => esc_html__( 'Heading h1 Fonts', 'delishs' ),
        'section'     => 'typo_setting',
        'default'     => [
            'font-family'    => '',
            'variant'        => '',
            'font-size'      => '',
            'line-height'    => '',
            'letter-spacing' => '0',
            'color'          => '',
        ],
        'priority'    => 10,
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => 'h1',
            ],
        ],
    ];

    $fields[] = [
        'type'        => 'typography',
        'settings'    => 'typography_h2_setting',
        'label'       => esc_html__( 'Heading h2 Fonts', 'delishs' ),
        'section'     => 'typo_setting',
        'default'     => [
            'font-family'    => '',
            'variant'        => '',
            'font-size'      => '',
            'line-height'    => '',
            'letter-spacing' => '0',
            'color'          => '',
        ],
        'priority'    => 10,
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => 'h2',
            ],
        ],
    ];

    $fields[] = [
        'type'        => 'typography',
        'settings'    => 'typography_h3_setting',
        'label'       => esc_html__( 'Heading h3 Fonts', 'delishs' ),
        'section'     => 'typo_setting',
        'default'     => [
            'font-family'    => '',
            'variant'        => '',
            'font-size'      => '',
            'line-height'    => '',
            'letter-spacing' => '0',
            'color'          => '',
        ],
        'priority'    => 10,
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => 'h3',
            ],
        ],
    ];

    $fields[] = [
        'type'        => 'typography',
        'settings'    => 'typography_h4_setting',
        'label'       => esc_html__( 'Heading h4 Fonts', 'delishs' ),
        'section'     => 'typo_setting',
        'default'     => [
            'font-family'    => '',
            'variant'        => '',
            'font-size'      => '',
            'line-height'    => '',
            'letter-spacing' => '0',
            'color'          => '',
        ],
        'priority'    => 10,
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => 'h4',
            ],
        ],
    ];

    $fields[] = [
        'type'        => 'typography',
        'settings'    => 'typography_h5_setting',
        'label'       => esc_html__( 'Heading h5 Fonts', 'delishs' ),
        'section'     => 'typo_setting',
        'default'     => [
            'font-family'    => '',
            'variant'        => '',
            'font-size'      => '',
            'line-height'    => '',
            'letter-spacing' => '0',
            'color'          => '',
        ],
        'priority'    => 10,
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => 'h5',
            ],
        ],
    ];

    $fields[] = [
        'type'        => 'typography',
        'settings'    => 'typography_h6_setting',
        'label'       => esc_html__( 'Heading h6 Fonts', 'delishs' ),
        'section'     => 'typo_setting',
        'default'     => [
            'font-family'    => '',
            'variant'        => '',
            'font-size'      => '',
            'line-height'    => '',
            'letter-spacing' => '0',
            'color'          => '',
        ],
        'priority'    => 10,
        'transport'   => 'auto',
        'output'      => [
            [
                'element' => 'h6',
            ],
        ],
    ];
    return $fields;
}

add_filter( 'kirki/fields', 'delishs_typo_fields' );

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
function delishs_THEME_option( $name ) {
    $value = '';
    if ( class_exists( 'delishs' ) ) {
        $value = Kirki::get_option( delishs_get_theme(), $name );
    }

    return apply_filters( 'delishs_THEME_option', $value, $name );
}

/**
 * Get config ID
 *
 * @return string
 */
function delishs_get_theme() {
    return 'delishs';
}