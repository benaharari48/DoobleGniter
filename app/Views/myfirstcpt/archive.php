<?php
defined('ABSPATH') OR exit('No direct script access allowed');
/**
* Archive View Template for Custom Post Type
* 
* This template dynamically generates the archive view for a custom 
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

    <!-- Spotlight Title Section -->
    <div id="spotlight-title" class="animated fadeInDown text-center">
        <h1><?php post_type_archive_title(); ?></h1>
    </div><!-- spotlight title ends -->
    
    <!-- Spotlight Note Section -->
    <div id="spotlight-note" class="animated fadeInDown text-center mt-3">
    <?php get_template_part( 'app/Views/template-parts/loop/loop' ); ?>
    </div><!-- spotlight note ends -->
    
</div><!-- spotlight-inner -->