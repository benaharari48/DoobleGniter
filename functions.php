<?php


define('MVC_PLUGIN_PATH', plugin_dir_path(__FILE__));

define('MVC_PLUGIN_URL', plugin_dir_url(__FILE__));

get_template_part('app/Config/config');

get_template_part('app/Config/autoload');

get_template_part('app/Config/wp-registers');