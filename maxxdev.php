<?php

/*
  Plugin Name: Maxxdev Coding Helper
  Plugin URI: http://maxxdev.de
  Description: This plugin helps you creating other wordpress plugins! Isn´t that awesome?
  Version: 1.0
  Author: Christian Schrut
  Author URI: http://maxxdev.de
 */

require_once "classes/admin.php";
require_once "classes/controller.php";
require_once "classes/date.php";
require_once "classes/formbuilder.php";
require_once "classes/frontend.php";
require_once "classes/maps.php";
require_once "classes/media.php";
require_once "classes/pages.php";
require_once "classes/paypalexpresscheckout.php";
require_once "classes/posttype.php";
require_once "classes/post.php";
require_once "classes/routes.php";
require_once "classes/session.php";
require_once "classes/user.php";
require_once "classes/userroles.php";
require_once "classes/widgets.php";

require_once "controllers/DefaultController.php";

class Maxxdev {

    public static function init() {
        // Do awesome stuff here, like creating a new route...
        // add_rewrite_rule("backend/?$", "index.php?pagename=backend_dashboard&action=index", "top");

        $pathControllers = dirname(__FILE__) . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR;
        $pathApp = ABSPATH . "app";
        $pathTemplates = get_template_directory() . DIRECTORY_SEPARATOR . "templates";
        $pathTheme = get_template_directory();

        set_include_path(get_include_path() . PATH_SEPARATOR . $pathControllers);
        set_include_path(get_include_path() . PATH_SEPARATOR . $pathApp);
        set_include_path(get_include_path() . PATH_SEPARATOR . $pathTemplates);
        set_include_path(get_include_path() . PATH_SEPARATOR . $pathTheme);

        Maxxdev_Helper_Frontend::addIncludePath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "controllers");
        Maxxdev_Helper_Frontend::addIncludePath(ABSPATH . "app");
    }

    public static function afterSetupTheme() {
        add_theme_support("post-thumbnails");
    }

    public static function enqueueScriptsFrontend() {
        Maxxdev_Helper_Frontend::enqueueScriptsFrontend();
    }

    public static function getPluginDirPath() {
        return plugin_dir_path(__FILE__);
    }

    public static function getPluginDirUrl() {
        return plugin_dir_url(__FILE__);
    }

}

add_action("init", array(Maxxdev, "init"));
add_action("wp_enqueue_scripts", array(Maxxdev, "enqueueScriptsFrontend"), 90);
add_action("after_setup_theme", array(Maxxdev, "afterSetupTheme"));
