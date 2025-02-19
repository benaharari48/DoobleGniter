<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/**
 * Taxonomy Archive View for 
 */
?>

<div id="spotlight-inner" class="container py-5">
    <h1><?php single_term_title(); ?></h1>
    <p><?php echo term_description(); ?></p>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
    <!-- Spotlight Title Section -->
    <div id="spotlight-title" class="animated fadeInDown text-center">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    </div><!-- spotlight title ends -->
    
    <!-- Spotlight Note Section -->
    <div id="spotlight-note" class="animated fadeInDown text-center mt-3">
        <p><?php the_excerpt(); ?></p>
    </div><!-- spotlight note ends -->
    
    <?php endwhile; else : ?>
        <p>No posts found in this category.</p>
    <?php endif; ?>
</div><!-- spotlight-inner -->
