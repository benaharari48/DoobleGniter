<?php
defined('ABSPATH') OR exit('No direct script access allowed');
/**
* Yoast SEO Breadcrumb Template
* 
* This template handles the display of Yoast SEO breadcrumbs on your website.
* The breadcrumbs provide easy navigation and improve site structure for both 
* users and search engines. It ensures that Yoast SEO breadcrumbs are displayed 
* properly if Yoast SEO is active and breadcrumbs are enabled in the plugin settings.
*/
if ( function_exists( 'yoast_breadcrumb' ) ) :
    // Output Yoast breadcrumbs
    yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
else :
    echo '<p>No breadcrumbs available.</p>';
endif;