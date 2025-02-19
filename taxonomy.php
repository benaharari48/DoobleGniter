<?php
/**
 * Taxonomy Page Dynamic Controller
 */
defined('ABSPATH') OR exit('No direct script access allowed');
/*
|---------------------------------------------------------------------- 
| Dynamic Controller Loading for Taxonomies
|---------------------------------------------------------------------- 
| This section dynamically loads the appropriate controller 
| based on the current taxonomy. The controller will then 
| execute the relevant method based on the requested action.
| 
| Ensures compatibility with WordPress best practices.
|
*/

// Detect if we are on a taxonomy archive page
if ( is_tax() || is_category() || is_tag() ) {

    // Get the current taxonomy slug
    $current_taxonomy = get_queried_object()->taxonomy;

    $current_post_type = get_taxonomy($current_taxonomy)->object_type['name']; // Get the current post type (e.g., 'post', 'page', custom post type)

    // Define the path to the controller file based on taxonomy name
    $controller_path = get_template_directory() . "/app/Controllers/{$current_post_type}Controller.php";

    // Check if the controller file exists
    if ( file_exists( $controller_path ) ) {

        // Include the controller file
        require_once $controller_path;

        // Dynamically load the controller class based on the taxonomy name
        $controller_class = "{$current_post_type}Controller";

        // Check if the controller class exists
        if ( class_exists( $controller_class ) ) {

            // Create an instance of the controller dynamically
            $controller = new $controller_class();

            // Call the archive method dynamically for taxonomy views
            $controller->taxonomy();

        } else {
            // If the controller class does not exist, display an error message
            error_log("{$controller_class} class not found.");
        }

    } else {
        // If the controller file does not exist, display an error message
        error_log("{$current_post_type}Controller.php not found.");
    }
}
