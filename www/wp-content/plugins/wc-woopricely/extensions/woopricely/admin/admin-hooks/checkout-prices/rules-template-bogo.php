<?php

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_bogo_qty', 10);

function zcpri_get_checkout_price_rule_template_fields_bogo_qty($in_fields) {
    $in_fields[] = array(
        'id' => 'bogo_qty',
        'type' => 'columns-field',
        'columns' => 5,
        'fold' => array(
            'target' => 'price_mode',
            'attribute' => 'value',
            'value' => array('buy_x_get_x', 'buy_x_get_y'),
            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
            'clear' => true,
        ),
        'fields' => array(
            array(
                'id' => 'purchase_qty',
                'type' => 'textbox',
                'input_type' => 'number',
                'column_size' => 2,
                'column_title' => esc_html__('Purchased Quantity', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Controls the minimum product quantity for the discount to apply', 'zcpri-woopricely'),
                'default' => '',
                'placeholder' => esc_html__('Quantity', 'zcpri-woopricely'),
                'width' => '100%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '1',
                ),
            ),
            array(
                'id' => 'discount_qty',
                'type' => 'textbox',
                'input_type' => 'number',
                'column_size' => 2,
                'column_title' => esc_html__('Received Quantity', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Controls the total number of products to apply the discount to', 'zcpri-woopricely'),
                'default' => '',
                'placeholder' => esc_html__('Quantity', 'zcpri-woopricely'),
                'width' => '100%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '1',
                ),
            ),
            array(
                'id' => 'auto_add',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__('Auto Add', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Automatically adds more discounted products if quantity is less than Received Quantity', 'zcpri-woopricely'),
                'options' => array(
                    'no' => esc_html__('No', 'zcpri-woopricely'),
                    'yes' => esc_html__('Yes', 'zcpri-woopricely'),
                ),
                'default' => 'no',
                'width' => '100%',
                'fold' => array(
                    'target' => 'price_mode',
                    'attribute' => 'value',
                    'value' => array('buy_x_get_y'),
                    'oparator' => 'eq',
                    'clear' => true,
                    'empty' => 'no',
                ),
            ),
        )
    );
    return $in_fields;
}

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_bogo_discount', 30);

function zcpri_get_checkout_price_rule_template_fields_bogo_discount($in_fields) {
    $in_fields[] = array(
        'id' => 'bogo_discount',
        'type' => 'columns-field',
        'columns' => 6,
        'fold' => array(
            'target' => 'price_mode',
            'attribute' => 'value',
            'value' => array('buy_x_get_x', 'buy_x_get_y'),
            'oparator' => 'eq',
            'clear' => true,
        ),
        'fields' => array(
            array(
                'id' => 'discount_type',
                'type' => 'select2',
                'column_size' => 2,
                'column_title' => esc_html__('Discount Type', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Controls discount amount type', 'zcpri-woopricely'),
                'options' => array(
                    'free' => esc_html__('Free', 'zcpri-woopricely'),
                    'fixed_price' => esc_html__('Fixed price', 'zcpri-woopricely'),
                    'fixed_price_unit' => esc_html__('Fixed price per unit', 'zcpri-woopricely'),
                    'fixed_discount' => esc_html__('Fixed discount amount', 'zcpri-woopricely'),
                    'fixed_discount_unit' => esc_html__('Fixed discount amount per unit', 'zcpri-woopricely'),
                    'per_discount' => esc_html__('Percentage discount', 'zcpri-woopricely'),
                ),
                'default' => 'free',
                'width' => '100%',
                'fold_id' => 'bogo_discount_type',
            ),
            array(
                'id' => 'base_on',
                'type' => 'select2',
                'column_size' => 2,
                'column_title' => esc_html__('Base On', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Controls how to calculate the discount pricing', 'zcpri-woopricely'),
                'options' => array(
                    'cart_price' => esc_html__('Cart item price', 'zcpri-woopricely'),
                    'product' => array(
                        'label' => 'Source Prices',
                        'options' => array(
                            'reg_price' => esc_html__('Source regular price', 'zcpri-woopricely'),
                            'sale_price' => esc_html__('Source sale price', 'zcpri-woopricely'),
                        ),
                    ),
                    'calc' => array(
                        'label' => 'Computed Prices',
                        'options' => array(
                            'calc_reg_price' => esc_html__('Computed regular price', 'zcpri-woopricely'),
                            'calc_sale_price' => esc_html__('Computed sale price', 'zcpri-woopricely'),
                        ),
                    ),
                ),
                'default' => 'cart_price',
                'width' => '100%',
                'fold' => array(
                    'target' => 'bogo_discount_type',
                    'attribute' => 'value',
                    'value' => array('fixed_discount', 'fixed_discount_unit', 'per_discount'),
                    'oparator' => 'eq',
                    'clear' => true,
                    'empty' => 'cart_price',
                ),
            ),
            array(
                'id' => 'amount',
                'type' => 'textbox',
                'input_type' => 'number',
                'column_size' => 1,
                'column_title' => esc_html__('Amount', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Controls the amount to apply based on the Discount Type method', 'zcpri-woopricely'),
                'default' => '',
                'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                'width' => '100%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '0.01',
                ),
                'fold' => array(
                    'target' => 'bogo_discount_type',
                    'attribute' => 'value',
                    'value' => 'free',
                    'oparator' => 'neq',
                    'clear' => true,
                ),
            ),
            array(
                'id' => 'repeat',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__('Repeating', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Allows the discounts to apply more than once', 'zcpri-woopricely'),
                'options' => array(
                    'no' => esc_html__('No', 'zcpri-woopricely'),
                    'yes' => esc_html__('Yes', 'zcpri-woopricely'),
                ),
                'default' => 'no',
                'width' => '100%',                
            ),
        )
    );
    return $in_fields;
}

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_purchased_products', 120);

function zcpri_get_checkout_price_rule_template_fields_purchased_products($in_fields) {
    $in_fields[] = array(
        'id' => 'purchased_products',
        'type' => 'simple-repeater',
        'filter_id' => 'checkout_price_products',
        'full_width' => true,
        'center_head' => true,
        'title' => esc_html__('Purchased Product Filters', 'zcpri-woopricely'),
        'desc' => esc_html__('List of product filters, empty filters will not include any product', 'zcpri-woopricely'),
        'white_repeater' => false,
        'repeater_size' => 'smaller',
        'buttons_sep' => false,
        'buttons_box_width' => '65px',
        'width' => '100%',
        'sortable' => array(
            'enabled' => true,
        ),
        'template_adder' => array(
            'position' => 'right', //left, right
            'show_list' => false,
            'button_text' => esc_html__('Add Filter', 'zcpri-woopricely'),
        ),
        'fold' => array(
            'target' => 'price_mode',
            'attribute' => 'value',
            'value' => 'buy_x_get_y',
            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
            'clear' => false,
        ),
    );
    return $in_fields;
}

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_discount_products', 130);

function zcpri_get_checkout_price_rule_template_fields_discount_products($in_fields) {
    $in_fields[] = array(
        'id' => 'discount_products',
        'type' => 'simple-repeater',
        'filter_id' => 'checkout_price_discount_products',
        'full_width' => true,
        'center_head' => true,
        'title' => esc_html__('Discount Product Filters', 'zcpri-woopricely'),
        'desc' => esc_html__('List of product filters, empty filters will not include any product', 'zcpri-woopricely'),
        'white_repeater' => false,
        'repeater_size' => 'smaller',
        'buttons_sep' => false,
        'buttons_box_width' => '65px',
        'width' => '100%',
        'template_adder' => array(
            'position' => 'right', //left, right
            'show_list' => false,
            'button_text' => esc_html__('Add Filter', 'zcpri-woopricely'),
        ),
        'fold' => array(
            'target' => 'price_mode',
            'attribute' => 'value',
            'value' => 'buy_x_get_y',
            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
            'clear' => false,
        ),
    );
    return $in_fields;
}

add_filter('zcpri/sanitize-checkout-prices-buy_x_get_x-rule-settings', 'sanitize_zcpri_checkout_prices_bogo_options');
add_filter('zcpri/sanitize-checkout-prices-buy_x_get_y-rule-settings', 'sanitize_zcpri_checkout_prices_bogo_options');

function sanitize_zcpri_checkout_prices_bogo_options($rule) {
    $rl = array();
    if (isset($rule['qty_base_on'])) {
        $rl['qty_base_on'] = $rule['qty_base_on'];
    }

    if (isset($rule['bogo_qty'])) {
        $rl['bogo_qty'] = $rule['bogo_qty'];
    }

    if (isset($rule['bogo_discount'])) {
        $rl['bogo_discount'] = $rule['bogo_discount'];
    }

    if (isset($rule['mode']) && $rule['mode'] == 'buy_x_get_y') {

        if (isset($rule['purchased_products'])) {
            $rl['purchased_products'] = $rule['purchased_products'];
        }

        if (isset($rule['discount_products'])) {
            $rl['discount_products'] = $rule['discount_products'];
        }
    } else {

        if (isset($rule['products'])) {
            $rl['products'] = $rule['products'];
        }
    }
    return $rl;
}
