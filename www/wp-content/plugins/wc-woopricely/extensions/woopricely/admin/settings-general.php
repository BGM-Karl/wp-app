<?php

add_filter( 'reon/get-option-page-' . $option_name . '-sections', 'zcpri_get_config_basic_section', 10 );

function zcpri_get_config_basic_section( $in_sections ) {
    $in_sections[] = array(
        'title' => esc_html__( 'General Settings', 'zcpri-woopricely' ),
        'id' => 'general-settings',
    );

    return $in_sections;
}

add_filter( 'get-option-page-' . $option_name . 'section-general-settings-fields', 'zcpri_get_sections_general_settings' );

function zcpri_get_sections_general_settings( $in_fields ) {


    $in_fields[] = array(
        'id' => 'metrics_tables',
        'type' => 'panel',
        'last' => true,
        'white_panel' => false,
        'panel_size' => 'smaller',
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'any_id',
                'type' => 'paneltitle',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Quantity Metrics Table', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Use this panel to apply volume metrics table settings on single product pages', 'zcpri-woopricely' ),
            ),
            array(
                'id' => 'any_id',
                'type' => 'columns-field',
                'columns' => 6,
                'merge_fields' => false,
                'fields' => array(
                    array(
                        'id' => 'enable',
                        'type' => 'select2',
                        'title' => esc_html__( 'Enable', 'zcpri-woopricely' ),
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Enable', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Enables all volume metrics tables on single product pages', 'zcpri-woopricely' ),
                        'default' => 'yes',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'position',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__( 'Position', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Controls metrics tables position on single product pages', 'zcpri-woopricely' ),
                        'default' => 'product_summary_21',
                        'minimum_results_forsearch' => 15,
                        'options' => array(
                            'product_summary_4' => esc_html__( 'Before Product Title', 'zcpri-woopricely' ),
                            'product_summary_6' => esc_html__( 'After Product Title', 'zcpri-woopricely' ),
                            'product_summary_11' => esc_html__( 'After Price', 'zcpri-woopricely' ),
                            'product_summary_21' => esc_html__( 'After Short Description', 'zcpri-woopricely' ),
                            'product_summary_31' => esc_html__( 'After Add To Cart', 'zcpri-woopricely' ),
                            'product_summary_41' => esc_html__( 'After Product Meta', 'zcpri-woopricely' ),
                            'product_summary_51' => esc_html__( 'After Share Buttons', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'layout',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__( 'Layout', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Controls metrics tables layout on single product pages', 'zcpri-woopricely' ),
                        'default' => 'horizontal',
                        'options' => array(
                            'horizontal' => esc_html__( 'Horizontal', 'zcpri-woopricely' ),
                            'vertical' => esc_html__( 'Vertical', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'show_headers',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Show Headers', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Shows all table headers', 'zcpri-woopricely' ),
                        'default' => 'yes',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                ),
            ),
            array(
                'id' => 'tables',
                'type' => 'repeater',
                'filter_id' => 'metrics_tables',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Metrics Tables', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Use this panel to create multiple volume metrics tables', 'zcpri-woopricely' ),
                'white_repeater' => true,
                'repeater_size' => 'smaller',
                'accordions' => true,
                'buttons_sep' => false,
                'default' => array( array( 'group_type' => 'default' ) ),
                'width' => '100%',
                'auto_expand' => array(
                    'new_section' => true,
                    'cloned_section' => true,
                    'default_section' => false,
                ),
                'sortable' => array(
                    'enabled' => false,
                ),
                'static_template' => 'default',
                'section_type_id' => 'group_type',
                'template_adder' => array(
                    'position' => 'right',
                    'show_list' => false,
                    'button_text' => esc_html__( 'Add New Table', 'zcpri-woopricely' ),
                ),
            ),
        ),
    );



    $in_fields[] = array(
        'id' => 'promo_message',
        'type' => 'panel',
        'last' => true,
        'white_panel' => false,
        'panel_size' => 'smaller',
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'any_id',
                'type' => 'paneltitle',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Promo Message Settings', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Use this panel to apply promo message settings on single product pages', 'zcpri-woopricely' ),
            ),
            array(
                'id' => 'any_id',
                'type' => 'columns-field',
                'columns' => 3,
                'merge_fields' => false,
                'fields' => array(
                    array(
                        'id' => 'enable',
                        'type' => 'select2',
                        'title' => esc_html__( 'Enable', 'zcpri-woopricely' ),
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Enable', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Enables promo message on single product pages', 'zcpri-woopricely' ),
                        'default' => 'yes',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'position',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__( 'Position', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Controls promo message position on single product pages', 'zcpri-woopricely' ),
                        'default' => 'product_summary_21',
                        'minimum_results_forsearch' => 15,
                        'options' => array(
                            'product_summary_4' => esc_html__( 'Before Product Title', 'zcpri-woopricely' ),
                            'product_summary_6' => esc_html__( 'After Product Title', 'zcpri-woopricely' ),
                            'product_summary_11' => esc_html__( 'After Price', 'zcpri-woopricely' ),
                            'product_summary_21' => esc_html__( 'After Short Description', 'zcpri-woopricely' ),
                            'product_summary_31' => esc_html__( 'After Add To Cart', 'zcpri-woopricely' ),
                            'product_summary_41' => esc_html__( 'After Product Meta', 'zcpri-woopricely' ),
                            'product_summary_51' => esc_html__( 'After Share Buttons', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                ),
            ),
        ),
    );


    $in_fields[] = array(
        'id' => 'notifications',
        'type' => 'panel',
        'last' => true,
        'white_panel' => false,
        'panel_size' => 'smaller',
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'any_id',
                'type' => 'paneltitle',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Cart/Checkout Notification Settings', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Use this panel to apply notification messages on cart and checkout pages', 'zcpri-woopricely' ),
            ),
            array(
                'id' => 'any_id',
                'type' => 'columns-field',
                'columns' => 3,
                'merge_fields' => false,
                'fields' => array(
                    array(
                        'id' => 'checkout_prices',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Enable Checkout Pricing Notifications', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Enables checkout pricing notifications on cart and checkout pages', 'zcpri-woopricely' ),
                        'default' => 'no',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'checkout_discounts',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Enable Checkout Discounts Notifications', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Enables checkout discounts notifications on cart and checkout pages', 'zcpri-woopricely' ),
                        'default' => 'no',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'checkout_fees',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Enable Checkout Fees Notifications', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Enables checkout fees notifications on cart and checkout pages', 'zcpri-woopricely' ),
                        'default' => 'no',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                ),
            ),
        ),
    );

    $in_fields[] = array(
        'id' => 'countdown_timer',
        'type' => 'columns-field',
        'last' => true,
        'panel' => true,
        'white_panel' => false,
        'panel_size' => 'small',
        'inner_title' => esc_html__( 'Countdown Timer Settings', 'zcpri-woopricely' ),
        'inner_desc' => esc_html__( 'Use this panel to apply countdown timer settings on single product pages', 'zcpri-woopricely' ),
        'columns' => 8,
        'fields' => array(
            array(
                'id' => 'enable',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Enable', 'zcpri-woopricely' ),
                'tooltip' => esc_html__( 'Enables countdoun timer on single product pages', 'zcpri-woopricely' ),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                    'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                ),
                'width' => '100%',
            ),
            array(
                'id' => 'time_left_mode',
                'type' => 'select2',
                'column_size' => 2,
                'column_title' => esc_html__( 'Time Left Mode', 'zcpri-woopricely' ),
                'tooltip' => esc_html__( 'Time left controls when to show the countdown timer', 'zcpri-woopricely' ),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__( 'Unlimited', 'zcpri-woopricely' ),
                    'seconds' => esc_html__( 'Seconds', 'zcpri-woopricely' ),
                    'minutes' => esc_html__( 'Minutes', 'zcpri-woopricely' ),
                    'hours' => esc_html__( 'Hours', 'zcpri-woopricely' ),
                    'days' => esc_html__( 'Days', 'zcpri-woopricely' ),
                    'weeks' => esc_html__( 'Weeks', 'zcpri-woopricely' ),
                    'months' => esc_html__( 'Months', 'zcpri-woopricely' ),
                ),
                'width' => '100%',
                'fold_id' => 'time_left_mode',
            ),
            array(
                'id' => 'time_left',
                'type' => 'textbox',
                'input_type' => 'number',
                'column_size' => 1,
                'column_title' => esc_html__( 'Time Left', 'zcpri-woopricely' ),
                'tooltip' => esc_html__( 'Time left controls when to show the countdown timer', 'zcpri-woopricely' ),
                'default' => '1',
                'placeholder' => esc_html__( '00', 'zcpri-woopricely' ),
                'attributes' => array(
                    'min' => '1',
                    'step' => '1',
                ),
                'width' => '100%',
                'fold' => array(
                    'target' => 'time_left_mode',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'neq', //eq, neq, gt_eq, lt_eq, gt, lt 
                    'clear' => false,
                ),
            ),
            array(
                'id' => 'position',
                'type' => 'select2',
                'column_size' => 2,
                'column_title' => esc_html__( 'Position', 'zcpri-woopricely' ),
                'tooltip' => esc_html__( 'Controls countdoun timer position on single product pages', 'zcpri-woopricely' ),
                'default' => 'product_summary_21',
                'options' => array(
                    'product_summary_4' => esc_html__( 'Before Product Title', 'zcpri-woopricely' ),
                    'product_summary_6' => esc_html__( 'After Product Title', 'zcpri-woopricely' ),
                    'product_summary_11' => esc_html__( 'After Price', 'zcpri-woopricely' ),
                    'product_summary_21' => esc_html__( 'After Short Description', 'zcpri-woopricely' ),
                    'product_summary_31' => esc_html__( 'After Add To Cart', 'zcpri-woopricely' ),
                    'product_summary_41' => esc_html__( 'After Product Meta', 'zcpri-woopricely' ),
                    'product_summary_51' => esc_html__( 'After Share Buttons', 'zcpri-woopricely' ),
                ),
                'width' => '100%',
            ),
            array(
                'id' => 'title',
                'type' => 'textbox',
                'input_type' => 'text',
                'column_size' => 2,
                'column_title' => esc_html__( 'Title', 'zcpri-woopricely' ),
                'tooltip' => esc_html__( 'Controls countdoun timer title on single product pages', 'zcpri-woopricely' ),
                'default' => 'Discount Ends In',
                'placeholder' => esc_html__( 'Title', 'zcpri-woopricely' ),
                'width' => '100%',
            ),
        ),
    );


    $in_fields[] = array(
        'id' => 'discounts_total',
        'type' => 'panel',
        'last' => true,
        'white_panel' => false,
        'panel_size' => 'smaller',
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'any_id',
                'type' => 'paneltitle',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Discounts Total Settings', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Use this panel to apply discounts total settings on cart and checkout pages', 'zcpri-woopricely' ),
            ),
            array(
                'id' => 'enable',
                'type' => 'group-field',
                'title' => esc_html__( 'Show Discounts Total', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Enables discounts total amount on both cart and checkout pages', 'zcpri-woopricely' ),
                'width' => '100%',
                'fields' => array(
                    array(
                        'id' => 'on_car',
                        'type' => 'select2',
                        'label' => array(
                            'title' => esc_html__( 'On Cart:', 'zcpri-woopricely' ),
                        ),
                        'default' => 'yes_neg',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                            'yes_neg' => esc_html__( 'Yes (with minus)', 'zcpri-woopricely' ),
                        ),
                        'width' => '152px',
                    ),
                    array(
                        'id' => 'on_checkout',
                        'type' => 'select2',
                        'label' => array(
                            'title' => esc_html__( 'On Checkout:', 'zcpri-woopricely' ),
                        ),
                        'default' => 'yes_neg',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                            'yes_neg' => esc_html__( 'Yes (with minus)', 'zcpri-woopricely' ),
                        ),
                        'width' => '152px',
                    ),
                ),
            ),
            array(
                'id' => 'titles',
                'type' => 'group-field',
                'title' => esc_html__( 'Titles', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Controls discounts total titles on both cart and checkout pages', 'zcpri-woopricely' ),
                'width' => '100%',
                'fields' => array(
                    array(
                        'id' => 'cart',
                        'type' => 'textbox',
                        'label' => array(
                            'title' => esc_html__( 'Cart:', 'zcpri-woopricely' ),
                        ),
                        'default' => 'Discounts Total:',
                        'placeholder' => esc_html__( 'Discounts Total', 'zcpri-woopricely' ),
                        'width' => '172px',
                    ),
                    array(
                        'id' => 'checkout',
                        'type' => 'textbox',
                        'label' => array(
                            'title' => esc_html__( 'Checkout:', 'zcpri-woopricely' ),
                        ),
                        'default' => 'Discounts Total:',
                        'placeholder' => esc_html__( 'Discounts Total', 'zcpri-woopricely' ),
                        'width' => '172px',
                    ),
                ),
            ),
            array(
                'id' => 'positions',
                'type' => 'group-field',
                'title' => esc_html__( 'Positions', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Controls discounts total position on both cart and checkout pages', 'zcpri-woopricely' ),
                'width' => '100%',
                'fields' => array(
                    array(
                        'id' => 'car',
                        'type' => 'select2',
                        'label' => array(
                            'title' => esc_html__( 'Cart:', 'zcpri-woopricely' ),
                        ),
                        'default' => 'after_order_total',
                        'options' => array(
                            'before_shipping' => esc_html__( 'Shipping (Before)', 'zcpri-woopricely' ),
                            'after_shipping' => esc_html__( 'Shipping (After)', 'zcpri-woopricely' ),
                            'before_order_total' => esc_html__( 'Totals (Before)', 'zcpri-woopricely' ),
                            'after_order_total' => esc_html__( 'Totals (After)', 'zcpri-woopricely' ),
                        ),
                        'width' => '172px',
                    ),
                    array(
                        'id' => 'checkout',
                        'type' => 'select2',
                        'label' => array(
                            'title' => esc_html__( 'Checkout:', 'zcpri-woopricely' ),
                        ),
                        'default' => 'after_order_total',
                        'options' => array(
                            'before_cart_contents' => esc_html__( 'Products (Before)', 'zcpri-woopricely' ),
                            'after_cart_contents' => esc_html__( 'Products (After)', 'zcpri-woopricely' ),
                            'before_shipping' => esc_html__( 'Shipping (Before)', 'zcpri-woopricely' ),
                            'after_shipping' => esc_html__( 'Shipping (After)', 'zcpri-woopricely' ),
                            'before_order_total' => esc_html__( 'Totals (Before)', 'zcpri-woopricely' ),
                            'after_order_total' => esc_html__( 'Totals (After)', 'zcpri-woopricely' ),
                        ),
                        'width' => '172px',
                    ),
                ),
            ),
        ),
    );

    $in_fields[] = array(
        'id' => 'cart_discounts',
        'type' => 'panel',
        'last' => true,
        'white_panel' => false,
        'panel_size' => 'smaller',
        'width' => '100%',
        'merge_fields' => false,
        'fields' => array(
            array(
                'id' => 'discount_groups_mode',
                'type' => 'select2',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Grouped Discounts Apply Mode', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Controls checkout grouped discounts apply mode', 'zcpri-woopricely' ),
                'default' => 'yes',
                'options' => array(
                    'all' => esc_html__( 'Apply all group discounts', 'zcpri-woopricely' ),
                    'bigger' => esc_html__( 'Apply bigger discount per group', 'zcpri-woopricely' ),
                    'smaller' => esc_html__( 'Apply smaller discount per group', 'zcpri-woopricely' ),
                    'first' => esc_html__( 'Apply first discount per group', 'zcpri-woopricely' ),
                    'last' => esc_html__( 'Apply last discount  per group', 'zcpri-woopricely' ),
                ),
                'width' => '350px',
            ),
            array(
                'id' => 'discount_coupon',
                'type' => 'columns-field',
                'last' => true,
                'columns' => 3,
                'panel' => true,
                'white_panel' => true,
                'panel_size' => 'small',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Checkout Discount Coupons', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Use this panel to apply discounts as coupons', 'zcpri-woopricely' ),
                'fields' => array(
                    array(
                        'id' => 'enable',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Apply As Coupons', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Applys checkout discounts as coupon codes', 'zcpri-woopricely' ),
                        'default' => 'no',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'allow_others',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Allow other coupon codes', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Allows other coupons on the cart', 'zcpri-woopricely' ),
                        'default' => 'yes',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'replace_labels',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Replace coupon labels', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Replaces coupon codes with discount labels', 'zcpri-woopricely' ),
                        'default' => 'no',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'width' => '100%',
                    ),
                )
            ),
            array(
                'id' => 'discount_groups',
                'type' => 'repeater',
                'filter_id' => 'discount_groups',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Checkout Discount Groups', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Multiple discounts can be assigned to a single group, use this controls to create those groups', 'zcpri-woopricely' ),
                'white_repeater' => true,
                'repeater_size' => 'smaller',
                'accordions' => true,
                'buttons_sep' => false,
                'default' => array( array( 'group_type' => 'default' ) ),
                'width' => '100%',
                'auto_expand' => array(
                    'new_section' => true,
                    'cloned_section' => true,
                    'default_section' => false,
                ),
                'sortable' => array(
                    'enabled' => false,
                ),
                'static_template' => 'default',
                'section_type_id' => 'group_type',
                'template_adder' => array(
                    'position' => 'right',
                    'show_list' => false,
                    'button_text' => esc_html__( 'Add Discount Group', 'zcpri-woopricely' ),
                ),
            )
        ),
    );

    $in_fields[] = array(
        'id' => 'any_id',
        'type' => 'panel',
        'last' => true,
        'white_panel' => false,
        'panel_size' => 'smaller',
        'merge_fields' => false,
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'fee_groups_mode',
                'type' => 'select2',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Grouped Fees Apply Mode', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Controls checkout grouped fees apply mode', 'zcpri-woopricely' ),
                'default' => 'yes',
                'options' => array(
                    'all' => esc_html__( 'Apply all group fees', 'zcpri-woopricely' ),
                    'bigger' => esc_html__( 'Apply bigger fee per group', 'zcpri-woopricely' ),
                    'smaller' => esc_html__( 'Apply smaller fee per group', 'zcpri-woopricely' ),
                    'first' => esc_html__( 'Apply first fee per group', 'zcpri-woopricely' ),
                    'last' => esc_html__( 'Apply last fee  per group', 'zcpri-woopricely' ),
                ),
                'width' => '350px',
            ),
            array(
                'id' => 'fee_groups',
                'type' => 'repeater',
                'filter_id' => 'fee_groups',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Checkout Fee Groups', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Multiple fees can be assigned to a single group, use this controls to create those groups', 'zcpri-woopricely' ),
                'white_repeater' => true,
                'repeater_size' => 'smaller',
                'accordions' => true,
                'buttons_sep' => false,
                'default' => array( array( 'group_type' => 'default' ) ),
                'width' => '100%',
                'auto_expand' => array(
                    'new_section' => true,
                    'cloned_section' => true,
                    'default_section' => false,
                ),
                'sortable' => array(
                    'enabled' => false,
                ),
                'static_template' => 'default',
                'section_type_id' => 'group_type',
                'template_adder' => array(
                    'position' => 'right',
                    'show_list' => false,
                    'button_text' => esc_html__( 'Add Fee Group', 'zcpri-woopricely' ),
                ),
            )
        ),
    );


    $in_fields[] = array(
        'id' => 'on_sale_products',
        'type' => 'panel',
        'last' => true,
        'white_panel' => false,
        'panel_size' => 'smaller',
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'any_id',
                'type' => 'paneltitle',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Products On Sale Query Settings', 'zcpri-woopricely' ),
                'desc' => wp_kses_post( __( 'Use this panel to apply products on sale query settings, use <a href="https://docs.woocommerce.com/document/woocommerce-shortcodes/" target="_blank">WooCommerce shortcodes</a> to display your products', 'zcpri-woopricely' ) ),
            ),
            array(
                'id' => 'any_id',
                'type' => 'columns-field',
                'columns' => 9,
                'merge_fields' => false,
                'fields' => array(
                    array(
                        'id' => 'enable',
                        'type' => 'select2',
                        'column_size' => 1,
                        'column_title' => esc_html__( 'Enable', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Enables products on sale query', 'zcpri-woopricely' ),
                        'default' => 'no',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'fold_id' => 'on_sale_enable',
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'product_count',
                        'type' => 'textbox',
                        'input_type' => 'number',
                        'column_size' => 2,
                        'column_title' => esc_html__( 'Number of Products', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Controls the maximum total number of products to query', 'zcpri-woopricely' ),
                        'default' => '50',
                        'placeholder' => esc_html__( '0.00', 'zcpri-woopricely' ),
                        'width' => '100%',
                        'attributes' => array(
                            'min' => '0',
                            'step' => '1',
                        ),
                        'fold' => array(
                            'target' => 'on_sale_enable',
                            'attribute' => 'value',
                            'value' => 'yes',
                            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => false,
                        ),
                    ),
                    array(
                        'id' => 'replace_default',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__( 'Replace Default Products', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Replaces woocommerce default products on sale', 'zcpri-woopricely' ),
                        'default' => 'no',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'fold' => array(
                            'target' => 'on_sale_enable',
                            'attribute' => 'value',
                            'value' => 'yes',
                            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => false,
                        ),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'debug_mode',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__( 'Debug Mode', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Enables/Disables query cache', 'zcpri-woopricely' ),
                        'default' => 'no',
                        'options' => array(
                            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                        ),
                        'fold' => array(
                            'target' => 'on_sale_enable',
                            'attribute' => 'value',
                            'value' => 'yes',
                            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => false,
                        ),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'cache_duration',
                        'type' => 'textbox',
                        'input_type' => 'number',
                        'column_size' => 2,
                        'column_title' => esc_html__( 'Cache Duration (in minutes)', 'zcpri-woopricely' ),
                        'tooltip' => esc_html__( 'Controls the cache duration on the query in minutes', 'zcpri-woopricely' ),
                        'default' => '30',
                        'placeholder' => esc_html__( '0.00', 'zcpri-woopricely' ),
                        'width' => '100%',
                        'attributes' => array(
                            'min' => '0',
                            'step' => '1',
                        ),
                        'fold' => array(
                            'target' => 'on_sale_enable',
                            'attribute' => 'value',
                            'value' => 'yes',
                            'oparator' => 'eq', //eq, neq, gt_eq, lt_eq, gt, lt 
                            'clear' => false,
                        ),
                    ),
                ),
            ),
        ),
    );

    $in_fields[] = array(
        'id' => 'any_id',
        'type' => 'panel',
        'last' => true,
        'white_panel' => false,
        'panel_size' => 'smaller',
        'width' => '100%',
        'merge_fields' => false,
        'fields' => array(
            array(
                'id' => 'checkout_prices_conditions_modes',
                'type' => 'simple-repeater',
                'filter_id' => 'checkout_prices_products_mode',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Checkout Pricing: Conditions Validation Modes', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Use this panel to control checkout pricing validation mode for conditions', 'zcpri-woopricely' ),
                'white_repeater' => true,
                'repeater_size' => 'smaller',
                'buttons_sep' => false,
                'buttons_box_width' => '65px',
                'width' => '100%',
                'default' => array( array( 'group_type' => 'mode' ) ),
                'sortable' => array(
                    'enabled' => false,
                ),
                'template_adder' => array(
                    'position' => 'right', //left, right
                    'show_list' => false,
                    'button_text' => esc_html__( 'Add Validation Mode', 'zcpri-woopricely' ),
                ),
            ),
        ),
    );


    $custom_css = ".zc_zri_promo{
       border: 1px solid #ffc000;
       background-color: #ffe38d;
       color: #5f4700;
}
.zcpri_metrics_table table{
       border-top: 1px solid #ccc;
}
.zcpri_metrics_table tr{
       border-bottom: 1px solid #ccc;
}
.zcpri_metrics_table th,.zcpri_metrics_table td{
       padding: 5px;
}";


    $in_fields[] = array(
        'id' => 'any_id',
        'type' => 'panel',
        'white_panel' => false,
        'panel_size' => 'smaller',
        'merge_fields' => false,
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'custom_css',
                'type' => 'textarea',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Custom CSS', 'zcpri-woopricely' ),
                'desc' => esc_html__( 'Additional css for, promo message, metric tables, count down timer, discounts and fees html', 'zcpri-woopricely' ),
                'default' => $custom_css,
                'placeholder' => esc_html__( 'Type here...', 'zcpri-woopricely' ),
                'width' => '100%',
                'cols' => '80',
                'rows' => '5',
                'height' => '50px'
            )
        ),
    );

    return $in_fields;
}

//========================
//Discount Groups Repeater
//========================
add_filter( 'reon/get-repeater-field-discount_groups-templates', 'zcpri_get_discount_groups_template', 10, 2 );

function zcpri_get_discount_groups_template( $in_templates, $args ) {

    if ( $args[ 'screen' ] == 'option-page' && $args[ 'option_name' ] == 'zc_pri' ) {

        $in_templates[] = array(
            'id' => 'default',
            'head' => array(
                'title' => '',
                'title_field' => 'title',
                'defaut_title' => esc_html__( 'Grouped Discounts', 'zcpri-woopricely' ),
            )
        );

        $in_templates[] = array(
            'id' => 'group',
            'head' => array(
                'title' => '',
                'title_field' => 'title',
                'defaut_title' => esc_html__( 'Grouped Discounts', 'zcpri-woopricely' ),
            )
        );
    }

    return $in_templates;
}

add_filter( 'roen/get-repeater-template-discount_groups-default-fields', 'zcpri_get_def_discount_groups_template_fields', 10, 2 );
add_filter( 'roen/get-repeater-template-discount_groups-group-fields', 'zcpri_get_grp_discount_groups_template_fields', 10, 2 );

function zcpri_get_def_discount_groups_template_fields( $in_fields, $args ) {

    $in_fields[] = array(
        'id' => 'option_id',
        'type' => 'hidden',
        'value' => '10280000',
    );

    return zcpri_get_discount_groups_template_fields( $in_fields, $args );
}

function zcpri_get_grp_discount_groups_template_fields( $in_fields, $args ) {

    $in_fields[] = array(
        'id' => 'option_id',
        'type' => 'autoid',
        'autoid' => 'woopricely',
    );

    return zcpri_get_discount_groups_template_fields( $in_fields, $args );
}

function zcpri_get_discount_groups_template_fields( $in_fields, $args ) {

    $in_fields[] = array(
        'id' => 'title',
        'type' => 'textbox',
        'title' => esc_html__( 'Title', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls the discounts group label', 'zcpri-woopricely' ),
        'default' => 'Grouped Discounts',
        'placeholder' => esc_html__( 'Type here...', 'zcpri-woopricely' ),
        'width' => '400px',
    );

    $in_fields[] = array(
        'id' => 'desc',
        'type' => 'textbox',
        'title' => esc_html__( 'Description', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls the discounts group description', 'zcpri-woopricely' ),
        'default' => '',
        'placeholder' => esc_html__( 'Type here...', 'zcpri-woopricely' ),
        'width' => '400px',
    );

    $in_fields[] = array(
        'id' => 'notification',
        'type' => 'textbox',
        'title' => esc_html__( 'Cart/Checkout Notification', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls the notification message on cart and checkout pages', 'zcpri-woopricely' ),
        'default' => '',
        'placeholder' => esc_html__( 'Type here...', 'zcpri-woopricely' ),
        'width' => '400px',
    );

    $in_fields[] = array(
        'id' => 'min',
        'type' => 'textbox',
        'input_type' => 'number',
        'title' => esc_html__( 'Minimum Discount', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls the discounts group minimum value', 'zcpri-woopricely' ),
        'default' => '',
        'placeholder' => esc_html__( '0 Minimum', 'zcpri-woopricely' ),
        'attributes' => array(
            'min' => '0',
            'step' => '0.01',
        ),
        'width' => '400px',
    );

    $in_fields[] = array(
        'id' => 'max',
        'type' => 'textbox',
        'input_type' => 'number',
        'title' => esc_html__( 'Maximum Discount', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls the discounts group maximum value', 'zcpri-woopricely' ),
        'default' => '',
        'placeholder' => esc_html__( 'No Maximum', 'zcpri-woopricely' ),
        'attributes' => array(
            'min' => '0',
            'step' => '0.01',
        ),
        'width' => '400px',
    );

    $in_fields[] = array(
        'id' => 'coupon_code',
        'type' => 'textbox',
        'title' => esc_html__( 'Coupon Code', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Specify the coupon code for this discounts group', 'zcpri-woopricely' ),
        'default' => '',
        'placeholder' => esc_html__( 'xx-xxxxx', 'zcpri-woopricely' ),
        'width' => '400px',
    );

    $in_fields[] = array(
        'id' => 'always_show',
        'type' => 'select2',
        'title' => esc_html__( 'Always Show', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Hide this discount group if discount value is zero', 'zcpri-woopricely' ),
        'default' => 'no',
        'options' => array(
            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
        ),
        'width' => '400px',
    );

    return $in_fields;
}

//===================
//Fee Groups Repeater
//===================
add_filter( 'reon/get-repeater-field-fee_groups-templates', 'zcpri_get_fee_groups_template', 10, 2 );

function zcpri_get_fee_groups_template( $in_templates, $args ) {

    if ( $args[ 'screen' ] == 'option-page' && $args[ 'option_name' ] == 'zc_pri' ) {

        $in_templates[] = array(
            'id' => 'default',
            'head' => array(
                'title' => '',
                'title_field' => 'title',
                'defaut_title' => esc_html__( 'Grouped Fees', 'zcpri-woopricely' ),
            )
        );

        $in_templates[] = array(
            'id' => 'group',
            'head' => array(
                'title' => '',
                'title_field' => 'title',
                'defaut_title' => esc_html__( 'Grouped Fees', 'zcpri-woopricely' ),
            )
        );
    }

    return $in_templates;
}

add_filter( 'roen/get-repeater-template-fee_groups-default-fields', 'zcpri_get_def_fee_groups_template_fields', 10, 2 );
add_filter( 'roen/get-repeater-template-fee_groups-group-fields', 'zcpri_get_grp_fee_groups_template_fields', 10, 2 );

function zcpri_get_def_fee_groups_template_fields( $in_fields, $args ) {

    $in_fields[] = array(
        'id' => 'option_id',
        'type' => 'hidden',
        'value' => '10280000',
    );

    return zcpri_get_fee_groups_template_fields( $in_fields, $args );
}

function zcpri_get_grp_fee_groups_template_fields( $in_fields, $args ) {

    $in_fields[] = array(
        'id' => 'option_id',
        'type' => 'autoid',
        'autoid' => 'woopricely',
    );

    return zcpri_get_fee_groups_template_fields( $in_fields, $args );
}

function zcpri_get_fee_groups_template_fields( $in_fields, $args ) {

    $in_fields[] = array(
        'id' => 'title',
        'type' => 'textbox',
        'title' => esc_html__( 'Title', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls the fee group label', 'zcpri-woopricely' ),
        'default' => 'Grouped Fees',
        'placeholder' => esc_html__( 'Type here...', 'zcpri-woopricely' ),
        'width' => '400px',
    );

    $in_fields[] = array(
        'id' => 'desc',
        'type' => 'textbox',
        'title' => esc_html__( 'Description', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls the fee group description', 'zcpri-woopricely' ),
        'default' => '',
        'placeholder' => esc_html__( 'Type here...', 'zcpri-woopricely' ),
        'width' => '400px',
    );

    $in_fields[] = array(
        'id' => 'notification',
        'type' => 'textbox',
        'title' => esc_html__( 'Cart/Checkout Notification', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls the notification message on cart and checkout pages', 'zcpri-woopricely' ),
        'default' => '',
        'placeholder' => esc_html__( 'Type here...', 'zcpri-woopricely' ),
        'width' => '400px',
    );

    $in_fields[] = array(
        'id' => 'min',
        'type' => 'textbox',
        'input_type' => 'number',
        'title' => esc_html__( 'Minimum Fee', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls the fees group minimum value', 'zcpri-woopricely' ),
        'default' => '',
        'placeholder' => esc_html__( '0 Minimum', 'zcpri-woopricely' ),
        'attributes' => array(
            'min' => '0',
            'step' => '0.01',
        ),
        'width' => '400px',
    );

    $in_fields[] = array(
        'id' => 'max',
        'type' => 'textbox',
        'input_type' => 'number',
        'title' => esc_html__( 'Maximum Fee', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls the fees group maximum value', 'zcpri-woopricely' ),
        'default' => '',
        'placeholder' => esc_html__( 'No Maximum', 'zcpri-woopricely' ),
        'attributes' => array(
            'min' => '0',
            'step' => '0.01',
        ),
        'width' => '400px',
    );

    $in_fields[] = array(
        'id' => 'taxable',
        'type' => 'select2',
        'title' => esc_html__( 'Tax Class', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Specify the tax class for this fees group', 'zcpri-woopricely' ),
        'default' => 'no',
        'options' => array(
            '--1' => esc_html__( 'Not Taxable', 'zcpri-woopricely' ),
            '' => esc_html__( 'Standard', 'zcpri-woopricely' ),
        ),
        'data' => 'wc:tax_classes',
        'width' => '400px',
    );



    $in_fields[] = array(
        'id' => 'always_show',
        'type' => 'select2',
        'title' => esc_html__( 'Always Show', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Hide this fee group if fee value is zero', 'zcpri-woopricely' ),
        'default' => 'no',
        'options' => array(
            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
        ),
        'width' => '400px',
    );

    return $in_fields;
}

//=============================
//Volume Metrics Table Repeater
//=============================

add_filter( 'reon/get-repeater-field-metrics_tables-templates', 'zcpri_get_volume_metrics_tables_template', 10, 2 );

function zcpri_get_volume_metrics_tables_template( $in_templates, $args ) {

    if ( $args[ 'screen' ] == 'option-page' && $args[ 'option_name' ] == 'zc_pri' ) {

        $in_templates[] = array(
            'id' => 'default',
            'head' => array(
                'title' => '',
                'title_field' => 'title',
                'defaut_title' => esc_html__( 'Volume Pricing', 'zcpri-woopricely' ),
            )
        );

        $in_templates[] = array(
            'id' => 'group',
            'head' => array(
                'title' => '',
                'title_field' => 'title',
                'defaut_title' => esc_html__( 'Volume Pricing', 'zcpri-woopricely' ),
            )
        );
    }

    return $in_templates;
}

add_filter( 'roen/get-repeater-template-metrics_tables-default-fields', 'zcpri_get_def_volume_metrics_tables_template_fields', 10, 2 );
add_filter( 'roen/get-repeater-template-metrics_tables-group-fields', 'zcpri_get_grp_volume_metrics_tables_template_fields', 10, 2 );

function zcpri_get_def_volume_metrics_tables_template_fields( $in_fields, $args ) {

    $in_fields[] = array(
        'id' => 'option_id',
        'type' => 'hidden',
        'value' => '10280000',
    );

    return zcpri_get_volume_metrics_tables_template_fields( $in_fields, $args );
}

function zcpri_get_grp_volume_metrics_tables_template_fields( $in_fields, $args ) {

    $in_fields[] = array(
        'id' => 'option_id',
        'type' => 'autoid',
        'autoid' => 'woopricely',
    );

    return zcpri_get_volume_metrics_tables_template_fields( $in_fields, $args );
}

function zcpri_get_volume_metrics_tables_template_fields( $in_fields, $args ) {

    $in_fields[] = array(
        'id' => 'table_title',
        'type' => 'group-field',
        'title' => esc_html__( 'Table Title', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls metrics table title', 'zcpri-woopricely' ),
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'enable',
                'type' => 'select2',
                'label' => array(
                    'title' => esc_html__( 'Show:', 'zcpri-woopricely' ),
                ),
                'default' => 'yes',
                'options' => array(
                    'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                    'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                ),
                'width' => '90px',
            ),
            array(
                'id' => 'title',
                'type' => 'textbox',
                'label' => array(
                    'title' => esc_html__( 'Text:', 'zcpri-woopricely' ),
                ),
                'default' => 'Volume Pricing',
                'placeholder' => esc_html__( 'Table title', 'zcpri-woopricely' ),
                'width' => '197px',
            ),
        ),
    );


    $in_fields[] = array(
        'id' => 'quatity_row',
        'type' => 'group-field',
        'title' => esc_html__( 'Quantity Row', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls metrics table quantity row', 'zcpri-woopricely' ),
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'enable',
                'type' => 'select2',
                'label' => array(
                    'title' => esc_html__( 'Show:', 'zcpri-woopricely' ),
                ),
                'default' => 'yes',
                'options' => array(
                    'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                    'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                ),
                'width' => '90px',
            ),
            array(
                'id' => 'label',
                'type' => 'textbox',
                'label' => array(
                    'title' => esc_html__( 'Row Label:', 'zcpri-woopricely' ),
                ),
                'default' => 'Qty',
                'placeholder' => esc_html__( 'Quantity row label', 'zcpri-woopricely' ),
                'width' => '162px',
            ),
        ),
    );


    $in_fields[] = array(
        'id' => 'price_row',
        'type' => 'group-field',
        'title' => esc_html__( 'Price Row', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls metrics table price row', 'zcpri-woopricely' ),
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'enable',
                'type' => 'select2',
                'label' => array(
                    'title' => esc_html__( 'Show:', 'zcpri-woopricely' ),
                ),
                'default' => 'yes',
                'options' => array(
                    'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                    'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                ),
                'width' => '90px',
            ),
            array(
                'id' => 'label',
                'type' => 'textbox',
                'label' => array(
                    'title' => esc_html__( 'Row Label:', 'zcpri-woopricely' ),
                ),
                'default' => 'Price',
                'placeholder' => esc_html__( 'Price row label', 'zcpri-woopricely' ),
                'width' => '162px',
            ),
        ),
    );


    $in_fields[] = array(
        'id' => 'price_per_row',
        'type' => 'group-field',
        'title' => esc_html__( 'Price Percent Row', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls metrics table price row', 'zcpri-woopricely' ),
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'enable',
                'type' => 'select2',
                'label' => array(
                    'title' => esc_html__( 'Show:', 'zcpri-woopricely' ),
                ),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                    'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                ),
                'width' => '90px',
            ),
            array(
                'id' => 'label',
                'type' => 'textbox',
                'label' => array(
                    'title' => esc_html__( 'Row Label:', 'zcpri-woopricely' ),
                ),
                'default' => 'Price (%)',
                'placeholder' => esc_html__( 'Price (%) row label', 'zcpri-woopricely' ),
                'width' => '162px',
            ),
        ),
    );

    $in_fields[] = array(
        'id' => 'discount_row',
        'type' => 'group-field',
        'title' => esc_html__( 'Discount Row', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls metrics table discount amount row', 'zcpri-woopricely' ),
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'enable',
                'type' => 'select2',
                'label' => array(
                    'title' => esc_html__( 'Show:', 'zcpri-woopricely' ),
                ),
                'default' => 'yes',
                'options' => array(
                    'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                    'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                ),
                'width' => '90px',
            ),
            array(
                'id' => 'label',
                'type' => 'textbox',
                'label' => array(
                    'title' => esc_html__( 'Row Label:', 'zcpri-woopricely' ),
                ),
                'default' => 'Discount',
                'placeholder' => esc_html__( 'Discount row label', 'zcpri-woopricely' ),
                'width' => '162px',
            ),
        ),
    );

    $in_fields[] = array(
        'id' => 'discount_per_row',
        'type' => 'group-field',
        'title' => esc_html__( 'Discount Percent Row', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls metrics table discount percentage row', 'zcpri-woopricely' ),
        'width' => '100%',
        'fields' => array(
            array(
                'id' => 'enable',
                'type' => 'select2',
                'label' => array(
                    'title' => esc_html__( 'Show:', 'zcpri-woopricely' ),
                ),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__( 'No', 'zcpri-woopricely' ),
                    'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
                ),
                'width' => '90px',
            ),
            array(
                'id' => 'label',
                'type' => 'textbox',
                'label' => array(
                    'title' => esc_html__( 'Row Label:', 'zcpri-woopricely' ),
                ),
                'default' => 'Discount (%)',
                'placeholder' => esc_html__( 'Discount (%) row label', 'zcpri-woopricely' ),
                'width' => '162px',
            ),
        ),
    );

    $in_fields[] = array(
        'id' => 'show_missed_ranges',
        'type' => 'select2',
        'title' => esc_html__( 'Show Missing Ranges', 'zcpri-woopricely' ),
        'desc' => esc_html__( 'Controls missing ranges visibility', 'zcpri-woopricely' ),
        'default' => 'yes',
        'options' => array(
            'no' => esc_html__( 'No', 'zcpri-woopricely' ),
            'yes' => esc_html__( 'Yes', 'zcpri-woopricely' ),
        ),
        'width' => '396px',
    );


    return $in_fields;
}

//============================
//Products Rule Modes Repeater
//============================
add_filter( 'reon/get-simple-repeater-field-checkout_prices_products_mode-templates', 'zcpri_get_checkout_prices_products_mode_template', 10, 2 );

function zcpri_get_checkout_prices_products_mode_template( $in_templates, $args ) {

    if ( $args[ 'screen' ] == 'option-page' && $args[ 'option_name' ] == 'zc_pri' ) {
        $in_templates[] = array(
            'id' => 'mode',
        );
    }

    return $in_templates;
}

add_filter( 'roen/get-simple-repeater-template-checkout_prices_products_mode-mode-fields', 'zcpri_get_checkout_prices_products_mode_template_mode_fields', 10, 2 );

function zcpri_get_checkout_prices_products_mode_template_mode_fields( $in_fields, $args ) {
    $rule_args = array(
        'section' => 'checkout_prices',
        'panel' => 'conditions',
    );

    $options = array(
        '' => esc_html__( 'All Conditions', 'zcpri-woopricely' ),
    );

    foreach ( zcpri_get_condition_list( $rule_args ) as $key => $value ) {
        $options[ $key ] = $value;
    }

    $in_fields[] = array(
        'id' => 'rule_type',
        'type' => 'select2',
        'default' => 'no',
        'options' => $options,
        'width' => '98%',
        'box_width' => '42%',
    );

    $in_fields[] = array(
        'id' => 'mode',
        'type' => 'select2',
        'default' => 'cart_checkout_product',
        'options' => array(
            'cart_checkout_product' => esc_html__( 'Validate on cart, checkout and products page', 'zcpri-woopricely' ),
            'cart_checkout' => esc_html__( 'Validate on cart and checkout page only', 'zcpri-woopricely' ),
        ),
        'width' => '100%',
        'box_width' => '58%',
    );


    return $in_fields;
}
