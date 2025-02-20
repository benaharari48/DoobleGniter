<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|---------------------------------------------------------------------- 
| Yoast SEO Custom Breadcrumb Integration
|---------------------------------------------------------------------- 
| This file handles custom functionality for Yoast SEO breadcrumbs.
| Hooks, custom breadcrumb logic, and any additional functionality 
| related to Yoast SEO breadcrumbs can be added here.
| Please ensure that this file is only included when the Yoast SEO plugin is active.
|
*/

if (function_exists('yoast_breadcrumb')) {

    /*
    |---------------------------------------------------------------------- 
    | Filter: Yoast SEO Breadcrumbs Title
    |---------------------------------------------------------------------- 
    | Custom function to modify the title of breadcrumbs.
    | You can change the breadcrumb title for a specific page or post type.
    |
    */
    add_filter('wpseo_breadcrumb_links', 'custom_yoast_breadcrumbs', 10, 1);
    function custom_yoast_breadcrumbs($links) {
        // Modify the breadcrumb array
        if (is_singular('post')) {
            // Example: Change the last breadcrumb link on post pages
            $links[count($links) - 1]['text'] = 'Custom Post Title';
        }
        
        return $links;
    }

    /*
    |---------------------------------------------------------------------- 
    | Filter: Yoast SEO Breadcrumb Separator
    |---------------------------------------------------------------------- 
    | Custom function to change the breadcrumb separator.
    | You can change the separator character, such as using ">" or "|".
    |
    */
    add_filter('wpseo_breadcrumb_separator', 'custom_breadcrumb_separator');
    function custom_breadcrumb_separator($separator) {
        // Change the separator to ">"
        return ' > ';
    }

    /*
    |---------------------------------------------------------------------- 
    | Action: Display Custom Breadcrumbs
    |---------------------------------------------------------------------- 
    | Custom function to output custom breadcrumbs in a template.
    | You can add additional logic or modify how breadcrumbs are displayed.
    |
    */
    add_action('wpseo_breadcrumb_output', 'custom_display_breadcrumbs', 10, 1);
    function custom_display_breadcrumbs($breadcrumb) {
        // Example: Add custom breadcrumbs output
        echo '<div class="custom-breadcrumbs">';
        echo $breadcrumb; // Default Yoast breadcrumb output
        echo '</div>';
    }

} else {
    // Yoast SEO is not active, log or notify if needed.
    error_log('Yoast SEO is not active.');
}