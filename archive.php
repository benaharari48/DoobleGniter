<?php
/**
 * Archive Page for Custom Post Type
 */
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|---------------------------------------------------------------------- 
| Dynamic Controller Loading for Archive Pages
|---------------------------------------------------------------------- 
| This section dynamically loads the appropriate controller 
| based on the queried post type. The controller will then 
| execute the relevant method to handle the archive display.
|
| It ensures compatibility with WordPress best practices.
|
*/

// Detect the queried post type on an archive page
if ( is_post_type_archive() ) {
    $current_post_type = get_query_var('post_type'); // Get the queried post type

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

            // Call the index() method dynamically
            $controller->archive();

        } else {
            // If the controller class does not exist, log an error
            error_log("{$controller_class} class not found.");
        }

    } else {
        // If the controller file does not exist, log an error
        error_log("{$current_post_type}Controller.php not found.");
    }
}