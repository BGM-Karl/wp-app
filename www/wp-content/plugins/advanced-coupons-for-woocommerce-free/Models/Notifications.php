<?php
namespace ACFWF\Models;

use ACFWF\Abstracts\Abstract_Main_Plugin_Class;
use ACFWF\Abstracts\Base_Model;
use ACFWF\Helpers\Helper_Functions;
use ACFWF\Helpers\Plugin_Constants;
use ACFWF\Interfaces\Activatable_Interface;
use ACFWF\Interfaces\Initializable_Interface;
use ACFWF\Interfaces\Model_Interface;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Model that houses the logic of the Notifications module.
 *
 * @since 4.6.2
 */
class Notifications extends Base_Model implements Model_Interface, Initializable_Interface, Activatable_Interface {
    /*
    |--------------------------------------------------------------------------
    | Class Properties
    |--------------------------------------------------------------------------
     */

    /*
    |--------------------------------------------------------------------------
    | Class Methods
    |--------------------------------------------------------------------------
     */

    /**
     * Class constructor.
     *
     * @since 4.6.2
     * @access public
     *
     * @param Abstract_Main_Plugin_Class $main_plugin      Main plugin object.
     * @param Plugin_Constants           $constants        Plugin constants object.
     * @param Helper_Functions           $helper_functions Helper functions object.
     */
    public function __construct( Abstract_Main_Plugin_Class $main_plugin, Plugin_Constants $constants, Helper_Functions $helper_functions ) {
        parent::__construct( $main_plugin, $constants, $helper_functions );
        $main_plugin->add_to_all_plugin_models( $this );
        $main_plugin->add_to_public_models( $this );
    }

    /**
     * Retrieves all admin notifications.
     *
     * @since 4.6.2
     * @access public
     *
     * @param array $notices Array of existing notices.
     * @return array Array of admin notifications.
     */
    public function get_all_admin_notifications( $notices ) {
        // Get WC Notes.
        $data_store  = \WC_Data_Store::load( 'admin-note' );
        $query_args  = array(
            'source'     => array( 'advancedcouponsplugin.com' ),
            'per_page'   => 100,
            'is_deleted' => 0,
        );
        $admin_notes = $data_store->get_notes( $query_args );

        // Parsing to ACFW Notes.
        foreach ( $admin_notes as $admin_note ) {
            $note         = $this->_helper_functions->wc_admin_note( $admin_note->note_id );
            $note_actions = $note->get_actions();
            $actions      = array();

            foreach ( $note_actions as $note_action ) {
                $actions[] = array(
                    'key'         => 'primary',
                    'link'        => $note_action->query,
                    'text'        => $note_action->label,
                    'is_external' => true,
                );
            }

            $data = array(
                'slug'                    => $note->get_name(),
                'id'                      => $note->get_id(),
                'is_dismissable'          => true,
                'is_in_app_notifications' => true,
                'type'                    => $note->get_type(),
                'heading'                 => $note->get_title(),
                'content'                 => array( $note->get_content() ),
                'actions'                 => $actions,
                'hide_action_dismiss'     => true,
                'nonce'                   => wp_create_nonce( 'acfw_dismiss_notice_' . $note->get_name() ),
            );

            $notices[ $note->get_name() ] = $data;
        }

        return $notices;
    }

    /**
     * Update on dismiss notice.
     *
     * @since 4.6.2
     * @access public
     *
     * @param string $notice_key Notice key.
     * @param string $response   Notice response.
     */
    public function update_on_notice_dismiss( $notice_key, $response ) {
        $data_store = \WC_Data_Store::load( 'admin-note' );
        $note_ids   = $data_store->get_notes_with_name( $notice_key );
        if ( empty( $note_ids ) ) {
            return;
        }

        $note = $this->_helper_functions->wc_admin_note( $note_ids[0] );
        $note->set_is_deleted( 1 );
        $note->save();
    }

    /**
     * Method to schedule notifications event.
     *
     * @since  4.6.2
     * @access private
     */
    public function _schedule_notifications_event() {
        if ( \WC()->queue()->get_next( Plugin_Constants::NOTIFICATIONS_SCHEDULE_HOOK, array(), Plugin_Constants::NOTIFICATIONS_SCHEDULE_HOOK ) instanceof \WC_DateTime ) {
            return;
        }

        // Schedule notifications daily.
        \WC()->queue()->schedule_recurring(
            strtotime( 'tomorrow midnight' ), // Schedule to start at midnight tomorrow.
            DAY_IN_SECONDS,
            Plugin_Constants::NOTIFICATIONS_SCHEDULE_HOOK,
            array(),
            Plugin_Constants::NOTIFICATIONS_SCHEDULE_HOOK
        );
    }

    /**
     * Implement notifications.
     *
     * @since  4.6.2
     * @access public
     */
    public function implement_notifications() {
        $notifications = $this->fetch_notifications();

        if ( ! $notifications ) {
            return false;
        }

        // Filter existing notifications.
        $existing_notifications = $this->filter_existing_notifications( $notifications );

        // Filter notifications based on conditions.
        $filtered_notifications = $this->filter_notifications_conditions( $existing_notifications );

        if ( empty( $filtered_notifications ) ) {
            return; // No notifications pass the conditions.
        }

        // Save filtered notifications.
        $this->save_notifications( $filtered_notifications );
    }

    /**
     * Fetch the notifications from server.
     *
     * @since  4.6.2
     * @access public
     *
     * @return mixed|false The decoded json string of notification settings in case success; False Otherwise.
     */
    public function fetch_notifications() {
        $path = '/notifications/notifications.' . $this->_get_notifications_environment() . '.json';
        $data = wp_remote_get( $this->_get_notifications_server_base() . $path );

        if ( is_wp_error( $data ) ) {
            return $data;
        }

        $notifications = json_decode( wp_remote_retrieve_body( $data ) ?? '[]', true );

        return $notifications;
    }

    /**
     * Filter out existing notices from the database.
     *
     * @since  4.6.2
     * @access public
     *
     * @param array $notifications The array of notifications to filter.
     * @return array The filtered array of new notifications.
     */
    public function filter_existing_notifications( $notifications ) {
        global $wpdb;

        $new_notifications = array();

        foreach ( $notifications as $notification ) {
            $existing_notice = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}wc_admin_notes WHERE name = %s AND source = %s",
                    'acfw-notification-' . sanitize_text_field( $notification['id'] ),
                    'advancedcouponsplugin.com'
                )
            );

            if ( null === $existing_notice ) {
                $new_notifications[] = $notification;
            }
        }

        return $new_notifications;
    }

    /**
     * Filter notifications based on conditions before saving.
     *
     * @since  4.6.2
     * @access public
     *
     * @param array $notifications The array of notifications to filter.
     * @return array The filtered array of notifications.
     */
    public function filter_notifications_conditions( $notifications ) {
        $filtered_notifications = array();

        foreach ( $notifications as $notification ) {
            // Check if all targets are active.
            if ( ! isset( $notification['targets'] ) || ! is_array( $notification['targets'] ) ) {
                continue; // Skip if targets are not provided or not an array.
            }

            if ( ! $this->_check_targets_active( $notification['targets'] ) ) {
                continue; // Skip if any target is not active.
            }

            // Check if schedule is valid.
            $schedule_valid   = true;
            $current_timezone = new \DateTimeZone( $this->_helper_functions->get_site_current_timezone() );
            $now              = new \WC_DateTime( 'now', $current_timezone );

            if ( null !== $notification['start_date'] ) {
                $start_time = new \WC_DateTime( $notification['start_date'], $current_timezone );
                if ( $now < $start_time ) {
                    $schedule_valid = false;
                }
            }

            if ( null !== $notification['end_date'] ) {
                $end_time = new \WC_DateTime( $notification['end_date'], $current_timezone );
                if ( $now > $end_time ) {
                    $schedule_valid = false;
                }
            }

            // Check if trigger conditions are met.
            $trigger_met = $this->_check_trigger_conditions( $notification );

            // Add notification to filtered list if all conditions are met.
            if ( $schedule_valid && $trigger_met ) {
                $filtered_notifications[] = $notification;
            }
        }

        return $filtered_notifications;
    }

    /**
     * Save notifications to the database.
     *
     * @since  4.6.2
     * @access public
     *
     * @param array $notifications The array of notifications to save.
     * @return void
     */
    public function save_notifications( $notifications ) {
        foreach ( $notifications as $notification ) {
            $name = 'acfw-notification-' . sanitize_text_field( $notification['id'] );

            $data_store = \WC_Data_Store::load( 'admin-note' );
            $note_ids   = $data_store->get_notes_with_name( $name );
            if ( ! empty( $note_ids ) ) {
                return;
            }

            // create admin note instance.
            $note = $this->_helper_functions->wc_admin_note();

            $note->set_title( $notification['title'] );
            $note->set_content( $notification['content'] );
            $note->set_name( $name );
            $note->set_content_data( (object) array() );
            $note->set_source( 'advancedcouponsplugin.com' );

            foreach ( $notification['buttons'] as $button ) {
                $button_name = 'acfw-notification-action-' . sanitize_text_field( $notification['id'] );
                $note->add_action( $button_name, $button['button_text'], $button['button_url'], 'unactioned' );
            }

            $note->save();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX methods
    |--------------------------------------------------------------------------
     */

    /**
     * AJAX read admin notice.
     *
     * @since 4.6.2
     * @access public
     */
    public function ajax_read_admin_notice() {
        $notice_key = isset( $_REQUEST['notice'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['notice'] ) ) : '';

        if ( defined( 'DOING_AJAX' )
            && DOING_AJAX
            && current_user_can( 'manage_options' )
            && $notice_key
            && isset( $_REQUEST['nonce'] )
            && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'acfw_dismiss_notice_' . $notice_key )
        ) {
            $data_store = \WC_Data_Store::load( 'admin-note' );
            $note_ids   = $data_store->get_notes_with_name( $notice_key );
            if ( empty( $note_ids ) ) {
                return;
            }

            $note = $this->_helper_functions->wc_admin_note( $note_ids[0] );
            $note->set_is_read( 1 );
            $note->save();
        }

        wp_die();
    }

    /*
    |--------------------------------------------------------------------------
    | Utilities
    |--------------------------------------------------------------------------
     */

    /**
     * Check if the targets specified in the notification are active.
     *
     * @since  4.6.2
     * @access private
     *
     * @param array $targets The array of targets specified in the notification.
     * @return bool True if all targets are active, false otherwise.
     */
    private function _check_targets_active( $targets ) {
        if ( ! is_array( $targets ) ) {
            return false;
        }

        // Loop through each target to check if it is active.
        foreach ( $targets as $target ) {
            switch ( $target ) {
                case 'everyone':
                    // Always return true if the target is 'everyone'.
                    return true;
                case 'acfwf_only':
                    // Check if the plugin advanced-coupons-for-woocommerce-free is active.
                    if ( is_plugin_active( 'advanced-coupons-for-woocommerce-free/advanced-coupons-for-woocommerce-free.php' ) ) {
                        return true;
                    }
                    break;
                case 'acfwf_is_active':
                    // Check if any instance of advanced-coupons-for-woocommerce-free is active.
                    if ( is_plugin_active( 'advanced-coupons-for-woocommerce-free/advanced-coupons-for-woocommerce-free.php' ) ) {
                        return true;
                    }
                    break;
                case 'acfwp_is_active':
                    // Check if any instance of advanced-coupons-for-woocommerce is active.
                    if ( is_plugin_active( 'advanced-coupons-for-woocommerce/advanced-coupons-for-woocommerce.php' ) ) {
                        return true;
                    }
                    break;
                case 'agc_is_active':
                    // Check if any instance of advanced-gift-cards-for-woocommerce-free is active.
                    if ( is_plugin_active( 'advanced-gift-cards-for-woocommerce-free/advanced-gift-cards-for-woocommerce.php' ) ) {
                        return true;
                    }
                    break;
                case 'all_premium_plugin_are_active':
                    // Check if both acfwp and agc are active.
                    if ( is_plugin_active( 'advanced-coupons-for-woocommerce/advanced-coupons-for-woocommerce.php' ) &&
                        is_plugin_active( 'advanced-gift-cards-for-woocommerce-free/advanced-gift-cards-for-woocommerce.php' ) ) {
                        return true;
                    }
                    break;
                default:
                    return false;
            }
        }

        return false;
    }

    /**
     * Check if trigger conditions are met for a notification.
     *
     * @since  4.6.2
     * @access private
     *
     * @param array $notification The notification data.
     * @return bool True if trigger conditions are met, false otherwise.
     */
    private function _check_trigger_conditions( $notification ) {
        if ( empty( $notification['trigger'] ) ) {
            return true; // No trigger specified, conditions are considered met.
        }

        if ( empty( $notification['trigger_value'] ) ) {
            return false; // Trigger value is missing, conditions are not met.
        }

        switch ( $notification['trigger'] ) {
            case 'after_days_install':
                $days_since_install = $this->_helper_functions->get_days_since_install();
                return ( $days_since_install >= intval( $notification['trigger_value'] ) );
            case 'after_numbers_coupon_created':
                $coupons_created = $this->_helper_functions->get_coupons_created_count();
                return ( $coupons_created >= intval( $notification['trigger_value'] ) );
            case 'number_coupon_orders_processed':
                $coupon_orders_processed = $this->_helper_functions->get_coupon_orders_processed_count();
                return ( $coupon_orders_processed >= intval( $notification['trigger_value'] ) );
            default:
                return false; // Unknown trigger, conditions are not met.
        }
    }

    /**
     * Get notifications server base.
     *
     * @since 4.6.2
     * @access private
     *
     * @return string Notifications server base.
     */
    private function _get_notifications_server_base() {
        if ( defined( 'ACFW_NOTIFICATIONS_SERVER_BASE' ) && ACFW_NOTIFICATIONS_SERVER_BASE ) {
            return ACFW_NOTIFICATIONS_SERVER_BASE;
        }

        return 'https://plugin.advancedcouponsplugin.com';
    }

    /**
     * Get notifications environment base.
     *
     * @since 4.6.2
     * @access private
     * @return string Notifications environment base (live or staging).
     */
    private function _get_notifications_environment() {
        if ( defined( 'ACFW_NOTIFICATIONS_ENVIRONMENT' ) && ACFW_NOTIFICATIONS_ENVIRONMENT ) {
            return ACFW_NOTIFICATIONS_ENVIRONMENT;
        }

        return 'live';
    }

    /*
    |--------------------------------------------------------------------------
    | Fulfill implemented interface contracts
    |--------------------------------------------------------------------------
     */

    /**
     * Execute codes that needs to run plugin activation.
     *
     * @since 4.6.2
     * @access public
     * @implements ACFWF\Interfaces\Activatable_Interface
     */
    public function activate() {
        $this->_schedule_notifications_event();
    }

    /**
     * Execute codes that needs to run plugin activation.
     *
     * @since 4.6.2
     * @access public
     * @implements ACFWF\Interfaces\Initializable_Interface
     */
    public function initialize() {
        add_action( 'wp_ajax_acfw_read_admin_notice', array( $this, 'ajax_read_admin_notice' ) );
    }


    /**
     * Execute Notifications class.
     *
     * @since 4.6.2
     * @access public
     * @inherit ACFWF\Interfaces\Model_Interface
     */
    public function run() {
        add_action( Plugin_Constants::NOTIFICATIONS_SCHEDULE_HOOK, array( $this, 'implement_notifications' ) );
        add_filter( 'acfw_get_all_admin_notices', array( $this, 'get_all_admin_notifications' ), 10, 1 );
        add_action( 'acfw_before_dismiss_admin_notice', array( $this, 'update_on_notice_dismiss' ), 10, 2 );
    }
}
