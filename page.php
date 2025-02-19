<?php
/**
 * Page Template
 */
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        // You can load a custom template part for page content
        get_template_part('views/template-parts/content', 'page');
    endwhile;
else :
    echo '<p>' . __('No page found', 'your-text-domain') . '</p>';
endif;

get_footer();