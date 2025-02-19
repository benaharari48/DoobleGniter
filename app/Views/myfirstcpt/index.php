<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/**
 * Archive View for Myfirstcpt
 */
?>
<div id="spotlight-inner" class="container py-5">
    
    <!-- Spotlight Title Section -->
    <div id="spotlight-title" class="animated fadeInDown text-center">
        <h1><?php post_type_archive_title(); ?></h1>
    </div><!-- spotlight title ends -->
    
    <!-- Spotlight Note Section -->
    <div id="spotlight-note" class="animated fadeInDown text-center mt-3">
    <?php if ( have_posts() ) : ?>
        <ul>
            <?php while ( have_posts() ) : the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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



    