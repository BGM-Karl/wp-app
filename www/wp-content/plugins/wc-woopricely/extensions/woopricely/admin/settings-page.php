<?php

if (!class_exists('Reon')) {
    return;
}

$option_name = "zc_pri";

$args = array(
    'option_name' => $option_name,
    'database' => 'option',
    'slug' => 'zc_pri',
    'page_id' => 'woopricely_page',
    'url_base'=> 'admin.php',
    'default_min_height' => '700px',
    'width' => 'auto',
    'aside_width' => '210px',
    'display' => array(
        'enabled' => true,
        'image' => WCWOOPRICELY_ASSETS_URL . 'images/aside_logo.png',
        'title' => esc_html__('WooPricely', 'zcpri-woopricely'),
        'sub_title' => 'Dynamic Pricing, Fees & Discounts',
        'version' => WCWOOPRICELY_VERSION,
        'styles' => array(
            'bg_image' => WCWOOPRICELY_ASSETS_URL . 'images/aside_bg.png',
            'bg_color' => '#0073aa',
            'color' => '#fff',
            'height' => '215px',
        ),
    ),
    'ajax' => array(
        'save_msg' => esc_html__('Done!!', 'zcpri-woopricely'),
        'save_error_msg' => esc_html__('Unable to save your settings', 'zcpri-woopricely'),
        'reset_msg' => esc_html__('Done!!', 'zcpri-woopricely'),
        'reset_error_msg' => esc_html__('Unable to reset reset your settings', 'zcpri-woopricely'),
        'nonce_error_msg' => esc_html__('invalid nonce', 'zcpri-woopricely'),
    ),
    'menu' => array(
        'enable' => true,        
        'title' => esc_html__('WooPricely', 'zcpri-woopricely'),
        'page_title' => esc_html__('WooPricely', 'zcpri-woopricely'),
        'icon' => 'dashicons-admin-generic',
        'priority' => 2,
        'parent' => 'woocommerce',        
        'capability' => 'manage_woocommerce',
    ),
    'import_export' => array(
        'enable' => true,
        'min_height' => '565px',
        'title' => esc_html__('Import / Export', 'zcpri-woopricely'),
        'import' => array(
            'title' => esc_html__('Import Settings', 'zcpri-woopricely'),
            'desc' => esc_html__('Here you can import new settings. Simply paste the settings url or data on the field below.', 'zcpri-woopricely'),
            'url_button_text' => esc_html__('Import from url', 'zcpri-woopricely'),
            'url_textbox_desc' => esc_html__("Paste the url to another site's settings below and click the 'Import Now' button.", 'zcpri-woopricely'),
            'url_textbox_hint' => esc_html__("Paste the url to another site's settings here...", 'zcpri-woopricely'),
            'data_button_text' => esc_html__('Import Data', 'zcpri-woopricely'),
            'data_textbox_desc' => esc_html__("Paste your backup settings below and click the 'Import Now' button.", 'zcpri-woopricely'),
            'data_textbox_hint' => esc_html__('Paste your backup settings here...', 'zcpri-woopricely'),
            'import_button_text' => esc_html__('Import Now', 'zcpri-woopricely'),
            'warn_text' => esc_html__('Warning! This will override all existing settings. proceed with caution!', 'zcpri-woopricely'),
        ),
        'export' => array(
            'title' => esc_html__('Export Settings', 'zcpri-woopricely'),
            'desc' => esc_html__('Here you can backup your current settings. You can later use it to restore your settings.', 'zcpri-woopricely'),
            'download_button_text' => esc_html__('Download Data', 'zcpri-woopricely'),
            'url_button_text' => esc_html__('Export url', 'zcpri-woopricely'),
            'url_textbox_desc' => esc_html__('Copy the url below, use it to transfer the settings from this site.', 'zcpri-woopricely'),
            'data_button_text' => esc_html__('Export Data', 'zcpri-woopricely'),
            'data_textbox_desc' => esc_html__('Copy the data below, use it as your backup.', 'zcpri-woopricely'),
        ),
    ),
    'header_buttons' => array(
        'reset_all_text' => esc_html__('Reset All', 'zcpri-woopricely'),
        'reset_section_text' => esc_html__('Reset Section', 'zcpri-woopricely'),
        'save_all_text' => esc_html__('Save All', 'zcpri-woopricely'),
        'save_section_text' => esc_html__('Save Section', 'zcpri-woopricely'),
    ),
    'footer_buttons' => array(
        'reset_all_text' => esc_html__('Reset All', 'zcpri-woopricely'),
        'reset_section_text' => esc_html__('Reset Section', 'zcpri-woopricely'),
        'save_all_text' => esc_html__('Save All', 'zcpri-woopricely'),
        'save_section_text' => esc_html__('Save Section', 'zcpri-woopricely'),
    ),
    'page_links' => array(
        array(
            'id' => 'zcpri_help',
            'title' => esc_html__('Help', 'zcpri-woopricely'),
            'icon' => 'fa fa-question-circle',
            'href' => 'https://codecanyon.net/item/woopricely-dynamic-pricing-fees-discounts/23844181/comments?ref=zendcrew',
            'target' => '_blank',
            'show_in' => 'both'
        ),
        array(
            'id' => 'zcpri_documentation',
            'title' => esc_html__('Documentation', 'zcpri-woopricely'),
            'icon' => 'fa fa-file-text-o',
            'href' => 'https://support.zendcrew.com/woo-pricely/',
            'target' => '_blank',
            'show_in' => 'both'
        ),
    ),
    'social_links' => array(
        array(
            'id' => 'zcpri_facebook',
            'title' => esc_html__('Facebook', 'zcpri-woopricely'),
            'icon' => 'fa fa-facebook',
            'href' => 'http://www.facebook.com/zendcrew',
            'target' => '_blank',
        ),
        array(
            'id' => 'zcpri_linkedin',
            'title' => esc_html__('LinkedIn', 'zcpri-woopricely'),
            'icon' => 'fa fa-linkedin',
            'href' => 'https://www.linkedin.com/company/zendcrew',
            'target' => '_blank',
        ),
        array(
            'id' => 'zcpri_stack_overflow',
            'title' => esc_html__('Stack Overflow', 'zcpri-woopricely'),
            'icon' => 'fa fa-stack-overflow',
            'href' => 'https://stackoverflow.com/users/8692713/zendcrew',
            'target' => '_blank',
        ),
        array(
            'id' => 'zcpri_instagram',
            'title' => esc_html__('Instagram', 'zcpri-woopricely'),
            'icon' => 'fa fa-instagram',
            'href' => 'https://www.instagram.com/zendcrew/',
            'target' => '_blank',
        ),
    ),
);


Reon::set_option_page($args);


require_once (dirname(__FILE__) . '/admin-functions.php');
require_once (dirname(__FILE__) . '/admin-hooks/admin-hooks.php');

require_once (dirname(__FILE__) . '/settings-general.php');
require_once (dirname(__FILE__) . '/settings-products-pricing.php');
require_once (dirname(__FILE__) . '/settings-checkout-pricing.php');
require_once (dirname(__FILE__) . '/settings-checkout-discounts.php');
require_once (dirname(__FILE__) . '/settings-checkout-fees.php');





add_filter('reon/process-save-options-' . $option_name, 'sanitize_zcpri_options', 10);


//==================
// Sanitize Settings
//==================
if (!function_exists('sanitize_zcpri_options')) {

    function sanitize_zcpri_options($options) {
        if (isset($options['products_pricing_rules'])) {
            $options['products_pricing_rules'] = sanitize_zcpri_product_prices_options($options['products_pricing_rules']);
        }

        if (isset($options['checkout_price_rules'])) {
            $options['checkout_price_rules'] = sanitize_zcpri_checkout_prices_options($options['checkout_price_rules']);
        }

        if (isset($options['checkout_discounts_rules'])) {
            $options['checkout_discounts_rules'] = sanitize_zcpri_checkout_discounts_options($options['checkout_discounts_rules']);
        }

        if (isset($options['checkout_fees_rules'])) {
            $options['checkout_fees_rules'] = sanitize_zcpri_checkout_fees_options($options['checkout_fees_rules']);
        }


        return $options;
    }

}
//==================================
// Sanitize product pricing settings
//==================================
if (!function_exists('sanitize_zcpri_product_prices_options')) {

    function sanitize_zcpri_product_prices_options($rules) {

        for ($i = 0; $i < count($rules); $i++) {
            if ($rules[$i]['price_mode'] == 'sale_price') {
                unset($rules[$i]['regular_adj']);
                unset($rules[$i]['clear_sale_price']);
                if ($rules[$i]['schedule_sale']['enable'] == 'no') {
                    unset($rules[$i]['schedule_sale']['from']);
                    unset($rules[$i]['schedule_sale']['to']);
                }
            } else if ($rules[$i]['price_mode'] == 'regular_price') {
                unset($rules[$i]['sale_adj']);
                unset($rules[$i]['schedule_sale']);
            } else {
                unset($rules[$i]['clear_sale_price']);

                if ($rules[$i]['schedule_sale']['enable'] == 'no') {
                    unset($rules[$i]['schedule_sale']['from']);
                    unset($rules[$i]['schedule_sale']['to']);
                }
            }
        }

        return $rules;
    }

}

//===================================
// Sanitize checkout pricing settings
//===================================
if (!function_exists('sanitize_zcpri_checkout_prices_options')) {

    function sanitize_zcpri_checkout_prices_options($rules) {

        for ($i = 0; $i < count($rules); $i++) {
            $rule_mode = $rules[$i]['mode'];
            
            $rule = apply_filters('zcpri/sanitize-checkout-prices-' . $rule_mode . '-rule-settings', $rules[$i]);

            if (!isset($rule['conditions']) && isset($rules[$i]['conditions'])) {
                $rule['conditions'] = $rules[$i]['conditions'];
            }

            if (!isset($rule['admin_note'])) {
                $rule['admin_note'] = $rules[$i]['admin_note'];
            }

            if (!isset($rule['message'])) {
                $rule['message'] = $rules[$i]['message'];
            }

            if (!isset($rule['notification'])) {
                $rule['notification'] = $rules[$i]['notification'];
            }

            $rule['mode'] = $rules[$i]['mode'];
            $rule['apply_mode'] = $rules[$i]['apply_mode'];
            $rule['enable'] = $rules[$i]['enable'];
            $rule['option_id'] = $rules[$i]['option_id'];
            $rules[$i] = $rule;
        }

        return $rules;
    }

}

//=====================================
// Sanitize checkout discounts settings
//=====================================
if (!function_exists('sanitize_zcpri_checkout_discounts_options')) {

    function sanitize_zcpri_checkout_discounts_options($rules) {

        for ($i = 0; $i < count($rules); $i++) {
            if ($rules[$i]['send_to_group'] == 'yes') {
                unset($rules[$i]['single']);
            } else {
                unset($rules[$i]['group']);
            }

            if ($rules[$i]['discount']['discount_type'] == 'fixed_discount' || $rules[$i]['discount']['discount_type'] == 'per_discount') {
                unset($rules[$i]['discount']['item_base_on']);
            } else {
                unset($rules[$i]['discount']['cart_base_on']);
            }
        }




        return $rules;
    }

}

//================================
// Sanitize checkout fees settings
//================================
if (!function_exists('sanitize_zcpri_checkout_fees_options')) {

    function sanitize_zcpri_checkout_fees_options($rules) {

        for ($i = 0; $i < count($rules); $i++) {
            if ($rules[$i]['send_to_group'] == 'yes') {
                unset($rules[$i]['single']);
            } else {
                unset($rules[$i]['group']);
            }


            if ($rules[$i]['fee']['fee_type'] == 'fixed_fee' || $rules[$i]['fee']['fee_type'] == 'per_fee') {
                unset($rules[$i]['fee']['item_base_on']);
            } else {
                unset($rules[$i]['fee']['cart_base_on']);
            }
        }




        return $rules;
    }

}


add_filter('reon/field-classes', 'zcpri_get_add_cssclasses', 20, 2);

if (!function_exists('zcpri_get_add_cssclasses')) {

    function zcpri_get_add_cssclasses($css_classes, $field) {

        if ($field['id'] == 'products_pricing_rules' || $field['id'] == 'checkout_price_rules' || $field['id'] == 'checkout_discounts_rules' || $field['id'] == 'checkout_fees_rules') {
            $css_classes[] = 'zcpri_module_rules';
        }

        if ($field['id'] == 'checkout_fees' || $field['id'] == 'checkout_discounts' || $field['id'] == 'checkout_prices' || $field['id'] == 'products_pricing') {
            $css_classes[] = 'zcpri_module_max';
        }
        if ($field['id'] == 'module_title') {
            $css_classes[] = 'zcpri_module_title';
        }

        return $css_classes;
    }

}
