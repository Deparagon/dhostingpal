<?php
/*
Plugin Name: App Hosting
Plugin URI: https://domainhostingpal.com/
Description: App hosting plugin for domainhostingpal, Domains & Web Services
Author: Kingsley Okpalaeke Paragon
Version: 1.0
Requires at least: 3.5
Requires PHP: 7.0
Tested up to: 5.7.1
Author URI: https://mrparagon.me
license: GPLV2
Text Domain: apphost
Domain Path: /langs/
*/



if (!defined('ABSPATH')) {
    exit;
}

function AppHost_activate()
{
    require_once plugin_dir_path(__FILE__).'/inc/AppHost_APHActivation.php';
    AppHost_APHActivation::run();
}

function AppHost_deactivate()
{
    require_once plugin_dir_path(__FILE__).'/inc/AppHost_APHDeactivation.php';
    AppHost_APHDeactivation::run();
}

register_activation_hook(__FILE__, 'AppHost_activate');
register_deactivation_hook(__FILE__, 'AppHost_deactivate');

/**
 * Let's Do it.
 */
require_once plugin_dir_path(__FILE__).'/inc/AppHost_AppHostLoader.php';
new AppHost_AppHostLoader();
