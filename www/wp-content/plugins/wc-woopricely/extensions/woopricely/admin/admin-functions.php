<?php

//===================
// Products Functions
//===================
if (!function_exists('zcpri_get_product_rule_list')) {

    function zcpri_get_product_rule_list($args) {
        $list = apply_filters('zcpri/get-product-rule-type-groups', array(), $args);
        foreach ($list as $key => $group) {
            $list[$key]['options'] = apply_filters('zcpri/get-product-rule-type-group-' . $key, array(), $args);
        }
        return $list;
    }

}

if (!function_exists('zcpri_get_product_rule_fields')) {

    function zcpri_get_product_rule_fields($args) {
        $field_groups = array();
        $req_field = array(
            array(
                'id' => 'is_req',
                'type' => 'select2',
                'default' => 'yes',
                'options' => array(
                    'no' => esc_html__('Optional', 'zcpri-woopricely'),
                    'yes' => esc_html__('Required', 'zcpri-woopricely'),
                ),
                'dyn_field_id' => 'is_req',
                'width' => '97%',
                'box_width' => '19%',
            )
        );

        foreach (apply_filters('zcpri/get-product-rule-type-fields', array(), $args) as $key => $src_fields) {
            $rules_width = '72%';

            if (isset($args['panel']) && $args['panel'] == 'prodects_in_group') {
                $fields = $src_fields;
                $rules_width = '62%';
            } else {
                $fields = array_merge($req_field, $src_fields);
            }

            $group_field = array(
                'id' => 'rule_type_' . $key,
                'type' => 'group-field',
                'dyn_switcher_target' => 'product_rule_type',
                'dyn_switcher_target_value' => $key,
                'fluid-group' => true,
                'width' => $rules_width,
                'css_class' => array('rn-last'),
            );


            if (count($fields) > 0) {
                $group_field['fields'] = $fields;
                $field_groups[] = $group_field;
            }
        }

        return $field_groups;
    }

}

//=====================
// Conditions Functions
//=====================

if (!function_exists('zcpri_get_condition_list')) {

    function zcpri_get_condition_list($args) {
        $list = apply_filters('zcpri/get-condition-type-groups', array(), $args);
        foreach ($list as $key => $group) {
            $list[$key]['options'] = apply_filters('zcpri/get-condition-type-group-' . $key, array(), $args);
        }
        return $list;
    }

}

if (!function_exists('zcpri_get_condition_fields')) {

    function zcpri_get_condition_fields($args) {
        $field_groups = array();
        $req_field = array(
            array(
                'id' => 'is_req',
                'type' => 'select2',
                'default' => 'yes',
                'options' => array(
                    'no' => esc_html__('Optional', 'zcpri-woopricely'),
                    'yes' => esc_html__('Required', 'zcpri-woopricely'),
                ),
                'width' => '97%',
                'box_width' => '19%',
            )
        );

        foreach (apply_filters('zcpri/get-condition-type-fields', array(), $args) as $key => $src_fields) {


            $fields = array_merge($req_field, $src_fields);
            $group_field = array(
                'id' => 'rule_type_' . $key,
                'type' => 'group-field',
                'dyn_switcher_target' => 'condition_type',
                'dyn_switcher_target_value' => $key,
                'fluid-group' => true,
                'width' => '72%',
                'css_class' => array('rn-last'),
            );

            if (count($fields) > 0) {
                $group_field['fields'] = $fields;
                $field_groups[] = $group_field;
            }
        }
        return $field_groups;
    }

}







