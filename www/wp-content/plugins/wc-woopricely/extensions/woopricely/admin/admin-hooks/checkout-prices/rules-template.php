<?php

require_once (dirname( __FILE__ ) . '/rules-template-simple.php');
require_once (dirname( __FILE__ ) . '/rules-template-bulk.php');
require_once (dirname( __FILE__ ) . '/rules-template-group.php');
require_once (dirname( __FILE__ ) . '/rules-template-bogo.php');

add_filter( 'reon/get-repeater-field-checkout_price_rules-templates', 'zcpri_get_checkout_price_rules_template', 10, 2 );

function zcpri_get_checkout_price_rules_template( $in_templates, $args ) {

    if ( $args[ 'screen' ] == 'option-page' && $args[ 'option_name' ] == 'zc_pri' ) {
        $in_templates[] = array(
            'id' => 'price_rule',
            'head' => array(
                'title' => '',
                'defaut_title' => esc_html__( 'Checkout Pricing', 'zcpri-woopricely' ),
                'title_field' => 'admin_note',
                'subtitle_field' => 'mode',
            )
        );
    }

    return $in_templates;
}

add_filter( 'roen/get-repeater-template-checkout_price_rules-price_rule-fields', 'zcpri_get_checkout_price_rule_template_fields', 10, 2 );

function zcpri_get_checkout_price_rule_template_fields( $in_fields, $args ) {

    $in_fields[] = array(
        'id' => 'option_id',
        'type' => 'autoid',
        'autoid' => 'woopricely',
    );

    $in_fields[] = array(
        'id' => 'any_id',
        'type' => 'panel',
        'full_width' => true,
        'center_head' => true,
        'white_panel' => true,
        'panel_size' => 'smaller',
        'width' => '100%',
        'last' => true,
        'merge_fields' => false,
        'fields' => apply_filters( 'zcpri/get-checkout-prices-settings-fields', array(
            array(
                'id' => 'any_id',
                'type' => 'columns-field',
                'columns' => 3,
                'merge_fields' => false,
                'fields' => array(
                    array(
                        'id' => 'mode',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Mode', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Controls the checkout pricing mode', 'zcpri-woopricely' ),
                        'default' => 'simple',
                        'options' => apply_filters( 'zcpri/get-checkout-prices-settings-modes', array(
                            'simple' => esc_html__( 'Simple Discount Pricing', 'zcpri-woopricely' ),
                            'bulk' => esc_html__( 'Bulk Discount Pricing', 'zcpri-woopricely' ),
                            'tiered' => esc_html__( 'Tiered Discount Pricing', 'zcpri-woopricely' ),
                            'products_group' => esc_html__( 'Products Group Pricing', 'zcpri-woopricely' ),
                            'buy_x_get_x' => esc_html__( 'Buy x Get x Pricing', 'zcpri-woopricely' ),
                            'buy_x_get_y' => esc_html__( 'Buy x Get y Pricing', 'zcpri-woopricely' ),
                        ) ),
                        'width' => '100%',
                        'fold_id' => 'price_mode',
                    ),
                    array(
                        'id' => 'qty_base_on',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Quantities Based On', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Controls how to count cart item quantities', 'zcpri-woopricely' ),
                        'options' => apply_filters( 'zcpri/get-checkout-prices-settings-quantity-based-on-options', array(
                            'product_id' => esc_html__( 'Product ID', 'zcpri-woopricely' ),
                            'variation_id' => esc_html__( 'Product Variations', 'zcpri-woopricely' ),
                            'category_id' => esc_html__( 'Product Categories', 'zcpri-woopricely' ),
                            'cart_key' => esc_html__( 'Cart Line Items', 'zcpri-woopricely' ),
                            'cart' => esc_html__( 'All Cart Items', 'zcpri-woopricely' ),
                        ) ),
                        'default' => 'product_id',
                        'width' => '100%',
                        'fold' => array(
                            'target' => 'price_mode',
                            'attribute' => 'value',
                            'value' => apply_filters( 'zcpri/get-checkout-prices-settings-quantity-based-on-folds', array( 'bulk', 'tiered', 'products_group', 'buy_x_get_x', 'buy_x_get_y' ) ),
                            'oparator' => 'eq',
                            'clear' => true,
                            'empty' => 'product_id',
                        ),
                    ),
                    array(
                        'id' => 'admin_note',
                        'type' => 'textbox',
                        'tooltip' => esc_html__( 'Adds a private note for reference purposes', 'zcpri-woopricely' ),
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Admin Note', 'zcpri-woopricely' ),
                        'default' => '',
                        'placeholder' => esc_html__( 'Type here...', 'zcpri-woopricely' ),
                        'width' => '100%',
                    ),
                ),
            ),
          ),
        )
    );

    $in_fields[] = array(
        'id' => 'conditions',
        'type' => 'panel',
        'full_width' => true,
        'center_head' => true,
        'white_panel' => true,
        'panel_size' => 'smaller',
        'width' => '100%',
        'merge_fields' => false,
        'fields' => array(
            array(
                'id' => 'conditions',
                'type' => 'simple-repeater',
                'filter_id' => 'checkout_price_conditions',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Conditions', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'List of conditions in which this rule should apply, empty conditions will apply in all cases', 'zcpri-woopricely' ),
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
                    'button_text' => esc_html__( 'Add Condition', 'zcpri-woopricely' ),
                ),
            ),
        ),
    );

    return $in_fields;
}

add_filter( 'roen/get-repeater-template-checkout_price_rules-price_rule-head-fields', 'zcpri_get_checkout_price_rule_template_head_fields', 10, 2 );

function zcpri_get_checkout_price_rule_template_head_fields( $in_fields, $args ) {
    $in_fields[] = array(
        'id' => 'any_id',
        'type' => 'group-field',
        'position' => 'right',
        'width' => '100%',
        'merge_fields' => false,
        'fields' => array(
            array(
                'id' => 'apply_mode',
                'type' => 'select2',
                'default' => 'with_others',
                'options' => array(
                    'with_others' => esc_html__( 'Apply this and other rules', 'zcpri-woopricely' ),
                    'only_this' => esc_html__( 'Apply only this rule', 'zcpri-woopricely' ),
                    'if_others' => esc_html__( 'Apply if other rules are valid', 'zcpri-woopricely' ),
                    'if_no_others' => esc_html__( 'Apply if no other valid rules', 'zcpri-woopricely' ),
                ),
                'width' => '210px',
            ),
            array(
                'id' => 'enable',
                'type' => 'select2',
                'default' => 'yes',
                'options' => array(
                    'yes' => esc_html__( 'Enable', 'zcpri-woopricely' ),
                    'no' => esc_html__( 'Disable', 'zcpri-woopricely' ),
                ),
                'width' => '95px',
            ),
        ),
    );

    return $in_fields;
}
