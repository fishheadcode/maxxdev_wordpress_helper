<?php

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
