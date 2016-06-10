<?php

class Maxxdev_Helper_Paypal_Express_Checkout {

	private static $clientID = "paypalseller_api1.maxxdev.de";
	private static $clientPassword = "3Q3JEVCFS757XSGG";
	private static $secretKey = "AxostzeY-6.nteo5U7BmkoHOlKMwAeXDBt8F736eY1t4dcDpB4FJhv2F";
	private static $sandboxMode = true;

	/**
	 * First step: Initiate Payment and get token from paypal for further actions
	 *
	 * @param type $amt The amount (i.e. 1.99)
	 * @return array
	 */
	public static function setExpressCheckout($amt, $listingID) {
		// init curl
		$ch = curl_init();

		// define fields
		$fields = self::getDefaultFields("SetExpressCheckout");
		$fields["PAYMENTREQUEST_0_PAYMENTACTION"] = "SALE";
		$fields["PAYMENTREQUEST_0_AMT"] = $amt;
		$fields["PAYMENTREQUEST_0_CURRENCYCODE"] = "EUR";
		$fields["PAYMENTREQUEST_0_DESC"] = __("Listing on Kickerspot");
		$fields["PAYMENTREQUEST_0_INVNUM"] = $listingID;
		$fields["RETURNURL"] = Kickerspot_URL::getListingsCreateSuccessURL();
		$fields["CANCELURL"] = Kickerspot_URL::getListingsCreateCancelURL();

		// set curl options
		curl_setopt($ch, CURLOPT_URL, "https://api-3t.sandbox.paypal.com/nvp");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, self::encodeNvpString($fields));

		// exec curl
		$response = curl_exec($ch);

		// return the results
		return self::decodeNvpString($response);
	}

	/**
	 * Second step: One must get payment details after getting forwarded back from paypal to the site!
	 * One does not simply don´t need these informations!
	 *
	 * @param string $token
	 * @return array
	 */
	public static function getExpressCheckoutDetails($token) {
		// init curl
		$ch = curl_init();

		// set fields
		$fields = self::getDefaultFields("GetExpressCheckoutDetails");
		$fields["TOKEN"] = $token;

		// set curl options
		curl_setopt($ch, CURLOPT_URL, "https://api-3t.sandbox.paypal.com/nvp");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, self::encodeNvpString($fields));

		// exec curl, get response
		$response = curl_exec($ch);

		// return the results
		return self::decodeNvpString($response);
	}

	/**
	 * Third and last step: After everything was successful, you need to complete the payment.
	 * #shutupandtakemymoney
	 *
	 * @param string $token
	 * @param string $payerID
	 * @param string $amt
	 * @param string $currency
	 * @return array
	 */
	public static function doExpressCheckoutPayment($details) {
		$token = $details["TOKEN"];
		$payerID = $details["PAYERID"];
		$amt = $details["AMT"];
		$currency = $details["CURRENCYCODE"];
		$desc = $details["PAYMENTREQUEST_0_DESC"];
		$listingID = $details["PAYMENTREQUEST_0_INVNUM"];

		// init curl
		$ch = curl_init();

		// set fields
		$fields = self::getDefaultFields("DoExpressCheckoutPayment");
		$fields["TOKEN"] = $token;
		$fields["PAYERID"] = $payerID;
		$fields["PAYMENTREQUEST_0_PAYMENTACTION"] = "SALE";
		$fields["PAYMENTREQUEST_0_AMT"] = $amt;
		$fields["PAYMENTREQUEST_0_CURRENCYCODE"] = $currency;
		$fields["PAYMENTREQUEST_0_DESC"] = $desc;
		$fields["PAYMENTREQUEST_0_INVNUM"] = $listingID;

		// set curl options
		curl_setopt($ch, CURLOPT_URL, "https://api-3t.sandbox.paypal.com/nvp");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, self::encodeNvpString($fields));

		// exec curl, get response
		$response = curl_exec($ch);

		// return the results
		return self::decodeNvpString($response);
	}

	private static function getDefaultFields($method) {
		return array(
			"USER" => self::$clientID,
			"PWD" => self::$clientPassword,
			"SIGNATURE" => self::$secretKey,
			"METHOD" => $method,
			"VERSION" => 78
		);
	}

	public static function getURLCheckout($token) {
		if (self::$sandboxMode == true) {
			return "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=" . $token;
		} else {
			return "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=" . $token;
		}
	}

	public static function encodeNvpString($fields) {
		$nvpstr = "";

		foreach ($fields as $key => $value) {
			$nvpstr .= sprintf("%s=%s&", urlencode(strtoupper($key)), urlencode($value));
		}

		return $nvpstr;
	}

	private static function decodeNvpString($nvpstr) {
		$pairs = explode("&", $nvpstr);
		$fields = array();

		foreach ($pairs as $pair) {
			$items = explode("=", $pair);
			$fields[urldecode($items[0])] = urldecode($items[1]);
		}

		return $fields;
	}

}
