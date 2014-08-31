<?php

class Maxxdev_Helper_Controller {

	private static function getClassNameFromPageName($page_name) {
		$className = "";
		$nextBig = true;


		for ($i = 0; $i < strlen($page_name); $i++) {
			$sign = $page_name[$i];
			$ascii = ord($sign);

			if (($ascii >= 65 && $ascii <= 90 ) ||
					($ascii >= 97 && $ascii <= 122)) {

				if ($nextBig === true) {
					$className .= strtoupper($sign);
				} else {
					$className .= strtolower($sign);
				}

				$nextBig = false;
			} elseif ($ascii >= 48 && $ascii <= 57) {
				$className .= $sign;
			} elseif ($sign == " ") {
				$nextBig = true;
			}
		}

		if (strlen($className) > 0) {
			return $className . "_Controller";
		} else {
			return null;
		}
	}

	public static function initController($template) {
		foreach (Maxxdev_Helper_Pages::$pages as $page_name) {
			if (is_page($page_name)) {
				// make valid class name
				$className = self::getClassNameFromPageName($page_name);

				// try to include class
				if (!class_exists($className)) {
					// if not exists: search for file "Maxxdev_Controller_$validname", implement it
					Maxxdev_Helper_Frontend::includeFile("controllers/" . $className . ".php");
				}

				// search for class
				if (class_exists($className)) {
					$controllerClass = new $className();

					// search for method "start"
					if (method_exists($controllerClass, "start")) {
						// execute $class->start();
						return $controllerClass->start();
					}
				}
			}
		}

		return $template;
	}

}

add_filter("template_include", array(Maxxdev_Helper_Controller, "initController"));
