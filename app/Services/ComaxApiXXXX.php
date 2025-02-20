<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Comax Custom REST API
|----------------------------------------------------------------------
| This file registers custom REST API endpoints for the Comax theme.
| It allows retrieving and creating posts via the API.
|
*/
/**
 * Register custom API routes
 */
function Comax_register_api_routes() {
    $service_lowercase = strtolower('Comax'); // Convert the service to lowercase before using

    register_rest_route(sprintf('%s/v1', $service_lowercase), '/ClubCustomers_Service', array(
        'methods'  => 'GET',
        'callback' => 'call_comax_soap_service', // Use double quotes for variable interpolation
    ));

}
add_action('rest_api_init', 'Comax_register_api_routes');

/**
 * Get all posts
 */
function Comax_get_posts() {
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
function Comax_create_post(WP_REST_Request $request) {
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


function call_comax_soap_service($data) {
    $url = 'http://ws.comax.co.il/Comax_WebServices/ClubCustomers_Service.asmx';
    $headers = array(
        'Content-Type' => 'text/xml; charset=utf-8',
        'SOAPAction'   => 'http://ws.comax.co.il/Comax_WebServices/Get_ClubCustomerDetailsBySearch_Simple',
    );

    $xml_data = '<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <Get_ClubCustomerDetailsBySearch_Simple xmlns="http://ws.comax.co.il/Comax_WebServices/">
                <ID>' . esc_xml($data['ID']) . '</ID>
                <Name>' . esc_xml($data['Name']) . '</Name>
                <IDCard>' . esc_xml($data['IDCard']) . '</IDCard>
                <City>' . esc_xml($data['City']) . '</City>
                <Phone>' . esc_xml($data['Phone']) . '</Phone>
                <Mobile>' . esc_xml($data['Mobile']) . '</Mobile>
                <Email>' . esc_xml($data['Email']) . '</Email>
                <GroupID>' . esc_xml($data['GroupID']) . '</GroupID>
                <CameFrom>' . esc_xml($data['CameFrom']) . '</CameFrom>
                <LoginID>' . esc_xml($data['LoginID']) . '</LoginID>
                <LoginPassword>' . esc_xml($data['LoginPassword']) . '</LoginPassword>
            </Get_ClubCustomerDetailsBySearch_Simple>
        </soap:Body>
    </soap:Envelope>';

    $response = wp_remote_post($url, array(
        'method'    => 'POST',
        'headers'   => $headers,
        'body'      => $xml_data,
    ));

    if (is_wp_error($response)) {
        return 'Error: ' . $response->get_error_message();
    } else {
        return wp_remote_retrieve_body($response);
    }
}

// Example usage:
$data = array(
    'ID'            => 'string',
    'Name'          => 'string',
    'IDCard'        => 'string',
    'City'          => 'string',
    'Phone'         => 'string',
    'Mobile'        => 'string',
    'Email'         => 'string',
    'GroupID'       => 'string',
    'CameFrom'      => 'string',
    'LoginID'       => 'string',
    'LoginPassword' => 'string',
);
