<?php
defined('ABSPATH') OR exit('No direct script access allowed');
/**
* Single View Template for Custom Post Type
* 
* This template dynamically generates the single view for a custom 
* post type. It ensures that the necessary structure exists and 
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
