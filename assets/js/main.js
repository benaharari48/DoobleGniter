// main.js

// Ensure jQuery is loaded before any script execution
(function($) {
    // Document ready function
    $(document).ready(function() {

        /*
        |---------------------------------------------------------------------- 
        | Example: Custom Script Initialization
        |---------------------------------------------------------------------- 
        |
        | Initialize any custom scripts or jQuery components here
        | This is a placeholder for functions like sliders, form handling, etc.
        |
        */
        
        // Example: Simple alert to verify jQuery is working
        console.log('main.js loaded and ready!');

        /*
        |---------------------------------------------------------------------- 
        | Example: Sending an AJAX Request with the CSRF Token
        |---------------------------------------------------------------------- 
        |
        | In this example, we send an AJAX request to a specified endpoint
        | while including the CSRF token generated in the <head> section 
        | of the HTML page. The token is sent in the request data under 
        | the 'csrf_token' parameter to protect against CSRF attacks.
        |
        | The jQuery.ajax() function is used to make a POST request to 
        | the 'your-ajax-endpoint'. The CSRF token is retrieved from the 
        | <meta> tag and included in the request data.
        |
        */
        
        // Retrieve the CSRF token from the meta tag in the <head> section
        var csrfToken = jQuery('meta[name="csrf-token"]').attr('content');

        // Example: Sending an AJAX request with the CSRF token
        jQuery.ajax({
            url: ajax_login_object.ajaxurl,  // Replace with your actual AJAX endpoint
            method: 'POST',
            data: {
                action: 'your_action',  // Action name for your request
                csrf_token: csrfToken,  // Include the CSRF token in the request
            },
            success: function(response) {
                // Handle the response after the AJAX request
                console.log('Response:', response);
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('AJAX Error:', error);
            }
        });

    });  // End of document ready function
})(jQuery);  // Self-executing function to ensure no conflicts with other libraries
