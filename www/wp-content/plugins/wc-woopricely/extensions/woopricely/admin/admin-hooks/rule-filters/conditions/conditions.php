<?php

require_once (dirname(__FILE__) . '/conditions-billing-payment-method.php');
require_once (dirname(__FILE__) . '/conditions-billing-country.php');
require_once (dirname(__FILE__) . '/conditions-billing-state.php');
require_once (dirname(__FILE__) . '/conditions-billing-postcode.php');
require_once (dirname(__FILE__) . '/conditions-shipping-method.php');
require_once (dirname(__FILE__) . '/conditions-shipping-rate.php');
require_once (dirname(__FILE__) . '/conditions-shipping-zone.php');
require_once (dirname(__FILE__) . '/conditions-shipping-cost.php');
require_once (dirname(__FILE__) . '/conditions-shipping-country.php');
require_once (dirname(__FILE__) . '/conditions-shipping-state.php');
require_once (dirname(__FILE__) . '/conditions-shipping-postcode.php');

require_once (dirname(__FILE__) . '/conditions-cart-subtotals.php');

require_once (dirname(__FILE__) . '/conditions-cart-total-quantity.php');
require_once (dirname(__FILE__) . '/conditions-cart-total-weight.php');
require_once (dirname(__FILE__) . '/conditions-cart-line-item-count.php');
require_once (dirname(__FILE__) . '/conditions-cart-coupons.php');

require_once (dirname(__FILE__) . '/conditions-cart-items-products.php');
require_once (dirname(__FILE__) . '/conditions-cart-items-categories.php');
require_once (dirname(__FILE__) . '/conditions-cart-items-tags.php');
require_once (dirname(__FILE__) . '/conditions-cart-items-variations.php');
require_once (dirname(__FILE__) . '/conditions-cart-items-attributes.php');
require_once (dirname(__FILE__) . '/conditions-cart-items-meta-field.php');

require_once (dirname(__FILE__) . '/conditions-cart-item-subtotal-products.php');
require_once (dirname(__FILE__) . '/conditions-cart-item-subtotal-categories.php');
require_once (dirname(__FILE__) . '/conditions-cart-item-subtotal-tags.php');
require_once (dirname(__FILE__) . '/conditions-cart-item-subtotal-attributes.php');
require_once (dirname(__FILE__) . '/conditions-cart-item-subtotal-variations.php');

require_once (dirname(__FILE__) . '/conditions-cart-item-quantity-products.php');
require_once (dirname(__FILE__) . '/conditions-cart-item-quantity-categories.php');
require_once (dirname(__FILE__) . '/conditions-cart-item-quantity-tags.php');
require_once (dirname(__FILE__) . '/conditions-cart-item-quantity-attributes.php');
require_once (dirname(__FILE__) . '/conditions-cart-item-quantity-variations.php');

require_once (dirname(__FILE__) . '/conditions-user-customers.php');
require_once (dirname(__FILE__) . '/conditions-user-is-logged-in.php');
require_once (dirname(__FILE__) . '/conditions-user-roles.php');
require_once (dirname(__FILE__) . '/conditions-user-caps.php');
require_once (dirname(__FILE__) . '/conditions-user-meta-field.php');

require_once (dirname(__FILE__) . '/conditions-customer-value-used-coupons.php');
require_once (dirname(__FILE__) . '/conditions-customer-value-total-spent.php');
require_once (dirname(__FILE__) . '/conditions-customer-value-last-order.php');
require_once (dirname(__FILE__) . '/conditions-customer-value-last-spent.php');
require_once (dirname(__FILE__) . '/conditions-customer-value-average-spent.php');
require_once (dirname(__FILE__) . '/conditions-customer-value-max-spent.php');
require_once (dirname(__FILE__) . '/conditions-customer-value-min-spent.php');
require_once (dirname(__FILE__) . '/conditions-customer-value-orders-count.php');
require_once (dirname(__FILE__) . '/conditions-customer-value-reviews-count.php');

require_once (dirname(__FILE__) . '/conditions-calendar-date.php');
require_once (dirname(__FILE__) . '/conditions-calendar-time.php');
require_once (dirname(__FILE__) . '/conditions-calendar-date-time.php');
require_once (dirname(__FILE__) . '/conditions-calendar-days-of-week.php');
require_once (dirname(__FILE__) . '/conditions-calendar-days-of-month.php');
require_once (dirname(__FILE__) . '/conditions-calendar-months-of-year.php');

require_once (dirname(__FILE__) . '/conditions-purchased-history-item-products.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-item-categories.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-item-tags.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-item-attributes.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-item-variations.php');

require_once (dirname(__FILE__) . '/conditions-purchased-history-quantity-products.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-quantity-categories.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-quantity-tags.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-quantity-attributes.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-quantity-variations.php');

require_once (dirname(__FILE__) . '/conditions-purchased-history-value-products.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-value-categories.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-value-tags.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-value-attributes.php');
require_once (dirname(__FILE__) . '/conditions-purchased-history-value-variations.php');


add_filter('zcpri/get-condition-type-groups', 'zcpri_get_conditions_rule_type_groups', 10, 2);

if (!function_exists('zcpri_get_conditions_rule_type_groups')) {

    function zcpri_get_conditions_rule_type_groups($groups, $args) {

        $groups['billing_shipping'] = array(
            'label' => esc_html__('Billing & Shipping', 'zcpri-woopricely')
        );

        $groups['cart'] = array(
            'label' => esc_html__('Cart', 'zcpri-woopricely')
        );
        $groups['cart_items'] = array(
            'label' => esc_html__('Items In Cart', 'zcpri-woopricely')
        );
         $groups['cart_items_subtotal'] = array(
            'label' => esc_html__('Cart Item Subtotals', 'zcpri-woopricely')
        );
        $groups['cart_items_quantity'] = array(
            'label' => esc_html__('Cart Item Quantity', 'zcpri-woopricely')
        );
        $groups['customer'] = array(
            'label' => esc_html__('Customer', 'zcpri-woopricely')
        );
        $groups['customer_value'] = array(
            'label' => esc_html__('Customer Value', 'zcpri-woopricely')
        );
        $groups['date_time'] = array(
            'label' => esc_html__('Date & Time', 'zcpri-woopricely')
        );
        $groups['purchased_history'] = array(
            'label' => esc_html__('Purchase History', 'zcpri-woopricely')
        );
        $groups['purchased_history_qty'] = array(
            'label' => esc_html__('Purchase History Quantity', 'zcpri-woopricely')
        );
        $groups['purchased_history_value'] = array(
            'label' => esc_html__('Purchase History Value', 'zcpri-woopricely')
        );
        return $groups;
    }

}
