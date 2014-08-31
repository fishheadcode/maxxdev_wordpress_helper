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
require_once "classes/media.php";
require_once "classes/pages.php";
require_once "classes/posttype.php";
require_once "classes/post.php";
require_once "classes/user.php";
require_once "classes/userroles.php";

class Maxxdev {

	public static function init() {
		
	}

	public static function enqueueScriptsFrontend() {
		Maxxdev_Helper_Frontend::enqueueScriptsFrontend();
	}

}

add_action("init", array(Maxxdev, "init"));
add_action("wp_enqueue_scripts", array(Maxxdev, "enqueueScriptsFrontend"), 90);
