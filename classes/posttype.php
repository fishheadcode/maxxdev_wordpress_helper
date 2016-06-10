<?php

class Maxxdev_Helper_Posttype {

    /**
     *
     * Adds a new custom post type
     *
     * @param string $post_type_name The name of the posttype
     * @param string $name The (plural) name of the posttype
     * @param string $singular_name The singular name of the posttype
     * @param string $text_new The text for creating a new element of this posttype
     * @param string $text_edit The text for editing an element of this posttype
     * @param string $text_watch The text for watching an element of this posttype
     * @param string $text_search The text for search elements of this posttype
     * @param string $text_search_not_found The text for "elements of this posttype not found"
     * @param string $text_no_deleted_elements The text for "there are no deleted elements of this posttype"
     * @param string $icon_path The folder/file where the icon is saved
     */
    public static function registerPostType($post_type_name, $name, $singular_name, $text_new, $text_edit, $text_watch, $text_search, $text_search_not_found, $text_no_deleted_elements, $icon_path, $rewrite = false, $show_in_nav = true, $position = false) {
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
            'parent_item_colon' => '',
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'menu_icon' => $icon_path,
            'rewrite' => $rewrite,
            'show_ui' => $show_in_nav,
            'show_in_nav' => $show_in_nav,
            'supports' => array('title', 'editor', 'thumbnail', 'comments', 'author', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'post-formats'),
            'taxonomies' => array("post_tag")
        );


        if ($position !== false) {
            $args['menu_position'] = $position;
        }

        if ($rewrite !== false && is_array($rewrite)) {
            $args["has_archive"] = true;
        } else {
            $args["has_archive"] = false;
        }

        // Register post type
        register_post_type($post_type_name, $args);
    }

    /**
     * Shorter version of registerPostType, which generates all texts automatically
     *
     * @param string $post_type_name Posttype name
     * @param string $name Plural name
     * @param string $singular_name Singular name
     * @param string $icon_path Path to the icon
     */
    public static function registerPostTypeShort($post_type_name, $name, $singular_name, $icon_path, $rewrite = false, $show_in_nav = true, $position = false) {
        $text_new = "$singular_name anlegen";
        $text_edit = "$singular_name bearbeiten";
        $text_watch = "$singular_name ansehen";
        $text_search = "$name suchen";
        $text_search_not_found = "Suche nach $name lieferte kein Ergebnis";
        $text_no_deleted_elements = "Keine gelöschten $name gefunden";

        Maxxdev_Helper_Posttype::registerPostType($post_type_name, $name, $singular_name, $text_new, $text_edit, $text_watch, $text_search, $text_search_not_found, $text_no_deleted_elements, $icon_path, $rewrite, $show_in_nav, $position);
    }

    /**
     *
     * @param string $identifier The name of the taxonomy, will be strolower()'d
     * @param string $posttype For which posttype the taxonomy shall be available?
     * @param string $singular Singular name of the taxonomy
     * @param string $plural Plural name of the taxonomy
     * @param array|boolean $rewrite true or false for rewriting, array(slug/with_front/hierarchical/ep_mask) for more details
     * @param array $terms Terms (Values) of the Taxonomy. Must be multiple arrays (0=name, 1=slug) within a main array. (e.g. array(array('name','slug'), array('name2','slug2'));)
     */
    public static function registerTaxonomy($identifier, $posttype, $singular, $plural, $rewrite = true, $terms = array()) {
        $labels = array(
            'name' => _x($plural, "taxonomy general name"),
            'singular_name' => _x($singular, "taxonomy singular name"),
            'search_items' => __("Search for $singular"),
            'all_items' => __("All $singular"),
            'parent_item' => __("Parent $singular"),
            'parent_item_colon' => __("Parent $singular:"),
            'edit_item' => __("Edit $singular"),
            'update_item' => __("Edit $singular"),
            'add_new_item' => __("New $singular"),
            'new_item_name' => __("New $singular name"),
        );

        // Register and attach to 'team' post type
        register_taxonomy(strtolower($identifier), $posttype, array(
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => $rewrite,
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

}
