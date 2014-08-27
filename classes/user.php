<?php

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
