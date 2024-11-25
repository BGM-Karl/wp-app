<?php

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_range_discount', 50);

function zcpri_get_checkout_price_rule_template_fields_range_discount($in_fields) {
    $in_fields[] = array(
        'id' => 'range_discount',
        'type' => 'columns-field',
        'columns' => 2,
        'fold' => array(
            'target' => 'price_mode',
            'attribute' => 'value',
            'value' => array('bulk', 'tiered'),
            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
            'clear' => true,
        ),
        'fields' => array(
            array(
                'id' => 'base_on',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__('Range Discounts Base On', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Controls how to calculate the range discount pricing', 'zcpri-woopricely'),
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
            ),
            array(
                'id' => 'metrics_table',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__('Metrics Table', 'zcpri-woopricely'),
                'tooltip' => esc_html__('Controls the metric tables to display on single product page', 'zcpri-woopricely'),
                'ajax_data' => 'dpd:metrics_table',
                'default' => '10280000',
                'placeholder' => esc_html__('Select group', 'zcpri-woopricely'),
                'width' => '100%',
            ),
        )
    );
    return $in_fields;
}

add_filter('zcpri/get-checkout-prices-settings-fields', 'zcpri_get_checkout_price_rule_template_fields_quantity_ranges', 80);

function zcpri_get_checkout_price_rule_template_fields_quantity_ranges($in_fields) {
    $in_fields[] = array(
        'id' => 'quantity_ranges',
        'type' => 'simple-repeater',
        'filter_id' => 'checkout_price_quantity_ranges',
        'full_width' => true,
        'center_head' => true,
        'title' => esc_html__('Quantity Ranges', 'zcpri-woopricely'),
        'desc' => esc_html__('Controls quantity range discounts pricing', 'zcpri-woopricely'),
        'white_repeater' => false,
        'repeater_size' => 'smaller',
        'buttons_sep' => false,
        'buttons_box_width' => '65px',
        'width' => '100%',
        'fold' => array(
            'target' => 'price_mode',
            'attribute' => 'value',
            'value' => array('bulk', 'tiered'),
            'oparator' => 'eq',
            'clear' => true,
        ),
        'default' => array(array('min' => 1, 'max' => 5)),
        'sortable' => array(
            'enabled' => false,
        ),
        'head' => array(
            'enable' => true,
            'enable_footer' => true,
            'titles' => array(
                array('offset' => '10px', 'text' => esc_html__('Minimum', 'zcpri-woopricely'), 'width' => '19.333%', 'tooltip' => "Controls quantity range's minimum quantity"),
                array('text' => esc_html__('Maximum', 'zcpri-woopricely'), 'width' => '18.9%', 'tooltip' => "Controls quantity range's minimum quantity"),
                array('text' => esc_html__('Discount Type', 'zcpri-woopricely'), 'width' => '34.8%', 'tooltip' => "Controls quantity range's discount type"),
                array('text' => esc_html__('Amount', 'zcpri-woopricely'), 'width' => '22%', 'tooltip' => "Controls quantity range's discount amount"),
            ),
        ),
        'template_adder' => array(
            'position' => 'right',
            'show_list' => false,
            'button_text' => esc_html__('Add Quantity Range', 'zcpri-woopricely'),
        ),
    );
    return $in_fields;
}

add_filter('zcpri/sanitize-checkout-prices-bulk-rule-settings', 'sanitize_zcpri_checkout_prices_bulk_options');
add_filter('zcpri/sanitize-checkout-prices-tiered-rule-settings', 'sanitize_zcpri_checkout_prices_bulk_options');

function sanitize_zcpri_checkout_prices_bulk_options($rule) {
    $rl = array();
    if (isset($rule['qty_base_on'])) {
        $rl['qty_base_on'] = $rule['qty_base_on'];
    }

    if (isset($rule['range_discount'])) {
        $rl['range_discount'] = $rule['range_discount'];
    }

    if (isset($rule['quantity_ranges'])) {
        $rl['quantity_ranges'] = $rule['quantity_ranges'];
    }

    if (isset($rule['products'])) {
        $rl['products'] = $rule['products'];
    }

    return $rl;
}
