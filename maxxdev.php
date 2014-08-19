<?php

/*
  Plugin Name: Maxxdev Coding Helper
  Plugin URI: http://maxxdev.de
  Description: This plugin helps you creating other wordpress plugins! Isn´t that awesome?
  Version: 1.0
  Author: Christian Schrut
  Author URI: http://maxxdev.de
 */

class Maxxdev_Helper_Frontend {

	private static $listFrontendCSS = array();
	private static $listFrontendJS = array();
	private static $listBackendCSS = array();
	private static $listBackendJS = array();

	/**
	 * adds CSS to the "CSS Queue"
	 *
	 * @param string $src the source of the CSS
	 * @param string $src_name the unique sourcename of the CSS
	 * @param boolean $frontend Should it be embedded in the frontend?
	 * @param boolean $backend Should it be embedded in the backend?
	 */
	private static function addCSSToList($src, $src_name, $frontend = true, $backend = false) {
		if ($frontend === true) {
			$obj = new stdClass();
			$obj->src = $src;
			$obj->src_name = $src_name;

			self::$listFrontendCSS[] = $obj;
		}

		if ($backend === true) {
			$obj = new stdClass();
			$obj->src = $src;
			$obj->src_name = $src_name;

			self::$listBackendCSS[] = $obj;
		}
	}

	/**
	 * adds JS to the "JS Queue"
	 *
	 * @param string $src the source of the JS
	 * @param string $src_name the unique sourcename of the JS
	 * @param boolean $frontend Should it be embedded in the frontend?
	 * @param boolean $backend Should it be embedded in the backend?
	 */
	private static function addJSToList($src, $src_name, $frontend = true, $backend = false) {
		if ($frontend === true) {
			$obj = new stdClass();
			$obj->src = $src;
			$obj->src_name = $src_name;

			self::$listFrontendJS[] = $obj;
		}

		if ($backend === true) {
			$obj = new stdClass();
			$obj->src = $src;
			$obj->src_name = $src_name;

			self::$listBackendJS[] = $obj;
		}
	}

	/**
	 * Works the queue of the temporarily cached CSS and JS files and embeds them to the frontend
	 */
	public static function enqueueScriptsFrontend() {
		foreach (self::$listFrontendCSS as $css) {
			wp_enqueue_style($css->src_name, $css->src);
		}

		foreach (self::$listFrontendJS as $js) {
			wp_enqueue_script($js->src_name, $js->src);
		}
	}

	/**
	 * Adds bootswatch to your site
	 * Please check the version number if given. The function won't check if the file exists (performance reasons)
	 *
	 * @param string $theme Name of the theme which should be added. Must be a valid bootswatch theme.
	 * @param string $specific_version Specify the version here. Default: 3.2.0
	 * @param boolean $frontend Should it be embedded in the frontend?
	 * @param boolean $backend Should it be embedded in the backend?
	 */
	public static function addBootswatch($theme = "amelia", $specific_version = "3.2.0", $frontend = true, $backend = true) {
		// define default theme if parameter $theme is not a valid theme
		$default_theme = "amelia";

		// define valid themes, which can be embedded
		$valid_themes = array(
			"amelia",
			"cerulean",
			"cosmo",
			"cyborg",
			"darkly",
			"flatly",
			"journal",
			"lumen",
			"readable",
			"simplex",
			"slate",
			"spacelab",
			"superhero",
			"united",
			"yeti"
		);

		// if $theme is not a valid theme...
		if (!in_array($theme, $valid_themes)) {
			// ... then set the $theme to the $default_theme
			$theme = $default_theme;
		}

		// embed theme in specific version
		self::addCSSToList("//maxcdn.bootstrapcdn.com/bootswatch/" . $specific_version . "/" . $theme . "/bootstrap.min.css", "maxxdev-helper-bootswatch", $frontend, $backend);
	}

	/**
	 * Adds font-awesome from the maxcdn servers
	 * Please check the version number if given. The function won't check if the file exists (performance reasons)
	 *
	 * @param string $specific_version Specify the version here. Default: 4.1.0
	 * @param boolean $frontend Should it be embedded in the frontend?
	 * @param boolean $backend Should it be embedded in the backend?
	 */
	public static function addFontAwesome($specific_version = "4.1.0", $frontend = true, $backend = true) {
		self::addCSSToList("//maxcdn.bootstrapcdn.com/font-awesome/" . $specific_version . "/css/font-awesome.min.css", "maxxdev-helper-fontawesome", $frontend, $backend);
	}

	/**
	 *
	 * Adds Bootstrap CSS and JS from the maxcdn servers
	 * Please check the version number if given. The function won't check if the file exists (performance reasons)
	 *
	 * @param string $specific_version Specify the version here. Default: 3.2.0
	 * @param boolean $load_css Should the css been loaded?
	 * @param boolean $load_javascript Should the min-js also been loaded?
	 * @param boolean $frontend Should it be embedded in the frontend?
	 * @param boolean $backend Should it be embedded in the backend?
	 */
	public static function addBootstrap($specific_version = "3.2.0", $load_css = true, $load_javascript = false, $frontend = true, $backend = true) {
		if ($load_css === true) {
			self::addCSSToList("//maxcdn.bootstrapcdn.com/bootstrap/" . $specific_version . "/css/bootstrap.min.css", "maxxdev-helper-bootstrap", $frontend, $backend);
		}

		if ($load_javascript === true) {
			self::addJSToList("//maxcdn.bootstrapcdn.com/bootstrap/" . $specific_version . "/js/bootstrap.min.js", "maxxdev-helper-bootstrap", $frontend, $backend);
		}
	}

	/**
	 * Adds jQuery to the site.
	 * Should be executed in the hook "wp_enqueue_scripts".
	 * If you don't pass a $specific_version with the version number of jquery, the latest stable version from code.jquery.com will be loaded.
	 * Otherwise, the specific version will be loaded from googleapis.com.
	 * Please check the version number if given. The function won't check if the file exists (performance reasons)
	 *
	 * @param string $specific_version If you want to have a specific version of jquery enter the version number here
	 * @param boolean $frontend Should it be embedded in the frontend?
	 * @param boolean $backend Should it be embedded in the backend?
	 */
	public static function addJQuery($specific_version = null, $frontend = true, $backend = true) {
		if ($specific_version === null) {
			self::addJSToList("//code.jquery.com/jquery.min.js", "maxxdev-helper-jquery", $frontend, $backend);
		} else {
			self::addJSToList("//ajax.googleapis.com/ajax/libs/jquery/" . $specific_version . "/jquery.min.js", "maxxdev-helper-jquery-specific", $frontend, $backend);
		}
	}

	/**
	 *
	 * Adds CSS to your site
	 *
	 * @param string $file_path The filepath of the CSS file
	 * @param string $style_name The name/handler of the style
	 * @param boolean $frontend Should it be embedded in the frontend?
	 * @param boolean $backend Should it be embedded in the backend?
	 */
	public static function addCSS($file_path, $style_name = null, $frontend = true, $backend = true) {
		if ($style_name === null) {
			$style_name = "maxxdev-helper-addCSS" . rand(1000, 9000);
		}

		self::addCSSToList($file_path, $style_name, $frontend, $backend);
	}

	/**
	 *
	 * Adds JS to your site
	 *
	 * @param string $file_path The filepath of the JS file
	 * @param string $script_name The name/handler of the script
	 * @param boolean $frontend Should it be embedded in the frontend?
	 * @param boolean $backend Should it be embedded in the backend?
	 */
	public static function addJs($file_path, $script_name = null, $frontend = true, $backend = true) {
		if ($script_name === null) {
			$script_name = "maxxdev-helper-addJs" . rand(1000, 9000);
		}

		self::addJSToList($file_path, $script_name, $frontend, $backend);
	}

}

class Maxxdev_Helper_Admin {

	/**
	 *
	 * Creates a new metabox in the admin area for the specified posttypes.
	 * Must be executed in the hook "add_meta_boxes".
	 * HowTo save the new fields: http://codex.wordpress.org/Function_Reference/add_meta_box
	 *
	 * @param array $screens An array with the posttypes, which shall show the metabox (e.g. array('post', 'page');)
	 * @param type $section_id The unique id of the metabox
	 * @param type $section_title The title of the metabox
	 * @param type $section_title_translate_key The translation key for the metabox title
	 * @param type $callback_function The callback function, which generates the fields
	 */
	public static function addAdminMetaBox($screens, $section_id, $section_title, $section_title_translate_key, $callback_function) {
		foreach ($screens as $screen) {

			add_meta_box(
					$section_id, __($section_title, $section_title_translate_key), $callback_function, $screen
			);
		}
	}

	/**
	 *
	 * @param string $parent_slug To which slug the menu point should be added?
	 * @param string $page_title
	 * @param string $menu_title
	 * @param string $menu_slug
	 * @param string $function
	 */
	public static function addAdminTopLevelSubmenu($parent_slug, $page_title, $menu_title, $menu_slug, $function) {
		add_submenu_page($parent_slug, $page_title, $menu_title, "manage_options", $menu_slug, $function);
	}

	/**
	 *
	 * @param string $plugin_dir needs to be plugin_dir_url(__FILE__) for recognizing icon-path
	 * @param string $page_title The title of the menu
	 * @param string $menu_title The title of the link
	 * @param string $menu_slug The slug
	 * @param string $function Function to display content of the menu point
	 * @param string $icon_filename filename of the icon, e.g. "icon.png"
	 * @param int $position position of the menu point, "81" is directly after "settings"
	 */
	public static function addAdminTopLevelMenu($plugin_dir, $page_title, $menu_title, $menu_slug, $function, $icon_filename, $position = 81) {
		$icon_url = $plugin_dir . "assets/icons/" . $icon_filename;
		add_menu_page($page_title, $menu_title, "manage_options", $menu_slug, $function, $icon_url, $position);
	}

	/**
	 *
	 * @param string $page_title String that appears at the browser title
	 * @param string $menu_title String that appears in the menu
	 * @param string $slug The slug for the backend URI
	 * @param string $function Which function should be called to display the content of this site?
	 */
	public static function addAdminOptionsPage($page_title, $menu_title, $slug, $function) {
		add_options_page($page_title, $menu_title, "manage_options", $slug, $function);
	}

}

class Maxxdev_Helper_Posttype {

	/**
	 *
	 * Adds a new custom post type
	 *
	 * @param string $post_type_name The name of the posttype
	 * @param string $name The (plural) name of the posttype
	 * @param string $singular_name The singular name of the posttype
	 * @param string $text_new The text for creating a new element of this posttype
	 * @param string $text_edit The text for editing an element of this posttype
	 * @param string $text_watch The text for watching an element of this posttype
	 * @param string $text_search The text for search elements of this posttype
	 * @param string $text_search_not_found The text for "elements of this posttype not found"
	 * @param string $text_no_deleted_elements The text for "there are no deleted elements of this posttype"
	 * @param string $icon_path The folder/file where the icon is saved
	 */
	public static function registerPostType($post_type_name, $name, $singular_name, $text_new, $text_edit, $text_watch, $text_search, $text_search_not_found, $text_no_deleted_elements, $icon_path, $rewrite = false, $show_in_nav = true, $position = false) {
		// Labels
		$labels = array(
			'name' => _x($name, "post type general name"),
			'singular_name' => _x($singular_name, "post type singular name"),
			'menu_name' => $name,
			'add_new' => _x($text_new, "team item"),
			'add_new_item' => __($text_new),
			'edit_item' => __($text_edit),
			'new_item' => __($text_new),
			'view_item' => __($text_watch),
			'search_items' => __($text_search),
			'not_found' => __($text_search_not_found),
			'not_found_in_trash' => __($text_no_deleted_elements),
			'parent_item_colon' => '',
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'menu_icon' => $icon_path,
			'rewrite' => $rewrite,
			'show_ui' => $show_in_nav,
			'show_in_nav' => $show_in_nav,
			'supports' => array('title', 'editor', 'thumbnail'));

		if ($position !== false) {
			$args['menu_position'] = $position;
		}

		if ($rewrite !== false && is_array($rewrite)) {
			$args["has_archive"] = true;
		} else {
			$args["has_archive"] = false;
		}

		// Register post type
		register_post_type($post_type_name, $args);
	}

	/**
	 * Shorter version of registerPostType, which generates all texts automatically
	 *
	 * @param string $post_type_name Posttype name
	 * @param string $name Plural name
	 * @param string $singular_name Singular name
	 * @param string $icon_path Path to the icon
	 */
	public static function registerPostTypeShort($post_type_name, $name, $singular_name, $icon_path, $rewrite = false, $show_in_nav = true, $position = false) {
		$text_new = "$singular_name anlegen";
		$text_edit = "$singular_name bearbeiten";
		$text_watch = "$singular_name ansehen";
		$text_search = "$name suchen";
		$text_search_not_found = "Suche nach $name lieferte kein Ergebnis";
		$text_no_deleted_elements = "Keine gelöschten $name gefunden";

		Maxxdev_Helper_Posttype::registerPostType($post_type_name, $name, $singular_name, $text_new, $text_edit, $text_watch, $text_search, $text_search_not_found, $text_no_deleted_elements, $icon_path, $rewrite, $show_in_nav, $position);
	}

	/**
	 *
	 * @param string $posttype For which posttype the taxonomy shall be available?
	 * @param string $singular Singular name of the taxonomy
	 * @param string $plural Plural name of the taxonomy
	 * @param array $terms Terms (Values) of the Taxonomy. Must be multiple arrays (0=name, 1=slug) within a main array. (e.g. array(array('name','slug'), array('name2','slug2'));)
	 */
	public static function registerTaxonomy($posttype, $singular, $plural, $terms = array()) {
		$labels = array(
			'name' => _x($plural, "taxonomy general name"),
			'singular_name' => _x($singular, "taxonomy singular name"),
			'search_items' => __("Suche nach $singular"),
			'all_items' => __("Alle $singular"),
			'parent_item' => __("Übergeordnete(s) $singular"),
			'parent_item_colon' => __("Übergeordnete(s) $singular:"),
			'edit_item' => __("$singular bearbeiten"),
			'update_item' => __("$singular bearbeiten"),
			'add_new_item' => __("$singular anlegen"),
			'new_item_name' => __("Neuer $singular Name"),
		);

		// Register and attach to 'team' post type
		register_taxonomy(strtolower($singular), $posttype, array(
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'hierarchical' => true,
			'query_var' => true,
			'rewrite' => true,
			'labels' => $labels
		));

		if (count($terms) > 0) {
			foreach ($terms as $term) {
				wp_insert_term($term[0], strtolower($singular), array(
					"description" => "",
					"slug" => $term[1],
					"parent" => ""
						)
				);
			}
		}
	}

}

class Maxxdev_Helper_Post {

	/**
	 * Creates a new page, if not exists
	 *
	 * @param string $page_title The title of the page, e.g. "Dashboard"
	 * @return boolean
	 */
	public static function createPage($page_title) {
		return Maxxdev_Helper_Pages::createPage($page_title);
	}

}

class Maxxdev_Helper_User {

	/**
	 * Creates a wordpress user
	 *
	 * @param string $username The username
	 * @param string $email The e-mail
	 * @param string $password The password, if null it will be generated
	 * @param int $password_length The length of the generated password
	 * @param boolean $password_special_signs Should the generated password contain special chars?
	 * @return array Always with keys "success" and "message", if user created also "user_id" as key
	 */
	public static function createUser($username, $email, $password = null, $password_length = 12, $password_special_signs = false) {
		$user_id = username_exists($username);

		if (!$user_id) {
			$email_exists = email_exists($email);

			if ($email_exists == false) {
				if ($password == null) {
					$password = wp_generate_password($password_length, $password_special_signs);
				}

				$user_id = wp_create_user($username, $password, $email);

				return array(
					"success" => true,
					"message" => __("User was created successfully"),
					"user_id" => $user_id
				);
			} else {
				return array(
					"success" => false,
					"message" => __("E-Mail exists already")
				);
			}
		} else {
			return array(
				"success" => false,
				"message" => __("Username exists already")
			);
		}
	}

	public static function search() {

	}

	public static function delete() {

	}

	public static function setRole() {

	}

	public static function login($user, $password, $remember = false) {
		$creds = array();
		$creds["user_login"] = $user;
		$creds["user_password"] = $password;
		$creds["remember"] = $remember;
		$login_user = wp_signon($creds);

		return $login_user;
	}

	public static function autoLogin($user, $password, $remember = false) {
		$autologin_user = self::login($user, $password, $remember);

		if (!is_wp_error($autologin_user)) {
			wp_set_current_user($autologin_user->ID);
		}

		return $autologin_user;
	}

}

class Maxxdev_Helper_UserRoles {

}

class Maxxdev_Helper_Date {

	/**
	 * Converts nglish day names to german day names
	 * This can be very helpful, if you´re not able/allowed to setlocale() on some servers
	 *
	 * @param string $str
	 * @return string
	 */
	public static function getGermanDays($str) {
		return str_replace(array(
			"Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
				), array(
			"Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag"
				), $str);
	}

	/**
	 * Converts english month names to german month names
	 * This can be very helpful, if you´re not able/allowed to setlocale() on some servers
	 *
	 * @param string $str
	 * @return string
	 */
	public static function getGermanMonths($str) {
		return str_replace(array(
			"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
				), array(
			"Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"
				), $str);
	}

}

class Maxxdev_Helper_Pages {

	/**
	 * Creates a new page, if not exists
	 *
	 * @param string $page_title The title of the page, e.g. "Dashboard"
	 * @return boolean
	 */
	public static function createPage($page_title) {
		$existingPage = get_posts(array(
			"post_type" => "page",
			"s" => $page_title
		));

		if (count($existingPage) > 0) {
			foreach ($existingPage as $ep) {
				if ($ep->post_title === $page_title) {
					return false;
				}
			}
		}

		wp_insert_post(array(
			"post_type" => "page",
			"post_title" => $page_title,
			"post_status" => "publish"
		));

		return true;
	}

	public static function getPageByTitle($title) {
		$page = get_page_by_title($title);

		if ($page === null) {
			return new stdClass();
		}

		return $page;
	}

	public static function getPageContentByTitle($title) {
		$page = self::getPageByTitle($title);
		return $page->post_content;
	}

}

class Maxxdev_Helper_Media {

	public static function addThumbnailSize($name, $width, $height, $crop = false, $check_existing_name = false) {
		$reserved_words = array("thumb", "thumbnail", "medium", "large", "post-thumbnail");

		if (in_array($name, $reserved_words)) {
			return false;
		}

		if ($check_existing_name === true) {
			global $_wp_additional_image_sizes;

			if (array_key_exists($name, $_wp_additional_image_sizes)) {
				return false;
			}
		}

		add_image_size($name, $width, $height, $crop);

		return true;
	}

}

add_action("wp_enqueue_scripts", array(Maxxdev_Helper_Frontend, "enqueueScriptsFrontend"));
