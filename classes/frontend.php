<?php

class Maxxdev_Helper_Frontend {

	private static $listFrontendCSS = array();
	private static $listFrontendJS = array();
	private static $listBackendCSS = array();
	private static $listBackendJS = array();
	private static $includePaths = array();

	public static function addIncludePath($path) {
		self::$includePaths[] = $path;
	}

	private static function initDefaultIncludePaths() {
		if (count(self::$includePaths) == 0) {
			// add new directories for embedding files later
			self::addIncludePath(get_template_directory());
			self::addIncludePath(plugin_dir_path(__FILE__));
		}
	}

	public static function includeFile($file) {
		$included = false;

		// initial call of default template paths
		self::initDefaultIncludePaths();

		if (count(self::$includePaths) > 0) {
			foreach (self::$includePaths as $include_path) {
				if ($included === false) {
					$file_path = $include_path . "/" . $file;

					if (file_exists($file_path)) {
						include $file_path;
						$included = true;
					}
				}
			}
		}

		if ($included === false) {
			if (file_exists($file)) {
				include $file;
				$included = true;
			}
		}

		return $included;
	}

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
