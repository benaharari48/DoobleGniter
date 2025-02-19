<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Remove WordPress Version Information
|----------------------------------------------------------------------
|
| This function removes the WordPress version number from the HTML source
| to prevent it from being exposed for security reasons.
|
*/
function DoobleGniter_wpversion_remove_version() {
    return '';
}
add_filter('the_generator', 'DoobleGniter_wpversion_remove_version');

/*
|----------------------------------------------------------------------
| Remove Unnecessary Meta Tags and Actions from wp_head
|----------------------------------------------------------------------
|
| This section removes various unnecessary meta tags and actions that
| are added to the wp_head, improving security and page load times.
|
*/
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('rest_api_init', 'wp_oembed_register_route');
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link');

/*
|----------------------------------------------------------------------
| Remove HTML Comments
|----------------------------------------------------------------------
|
| This function removes all HTML comments from the page output for 
| better security and privacy.
|
*/
function DoobleGniter_callback($buffer) {
    $buffer = preg_replace('/<!--(.|s)*?-->/', '', $buffer);
    return $buffer;
}

function DoobleGniter_buffer_start() {
    ob_start("DoobleGniter_callback");
}

function DoobleGniter_buffer_end() {
    ob_end_flush();
}

// Start and end output buffering to remove comments
add_action('get_header', 'DoobleGniter_buffer_start');
add_action('wp_footer', 'DoobleGniter_buffer_end');

/*
|----------------------------------------------------------------------
| Disable WordPress Feeds
|----------------------------------------------------------------------
|
| This disables all WordPress feed types (RSS, RDF, Atom) and replaces
| them with a custom message.
|
*/
function DoobleGniter_itsme_disable_feed() {
    wp_die(__('No feed available, please visit the <a href="'. esc_url(home_url('/')) .'">homepage</a>!'));
}

add_action('do_feed', 'DoobleGniter_itsme_disable_feed', 1);
add_action('do_feed_rdf', 'DoobleGniter_itsme_disable_feed', 1);
add_action('do_feed_rss', 'DoobleGniter_itsme_disable_feed', 1);
add_action('do_feed_rss2', 'DoobleGniter_itsme_disable_feed', 1);
add_action('do_feed_atom', 'DoobleGniter_itsme_disable_feed', 1);
add_action('do_feed_rss2_comments', 'DoobleGniter_itsme_disable_feed', 1);
add_action('do_feed_atom_comments', 'DoobleGniter_itsme_disable_feed', 1);

/*
|----------------------------------------------------------------------
| Disable Author URL Redirect
|----------------------------------------------------------------------
|
| This function disables author archive pages by redirecting to the homepage.
| It prevents any unnecessary exposure of author pages.
|
*/
add_action('template_redirect', 'DoobleGniter_disableAuthorUrl');

function DoobleGniter_disableAuthorUrl() {
    if (is_author()) {
        wp_redirect(home_url());
        exit();
    }
}

/*
|----------------------------------------------------------------------
| Hide WordPress Login Errors
|----------------------------------------------------------------------
|
| This function hides the default WordPress login error message and 
| provides a custom error message to enhance security.
|
*/
function DoobleGniter_no_wordpress_errors() {
    return 'הנתונים שגויים, אנא נסו שנית';
}
add_filter('login_errors', 'DoobleGniter_no_wordpress_errors');

// Disable file editing from WordPress admin area
define('DISALLOW_FILE_EDIT', true);

/*
|----------------------------------------------------------------------
| Disable WordPress Emojis
|----------------------------------------------------------------------
|
| This function disables the automatic insertion of WordPress emojis 
| across the site and the admin area, improving page load performance.
|
*/
function DoobleGniter_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');    
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    
    // Remove emoji plugin from TinyMCE editor
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'DoobleGniter_disable_emojis');

/**
 * Filter out the TinyMCE emoji plugin.
 *
 * This function removes the emoji plugin from the TinyMCE editor in the admin area.
 */
function disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

/*
|----------------------------------------------------------------------
| Disable WordPress Comments Completely
|----------------------------------------------------------------------
|
| This function removes all comment-related functionality from the 
| WordPress front-end and admin area. It disables support for comments 
| on posts and pages, hides existing comments, removes menu items, 
| and redirects comment-related pages.
|
| This improves security, performance, and user experience.
|
*/

function DoobleGniter_disable_comments() {
    // Remove comments support from post types
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');

    // Close comments on front-end
    add_filter('comments_open', '__return_false', 20, 2);
    add_filter('pings_open', '__return_false', 20, 2);

    // Hide existing comments
    add_filter('comments_array', '__return_empty_array', 10, 2);

    // Remove comments from admin menu
    add_action('admin_menu', function() {
        remove_menu_page('edit-comments.php');
    });

    // Redirect comments page if accessed
    add_action('admin_init', function() {
        global $pagenow;
        if ($pagenow === 'edit-comments.php') {
            wp_redirect(admin_url());
            exit;
        }
    });

    // Remove comments from admin bar
    add_action('init', function() {
        if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
    });
}
add_action('init', 'DoobleGniter_disable_comments');


/*
|----------------------------------------------------------------------
| Create .htaccess in Uploads Directory to Prevent PHP Execution
|----------------------------------------------------------------------
|
| This function automatically generates a .htaccess file inside the 
| WordPress uploads directory. It ensures that no PHP files are 
| executed in the uploads directory for better security.
|
*/
function DoobleGniter_create_htaccess_for_uploads() {
    $upload_dir = wp_upload_dir()['basedir']; // Get the WordPress uploads directory
    $htaccess_path = $upload_dir . '/.htaccess';

    // Check if the .htaccess file already exists
    if (file_exists($htaccess_path)) {
        return; // Exit if the file exists
    }

    // .htaccess content to disable PHP execution in the uploads folder with comments
    $htaccess_content = "/*
|----------------------------------------------------------------------
| Prevent PHP File Execution in Uploads Directory
|----------------------------------------------------------------------
|
| This .htaccess file prevents PHP files from being executed in the 
| WordPress uploads directory. This enhances security by ensuring 
| that no malicious files can be executed if uploaded by users.
|
| It blocks PHP execution in all subdirectories within the uploads 
| folder while still allowing normal media file uploads like images, 
| PDFs, etc.
|
*/
<Files *.php>
  deny from all
</Files>

<FilesMatch \"\.(htaccess|htpasswd)\">
  deny from all
</FilesMatch>

<FilesMatch \"^\\.\">
  deny from all
</FilesMatch>
    ";

    // Write the content to the .htaccess file
    file_put_contents($htaccess_path, $htaccess_content);
}
add_action('after_setup_theme', 'DoobleGniter_create_htaccess_for_uploads');




/*
|---------------------------------------------------------------------- 
| Add CSRF Token to the Head Section of WordPress Site
|---------------------------------------------------------------------- 
|
| This function generates a nonce (CSRF token) for a specific action 
| and outputs it as a meta tag within the <head> section of the 
| WordPress site. This token can be used in JavaScript to secure 
| AJAX requests and other form submissions.
|
| The nonce is generated using WordPress's wp_create_nonce() function, 
| and the resulting token is embedded in the page's HTML inside a 
| <meta> tag with the name "csrf-token". The token is then accessible 
| via JavaScript to be sent along with requests to protect against 
| CSRF (Cross-Site Request Forgery) attacks.
|
*/

add_action('wp_head', 'DoobleGniter_add_csrf_token_to_head');

function DoobleGniter_add_csrf_token_to_head() {
    /*
    |---------------------------------------------------------------
    | Generate CSRF Token (Nonce)
    |---------------------------------------------------------------
    | The wp_create_nonce() function generates a nonce for the 
    | action 'DoobleGniter_token'. This nonce acts as a CSRF token and 
    | will be used to validate requests made to the server.
    */
    $csrf_token = wp_create_nonce('DoobleGniter_token'); 

    /*
    |---------------------------------------------------------------
    | Output the CSRF Token as a Meta Tag in the Head
    |---------------------------------------------------------------
    | This part of the function outputs the nonce token as a 
    | <meta> tag within the <head> section. The token is safely 
    | escaped with esc_attr() to prevent any security vulnerabilities.
    */
    echo '<meta name="csrf-token" content="' . esc_attr($csrf_token) . '" />';
}