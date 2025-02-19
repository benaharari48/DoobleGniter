<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/**
 * Method to generate custom post type classes (Controller, Model, Views)
 * 
 * This method dynamically creates the necessary files and directories 
 * for the Controller, Model, and View of a custom post type. If the 
 * files don't exist, they are created with basic structure.
 * 
 * @param string $post_type The name of the custom post type.
 */

class PostTypeGenerator {

    // Method to generate custom post type classes
    public static function generate($post_type) {
        $post_type = str_replace(' ', '', ucfirst($post_type['name'])); // Ensure proper casing
        $controller_path = MVC_PLUGIN_PATH . "app/Controllers/{$post_type}Controller.php";
        $model_path = MVC_PLUGIN_PATH . "app/Models/{$post_type}Model.php";
        $view_path = MVC_PLUGIN_PATH . "app/Views/" . strtolower($post_type);

        // Create directories if they don't exist
        if (!file_exists(dirname($controller_path))) {
            mkdir(dirname($controller_path), 0755, true);
        }
        if (!file_exists(dirname($model_path))) {
            mkdir(dirname($model_path), 0755, true);
        }
        if (!file_exists($view_path)) {
            mkdir($view_path, 0755, true);
        }

        // Generate Controller
        if (!file_exists($controller_path)) {
file_put_contents($controller_path, "<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Controller for {$post_type}
|----------------------------------------------------------------------
|
| This controller handles requests related to the '{$post_type}' post type.
| It interacts with the {$post_type}Model to fetch data and loads the 
| appropriate view templates.
|
*/

class {$post_type}Controller {

    /*
    |----------------------------------------------------------------------
    | Constructor: Load the Model
    |----------------------------------------------------------------------
    |
    | Automatically loads the model when the controller is instantiated.
    |
    */
    public function __construct() {
        require_once MVC_PLUGIN_PATH . 'app/Models/{$post_type}Model.php';

        // Hook into the 'wp_ajax_' action for the custom AJAX handler
        add_action('wp_ajax_your_action', array(\$this, 'handle_your_action'));
        add_action('wp_ajax_nopriv_your_action', array(\$this, 'handle_your_action'));

    }

    /*
    |----------------------------------------------------------------------
    | Index: Display Archive Page
    |----------------------------------------------------------------------
    |
    | Loads the archive page for '{$post_type}' by fetching all related posts.
    | The data is retrieved from the model and passed to the archive template.
    |
    */
    public function index() {
        \$model = new {$post_type}Model();
        \$data = \$model->getAllPosts(); // Fetch all posts

        get_header();
        get_template_part('app/views/' . strtolower(get_post_type()) . '/index', null, ['data' => \$data]);
        get_footer();
    }

    /*
    |----------------------------------------------------------------------
    | Single: Display Single Post Page
    |----------------------------------------------------------------------
    |
    | Loads a single '{$post_type}' post page by fetching data based on ID.
    | If no ID is provided, it returns an error message.
    |
    */
    public function single(\$id = false) {
        \$model = new {$post_type}Model();
        \$data = \$model->getDataById(\$id);

        get_header();
        get_template_part('app/views/' . strtolower(get_post_type()) . '/single', null, ['data' => \$data]);
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
        \$current_taxonomy = get_queried_object()->taxonomy;
        \$term_id = get_queried_object_id();

        \$model = new {$post_type}Model();
        \$data = \$model->getPostsByTaxonomy(\$current_taxonomy, \$term_id);

        get_header();
        get_template_part('app/views/' . strtolower(get_taxonomy(\$current_taxonomy)->object_type[0]) . '/taxonomy', null, ['data' => \$data]);
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
        if ( ! isset(\$_POST['csrf_token']) || ! wp_verify_nonce(\$_POST['csrf_token'], 'DoobleGniter_token') ) {
            wp_send_json_error('Invalid CSRF token');
            return;
        }

        // Proceed with your action here (e.g., saving data, processing, etc.)
        // Example: Just a success response for now
        wp_send_json_success('Action successfully processed');
    }

}

new {$post_type}Controller();");
        }


        // Generate Model
        if (!file_exists($model_path)) {
            file_put_contents($model_path, "<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Model for {$post_type}
|----------------------------------------------------------------------
|
| This class handles data retrieval for the '{$post_type}' post type.
| It includes methods for fetching single posts, archives, 
| taxonomy-related posts, and ACF fields.
|
*/

class {$post_type}Model {

    /*
    |----------------------------------------------------------------------
    | Get General Data
    |----------------------------------------------------------------------
    |
    | Returns a static message for '{$post_type}'.
    |
    */
    public function getData() {
        return 'Data for {$post_type}';
    }

    /*
    |----------------------------------------------------------------------
    | Get Data by Post ID
    |----------------------------------------------------------------------
    |
    | Fetches data for a specific '{$post_type}' post using its ID.
    | Retrieves ACF fields and returns structured data.
    |
    */
    public function getDataById(\$id = false) {
        if (!\$id) {
            return 'Data for {$post_type} with ID unknown';
        }

        // Fetch ACF Fields
        \$acf_fields = [
            'acf_field_1' => get_field('your_field_name', \$id),
            'acf_field_2' => get_field('another_field_name', \$id),
        ];

        return [
            'message'   => 'Data for {$post_type} with ID ' . \$id,
            'acf_fields' => \$acf_fields,
        ];
    }

    /*
    |----------------------------------------------------------------------
    | Get All Posts (Archive)
    |----------------------------------------------------------------------
    |
    | Retrieves all published posts of '{$post_type}', including ACF fields.
    |
    */
    public function getAllPosts() {
        \$args = [
            'post_type'      => '{$post_type}',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ];

        \$query = new WP_Query(\$args);
        \$posts = [];

        if (\$query->have_posts()) {
            while (\$query->have_posts()) {
                \$query->the_post();
                \$post_id = get_the_ID();

                \$posts[] = [
                    'id'         => \$post_id,
                    'title'      => get_the_title(),
                    'permalink'  => get_permalink(),
                    'acf_field'  => get_field('your_field_name', \$post_id),
                ];
            }
            wp_reset_postdata();
        }

        return \$posts;
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
    public function getPostsByTaxonomy(\$taxonomy, \$term_id) {
        \$args = [
            'post_type'      => '{$post_type}',
            'tax_query'      => [
                [
                    'taxonomy' => \$taxonomy,
                    'field'    => 'term_id',
                    'terms'    => \$term_id,
                ],
            ],
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ];

        \$query = new WP_Query(\$args);
        \$posts = [];

        if (\$query->have_posts()) {
            while (\$query->have_posts()) {
                \$query->the_post();
                \$post_id = get_the_ID();

                \$posts[] = [
                    'id'         => \$post_id,
                    'title'      => get_the_title(),
                    'permalink'  => get_permalink(),
                    'acf_field'  => get_field('your_field_name', \$post_id),
                ];
            }
            wp_reset_postdata();
        }

        return \$posts;
    }

    /*
    |----------------------------------------------------------------------
    | Get Taxonomy Terms
    |----------------------------------------------------------------------
    |
    | Retrieves all terms of a given taxonomy related to '{$post_type}'.
    |
    */
    public function getTaxonomyTerms(\$taxonomy) {
        \$terms = get_terms([
            'taxonomy'   => \$taxonomy,
            'hide_empty' => false,
        ]);

        if (is_wp_error(\$terms)) {
            return [];
        }

        \$result = [];
        foreach (\$terms as \$term) {
            \$result[] = [
                'id'    => \$term->term_id,
                'name'  => \$term->name,
                'slug'  => \$term->slug,
                'count' => \$term->count,
            ];
        }

        return \$result;
    }
}");
        }


        // Generate Views
        if (!file_exists("$view_path/index.php")) {
            file_put_contents("$view_path/index.php", "<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/**
 * Archive View for $post_type
 */
?>
<div id=\"spotlight-inner\" class=\"container py-5\">
    
    <!-- Spotlight Title Section -->
    <div id=\"spotlight-title\" class=\"animated fadeInDown text-center\">
        <h1><?php post_type_archive_title(); ?></h1>
    </div><!-- spotlight title ends -->
    
    <!-- Spotlight Note Section -->
    <div id=\"spotlight-note\" class=\"animated fadeInDown text-center mt-3\">
    <?php if ( have_posts() ) : ?>
        <ul>
            <?php while ( have_posts() ) : the_post(); ?>
                <li>
                    <a href=\"<?php the_permalink(); ?>\"><?php the_title(); ?></a>
                    <p><?php the_excerpt(); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>

        <?php 
        // Pagination
        the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => __('« Previous', 'textdomain'),
            'next_text' => __('Next »', 'textdomain'),
        ]);
        ?>

    <?php else : ?>
        <p><?php esc_html_e('No posts found.', 'textdomain'); ?></p>
    <?php endif; ?>
    </div><!-- spotlight note ends -->
    
</div><!-- spotlight-inner -->



    ");
        }

        if (!file_exists("$view_path/single.php")) {
            file_put_contents("$view_path/single.php", "<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/**
 * Single View for $post_type
 */
?>

<div id=\"spotlight-inner\" class=\"container py-5\">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
    <!-- Spotlight Title Section -->
    <div id=\"spotlight-title\" class=\"animated fadeInDown text-center\">
        <h1><?php the_title(); ?></h1>
    </div><!-- spotlight title ends -->
    
    <!-- Spotlight Note Section -->
    <div id=\"spotlight-note\" class=\"animated fadeInDown text-center mt-3\">
        <p><?php the_content(); ?></p>
    </div><!-- spotlight note ends -->
    
    <?php endwhile; endif; ?>
</div><!-- spotlight-inner -->
");
        }


        if (!file_exists("$view_path/taxonomy.php")) {
            file_put_contents("$view_path/taxonomy.php", "<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/**
 * Taxonomy Archive View for $taxonomy
 */
?>

<div id=\"spotlight-inner\" class=\"container py-5\">
    <h1><?php single_term_title(); ?></h1>
    <p><?php echo term_description(); ?></p>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
    <!-- Spotlight Title Section -->
    <div id=\"spotlight-title\" class=\"animated fadeInDown text-center\">
        <h2><a href=\"<?php the_permalink(); ?>\"><?php the_title(); ?></a></h2>
    </div><!-- spotlight title ends -->
    
    <!-- Spotlight Note Section -->
    <div id=\"spotlight-note\" class=\"animated fadeInDown text-center mt-3\">
        <p><?php the_excerpt(); ?></p>
    </div><!-- spotlight note ends -->
    
    <?php endwhile; else : ?>
        <p>No posts found in this category.</p>
    <?php endif; ?>
</div><!-- spotlight-inner -->
");
        }


    }



    // Method to register custom post type
    public static function register_post_type($post_type) {

        $args = array(
            'labels' => array(
                'name' => __(ucfirst($post_type['label']), 'DoobleGniter'),
                'singular_name' => __(ucfirst($post_type['label']), 'DoobleGniter'),
                'add_new' => __('Add New', 'DoobleGniter'),
                'add_new_item' => __('Add New ' . ucfirst($post_type['label']), 'DoobleGniter'),
                'edit_item' => __('Edit ' . ucfirst($post_type['label']), 'DoobleGniter'),
                'new_item' => __('New ' . ucfirst($post_type['label']), 'DoobleGniter'),
                'view_item' => __('View ' . ucfirst($post_type['label']), 'DoobleGniter'),
                'search_items' => __('Search ' . ucfirst($post_type['label']), 'DoobleGniter'),
                'not_found' => __('No ' . $post_type['label'] . ' found', 'DoobleGniter'),
                'not_found_in_trash' => __('No ' . $post_type['label'] . ' found in Trash', 'DoobleGniter'),
                'all_items' => __('All ' . ucfirst($post_type['label']), 'DoobleGniter'),
                'archives' => __(ucfirst($post_type['label']) . ' Archives', 'DoobleGniter'),
                'insert_into_item' => __('Insert into ' . $post_type['label'], 'DoobleGniter'),
                'uploaded_to_this_item' => __('Uploaded to this ' . $post_type['label'], 'DoobleGniter'),
            ),
            'public' => true,
            'show_in_rest' => true, // For Gutenberg support
            'has_archive' => true,  // Enable archive page
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'rewrite' => array('slug' =>  $post_type['slug']),
            'menu_icon' => $post_type['menu_icon'], // Set the dashboard icon

        );

        register_post_type($post_type['name'], $args);
    }

    // Method to register taxonomy for the custom post type
    public static function register_taxonomy($post_type) {

        if( isset($post_type['taxonomies']) && !empty($post_type['taxonomies']) ){

            foreach ($post_type['taxonomies'] as $key => $taxonomy) {
                
                $args = array(
                    'hierarchical' => true, // Set to false for non-hierarchical taxonomy
                    'labels' => array(
                        'name'                  => __(ucfirst($post_type['label']) . ' '.__(ucfirst($taxonomy['name'])), 'DoobleGniter'),
                        'singular_name'         => __(ucfirst($post_type['label']) . ' '.__(ucfirst($taxonomy['singular_name'])), 'DoobleGniter'),
                        'search_items'          => __('Search ' . ucfirst($post_type['label']) . ' '.__(ucfirst($taxonomy['name'])), 'DoobleGniter'),
                        'all_items'             => __('All ' . ucfirst($post_type['label']) . ' '.__(ucfirst($taxonomy['name'])), 'DoobleGniter'),
                        'parent_item'           => __('Parent ' . ucfirst($post_type['label']) . ' '.__(ucfirst($taxonomy['singular_name'])), 'DoobleGniter'),
                        'parent_item_colon'     => __('Parent ' . ucfirst($post_type['label']) . ' '.__(ucfirst($taxonomy['singular_name'])).':.', 'DoobleGniter'),
                        'edit_item'             => __('Edit ' . ucfirst($post_type['label']) . ' '.__(ucfirst($taxonomy['singular_name'])), 'DoobleGniter'),
                        'update_item'           => __('Update ' . ucfirst($post_type['label']) . ' '.__(ucfirst($taxonomy['singular_name'])), 'DoobleGniter'),
                        'add_new_item'          => __('Add New ' . ucfirst($post_type['label']) . ' '.__(ucfirst($taxonomy['singular_name'])), 'DoobleGniter'),
                        'new_item_name'         => __('New ' . ucfirst($post_type['label']) . ' '.__(ucfirst($taxonomy['singular_name'])).' Name', 'DoobleGniter'),
                        'menu_name'             => __(ucfirst($post_type['label']) . ' '.__(ucfirst($taxonomy['name'])), 'DoobleGniter'),
                    ),
                    'show_ui' => true,
                    'show_in_rest' => true, // Enable in REST API for Gutenberg
                    'query_var' => true,
                    'rewrite' => array(
                        'slug' =>  $post_type['slug'] . '-'.__(strtolower($taxonomy['singular_name'])),
                        'with_front' => false,
                    ),
                );
                // var_dump( __(strtolower($taxonomy['singular_name'])) );die();
                register_taxonomy($post_type['name'] . '_'.__(strtolower($taxonomy['singular_name'])), $post_type['name'], $args);

            }


        }

    }

    // Method to load translation files
    public static function load_translations() {
        load_plugin_textdomain('DoobleGniter', false, plugin_dir_path(__FILE__) . 'languages');
    }
    
}