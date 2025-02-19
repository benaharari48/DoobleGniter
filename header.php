<?php
// header.php for WordPress theme
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Header Template
|----------------------------------------------------------------------
| This file includes the top section of the theme, including the 
| navigation, WordPress hooks like `wp_head()` for dynamic assets, 
| and the page layout structure.
|
*/

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo( 'name' ); ?></title>
    
    <!-- Ensure wp_head() is called for plugins and theme assets -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <!-- Hook for after the opening body tag -->
    <?php wp_body_open(); ?>

    <!-- Start of Header Section -->
    <header>
        <div class="container">
            <p class="h2 text-white text-start"><?php bloginfo( 'name' ); ?></p>
            <!-- Navigation or additional header content can be added here -->
        </div>
    </header>
    <!-- End of Header Section -->