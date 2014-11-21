<?php

/**
 * Helps you to send mails much easier
 */
class Maxxdev_Helper_Mail {

	private $to;
	private $from;
	private $subject;
	private $message;
	private $header;
	private $attachments;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->header = array();
		$this->attachments = array();
		$this->from = "";
		$this->to = "";
		$this->message = "";
		$this->subject = "";
	}

	/**
	 * Set the reciever(s).
	 * String (comma-separated) or array of reciver(s) expected.
	 *
	 * @param string|array $to array or string (comma-separated) of recievers
	 */
	public function setTo($to) {
		$this->to = $to;
	}

	/**
	 * Sets the subject of the email
	 * 
	 * @param string $subject the email subject
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * Sets the "from"-property in the header
	 *
	 * @param string $name the name which will be displayed then in the inbox
	 * @param string $email the email (e.g. for reply)
	 */
	public function setFrom($name, $email) {
		$this->from = $name . " <" . $email . ">";
	}

	/**
	 * Sets the message of the mail and replaces (if $data is given)
	 * the placeholders in the template. The placeholders must look
	 * like this: "Dear {firstname} {lastname}". So the array needs
	 * to contain $data["firstname"] and $data["lastname"]
	 *
	 * @param string $message the message/body of the mail
	 * @param array $data the values, which will be replaced instead of the placeholders
	 */
	public function setMessage($message, $data = array()) {
		$this->message = $message;
		$this->replaceMessage($data);
	}

	/**
	 * Replaces all placeholders in the given email-message.
	 * The placeholders must look like this:
	 * "Dear {firstname} {lastname}". So the array needs to
	 * contain $data["firstname"] and $data["lastname"]
	 *
	 * @param array $data the values, which will be replaced instead of the placeholders
	 */
	public function replaceMessage($data = array()) {
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
				$this->message = str_replace("{" . $key . "}", $value, $this->message);
			}
		}
	}

	/**
	 * Adds an attachment to the email
	 *
	 * @param string $filepath the path to the file (e.g. "/var/www/htdocs/mywebsite/rules/terms.pdf")
	 */
	public function addAttachment($filepath) {
		$this->attachments[] = $filepath;
	}

	/**
	 * Builds the header, e.g. the "From:"-part.
	 */
	private function buildHeader() {
		$this->header = array();

		if (strlen($this->from) > 0) {
			$this->header[] = $this->from;
		}
	}

	/**
	 * Send out the mail!
	 *
	 * @return boolean returns the result of sending out the email
	 */
	public function send() {
		$this->buildHeader();

		return wp_mail($this->to, $this->subject, $this->message, $this->header, $this->attachments);
	}

}
