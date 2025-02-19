<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| WP Registers Configuration
|----------------------------------------------------------------------
|
| This file holds all the registrations required for your WordPress theme
| or plugin. This includes registering hooks, custom post types, taxonomies,
| custom menus, and other necessary components.
|
| Define the hooks, custom post types, menus, and other components here.
| Each will be automatically registered or included as needed.
|
| Example:
|   - Register hooks like 'enqueue', 'security', etc.
|   - Register custom post types like 'book', 'movie'.
|   - Register custom menus like 'main_menu', 'footer_menu'.
|
*/




/*
|----------------------------------------------------------------------
| Generate and Register Post Type
|----------------------------------------------------------------------
|
| We first call the generate method to handle any generation logic for
| the post type if required. This could include creating necessary files 
| or structures related to the post type.
|
| After generating, we proceed to register the custom post type and 
| its taxonomy using the appropriate methods.
|
*/
if ( isset( $GLOBALS['config']['post_types'] ) && is_array( $GLOBALS['config']['post_types'] ) ) {
    
    // Loop through each post type defined in the configuration array
    foreach ( $GLOBALS['config']['post_types'] as $post_type ) {
        
        // Check if the PostTypeGenerator class exists before calling its methods
        if( class_exists('PostTypeGenerator') ) {

            // Generate the post type (e.g., may create or prepare necessary resources)
            PostTypeGenerator::generate($post_type);
            
            // Register the custom post type with WordPress
            PostTypeGenerator::register_post_type($post_type);
            
            // Register associated taxonomies (e.g., categories, tags) for the post type
            PostTypeGenerator::register_taxonomy($post_type);
        }
    }
} else {

    error_log("No post types defined in the configuration.");
}




/*
|---------------------------------------------------------------------- 
| Register and Display Custom Menus 
|---------------------------------------------------------------------- 
| This block registers the custom menus based on the configuration array.
| The menus can then be displayed in specific locations on the theme 
| (header, footer, etc.).
*/
function register_dynamic_menus() {
    // Check if the 'menus' array is set in the global configuration and is an array
    if ( isset( $GLOBALS['config']['menus'] ) && is_array( $GLOBALS['config']['menus'] ) ) {
        
        // Loop through each menu defined in the configuration array
        foreach ( $GLOBALS['config']['menus'] as $menu ) {
            // Register the menu with its 'location' and 'description'
            register_nav_menu( $menu['location'], __( $menu['description'], 'theme-textdomain' ) );
        }
    } else {
        // Log an error if no menus are defined in the configuration array
        error_log( 'No menus defined in the configuration.' );
    }
}

// Hook the function to the 'init' action to register menus during WordPress initialization
add_action( 'init', 'register_dynamic_menus' );




/*
|---------------------------------------------------------------------- 
| Check and Install Required Plugins 
|---------------------------------------------------------------------- 
| This block checks if the required plugins are installed and activated.
| If any required plugin is not installed or activated, it will notify
| the admin and provide a link to the plugin's installation page.
*/
function check_required_plugins() {
    // Check if the 'required_plugins' array is set in the global configuration
    if ( isset( $GLOBALS['config']['required_plugins'] ) && is_array( $GLOBALS['config']['required_plugins'] ) ) {

        // Start an empty array to hold any missing plugins
        $missing_plugins = [];

        // Loop through each required plugin
        foreach ( $GLOBALS['config']['required_plugins'] as $plugin ) {
            // Check if the plugin is active
            if ( ! is_plugin_active( $plugin['slug'] . '/' . $plugin['slug'] . '.php' ) ) {
                // If the plugin is not active, add it to the missing plugins array
                $missing_plugins[] = $plugin;
            }
        }

        // If there are missing plugins, notify the admin
        if ( ! empty( $missing_plugins ) ) {
            // Loop through each missing plugin and add a separate notice
            foreach ( $missing_plugins as $plugin ) {
                add_action( 'admin_notices', function() use ( $plugin ) {
                    // Display a separate message for each missing plugin
                    echo '<div class="error"><p><strong>' . esc_html( $plugin['name'] ) . ' is required for the full functionality of the theme.</strong></p>';
                    echo '<p><a href="' . esc_url( $plugin['url'] ) . '" target="_blank">' . esc_html( $plugin['name'] ) . '</a> is not installed or activated. Please install and activate it.</p></div>';
                });
            }
        }
    } else {
        // Log an error if no plugins are defined in the configuration array
        error_log( 'No required plugins defined in the configuration.' );
    }
}

// Hook the function to the 'admin_init' action to check the plugins when the admin panel loads
add_action( 'admin_init', 'check_required_plugins' );

?>
