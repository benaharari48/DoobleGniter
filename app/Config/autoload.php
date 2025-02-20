<?php
defined('ABSPATH') OR exit('No direct script access allowed');




/*
|----------------------------------------------------------------------
| Auto-load Providers Configuration Handler
|----------------------------------------------------------------------
|
| This section will automatically include provider files based on the
| defined names in the configuration.
|
| Example: If 'post-type-generator' is defined, it will load
| app/providers/PostTypeGenerator.php
|
*/

if ( isset( $GLOBALS['config']['providers'] ) && is_array( $GLOBALS['config']['providers'] ) ) {
    foreach ( $GLOBALS['config']['providers'] as $provider ) {

        // Construct the provider file path
        $provider_file = get_template_directory() . '/app/Providers/' . $provider . '.php';

        // Check if the provider file exists
            if ( file_exists( $provider_file ) ) {
                
            // Include the provider file
            require_once $provider_file;

        } else {
            // Log an error if the provider file doesn't exist
            error_log( "Provider file '{$provider}' not found." );
        }

    }
}


/*
|----------------------------------------------------------------------
| Hook Files Auto-loader Configuration
|----------------------------------------------------------------------
|
| This file automatically includes hook files based on the defined names.
| Define all your hook files in the configuration array and they will
| be included in the WordPress theme as needed.
|
*/

if ( isset( $GLOBALS['config']['hooks'] ) && is_array( $GLOBALS['config']['hooks'] ) ) {
    foreach ( $GLOBALS['config']['hooks'] as $hook ) {

        // Construct the hook file path
        $hook_file = get_template_directory() . '/app/Hooks/' . $hook . '.php';
        
        // Check if the hook file exists
        if ( file_exists( $hook_file ) ) {

            // Use get_template_part to load the hook file (with custom path)
            require_once $hook_file;
        } else {
            // Log or handle cases where the file doesn't exist
            error_log( "Hook file '{$hook_file}' not found." );
        }

    }

}



/*
|----------------------------------------------------------------------
| Auto-load Services Configuration
|----------------------------------------------------------------------
|
| This section will automatically include service files based on the 
| defined names in the configuration.
|
| Services can be used for handling various functionalities like:
| - SimplyApi
|
| To add a new service, define its name in the $GLOBALS['config']['services']
| array, and place the corresponding file in the app/Services/ directory.
|
*/
if ( isset( $GLOBALS['config']['services'] ) && is_array( $GLOBALS['config']['services'] ) ) {
    foreach ( $GLOBALS['config']['services'] as $service ) {
        $service_file = get_template_directory() . '/app/Services/' . $service . 'Api.php';

        if ( file_exists( $service_file ) ) {
            require_once $service_file;
        } else {
            error_log( "Service file '{$service}' not found." );
        }
    }
}


/*
|---------------------------------------------------------------------- 
| Auto-load Third-Party Providers Configuration Handler
|---------------------------------------------------------------------- 
| This section will automatically include third-party provider files 
| based on the defined names in the configuration.
|
| Example: If 'WooCommerce' is defined, it will load
| app/third-party/WooCommerce.php
|
*/

if ( isset( $GLOBALS['config']['third-party'] ) && is_array( $GLOBALS['config']['third-party'] ) ) {
    foreach ( $GLOBALS['config']['third-party'] as $thirdparty ) {

        // Construct the third-party file path for third-party
        $third_party_file = get_template_directory() . '/app/third-party/' . $thirdparty . '.php';
        
        // Check if the third-party third-party file exists
        if ( file_exists( $third_party_file ) ) {

            // Include the third-party third-party file
            require_once $third_party_file;

        } else {
            // Log an error if the third-party third-party file doesn't exist
            error_log( "Third-party third-party file '{$thirdparty}' not found." );
        }

    }
}


/*
|---------------------------------------------------------------------- 
| Auto-load Helper Functions Configuration Handler
|---------------------------------------------------------------------- 
| This section will automatically include helper function files based on 
| the defined names in the configuration.
|
| Example: If 'helpers' is defined, it will load 
| app/helpers/helpers.php
|
*/

if ( isset( $GLOBALS['config']['helpers'] ) && is_array( $GLOBALS['config']['helpers'] ) ) {
    foreach ( $GLOBALS['config']['helpers'] as $helper ) {

        // Construct the helper file path for the helper
        $helper_file = get_template_directory() . '/app/helpers/' . $helper . '.php';
        
        // Check if the helper file exists
        if ( file_exists( $helper_file ) ) {

            // Include the helper file
            require_once $helper_file;

        } else {
            // Log an error if the helper file doesn't exist
            error_log( "Helper file '{$helper}' not found." );
        }

    }
}


/**
 * ----------------------------------------------------------------------
 * Auto-load Controllers for Custom Post Types
 * ----------------------------------------------------------------------
 * This section automatically loads controller files from 
 * the `/app/Controllers/` directory.
 * 
 * It dynamically includes all `.php` files in the folder, ensuring 
 * that controllers are available when needed.
 * 
 * Example: If `HomeController.php` exists, it will be loaded automatically.
 * 
 */

$controllers_dir = get_template_directory() . '/app/Controllers/';
$controller_files = glob($controllers_dir . '*.php'); // Get all controller files

if (!empty($controller_files)) {
    foreach ($controller_files as $file) {
        
        // Extract the file name without extension
        $controller_name = basename($file, '.php');

        // Dynamically load the template part (if needed)
        get_template_part('/app/Controllers/' . $controller_name);
        
    }
}
