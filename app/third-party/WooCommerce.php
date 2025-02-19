<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|---------------------------------------------------------------------- 
| WooCommerce Custom Integration
|---------------------------------------------------------------------- 
| This file handles custom functionality for WooCommerce integration.
| Hooks related to the cart, checkout, and product pages can be added here.
|
| Please ensure that this file is only included when the WooCommerce plugin is active.
|
*/

if (class_exists('WooCommerce')) {

    /*
    |---------------------------------------------------------------------- 
    | Hook: Before Shop Loop
    |---------------------------------------------------------------------- 
    | Custom function to display content before the product loop.
    | This can be used to add custom messages, banners, or promotions.
    |
    */
    add_action('woocommerce_before_shop_loop', 'custom_woocommerce_before_shop_loop', 10);
    function custom_woocommerce_before_shop_loop() {
        echo '<p>Welcome to our shop!</p>';
    }

    /*
    |---------------------------------------------------------------------- 
    | Hook: Add Custom Field to Product Page
    |---------------------------------------------------------------------- 
    | Custom function to add custom fields to the WooCommerce product pages.
    | This could be additional product details or customer instructions.
    |
    */
    add_action('woocommerce_single_product_summary', 'custom_woocommerce_product_field', 25);
    function custom_woocommerce_product_field() {
        echo '<p>Additional product details here.</p>';
    }

    /*
    |---------------------------------------------------------------------- 
    | Hook: Customize Checkout Fields
    |---------------------------------------------------------------------- 
    | Custom function to modify or add fields to the WooCommerce checkout page.
    |
    */
    add_filter('woocommerce_checkout_fields', 'custom_woocommerce_checkout_fields');
    function custom_woocommerce_checkout_fields($fields) {
        $fields['billing']['billing_custom_field'] = array(
            'type'        => 'text',
            'label'       => __('Custom Field', 'woocommerce'),
            'placeholder' => _x('Enter custom info', 'placeholder', 'woocommerce'),
            'required'    => true,
            'clear'       => true,
        );
        return $fields;
    }

}