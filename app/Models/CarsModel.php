<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Model for Cars
|----------------------------------------------------------------------
|
| This class handles data retrieval for the 'Cars' post type.
| It includes methods for fetching single posts, archives, 
| taxonomy-related posts, and ACF fields.
|
*/

class CarsModel {

    /*
    |----------------------------------------------------------------------
    | Get General Data
    |----------------------------------------------------------------------
    |
    | Returns a static message for 'Cars'.
    |
    */
    public function getData() {
        return 'Data for Cars';
    }

    /*
    |----------------------------------------------------------------------
    | Get Data by Post ID
    |----------------------------------------------------------------------
    |
    | Fetches data for a specific 'Cars' post using its ID.
    | Retrieves ACF fields and returns structured data.
    |
    */
    public function getDataById($id = false) {
        if (!$id) {
            return 'Data for Cars with ID unknown';
        }

        // Fetch ACF Fields
        $acf_fields = [
            'acf_field_1' => get_field('your_field_name', $id),
            'acf_field_2' => get_field('another_field_name', $id),
        ];

        return [
            'message'   => 'Data for Cars with ID ' . $id,
            'acf_fields' => $acf_fields,
        ];
    }

    /*
    |----------------------------------------------------------------------
    | Get All Posts (Archive)
    |----------------------------------------------------------------------
    |
    | Retrieves all published posts of 'Cars', including ACF fields.
    |
    */
    public function getAllPosts() {
        $args = [
            'post_type'      => 'Cars',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ];

        $query = new WP_Query($args);
        $posts = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();

                $posts[] = [
                    'id'         => $post_id,
                    'title'      => get_the_title(),
                    'permalink'  => get_permalink(),
                    'acf_field'  => get_field('your_field_name', $post_id),
                ];
            }
            wp_reset_postdata();
        }

        return $posts;
    }

    /*
    |----------------------------------------------------------------------
    | Get Posts by Taxonomy Term
    |----------------------------------------------------------------------
    |
    | Retrieves posts under a specific taxonomy term.
    | Useful for category/tag-based filtering.
    |
    */
    public function getPostsByTaxonomy($taxonomy, $term_id) {
        $args = [
            'post_type'      => 'Cars',
            'tax_query'      => [
                [
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                ],
            ],
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ];

        $query = new WP_Query($args);
        $posts = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();

                $posts[] = [
                    'id'         => $post_id,
                    'title'      => get_the_title(),
                    'permalink'  => get_permalink(),
                    'acf_field'  => get_field('your_field_name', $post_id),
                ];
            }
            wp_reset_postdata();
        }

        return $posts;
    }

    /*
    |----------------------------------------------------------------------
    | Get Taxonomy Terms
    |----------------------------------------------------------------------
    |
    | Retrieves all terms of a given taxonomy related to 'Cars'.
    |
    */
    public function getTaxonomyTerms($taxonomy) {
        $terms = get_terms([
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
        ]);

        if (is_wp_error($terms)) {
            return [];
        }

        $result = [];
        foreach ($terms as $term) {
            $result[] = [
                'id'    => $term->term_id,
                'name'  => $term->name,
                'slug'  => $term->slug,
                'count' => $term->count,
            ];
        }

        return $result;
    }
}