<?php
defined('ABSPATH') OR exit('No direct script access allowed'); 
 /**
 * Controller for 404
 */
class Page404Controller {

    public function __construct() {
        // Initialization code, like loading models, etc.
    }

    public function index() {
        
        // Load the header of the theme
        get_header();
        
        // Use WordPress function get_template_part() for views
        get_template_part('app/views/404/404');
        
        // Load the footer of the theme
        get_footer();


    }

}