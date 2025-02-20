<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|---------------------------------------------------------------------- 
| Controller for Home
|---------------------------------------------------------------------- 
|
| This controller handles requests for the homepage and 404 pages.
| It loads the necessary views and templates for these pages.
|
*/
class DoobleGniterController {

    /*
    |---------------------------------------------------------------------- 
    | Constructor: Initialize the Controller
    |---------------------------------------------------------------------- 
    |
    | The constructor can be used to load models or set up hooks.
    | Currently, no models are being loaded in this example.
    |
    */
    public function __construct() {
        // Initialization code can go here, such as loading models or setting up hooks.
    }

    /*
    |---------------------------------------------------------------------- 
    | Index: Display Home Page
    |---------------------------------------------------------------------- 
    |
    | This method loads the home page template.
    | It loads the header, the home view, and the footer.
    |
    */
    public function index() {
        get_header();  // Load the theme's header
        get_template_part('app/views/home/home');  // Load the home page view
        get_footer();  // Load the theme's footer
    }

    /*
    |---------------------------------------------------------------------- 
    | Page 404: Display 404 Error Page
    |---------------------------------------------------------------------- 
    |
    | This method loads the 404 error page template when a page is not found.
    | It loads the header, the 404 view, and the footer.
    |
    */
    public function page404() {
        get_header();  // Load the theme's header
        get_template_part('app/views/404/404');  // Load the 404 error view
        get_footer();  // Load the theme's footer
    }

}