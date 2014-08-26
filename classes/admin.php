<?php

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
