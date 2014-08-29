<?php

class Maxxdev_Helper_Pages {

	/**
	 * Creates a new page, if not exists
	 *
	 * @param string $page_title The title of the page, e.g. "Dashboard"
	 * @return boolean
	 */
	public static function createPage($page_title, $page_template = null) {
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

		$post_id = wp_insert_post(array(
			"post_type" => "page",
			"post_title" => $page_title,
			"post_status" => "publish"
		));

		if ($page_template != null) {
			self::setPageTemplate($post_id, $page_template);
		}

		return true;
	}

	/**
	 * Sets a template file to a page
	 * 
	 * @param int $page_id The ID of the post
	 * @param string $template_file The template file in the template folder, e.g. "myfile.php"
	 */
	public static function setPageTemplate($page_id, $template_file) {
		update_post_meta($page_id, "_wp_page_template", $template_file);
	}

	/**
	 * Returns the page as object.
	 * If no page is found, an empty stdClass() object will be returned
	 * 
	 * @param string $title Title of the page, e.g. "My Test Page"
	 * @return \stdClass
	 */
	public static function getPageByTitle($title) {
		$page = get_page_by_title($title);

		if ($page === null) {
			return new stdClass();
		}

		return $page;
	}

	/**
	 * Returns the content of a specific page.
	 * The page will be searchd by the title (first param $title)
	 * 
	 * @param string $title The page name, e.g. "My Test Page"
	 * @return string
	 */
	public static function getPageContentByTitle($title) {
		$page = self::getPageByTitle($title);
		return $page->post_content;
	}

}
