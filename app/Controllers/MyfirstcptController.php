<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Controller for Myfirstcpt
|----------------------------------------------------------------------
|
| This controller handles requests related to the 'Myfirstcpt' post type.
| It interacts with the MyfirstcptModel to fetch data and loads the 
| appropriate view templates.
|
*/

class MyfirstcptController {

    /*
    |----------------------------------------------------------------------
    | Constructor: Load the Model
    |----------------------------------------------------------------------
    |
    | Automatically loads the model when the controller is instantiated.
    |
    */
    public function __construct() {
        require_once MVC_PLUGIN_PATH . 'app/Models/MyfirstcptModel.php';

        // Hook into the 'wp_ajax_' action for the custom AJAX handler
        add_action('wp_ajax_your_action', array($this, 'handle_your_action'));
        add_action('wp_ajax_nopriv_your_action', array($this, 'handle_your_action'));

    }

    /*
    |----------------------------------------------------------------------
    | Index: Display Archive Page
    |----------------------------------------------------------------------
    |
    | Loads the archive page for 'Myfirstcpt' by fetching all related posts.
    | The data is retrieved from the model and passed to the archive template.
    |
    */
    public function index() {
        $model = new MyfirstcptModel();
        $data = $model->getAllPosts(); // Fetch all posts

        get_header();
        get_template_part('app/views/' . strtolower(get_post_type()) . '/index', null, ['data' => $data]);
        get_footer();
    }

    /*
    |----------------------------------------------------------------------
    | Single: Display Single Post Page
    |----------------------------------------------------------------------
    |
    | Loads a single 'Myfirstcpt' post page by fetching data based on ID.
    | If no ID is provided, it returns an error message.
    |
    */
    public function single($id = false) {
        $model = new MyfirstcptModel();
        $data = $model->getDataById($id);

        get_header();
        get_template_part('app/views/' . strtolower(get_post_type()) . '/single', null, ['data' => $data]);
        get_footer();
    }

    /*
    |----------------------------------------------------------------------
    | Taxonomy: Display Taxonomy Archive Page
    |----------------------------------------------------------------------
    |
    | Loads posts based on taxonomy terms.
    | Automatically detects the current queried taxonomy and fetches 
    | relevant posts.
    |
    */
    public function taxonomy() {
        $current_taxonomy = get_queried_object()->taxonomy;
        $term_id = get_queried_object_id();

        $model = new MyfirstcptModel();
        $data = $model->getPostsByTaxonomy($current_taxonomy, $term_id);

        get_header();
        get_template_part('app/views/' . strtolower(get_taxonomy($current_taxonomy)->object_type[0]) . '/taxonomy', null, ['data' => $data]);
        get_footer();
    }

    /*
    |----------------------------------------------------------------------
    | Handle AJAX Action with CSRF Token
    |----------------------------------------------------------------------
    |
    | This method verifies the CSRF token and processes the AJAX request.
    | It ensures the security of the action by verifying the nonce before 
    | executing the intended functionality.
    |
    */
    public function handle_your_action() {
        // Verify the nonce (CSRF token)
        if ( ! isset($_POST['csrf_token']) || ! wp_verify_nonce($_POST['csrf_token'], 'DoobleGniter_token') ) {
            wp_send_json_error('Invalid CSRF token');
            return;
        }

        // Proceed with your action here (e.g., saving data, processing, etc.)
        // Example: Just a success response for now
        wp_send_json_success('Action successfully processed');
    }

}

new MyfirstcptController();