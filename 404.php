<?php
/**
 * Page Template
 */
// Ensure the script cannot be accessed directly by anyone other than WordPress
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Home Controller
|----------------------------------------------------------------------
| This section dynamically loads the Page404Controller based on the file 
| path and executes the corresponding method. It checks for the 
| existence of the file and method to avoid errors.
|
| It also ensures compatibility with WordPress best practices.
|
*/

// Define the path to the controller file
$controller_path = get_template_directory() . '/app/Controllers/Page404Controller.php';

// Check if the controller file exists
if ( file_exists( $controller_path ) ) {

    // Include the controller file
    require_once $controller_path;

    // Check if the Page404Controller class exists
    if ( class_exists( 'Page404Controller' ) ) {

        // Create an instance of the Page404Controller dynamically
        $Page404Controller = new Page404Controller();

        // Set the default method as 'index', or get it from the URL parameter
        $method = isset( $_GET['method'] ) ? $_GET['method'] : 'index'; // Default method is 'index'

        // Check if the requested method exists in the controller class
        if ( method_exists( $Page404Controller, $method ) ) {
            // Call the method dynamically
            $Page404Controller->$method();
        } else {
            // If method doesn't exist, fall back to the default 'index' method
            $Page404Controller->index();
        }

    } else {
        // If the class does not exist, display an error message
        error_log('Page404Controller class not found.');
    }

} else {
    // If the file does not exist, display an error message
    error_log('Page404Controller.php not found.');
}
