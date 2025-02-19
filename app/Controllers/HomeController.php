<?php
defined('ABSPATH') OR exit('No direct script access allowed'); 
 /**
 * Controller for home
 */
class HomeController {

    public function __construct() {
        // Initialization code, like loading models, etc.
    }

    public function index() {
        
        // Load the header of the theme
        get_header();
        
        // Use WordPress function get_template_part() for views
        get_template_part('app/views/home/home');
        
        // Load the footer of the theme
        get_footer();


    }

}