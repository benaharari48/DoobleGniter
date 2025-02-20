<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/**
 * Simple Loop Template for WordPress
 * 
 * This template generates a basic loop to display posts (or custom post types) on the website.
 * The loop ensures that the necessary structure exists to load relevant post content from WordPress.
 * Only variables from the controller or ACF fields should be used for output.
 * 
 * Refer to ACF documentation for proper usage of ACF fields:
 * - Repeater Fields: https://www.advancedcustomfields.com/resources/repeater/
 * - Flexible Content Fields: https://www.advancedcustomfields.com/resources/flexible-content/
 * - Relationship Fields: https://www.advancedcustomfields.com/resources/relationship/
 * 
 * ⚠️ IMPORTANT: Do not write spaghetti code! 
 * Anyone who does will have their legs cut off. ⚔️
 */

if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
    
        <div class="post">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <p class="post-date"><?php the_date(); ?></p>
            <p class="post-excerpt">
                <?php the_excerpt(); ?>
            </p>
        </div><!-- .post -->

    <?php endwhile;
else :
    echo '<p>No posts found.</p>';
endif;