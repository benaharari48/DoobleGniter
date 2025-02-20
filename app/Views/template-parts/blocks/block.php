<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/**
 * Custom Block Template for WordPress
 * 
 * This template is used to render a custom block in WordPress. It can be dynamically
 * included within other templates, such as posts, pages, or any custom post type.
 * Only variables from the controller or ACF should be used for data output.
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

<div class="custom-block">
    <?php if( get_field('block_title') ) : ?>
        <h2 class="block-title">
            <?php the_field('block_title'); ?>
        </h2>
    <?php endif; ?>

    <?php if( get_field('block_description') ) : ?>
        <p class="block-description">
            <?php the_field('block_description'); ?>
        </p>
    <?php endif; ?>
    
    <?php 
    // Example of looping through a repeater field (if any)
    if( have_rows('block_items') ):
        echo '<ul class="block-items">';
        while( have_rows('block_items') ): the_row();
            $item = get_sub_field('item_name');
            echo '<li>' . esc_html( $item ) . '</li>';
        endwhile;
        echo '</ul>';
    endif;
    ?>
</div><!-- .custom-block -->