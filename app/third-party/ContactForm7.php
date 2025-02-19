<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|---------------------------------------------------------------------- 
| Contact Form 7 Custom Integration
|---------------------------------------------------------------------- 
| This file handles custom functionality for Contact Form 7 integration.
| Hooks, custom form validation, and any additional functionality related 
| to CF7 can be added here.
|
| Please ensure that this file is only included when the CF7 plugin is active.
|
*/

if (class_exists('WPCF7')) {

    /*
    |---------------------------------------------------------------------- 
    | Hook: Before Send Mail
    |---------------------------------------------------------------------- 
    | Custom function to execute before the email is sent by CF7.
    | You can modify the form data or perform additional checks here.
    |
    */
    add_action('wpcf7_before_send_mail', 'custom_cf7_before_send_mail', 10, 3);
    function custom_cf7_before_send_mail($contact_form, &$abort, $submission) {
        // Custom logic here, e.g., modify $submission data or add custom validation
        $data = $submission->get_posted_data();
        // Do something with the $data
    }

    /*
    |---------------------------------------------------------------------- 
    | Hook: After Submit
    |---------------------------------------------------------------------- 
    | Custom function to execute after the form has been submitted.
    | You can redirect, log data, or show custom messages.
    |
    */
    add_action('wpcf7_mail_sent', 'custom_cf7_after_submit');
    function custom_cf7_after_submit($contact_form) {
        // Example: Redirect to a custom URL after form submission
        wp_redirect(home_url('/thank-you'));
        exit;
    }

}