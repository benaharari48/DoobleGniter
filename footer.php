<?php
// footer.php for WordPress theme
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Footer Template
|----------------------------------------------------------------------
| This file contains the footer section of the theme.
| It includes the footer menu and WordPress hooks like `wp_footer()`.
|
*/

?>

    <!-- Start of Footer Section -->
    <footer>
        <div class="container">
            <nav>
                <ul class="footer-nav">
                    <li><a href="#">Terms</a></li>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. All Rights Reserved.</p>
        </div>
    </footer>
    <!-- End of Footer Section -->

    <!-- Ensure wp_footer() is called before closing the body tag -->
    <?php wp_footer(); ?>

</body>
</html>