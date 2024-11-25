<?php

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_group_discount', 40);

function zcpri_get_checkout_price_rule_template_fields_group_discount($in_fields) {
    $in_fields[] = array(
        'id' => 'group_discount',
        'type' => 'columns-field',
        'columns' => 6,
        'fold' => array(
            'target' => 'price_mode',
            'attribute' => 'value',
            'value' => 'products_group',
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
                    'fixed_price_unit' => esc_html__('Fixed price per item', 'zcpri-woopricely'),
                    'fixed_group_price' => esc_html__('Fixed price per group', 'zcpri-woopricely'),
                    'fixed_discount_unit' => esc_html__('Fixed discount per item', 'zcpri-woopricely'),
                    'fixed_group_discount' => esc_html__('Fixed discount per group', 'zcpri-woopricely'),
                    'per_discount' => esc_html__('Percentage discount', 'zcpri-woopricely'),
                ),
                'default' => 'fixed_price_unit',
                'width' => '100%',
                'fold_id' => 'group_discount_type',
            ),
            array(
                'id' => 'base_on',
                'type' => 'select2',
                'column_size' => 2,
                'column_title' => esc_html__('Base On', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Controls how to calculate the products group discount pricing', 'zcpri-woopricely'),
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
                    'target' => 'group_discount_type',
                    'attribute' => 'value',
                    'value' => array('fixed_discount', 'fixed_group_discount', 'per_discount', 'per_group_discount'),
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
                    'target' => 'group_discount_type',
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
                'tooltip' => esc_html__('Allows group discount pricing to apply discounts more than once', 'zcpri-woopricely'),
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

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_products_in_group', 90);

function zcpri_get_checkout_price_rule_template_fields_products_in_group($in_fields) {
    $in_fields[] = array(
        'id' => 'products_in_group',
        'type' => 'simple-repeater',
        'filter_id' => 'checkout_price_products_in_group',
        'full_width' => true,
        'center_head' => true,
        'title' => esc_html__('Products In Group', 'zcpri-woopricely'),
        'desc' => esc_html__('List of group product filters, empty filters will not include any product', 'zcpri-woopricely'),
        'white_repeater' => false,
        'repeater_size' => 'smaller',
        'buttons_sep' => false,
        'buttons_box_width' => '65px',
        'width' => '100%',
        'fold' => array(
            'target' => 'price_mode',
            'attribute' => 'value',
            'value' => 'products_group',
            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
            'clear' => true,
        ),
        'default' => array(array('qty' => 2, 'rule_type' => 'products')),
        'sortable' => array(
            'enabled' => false,
        ),
        'template_adder' => array(
            'position' => 'right', //left, right
            'show_list' => false,
            'button_text' => esc_html__('Add Filter', 'zcpri-woopricely'),
        ),
    );
    return $in_fields;
}

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_group_product_rules', 110);

function zcpri_get_checkout_price_rule_template_fields_group_product_rules($in_fields) {
    $in_fields[] = array(
        'id' => 'group_product_rules',
        'type' => 'simple-repeater',
        'filter_id' => 'checkout_price_products',
        'full_width' => true,
        'center_head' => true,
        'last' => true,
        'title' => esc_html__('Other Product Filters', 'zcpri-woopricely'),
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
            'button_text' => esc_html__('Add Rule', 'zcpri-woopricely'),
        ),
        'fold' => array(
            'target' => 'price_mode',
            'attribute' => 'value',
            'value' => array('products_group'),
            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
            'clear' => true,
        ),
    );
    return $in_fields;
}

add_filter('zcpri/sanitize-checkout-prices-products_group-rule-settings', 'sanitize_zcpri_checkout_prices_products_group_options');

function sanitize_zcpri_checkout_prices_products_group_options($rule) {
    $rl = array();

    if (isset($rule['qty_base_on'])) {
        $rl['qty_base_on'] = $rule['qty_base_on'];
    }

    if (isset($rule['group_discount'])) {
        $rl['group_discount'] = $rule['group_discount'];
    }
    
    if (isset($rule['products_in_group'])) {
        $rl['products_in_group'] = $rule['products_in_group'];
    }
    
    if (isset($rule['group_product_rules'])) {
        $rl['group_product_rules'] = $rule['group_product_rules'];
    }

    return $rl;
}
