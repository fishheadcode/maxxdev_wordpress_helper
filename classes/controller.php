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
            } elseif ($sign == " " || $sign == "-" || $sign == "_") {
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
        Maxxdev_Helper_Pages::addPage(get_post_type(get_the_ID()));
        $page = "";
        $pagename = get_query_var("pagename");
        $actionName = get_query_var("action");

        if (strlen($actionName) == 0) {
            $actionName = "indexAction";
        } else {
            $actionName = strtolower($actionName) . "Action";
        }

        if (is_single() && !in_array($pagename, Maxxdev_Helper_Pages::$pages)) {
            $page = get_post_type(get_the_ID());
        } elseif (is_home()) {
            $page = "index";
        } else {
            foreach (Maxxdev_Helper_Pages::$pages as $page_name) {
                if (is_page($page_name)) {
                    $page = $page_name;
                } elseif ($page_name == get_query_var("pagename")) {
                    $page = $page_name;
                }
            }

            if (strlen($page) == 0) {
                if (post_type_exists(get_query_var("pagename"))) {
                    $page = get_query_var("pagename");
                }
            }

            if (strlen($page) == 0) {
                $page = $pagename;
            }
        }
        if (strlen($page) > 0) {
            // make valid class name
            $className = self::getClassNameFromPageName($page);

            // get filename
            $fileName = str_replace("_", "", $className);

            // try to include class
            if (!class_exists($className)) {
                // if not exists: search for file "Maxxdev_Controller_$validname", implement it
                Maxxdev_Helper_Frontend::includeFile("controllers/" . $fileName . ".php");
            }

            // search for class
            if (class_exists($className)) {
                $controllerClass = new $className();

                // search for method $actionName
                if (method_exists($controllerClass, $actionName)) {
                    return $controllerClass->$actionName($template);
                } else {
                    if (method_exists($controllerClass, "indexAction")) {
                        return $controllerClass->indexAction($template);
                    }
                }
            }
        }

        return $template;
    }

}

add_filter("template_include", array(Maxxdev_Helper_Controller, "initController"));
