<?php

add_filter('reon/get-option-page-' . $option_name . '-sections', 'dpd_get_config_checkout_fee_section', 40);

function dpd_get_config_checkout_fee_section($in_sections) {
    $in_sections[] = array(
        'title' => esc_html__('Checkout Fees', 'zcpri-woopricely'),
        'id' => 'checkout_fees',
    );

    return $in_sections;
}

add_filter('get-option-page-' . $option_name . 'section-checkout_fees-fields', 'zc_get_dpd_config_sections_fees');

function zc_get_dpd_config_sections_fees($in_fields) {

    $in_fields[] = array(
        'id' => 'module_title',
        'type' => 'paneltitle',
        'full_width' => true,
        'center_head' => true,
        'title' => esc_html__('Checkout Fee Rules', 'zcpri-woopricely'),
        'desc' => esc_html__('Create unlimited number checkout fee rules', 'zcpri-woopricely'),
    );

    $in_fields[] = array(
        'id' => 'checkout_fees',
        'type' => 'panel',
        'last' => true,
        'white_panel' => false,
        'panel_size' => 'smaller',
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'any_id',
                'type' => 'columns-field',
                'columns' => 8,
                'merge_fields' => false,
                'fields' => array(
                    array(
                        'id' => 'max_fee_type',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__('Fees Limit', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls checkout fees limit', 'zcpri-woopricely'),
                        'default' => 'before_add_to_cart',
                        'options' => array(
                            'no' => esc_html__('No limit', 'zcpri-woopricely'),
                            'amount' => esc_html__('Fee amount', 'zcpri-woopricely'),
                            'per' => esc_html__('Percentage Fee', 'zcpri-woopricely'),
                        ),
                        'width' => '100%',
                        'fold_id' => 'max_fee_type',
                    ),
                    array(
                        'id' => 'max_fee_amount',
                        'type' => 'textbox',
                        'input_type' => 'number',
                        'column_size' => 1,
                        'column_title' => esc_html__('Limit', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls fees limit amount', 'zcpri-woopricely'),
                        'default' => '',
                        'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
                        'width' => '100%',
                        'attributes' => array(
                            'min' => '0',
                            'step' => '1',
                        ),
                        'fold' => array(
                            'target' => 'max_fee_type',
                            'attribute' => 'value',
                            'value' => 'no',
                            'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => true,
                        ),
                    ),
                    array(
                        'id' => 'base_on',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__('Limit Based On', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls checkout percentage fees limit based on cart totals', 'zcpri-woopricely'),
                        'default' => 'subtotal',
                        'options' => array(
                            'subtotal' => esc_html__('Subtotal including tax', 'zcpri-woopricely'),
                            'subtotal_ex_tax' => esc_html__('Subtotal excluding tax', 'zcpri-woopricely'),
                        ),
                        'width' => '100%',
                        'fold' => array(
                            'target' => 'max_fee_type',
                            'attribute' => 'value',
                            'value' => 'per',
                            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => true,
                            'empty' => 'subtotal',
                        ),
                    ),
                    array(
                        'id' => 'mode',
                        'type' => 'select2',
                        'column_size' => 3,
                        'column_title' => esc_html__('Rules Apply Mode', 'zcpri-woopricely'),
                        'tooltip' => esc_html__('Controls checkout fees rules apply mode', 'zcpri-woopricely'),
                        'default' => 'yes',
                        'options' => array(
                            'all' => esc_html__('Apply all valid rules', 'zcpri-woopricely'),
                            'bigger' => esc_html__('Apply rules/groups with bigger fee', 'zcpri-woopricely'),
                            'smaller' => esc_html__('Apply rules/groups with smaller fee', 'zcpri-woopricely'),
                            'first' => esc_html__('Apply first valid rule/group', 'zcpri-woopricely'),
                            'last' => esc_html__('Apply last valid rule/group', 'zcpri-woopricely'),
                            'no' => esc_html__('Do not apply any rule', 'zcpri-woopricely'),
                        ),
                        'width' => '100%',
                    ),
                ),
            ),
        ),
    );

    $in_fields[] = array(
        'id' => 'checkout_fees_rules',
        'type' => 'repeater',
        'white_repeater' => false,
        'repeater_size' => 'small',
        'accordions' => true,
        'buttons_sep' => false,
        'delete_button' => true,
        'clone_button' => true,
        'width' => '100%',
        'auto_expand' => array(
            'new_section' => true,
            'cloned_section' => true,
        ),
        'sortable' => array(
            'enabled' => true,
        ),
        'template_adder' => array(
            'position' => 'right',
            'show_list' => false,
            'button_text' => esc_html__('Add Fee Rule', 'zcpri-woopricely'),
        ),
    );


    return $in_fields;
}

//===================
//Fee Groups DataList
//===================

add_filter('reon/get-data-list', 'zcpri_get_fee_group_data_list', 10, 2);

function zcpri_get_fee_group_data_list($result, $data_args) {
    global $zc_pri;
    if ($data_args['source'] == 'dpd:fee_groups') {
        if (isset($zc_pri['fee_groups'])) {

            foreach ( $zc_pri[ 'fee_groups' ] as $group ) {
                
                $result[ $group[ 'option_id' ] ] = $group[ 'title' ];
            }
        }
        if (count($result) == 0) {
            $result['10280000'] = esc_html__('Grouped Fees', 'zcpri-woopricely');
        }
    }

    return $result;
}
