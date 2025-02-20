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
| This section dynamically loads the DoobleGniterController based on the file 
| path and executes the corresponding method. It checks for the 
| existence of the file and method to avoid errors.
|
| It also ensures compatibility with WordPress best practices.
|
*/

// Define the path to the controller file
$controller_path = get_template_directory() . '/app/Controllers/DoobleGniterController.php';

// Check if the controller file exists
if ( file_exists( $controller_path ) ) {

    // Include the controller file
    require_once $controller_path;

    // Check if the DoobleGniterController class exists
    if ( class_exists( 'DoobleGniterController' ) ) {

        // Create an instance of the DoobleGniterController dynamically
        $DoobleGniterController = new DoobleGniterController();

        // Set the default method as 'index', or get it from the URL parameter
        $method = isset( $_GET['method'] ) ? $_GET['method'] : 'page404'; // Default method is 'index'

        // Check if the requested method exists in the controller class
        $DoobleGniterController->page404();

    } else {
        // If the class does not exist, display an error message
        error_log('DoobleGniterController class not found.');
    }

} else {
    // If the file does not exist, display an error message
    error_log('DoobleGniterController.php not found.');
}
