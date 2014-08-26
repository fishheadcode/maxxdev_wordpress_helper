<?php

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
