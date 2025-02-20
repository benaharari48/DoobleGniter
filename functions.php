<?php

/*
|---------------------------------------------------------------------- 
| Plugin Directory Path & URL Definitions
|---------------------------------------------------------------------- 
|
| These constants define the path and URL to the plugin directory, 
| which can be used for file inclusions and asset loading within the plugin.
|
*/

define('MVC_PLUGIN_PATH', plugin_dir_path(__FILE__)); // Defines the plugin directory path

define('MVC_PLUGIN_URL', plugin_dir_url(__FILE__)); // Defines the plugin directory URL

/*
|---------------------------------------------------------------------- 
| Configuration File Inclusion
|---------------------------------------------------------------------- 
|
| This section loads the configuration file from the 'app/Config/' directory.
| The configuration file usually contains global settings for the plugin.
|
*/

get_template_part('app/Config/config'); // Includes the config.php file

/*
|---------------------------------------------------------------------- 
| Autoload Configuration
|---------------------------------------------------------------------- 
|
| This section loads the autoload file from the 'app/Config/' directory.
| The autoload file is responsible for loading necessary classes automatically.
|
*/

get_template_part('app/Config/autoload'); // Includes the autoload.php file