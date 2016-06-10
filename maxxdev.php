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

class Maxxdev {

	public static function init() {
		
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
