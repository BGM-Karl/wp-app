<?php

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_simple', 20);

function zcpri_get_checkout_price_rule_template_fields_simple($in_fields) {
    $in_fields[] = array(
        'id' => 'simple_discount',
        'type' => 'columns-field',
        'columns' => 5,
        'fold' => array(
            'target' => 'price_mode',
            'attribute' => 'value',
            'value' => array('simple'),
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
                'default' => 'fixed_discount',
                'width' => '100%',
                'fold_id' => 'discount_type',
            ),
            array(
                'id' => 'base_on',
                'type' => 'select2',
                'column_size' => 2,
                'column_title' => esc_html__('Base On', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Controls how to calculate the simple discount pricing', 'zcpri-woopricely'),
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
                    'target' => 'discount_type',
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
                    'target' => 'discount_type',
                    'attribute' => 'value',
                    'value' => 'free',
                    'oparator' => 'neq',
                    'clear' => true,
                ),
            ),
        )
    );
    return $in_fields;
}

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_messages', 60);

function zcpri_get_checkout_price_rule_template_fields_messages($in_fields) {
    $in_fields[] = array(
        'id' => 'any_id',
        'type' => 'columns-field',
        'columns' => 1,
        'merge_fields' => false,
        'fields' => array(
            array(
                'id' => 'message',
                'type' => 'textbox',
                'column_size' => 1,
                'column_title' => esc_html__('Promo Message', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Controls the promotional message on single product page', 'zcpri-woopricely'),
                'default' => '',
                'placeholder' => esc_html__('Type here...', 'zcpri-woopricely'),
                'width' => '100%',
            ),
        )
    );
    $in_fields[] = array(
        'id' => 'any_id',
        'type' => 'columns-field',
        'columns' => 1,
        'merge_fields' => false,
        'fields' => array(
            array(
                'id' => 'notification',
                'type' => 'textbox',
                'column_size' => 1,
                'column_title' => esc_html__('Cart/Checkout Notification', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Controls the notification message on cart and checkout pages', 'zcpri-woopricely'),
                'default' => '',
                'placeholder' => esc_html__('Type here...', 'zcpri-woopricely'),
                'width' => '100%',
            ),
        )
    );
    return $in_fields;
}

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_product_filters', 100);

function zcpri_get_checkout_price_rule_template_fields_product_filters($in_fields) {
    $in_fields[] = array(
        'id' => 'products',
        'type' => 'simple-repeater',
        'filter_id' => 'checkout_price_products',
        'full_width' => true,
        'center_head' => true,
        'title' => esc_html__('Product Filters', 'zcpri-woopricely'),
        'desc' => esc_html__('List of product filters, empty filters will include all products', 'zcpri-woopricely'),
        'white_repeater' => false,
        'repeater_size' => 'smaller',
        'buttons_sep' => false,
        'buttons_box_width' => '65px',
        'width' => '100%',
        'sortable' => array(
            'enabled' => true,
        ),
        'template_adder' => array(
            'position' => 'right',
            'show_list' => false,
            'button_text' => esc_html__('Add Filter', 'zcpri-woopricely'),
        ),
        'fold' => array(
            'target' => 'price_mode',
            'attribute' => 'value',
            'value' => apply_filters('zcpri/get-checkout-prices-settings-product-filters-folds', array('simple', 'bulk', 'tiered', 'buy_x_get_x')),
            'oparator' => 'eq',
            'clear' => true,
        ),
    );
    return $in_fields;
}

add_filter('zcpri/sanitize-checkout-prices-simple-rule-settings', 'sanitize_zcpri_checkout_prices_simple_options');

function sanitize_zcpri_checkout_prices_simple_options($rule) {
    $rl = array();
    
    if (isset($rule['simple_discount'])) {
        $rl['simple_discount'] = $rule['simple_discount'];
    }

    if (isset($rule['products'])) {
        $rl['products'] = $rule['products'];
    }

    return $rl;
}
