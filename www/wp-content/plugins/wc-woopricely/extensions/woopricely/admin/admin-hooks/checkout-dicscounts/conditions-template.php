<?php

add_filter('reon/get-simple-repeater-field-discount_conditions-templates', 'zcpri_get_discount_conditions_template', 10, 2);

function zcpri_get_discount_conditions_template($in_templates, $args) {

    if ($args['screen'] == 'option-page' && $args['option_name'] == 'zc_pri') {
        $in_templates[] = array(
            'id' => 'conditions',
        );
    }

    return $in_templates;
}

add_filter('roen/get-simple-repeater-template-discount_conditions-conditions-fields', 'zcpri_get_discount_conditions_template_fields', 10, 2);

function zcpri_get_discount_conditions_template_fields($in_fields, $args) {
    $rule_args = array(
        'section' => 'checkout_discounts',
        'panel' => 'conditions',
    );

    $in_fields[] = array(
        'id' => 'rule_type',
        'type' => 'select2',
        'default' => 'no',
        'options' => zcpri_get_condition_list($rule_args),
        'width' => '97%',
        'box_width' => '28%',
        'dyn_switcher_id' => 'condition_type',
    );


    foreach (zcpri_get_condition_fields($rule_args) as $fld) {
        $in_fields[] = $fld;
    }

    return $in_fields;
}
