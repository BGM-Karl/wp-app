<?php

add_filter('reon/get-simple-repeater-field-checkout_price_quantity_ranges-templates', 'zcpri_get_checkout_price_quantity_ranges_template', 10, 2);

function zcpri_get_checkout_price_quantity_ranges_template($in_templates, $args) {

    if ($args['screen'] == 'option-page' && $args['option_name'] == 'zc_pri') {
        $in_templates[] = array(
            'id' => 'range',
        );
    }

    return $in_templates;
}

add_filter('roen/get-simple-repeater-template-checkout_price_quantity_ranges-range-fields', 'zcpri_get_checkout_price_quantity_ranges_template_fields', 10, 2);

function zcpri_get_checkout_price_quantity_ranges_template_fields($in_fields, $args) {

    $in_fields[] = array(
        'id' => 'min_qty',
        'type' => 'textbox',
        'input_type' => 'number',
        'default' => '',
        'placeholder' => esc_html__('Minimum', 'zcpri-woopricely'),
        'width' => '97%',
        'box_width' => '19%',
        'attributes' => array(
            'min' => '0',
            'step' => '1',
        ),
    );

    $in_fields[] = array(
        'id' => 'max_qty',
        'type' => 'textbox',
        'input_type' => 'number',
        'default' => '',
        'placeholder' => esc_html__('No maximum', 'zcpri-woopricely'),
        'width' => '97%',
        'box_width' => '19%',
        'attributes' => array(
            'min' => '0',
            'step' => '1',
        ),
    );

    $in_fields[] = array(
        'id' => 'discount_type',
        'type' => 'select2',
        'options' => array(
            'fixed_price_unit' => esc_html__('Fixed price per unit', 'zcpri-woopricely'),
            'fixed_discount_unit' => esc_html__('Fixed discount amount per unit', 'zcpri-woopricely'),
            'per_discount' => esc_html__('Percentage discount', 'zcpri-woopricely'),
        ),
        'default' => 'fixed_price_unit',
        'width' => '98%',
        'box_width' => '35%',
    );


    $in_fields[] = array(
        'id' => 'amount',
        'type' => 'textbox',
        'input_type' => 'number',
        'default' => '',
        'placeholder' => esc_html__('0.00', 'zcpri-woopricely'),
        'width' => '100%',
        'box_width' => '26%',
        'attributes' => array(
            'min' => '0',
            'step' => '0.01',
        ),
    );





    return $in_fields;
}
