<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Custom Script Management with ACF Options
|----------------------------------------------------------------------
|
| This code provides an interface in the WordPress admin for managing
| custom scripts. The scripts can be added in three key locations:
| 
| 1. Header (inside <head> tag)
| 2. Body (right after the opening <body> tag)
| 3. Footer (before the closing </body> tag)
|
| Using the ACF (Advanced Custom Fields) plugin, custom fields are created
| for each script, which can be managed directly from the WordPress admin.
|
| The functions hook into WordPress actions to output the scripts in 
| the correct locations in the theme's layout.
|
*/

// Check if ACF is active before proceeding
if ( function_exists( 'acf_add_options_page' ) ) {

    // Add an options page under the "Settings" menu for managing scripts
    acf_add_options_page(array(
        'page_title'    => __('Custom Script Management', 'your-text-domain'), // Page title for the options page
        'menu_title'    => __('Custom Scripts', 'your-text-domain'), // Menu item title
        'menu_slug'     => 'custom-script-management', // The slug for the options page
        'capability'    => 'manage_options', // The user capability required to access the page
        'parent_slug'   => 'options-general.php', // Parent menu slug (this adds it under Settings)
        'redirect'      => false, // Prevent redirection to another page after saving
    ));
    
    // Add a field group for managing custom scripts via ACF
    if( function_exists('acf_add_local_field_group') ) {
        acf_add_local_field_group(array(
            'key' => 'group_custom_scripts', // Unique group key
            'title' => __('Custom Scripts', 'your-text-domain'), // Title of the field group
            'fields' => array(
                // Field for the custom header script
                array(
                    'key' => 'field_custom_script_header', // Unique field key
                    'label' => __('Header Script', 'your-text-domain'), // Label for the field
                    'name' => 'custom_script_header', // Name of the field
                    'type' => 'textarea', // Field type (textarea for entering JavaScript)
                    'instructions' => __('Enter your custom header script here.', 'your-text-domain'), // Instructions for the field
                    'rows' => 5, // Number of rows for the textarea
                ),
                // Field for the custom body script
                array(
                    'key' => 'field_custom_script_body', 
                    'label' => __('Body Script', 'your-text-domain'),
                    'name' => 'custom_script_body',
                    'type' => 'textarea',
                    'instructions' => __('Enter your custom body script here.', 'your-text-domain'),
                    'rows' => 5,
                ),
                // Field for the custom footer script
                array(
                    'key' => 'field_custom_script_footer',
                    'label' => __('Footer Script', 'your-text-domain'),
                    'name' => 'custom_script_footer',
                    'type' => 'textarea',
                    'instructions' => __('Enter your custom footer script here.', 'your-text-domain'),
                    'rows' => 5,
                ),
            ),
            // Specify where this field group should appear (on the options page)
            'location' => array(
                array(
                    array(
                        'param' => 'options_page', // Apply to options page
                        'operator' => '==',
                        'value' => 'custom-script-management', // Matching the options page slug
                    ),
                ),
            ),
        ));
    }

    /*
    |----------------------------------------------------------------------
    | Custom Script Injections for WordPress Theme
    |----------------------------------------------------------------------
    |
    | These actions allow for custom scripts to be added at different points
    | in the theme's layout. The hooks `wp_body_open`, `wp_footer`, and `wp_head`
    | are used to inject scripts in various positions: after the <body> tag, 
    | before the closing </body> tag, and inside the <head> tag.
    |
    | Custom scripts or other elements can be echoed within these actions.
    |
    */

    // Add scripts right after the opening <body> tag
    add_action('wp_body_open', 'add_custom_body_script');
    function add_custom_body_script() {
        /*
        |---------------------------------------------------------------
        | Custom body script injection
        |---------------------------------------------------------------
        | This function is hooked to the 'wp_body_open' action.
        | It adds custom scripts right after the <body> tag opens.
        | Replace the 'var_dump' with your desired script or content.
        */
        // Fetch the custom body script from ACF options page
        $body_script = get_field('custom_script_body', 'option'); // 'option' specifies it's from the options page
        
        if ($body_script) {
            // Output the custom body script inside <script> tags
            echo '<script>' . ($body_script) . '</script>';
        }
    }

    // Add scripts before closing </body> tag (footer)
    add_action('wp_footer', 'add_custom_footer_script');
    function add_custom_footer_script() {
        /*
        |---------------------------------------------------------------
        | Custom footer script injection
        |---------------------------------------------------------------
        | This function is hooked to the 'wp_footer' action.
        | It adds custom scripts just before the closing </body> tag.
        | Replace the 'var_dump' with your desired footer script or content.
        */
        // Fetch the custom footer script from ACF options page
        $footer_script = get_field('custom_script_footer', 'option');
        
        if ($footer_script) {
            // Output the custom footer script inside <script> tags
            echo '<script>' . ($footer_script) . '</script>';
        }
    }

    // Add scripts inside the <head> tag
    add_action('wp_head', 'add_custom_head_script');
    function add_custom_head_script() {
        /*
        |---------------------------------------------------------------
        | Custom head script injection
        |---------------------------------------------------------------
        | This function is hooked to the 'wp_head' action.
        | It adds custom scripts inside the <head> section of the HTML.
        | Replace the 'var_dump' with your desired head script or content.
        */
        // Fetch the custom header script from ACF options page
        $header_script = get_field('custom_script_header', 'option');
        
        if ($header_script) {
            // Output the custom header script inside <script> tags
            echo '<script>' . ($header_script) . '</script>';
        }
    }

}

