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

	public static function getPostIdPostName($post_name) {
		global $wpdb;

		$data = $wpdb->get_results("SELECT ID FROM wp_posts WHERE post_name = '$post_name'");

		if (count($data) > 0) {
			return $data[0]->ID;
		} else {
			return 0;
		}
	}

	public static function getPostNameById($id) {
		global $wpdb;

		$data = $wpdb->get_results("SELECT post_name FROM wp_posts WHERE ID = '$id'");

		if (count($data) > 0) {
			return $data[0]->post_name;
		} else {
			return 0;
		}
	}

}
