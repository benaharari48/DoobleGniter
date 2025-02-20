<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Test Custom REST API
|----------------------------------------------------------------------
| This file registers custom REST API endpoints for the Test theme.
| It allows retrieving and creating posts via the API.
|
*/

class Test_API_Controller {

    public function __construct() {
        add_action('rest_api_init', array($this, 'register_api_routes'));
    }

    /**
     * Register custom API routes
     */
    public function register_api_routes() {
        $service_lowercase = strtolower('Test'); // Convert the service to lowercase before using

        register_rest_route(sprintf('%s/v1', $service_lowercase), '/posts', array(
            'methods'  => 'GET',
            'callback' => array($this, 'get_posts'), // Use class method
        ));

        register_rest_route(sprintf('%s/v1', $service_lowercase), '/post', array(
            'methods'  => 'POST',
            'callback' => array($this, 'create_post'), // Use class method
            'permission_callback' => '__return_true',
        ));
    }

    /**
     * Get all posts
     */
    public function get_posts() {
        $posts = get_posts(array(
            'post_type'      => 'post',
            'posts_per_page' => 5,
        ));

        if (empty($posts)) {
            return new WP_Error('no_posts', 'No posts found', array('status' => 404));
        }

        return rest_ensure_response($posts);
    }

    /**
     * Create a new post
     */
    public function create_post(WP_REST_Request $request) {
        $params = $request->get_json_params();

        if (empty($params['title']) || empty($params['content'])) {
            return new WP_Error('missing_fields', 'Title and content are required', array('status' => 400));
        }

        $post_id = wp_insert_post(array(
            'post_title'   => sanitize_text_field($params['title']),
            'post_content' => sanitize_textarea_field($params['content']),
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
        ));

        if (is_wp_error($post_id)) {
            return new WP_Error('error_creating', 'Error creating post', array('status' => 500));
        }

        return rest_ensure_response(array('message' => 'Post created successfully!', 'post_id' => $post_id));
    }
}

// Instantiate the class
new Test_API_Controller();
