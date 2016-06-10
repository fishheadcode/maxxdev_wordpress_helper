<?php

/**
 * This class helps you to create new routes, like /ajax/myupdateevent or ajax/login
 * The "requests" will then be forwared to the specific page you have given as the first url-part
 * Then, in combination with the controllers, you can do your stuff then
 */
class Maxxdev_Helper_Routes {

	/**
	 * Adds a new route
	 *
	 * @param string $regex "ajax/updateinvitation"
	 * @param type $controller
	 * @param type $params
	 */
	public static function addRoute($regex, $forcePageName = null, $forceFunction = null) {
		$paths = explode("/", $regex);

		if ($forcePageName == null) {
			$page_name = $paths[0];
		} else {
			$page_name = $forcePageName;
		}

		if ($forceFunction == null) {
			$function_name = $paths[1];
		} else {
			$function_name = $forceFunction;
		}

		add_rewrite_rule($regex . "/?$", "index.php?pagename=" . $page_name . "&function=" . $function_name, "top");
	}

	/**
	 * Adds new query vars to the public known query vars, so wordpress can recognize themn
	 *
	 * @param array $public_query_vars the already known query vars
	 * @return array returns all now wknown query vars
	 */
	public static function addQueryVars($public_query_vars) {
		$public_query_vars[] = "function";
		$public_query_vars[] = "param1";
		$public_query_vars[] = "param2";
		$public_query_vars[] = "param3";
		$public_query_vars[] = "param4";

		$public_query_vars[] = "team_id";
		$public_query_vars[] = "event_type";
		$public_query_vars[] = "team";
		$public_query_vars[] = "event";
		$public_query_vars[] = "action";
		$public_query_vars[] = "section";
		$public_query_vars[] = "player_id";
		$public_query_vars[] = "method";
		$public_query_vars[] = "accepted";
		$public_query_vars[] = "term";
		$public_query_vars[] = "id";
		$public_query_vars[] = "key";
		$public_query_vars[] = "preset";

		return $public_query_vars;
	}

}

add_filter("query_vars", array(Maxxdev_Helper_Routes, "addQueryVars"));

