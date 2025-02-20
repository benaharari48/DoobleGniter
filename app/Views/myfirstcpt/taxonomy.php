<?php
defined('ABSPATH') OR exit('No direct script access allowed');
/**
* Taxonomy Archive View Template for 
* 
* This template dynamically generates the archive view for a custom 
* taxonomy. It ensures that the necessary structure exists and 
* loads the relevant content from WordPress. Only variables from 
* the controller or ACF should be used for data output.
* 
* Refer to ACF documentation for proper usage of ACF fields:
* - Repeater Fields: https://www.advancedcustomfields.com/resources/repeater/
* - Flexible Content Fields: https://www.advancedcustomfields.com/resources/flexible-content/
* - Relationship Fields: https://www.advancedcustomfields.com/resources/relationship/
* 
* ⚠️ IMPORTANT: Do not write spaghetti code! 
* Anyone who does will have their legs cut off. ⚔️
*/
?>

<div id="spotlight-inner" class="container py-5">

    <?php get_template_part( 'app/Views/template-parts/global/breadcrumbs' ); ?>

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
