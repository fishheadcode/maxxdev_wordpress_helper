<?php

class Maxxdev_Helper_Widgets {

    private static $sidebars = array();

    /**
     * Adds a new sidebar widget
     * 
     * @param string $name
     * @param string $id
     * @param string $beforeWidget
     * @param string $afterWidget
     * @param string $beforeTitle
     * @param string $afterTitle
     */
    public static function addSidebar($name, $id, $beforeWidget, $afterWidget, $beforeTitle, $afterTitle) {
        self::$sidebars[] = array(
            "name" => $name,
            "id" => $id,
            "before_widget" => $beforeWidget,
            "after_widget" => $afterWidget,
            "before_title" => $beforeTitle,
            "after_title" => $afterTitle
        );
    }

    /**
     * Initiate all added widgets
     */
    public static function initWidgets() {
        if (count(self::$sidebars) > 0) {
            foreach (self::$sidebars as $sidebar) {
                register_sidebar($sidebar);
            }
        }
    }

}

add_action("widgets_init", array("Maxxdev_Helper_Widgets", "initWidgets"));
