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
| This section dynamically loads the HomeController based on the file 
| path and executes the corresponding method. It checks for the 
| existence of the file and method to avoid errors.
|
| It also ensures compatibility with WordPress best practices.
|
*/

// Define the path to the controller file
$controller_path = get_template_directory() . '/app/Controllers/HomeController.php';

// Check if the controller file exists
if ( file_exists( $controller_path ) ) {

    // Include the controller file
    require_once $controller_path;

    // Check if the HomeController class exists
    if ( class_exists( 'HomeController' ) ) {

        // Create an instance of the HomeController dynamically
        $HomeController = new HomeController();

        // Set the default method as 'index', or get it from the URL parameter
        $method = isset( $_GET['method'] ) ? $_GET['method'] : 'index'; // Default method is 'index'

        // Check if the requested method exists in the controller class
        if ( method_exists( $HomeController, $method ) ) {
            // Call the method dynamically
            $HomeController->$method();
        } else {
            // If method doesn't exist, fall back to the default 'index' method
            $HomeController->index();
        }

    } else {
        // If the class does not exist, display an error message
        error_log('HomeController class not found.');
    }

} else {
    // If the file does not exist, display an error message
    error_log('HomeController.php not found.');
}
