<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Register and Enqueue Custom Scripts
|----------------------------------------------------------------------
|
| This function registers and enqueues the necessary JavaScript files
| for the theme. It includes jQuery, Bootstrap 5.3, and a custom main script.
| The scripts are loaded in the footer for better performance.
|
*/
function DoobleGniter_register_scripts() {

    // Register and enqueue Bootstrap 5.3 JS (ensure you are using the right version)
    wp_register_script( 'DoobleGniter-bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true );
    wp_enqueue_script( 'DoobleGniter-bootstrap-js' );

    // Register and enqueue custom main script
    wp_register_script( 'DoobleGniter-main-js', get_template_directory_uri().'/assets/js/main.js', array('jquery', 'DoobleGniter-bootstrap-js'), 1 , true );
    wp_enqueue_script( 'DoobleGniter-main-js' );

    // Localize script for AJAX functionality
    wp_localize_script( 'DoobleGniter-main-js', 'ajax_login_object', array( 
        'ajaxurl'       => admin_url( 'admin-ajax.php' ),
        'redirecturl'   => home_url(),
    ));

    // Add inline script if needed (e.g., for Google Analytics or other third-party code)
    // wp_add_inline_script( 'DoobleGniter-main-js', 'console.log("Inline script");' );

}
add_action( 'wp_enqueue_scripts', 'DoobleGniter_register_scripts' );


/*
|----------------------------------------------------------------------
| Register and Enqueue Custom Styles
|----------------------------------------------------------------------
|
| This function registers and enqueues the necessary CSS files for the
| theme. It includes Bootstrap 5.3, custom styles, and additional libraries.
| Styles are loaded in the head for critical rendering path.
|
*/
function DoobleGniter_register_styles() {

    // Register and enqueue Bootstrap 5.3 CSS
    wp_register_style( 'DoobleGniter-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' );
    wp_enqueue_style( 'DoobleGniter-bootstrap-css' );

    // Register and enqueue custom CSS
    wp_register_style( 'DoobleGniter-main', get_template_directory_uri().'/assets/css/main.css' );
    wp_enqueue_style( 'DoobleGniter-main' );

}
add_action( 'wp_enqueue_scripts', 'DoobleGniter_register_styles' );


/*
|----------------------------------------------------------------------
| Defer or Async Non-Essential Scripts
|----------------------------------------------------------------------
|
| This function adds the 'defer' or 'async' attribute to non-essential
| JavaScript files to improve page load times.
|
*/
function DoobleGniter_defer_or_async_scripts($tag, $handle) {
    $defer_scripts = array('google-analytics', 'third-party-script'); // Replace with handles of non-essential scripts

    if ( in_array( $handle, $defer_scripts ) ) {
        return str_replace(' src', ' defer="defer" src', $tag);
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'DoobleGniter_defer_or_async_scripts', 10, 2 );
