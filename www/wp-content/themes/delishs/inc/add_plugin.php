<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme madison for publication on ThemeForest
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

add_action( 'tgmpa_register', 'delishs_register_required_plugins' );

function delishs_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    
    $plugins = [
        [
            'name'     => esc_html__( 'Elementor Page Builder', 'delishs' ),
            'slug'     => 'elementor',
            'required' => true,
        ],
        [
            'name'         => esc_html__( 'Delishs Core', 'delishs' ),
            'slug'         => 'delishs-core',
            'source'	   => DELISHS_THEME_INC . '/plugins/delishs-core.zip',
            'required'     => true,
        ],
        [
            'name'         => esc_html__( 'Advanced Custom Fields Pro', 'delishs' ),
            'slug'         => 'advanced-custom-fields-pro',
            'source'	   => DELISHS_THEME_INC . '/plugins/advanced-custom-fields-pro.zip',
            'required'     => true,
        ],
        [
            'name'     => esc_html__( 'WP Classic Editor', 'delishs' ),
            'slug'     => 'classic-editor',
            'required' => false,
        ],
        [
            'name'     => esc_html__( 'Contact Form 7', 'delishs' ),
            'slug'     => 'contact-form-7',
            'required' => false,
        ],
        [
            'name'     => esc_html__( 'One Click Demo Import', 'delishs' ),
            'slug'     => 'one-click-demo-import',
            'required' => false,
        ],
        array(
            'name'     =>  esc_html__('Kirki Customizer Framework','delishs'),
            'slug'     => 'kirki',
            'required' => false,
        ), 
        array(
            'name'     =>  esc_html__('Breadcrumb NavXT','delishs'),
            'slug'     => 'breadcrumb-navxt',
            'required' => false,
        ),
        array(
            'name'     =>  esc_html__('MC4WP: Mailchimp for WordPress','delishs'),
            'slug'     => 'mailchimp-for-wp',
            'required' => false,
        ),
        array(
            'name'     => esc_html__('WooCommerce','delishs'),
            'slug'     => 'woocommerce',
            'required' => false, 
        ), 
        array(
            'name'     => esc_html__('WPC Smart Quick View for WooCommerce','delishs'),
            'slug'     => 'woo-smart-quick-view',
            'required' => false, 
        ), 
        array(
            'name'     => esc_html__('TI WooCommerce Wishlist','delishs'),
            'slug'     => 'ti-woocommerce-wishlist',
            'required' => false, 
        ),
    ];
    $config = [
        'id'           => 'delishs', // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '', // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true, // Show admin notices or not.
        'dismissable'  => true, // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '', // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false, // Automatically activate plugins after installation or not.
        'message'      => '', // Message to output right before the plugins table.

        'strings'      => [
            'page_title'                      => esc_html__( 'Install Required Plugins', 'delishs' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'delishs' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'delishs' ),
            'updating'                        => esc_html__( 'Updating Plugin: %s', 'delishs' ),
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'delishs' ),
            'notice_can_install_required'     => _n_noop(
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.',
                'delishs'
            ),
            'notice_can_install_recommended'  => _n_noop(
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.',
                'delishs'
            ),
            'notice_ask_to_update'            => _n_noop(
                'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                'delishs'
            ),
            'notice_ask_to_update_maybe'      => _n_noop(
                'There is an update available for: %1$s.',
                'There are updates available for the following plugins: %1$s.',
                'delishs'
            ),
            'notice_can_activate_required'    => _n_noop(
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'delishs'
            ),
            'notice_can_activate_recommended' => _n_noop(
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.',
                'delishs'
            ),
            'install_link'                    => _n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'delishs'
            ),
            'update_link'                     => _n_noop(
                'Begin updating plugin',
                'Begin updating plugins',
                'delishs'
            ),
            'activate_link'                   => _n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'delishs'
            ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'delishs' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'delishs' ),
            'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'delishs' ),
            'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'delishs' ),
            'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'delishs' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'delishs' ),
            'dismiss'                         => esc_html__( 'Dismiss this notice', 'delishs' ),
            'notice_cannot_install_activate'  => esc_html__( 'There are one or more required or recommended plugins to install, update or activate.', 'delishs' ),
            'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'delishs' ),
            'nag_type'                        => '',
        ],
    ];
    tgmpa( $plugins, $config );
}
