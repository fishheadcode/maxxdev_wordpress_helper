<?php

class Maxxdev_Helper_Session {

	private static $session_var_name = "maxxdev_session_messages";

	public static function addSuccessMessage($message) {
		self::addMessage("success", $message);
	}

	public static function addErrorMessage($message) {
		self::addMessage("error", $message);
	}

	public static function addWarningMessage($message) {
		self::addMessage("warning", $message);
	}

	public static function addMessage($type, $message) {
		@session_start();

		if (!isset($_SESSION[self::$session_var_name])) {
			self::resetMessages();
		}

		$_SESSION[self::$session_var_name][] = new Maxxdev_Helper_Session_Message($type, $message);
	}

	public static function getMessages() {
		// start session
		@session_start();

		// get messages
		$messages = $_SESSION[self::$session_var_name];

		// reset messages
		self::resetMessages();

		// return messages
		return $messages;
	}

	private static function resetMessages() {
		$_SESSION[self::$session_var_name] = array();
	}

}

class Maxxdev_Helper_Session_Message {

	public $type;
	public $message;

	public function __construct($type, $message) {
		$this->type = $type;
		$this->message = $message;
	}

}
