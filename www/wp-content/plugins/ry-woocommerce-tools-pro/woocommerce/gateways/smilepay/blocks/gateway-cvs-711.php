<?php

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

final class RY_SmilePay_Gateway_Cvs_711_Blocks_Support extends AbstractPaymentMethodType
{
    protected $name = 'ry_smilepay_cvs_711';

    private $gateway;

    public function initialize()
    {
        $this->settings = get_option('woocommerce_ry_smilepay_cvs_711_settings', []);
        $payment_gateways = WC()->payment_gateways->payment_gateways();
        $this->gateway = $payment_gateways[$this->name];
    }

    public function is_active()
    {
        return $this->gateway->is_available();
    }

    public function get_payment_method_script_handles()
    {
        $script_asset = include RY_WTP_PLUGIN_DIR . 'assets/blocks/gateways/smilepay/cvs-711.asset.php';

        wp_register_script('ry-smilepay-cvs-711-block', RY_WTP_PLUGIN_URL . 'assets/blocks/gateways/smilepay/cvs-711.js', $script_asset['dependencies'], $script_asset['version'], true);
        wp_set_script_translations('ry-smilepay-cvs-711-block', 'ry-woocommerce-tools-pro', RY_WTP_PLUGIN_LANGUAGES_DIR);

        return ['ry-smilepay-cvs-711-block'];
    }

    public function get_payment_method_data()
    {
        return [
            'title' => $this->get_setting('title'),
            'button_title' => $this->gateway->order_button_text,
            'description' => $this->get_setting('description'),
            'supports' => array_filter($this->gateway->supports, [$this->gateway, 'supports']),
            'icons' => [
                'id' => $this->name,
                'src' => $this->gateway->get_icon_url(),
                'alt' => __('SmilePay', 'ry-woocommerce-tools-pro'),
            ],
        ];
    }
}