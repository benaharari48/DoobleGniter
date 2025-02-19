<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/*
|----------------------------------------------------------------------
| Custom Post Types Configuration
|----------------------------------------------------------------------
|
| This is the configuration file for custom post types.
| Define all your custom post types here in a similar structure.
|
*/

$GLOBALS['config']['post_types'] = [
    [
        'name'     => 'myfirstcpt',
        'slug'     => 'my-first-cpt',
        'label'    => 'my first cpt',
        'menu_icon'=> 'dashicons-clipboard', // Suggested: Clipboard icon for general content
        'taxonomies' => [
            [
                'name'          =>'categories',
                'singular_name' =>'category',
            ]
        ]
    ],
    [
        'name'     => 'cars',
        'slug'     => 'cars',
        'label'    => 'cars',
        'menu_icon'=> 'dashicons-car', // Suggested: Car icon for vehicles
        'taxonomies' => [
            [
                'name'          =>'Categories',
                'singular_name' =>'Category',
            ],
            [
                'name'          =>'Catalog',
                'singular_name' =>'Catalog',
            ]
        ]
    ],
];



/*
|----------------------------------------------------------------------
| Menu Configuration
|----------------------------------------------------------------------
|
| This file holds the configuration for all your custom menus.
| Define all your menus here in an easy-to-manage format.
|
*/

$GLOBALS['config']['menus'] = [
    [
        'location' => 'primary_menu',
        'description' => 'Main Navigation Menu',
        'display_location' => 'header', // Optional: where to display (e.g., header, footer)
    ],
    [
        'location' => 'footer_menu',
        'description' => 'Footer Navigation Menu',
        'display_location' => 'footer',
    ],
    [
        'location' => 'social_menu',
        'description' => 'Social Media Links',
        'display_location' => 'footer',
    ],
];


/*
|----------------------------------------------------------------------
| Required Plugin Configuration
|----------------------------------------------------------------------
|
| This file holds the configuration for all your required plugins.
| Define all your required plugins here.
|
*/

$GLOBALS['config']['required_plugins'] = [
    [
        'name' => 'Yoast SEO',
        'slug' => 'wordpress-seo',
        'url' => 'https://wordpress.org/plugins/wordpress-seo/',
    ],
    [
        'name' => 'WooCommerce',
        'slug' => 'woocommerce',
        'url' => 'https://woocommerce.com/',
    ],
    [
        'name' => 'Contact Form 7',
        'slug' => 'contact-form-7',
        'url' => 'https://wordpress.org/plugins/contact-form-7/',
    ],
    [
        'name' => 'Advanced Custom Fields PRO',
        'slug' => 'advanced-custom-fields-pro',
        'url' => 'https://www.advancedcustomfields.com/pro/',
    ],
    [
        'name' => 'Headers Security Advanced HSTS WP',
        'slug' => 'headers-security-advanced-hsts-wp',
        'url' => 'https://wordpress.org/plugins/headers-security-advanced-hsts-wp/',
    ],
    [
        'name' => 'Limit Login Attempts Reloaded',
        'slug' => 'limit-login-attempts-reloaded',
        'url' => 'https://wordpress.org/plugins/limit-login-attempts-reloaded/',
    ],
    [
        'name' => 'WPS Hide Login',
        'slug' => 'wps-hide-login',
        'url' => 'https://wordpress.org/plugins/wps-hide-login/',
    ],
];


/*
|----------------------------------------------------------------------
| Auto-load Hook Files Configuration
|----------------------------------------------------------------------
|
| This file holds the configuration for all your auto-load hook files.
| Define all your hook files here, and they will be automatically included
| based on the defined names.
|
| Example:
|   'enqueue'    => Will load app/hooks/enqueue.php
|   'security'   => Will load app/hooks/security.php
|   'custom-hook'=> Will load app/hooks/custom-hook.php
|
*/

$GLOBALS['config']['hooks'] = [
    'enqueue',    // Will load app/hooks/enqueue.php
    'security',   // Will load app/hooks/security.php
    'tags',       // Will load app/hooks/tags.php
    'widgets',    // Will load app/hooks/widgets.php
    'images',     // Will load app/hooks/images.php
];


/*
|----------------------------------------------------------------------
| Auto-load Providers Configuration
|----------------------------------------------------------------------
|
| This file holds the configuration for all your auto-load provider files.
| Define all your provider files here, and they will be automatically included
| based on the defined names.
|
| Example:
|   'post-type-generator' => Will load app/providers/PostTypeGenerator.php
|   'another-provider'    => Will load app/providers/AnotherProvider.php
|
*/

$GLOBALS['config']['providers'] = [
    'PostTypeGenerator', // Will load app/providers/PostTypeGenerator.php
];


/*
|---------------------------------------------------------------------- 
| Auto-load Third-Party Providers Configuration
|---------------------------------------------------------------------- 
| This file holds the configuration for all your third-party provider files.
| Define all your third-party provider files here, and they will be 
| automatically included based on the defined names.
|
| Example:
|   'WooCommerce' => Will load app/third-party/PostTypeGenerator.php
|   'ContactForm7' => Will load app/third-party/ContactForm7.php
|
*/

$GLOBALS['config']['third-party'] = [
    'WooCommerce',  // Will load app/third-party/WooCommerce.php
    'ContactForm7', // Will load app/third-party/ContactForm7.php
    // Add more third-party third-party here as needed
];