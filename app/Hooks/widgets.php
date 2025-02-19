<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| DoobleGniter Dashboard Customization
|----------------------------------------------------------------------
|
| This file handles the customization of the WordPress admin dashboard 
| for the DoobleGniter theme. It adds a custom dashboard widget for help 
| information and removes several default dashboard widgets to declutter 
| the admin interface.
|
*/

/*
|----------------------------------------------------------------------
| Add Custom Dashboard Widget
|----------------------------------------------------------------------
|
| This function registers a custom dashboard widget named "דובל פתרונות דיגיטליים"
| (Dooble Solutions Digital) using wp_add_dashboard_widget(). The widget displays 
| a logo and contact information for support.
|
*/
function DoobleGniter_dashboard_widgets() {
    global $wp_meta_boxes;
    wp_add_dashboard_widget(
        'custom_help_widget',          // Unique widget slug
        'דובל פתרונות דיגיטליים',      // Widget title (in Hebrew)
        'DoobleGniter_dashboard_help'        // Callback function to render widget content
    );
}

/*
|----------------------------------------------------------------------
| Render Custom Dashboard Help Widget
|----------------------------------------------------------------------
|
| This function outputs the content for the custom dashboard widget.
| It displays a centered logo (linked to the Dooble website) and 
| technical support contact information.
|
*/
function DoobleGniter_dashboard_help() {
    echo '<p style="text-align:center;"><a href="https://www.dooble.co.il/" target="_blank"><img src="' . get_template_directory_uri() . '/assets/images/dooble-logo.jpg" /></a></p>';
    echo '<p style="text-align:center;">שירות לקוחות ותמיכה טכנית: 072-2788660</p>';
}

/*
|----------------------------------------------------------------------
| Remove Unnecessary Dashboard Widgets
|----------------------------------------------------------------------
|
| This function removes several default WordPress dashboard widgets 
| that are not required, resulting in a cleaner admin dashboard.
|
| Widgets removed:
| - Incoming Links
| - Plugins
| - WordPress News (Primary)
| - Secondary
| - Quick Draft
| - Recent Drafts
| - Recent Comments (Activity)
| - At a Glance
| - Activity (WordPress 3.8+)
| - Site Health
| - Yoast SEO Dashboard Overview
|
*/
function DoobleGniter_remove_dashboard_meta() {
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' ); // Removes the 'Incoming Links' widget.
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' ); // Removes the 'Plugins' widget.
    remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' ); // Removes the 'WordPress News' widget.
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' ); // Removes the secondary widget.
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // Removes the 'Quick Draft' widget.
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' ); // Removes the 'Recent Drafts' widget.
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Removes the 'Recent Comments' widget.
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // Removes the 'At a Glance' widget.
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); // Removes the 'Activity' widget.
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' ); // Removes the 'Site Health' widget.
    remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' ); // Removes the Yoast SEO dashboard widget.
}
add_action( 'admin_init', 'DoobleGniter_remove_dashboard_meta' );

/*
|----------------------------------------------------------------------
| Hook Custom Dashboard Widgets into WordPress
|----------------------------------------------------------------------
|
| This action adds our custom dashboard widget to the WordPress dashboard
| during the dashboard setup process.
|
*/
add_action( 'wp_dashboard_setup', 'DoobleGniter_dashboard_widgets' );
