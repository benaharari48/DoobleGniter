<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/**
 * Single View for Cars
 */
?>

<div id="spotlight-inner" class="container py-5">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
    <!-- Spotlight Title Section -->
    <div id="spotlight-title" class="animated fadeInDown text-center">
        <h1><?php the_title(); ?></h1>
    </div><!-- spotlight title ends -->
    
    <!-- Spotlight Note Section -->
    <div id="spotlight-note" class="animated fadeInDown text-center mt-3">
        <p><?php the_content(); ?></p>
    </div><!-- spotlight note ends -->
    
    <?php endwhile; endif; ?>
</div><!-- spotlight-inner -->
