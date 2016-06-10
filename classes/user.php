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

	public static function changePassword($user, $user_id, $oldPassword, $newPassword, $newPasswordConfirmation, $autologin = false) {
		if ($newPassword != $newPasswordConfirmation) {
			return array("success" => false, "message" => __("The new passwords did not match"));
		}

		$login = self::login($user, $oldPassword, false);

		if (is_wp_error($login)) {
			return array("success" => false, "message" => __("Your login credentials are not valid"));
		}

		wp_set_password($newPassword, $user_id);

		return array("success" => true);
	}

	public static function resetPassword($user) {
		$user_id = username_exists($user);

		if (is_numeric($user_id) && $user_id !== false) {
			if (self::sendPasswordResetMail($user, $user_id)) {
				return array("success" => true, "message" => __("Password reset successful. An email with further instruction will be sent to you."));
			} else {
				return array("success" => false, "message" => __("Error at sending password reset email. Please try again later."));
			}
		} else {
			return array("success" => false, "message" => __("User does not exist"));
		}
	}

	public static function sendPasswordResetMail($email, $user_id) {
		// generate key
		$key1 = md5(rand(1000, 9999) . rand(1000, 9999));
		$key2 = md5(rand(1000, 9999) . rand(1000, 9999));
		$key = $key1 . $key2;

		// set url
		$url = get_bloginfo("url") . "/resetpassword/" . $user_id . "/" . $key;
		$blogname = get_bloginfo("name");
		
		$message = __(file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "emails" . DIRECTORY_SEPARATOR . "resetpassword.txt"));
		$message = str_replace(array("{link}","{blogname}"), array($url, $blogname), $message);

		// save key
		update_user_meta($user_id, "passwordresetkey", $key);

		// send mail
		wp_mail($email, "Passwort zurücksetzen", $message);

		return true;
	}

}
