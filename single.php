<?php
/**
 * Single Page for Custom Post Type
 */
defined('ABSPATH') OR exit('No direct script access allowed');
/*
|---------------------------------------------------------------------- 
| Dynamic Controller Loading for Single Post Types
|---------------------------------------------------------------------- 
| This section dynamically loads the appropriate controller 
| based on the current post type. The controller will then 
| execute the relevant method based on the requested action.
|
| It ensures compatibility with WordPress best practices.
|
*/

// Detect the current post type on a single page
if ( is_singular() ) {
    $current_post_type = get_post_type(); // Get the current post type (e.g., 'post', 'page', custom post type)

    // Define the path to the controller file based on post type
    $controller_path = get_template_directory() . "/app/Controllers/{$current_post_type}Controller.php";

    // Check if the controller file exists
    if ( file_exists( $controller_path ) ) {

        // Include the controller file
        require_once $controller_path;

        // Dynamically load the controller class based on the post type
        $controller_class = "{$current_post_type}Controller";

        // Check if the controller class exists
        if ( class_exists( $controller_class ) ) {

            // Create an instance of the controller dynamically
            $controller = new $controller_class();

            // Call the method dynamically
            $controller->single();

        } else {
            // If the controller class does not exist, display an error message
            error_log("{$controller_class} class not found.");
        }

    } else {
        // If the controller file does not exist, display an error message
        error_log("{$current_post_type}Controller.php not found.");
    }
}
