<?php
defined('ABSPATH') OR exit('No direct script access allowed');

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
if ( isset( $GLOBALS['config']['custom_post_types'] ) && is_array( $GLOBALS['config']['custom_post_types'] ) ) {
    
    // Loop through each post type defined in the configuration array
    foreach ( $GLOBALS['config']['custom_post_types'] as $post_type ) {

        // Check if the PostTypeGenerator class exists before calling its methods
        if( class_exists('PostTypeGenerator') ) {

            // Generate the post type (e.g., may create or prepare necessary resources)
            PostTypeGenerator::generate($post_type);

        }
    }
} else {

    error_log("No post types defined in the configuration.");
}


/*
|---------------------------------------------------------------------- 
| Generate and Register Services
|---------------------------------------------------------------------- 
|
| This section handles the generation and registration of services.
| It first checks for any required generation logic, then proceeds to
| register the services with the necessary parameters.
|
| If a ServiceGenerator class exists, it will be called to handle 
| service-related operations such as preparing the service and its
| associated resources.
|
*/
if ( isset( $GLOBALS['config']['services'] ) && is_array( $GLOBALS['config']['services'] ) ) {

    // Loop through each service defined in the configuration array
    foreach ( $GLOBALS['config']['services'] as $service ) {

        // Check if the ServiceGenerator class exists before calling its methods
        if( class_exists('ServiceGenerator') ) {
            
            // Generate the service (e.g., create or prepare necessary resources)
            ServiceGenerator::generate($service);

        }
    }

} else {

    error_log("No services defined in the configuration.");
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


/*
|---------------------------------------------------------------------- 
| Register Custom Post Types and Taxonomies 
|---------------------------------------------------------------------- 
| This section registers custom post types and their associated taxonomies.
| It dynamically generates the arguments for each post type and its 
| taxonomies, including labels, slugs, and taxonomy-specific settings.
|
| Example:
|   If a custom post type is defined with taxonomies, 
|   they will be automatically registered.
|
*/

function register_custom_post_types() {
    // Check if 'custom_post_types' is defined in the global configuration
    if ( isset( $GLOBALS['config']['custom_post_types'] ) && is_array( $GLOBALS['config']['custom_post_types'] ) ) {

        // Loop through each custom post type defined in the config
        foreach ( $GLOBALS['config']['custom_post_types'] as $post_type ) {

            // Set the arguments for the custom post type registration
            $args = array(
                'labels' => array(
                    'name' => __( ucfirst($post_type['label']), 'DoobleGniter' ),
                    'singular_name' => __( ucfirst($post_type['label']), 'DoobleGniter' ),
                    'add_new' => __('Add New', 'DoobleGniter'),
                    'add_new_item' => __('Add New ' . ucfirst($post_type['label']), 'DoobleGniter'),
                    'edit_item' => __('Edit ' . ucfirst($post_type['label']), 'DoobleGniter'),
                    'new_item' => __('New ' . ucfirst($post_type['label']), 'DoobleGniter'),
                    'view_item' => __('View ' . ucfirst($post_type['label']), 'DoobleGniter'),
                    'search_items' => __('Search ' . ucfirst($post_type['label']), 'DoobleGniter'),
                    'not_found' => __('No ' . $post_type['label'] . ' found', 'DoobleGniter'),
                    'not_found_in_trash' => __('No ' . $post_type['label'] . ' found in Trash', 'DoobleGniter'),
                    'all_items' => __('All ' . ucfirst($post_type['label']), 'DoobleGniter'),
                    'archives' => __( ucfirst($post_type['label']) . ' Archives', 'DoobleGniter' ),
                    'insert_into_item' => __('Insert into ' . $post_type['label'], 'DoobleGniter'),
                    'uploaded_to_this_item' => __('Uploaded to this ' . $post_type['label'], 'DoobleGniter'),
                ),
                'public' => true,
                'show_in_rest' => true, // For Gutenberg support
                'has_archive' => true,  // Enable archive page
                'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
                'rewrite' => array( 'slug' => $post_type['slug'] ),
                'menu_icon' => $post_type['menu_icon'], // Set the dashboard icon
            );

            // Register the custom post type
            register_post_type( $post_type['name'], $args );

            // Loop through and register taxonomies for the custom post type
            foreach ( $post_type['taxonomies'] as $taxonomy ) {
                $taxonomy_args = array(
                    'hierarchical' => true, // Set to false for non-hierarchical taxonomy
                    'labels' => array(
                        'name' => __( ucfirst($post_type['label']) . ' ' . ucfirst($taxonomy['name']), 'DoobleGniter' ),
                        'singular_name' => __( ucfirst($taxonomy['singular_name']), 'DoobleGniter' ),
                        'search_items' => __('Search ' . ucfirst($taxonomy['name']), 'DoobleGniter'),
                        'all_items' => __('All ' . ucfirst($taxonomy['name']), 'DoobleGniter'),
                        'parent_item' => __('Parent ' . ucfirst($taxonomy['singular_name']), 'DoobleGniter'),
                        'parent_item_colon' => __('Parent ' . ucfirst($taxonomy['singular_name']) . ':', 'DoobleGniter'),
                        'edit_item' => __('Edit ' . ucfirst($taxonomy['singular_name']), 'DoobleGniter'),
                        'update_item' => __('Update ' . ucfirst($taxonomy['singular_name']), 'DoobleGniter'),
                        'add_new_item' => __('Add New ' . ucfirst($taxonomy['singular_name']), 'DoobleGniter'),
                        'new_item_name' => __('New ' . ucfirst($taxonomy['singular_name']) . ' Name', 'DoobleGniter'),
                        'menu_name' => __( ucfirst($taxonomy['name']), 'DoobleGniter' ),
                    ),
                    'show_ui' => true,
                    'show_in_rest' => true, // Enable in REST API for Gutenberg
                    'query_var' => true,
                    'rewrite' => array(
                        'slug' => $post_type['slug'] . '-' . strtolower($taxonomy['singular_name']),
                        'with_front' => false,
                    ),
                );

                // Register the taxonomy for the custom post type
                register_taxonomy( $post_type['name'] . '_' . strtolower($taxonomy['singular_name']), $post_type['name'], $taxonomy_args );
            }
        }
    }
}

// Hook into 'init' to register custom post types and taxonomies
add_action( 'init', 'register_custom_post_types' );


/*
|---------------------------------------------------------------------- 
| Conditional Disable Gutenberg Editor
|---------------------------------------------------------------------- 
|
| This code checks the custom configuration value in the global config
| array and disables Gutenberg if the 'disable_gutenberg' value is true.
| It uses the 'init' hook to ensure it's checked during WordPress initialization.
|
*/

function disable_gutenberg_if_configured() {
    if ( isset($GLOBALS['config']['disable_gutenberg']) && $GLOBALS['config']['disable_gutenberg'] === true ) {
        add_filter('use_block_editor_for_post', '__return_false');
    }
}

add_action('init', 'disable_gutenberg_if_configured');