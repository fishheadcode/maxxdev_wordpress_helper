<?php

/*
  Plugin Name: Maxxdev Coding Helper
  Plugin URI: http://maxxdev.de
  Description: This plugin helps you creating other wordpress plugins! Isn´t that awesome?
  Version: 1.0
  Author: Christian Schrut
  Author URI: http://maxxdev.de
 */

class Maxxdev {

    /**
     *
     * Adds a new custom post type
     *
     * @param string $post_type_name
     * @param string $name
     * @param string $singular_name
     * @param string $text_new
     * @param string $text_edit
     * @param string $text_watch
     * @param string $text_search
     * @param string $text_search_not_found
     * @param string $text_no_deleted_elements
     */
    public static function registerPostType($post_type_name, $name, $singular_name, $text_new, $text_edit, $text_watch, $text_search, $text_search_not_found, $text_no_deleted_elements) {
        // Labels
        $labels = array(
            'name' => _x($name, "post type general name"),
            'singular_name' => _x($singular_name, "post type singular name"),
            'menu_name' => $name,
            'add_new' => _x($text_new, "team item"),
            'add_new_item' => __($text_new),
            'edit_item' => __($text_edit),
            'new_item' => __($text_new),
            'view_item' => __($text_watch),
            'search_items' => __($text_search),
            'not_found' => __($text_search_not_found),
            'not_found_in_trash' => __($text_no_deleted_elements),
            'parent_item_colon' => ''
        );

        // Register post type
        register_post_type($post_type_name, array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => false,
            'menu_icon' => plugin_dir_url(__FILE__) . "assets/icons/" . $post_type_name . ".png",
            'rewrite' => false,
            'supports' => array('title', 'editor', 'thumbnail')
        ));
    }

    /**
     *
     * @param string $posttype
     * @param string $singular
     * @param string $plural
     * @param array $terms
     */
    public static function registerTaxonomy($posttype, $singular, $plural, $terms = array()) {
        $labels = array(
            'name' => _x($plural, "taxonomy general name"),
            'singular_name' => _x($singular, "taxonomy singular name"),
            'search_items' => __("Suche nach $singular"),
            'all_items' => __("Alle $singular"),
            'parent_item' => __("Übergeordnete(s) $singular"),
            'parent_item_colon' => __("Übergeordnete(s) $singular:"),
            'edit_item' => __("$singular bearbeiten"),
            'update_item' => __("$singular bearbeiten"),
            'add_new_item' => __("$singular anlegen"),
            'new_item_name' => __("Neuer $singular Name"),
        );

        // Register and attach to 'team' post type
        register_taxonomy(strtolower($singular), $posttype, array(
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => true,
            'labels' => $labels
        ));

        if (count($terms) > 0) {
            foreach ($terms as $term) {
                wp_insert_term($term[0], strtolower($singular), array(
                    "description" => "",
                    "slug" => $term[1],
                    "parent" => ""
                        )
                );
            }
        }
    }

    /**
     *
     * Adds CSS to your site
     *
     * @param string $filename
     * @param string $style_name
     * @param string $folder
     */
    public static function addCSS($filename, $style_name = "my_style", $folder = null) {
        if ($folder === null || strlen($folder) === 0) {
            $folder = plugin_dir_url(__FILE__) . "/css/";
        }

        wp_enqueue_style($style_name, $folder . $filename);
    }

    /**
     *
     * Adds JS to your site
     *
     * @param string $filename
     * @param string $style_name
     * @param string $folder
     */
    function addJs($filename, $script_name = "my_script", $folder = null) {
        if ($folder === null || strlen($folder) === 0) {
            $folder = plugin_dir_url(__FILE__) . "/js/";
        }

        wp_enqueue_script($script_name, $folder . $filename);
    }

    /**
     *
     * @param string $page_title
     * @param string $menu_title
     * @param string $capability
     * @param string $slug
     */
    function addAdminOptionsPage($page_title, $menu_title, $capability, $slug) {
        add_options_page($page_title, $menu_title, $capability, $slug);
    }

}

/**
 * Just an alias
 */
class MDH extends Maxxdev {

}

/**
 * Just an alias
 */
class MDHelper extends Maxxdev {

}
