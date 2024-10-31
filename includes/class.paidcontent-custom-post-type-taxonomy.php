<?php

if (!class_exists('PaidContentCustomPostTypeTaxonomy')) {

    class PaidContentCustomPostTypeTaxonomy
    {

        const DEFAULT_POST_TYPE = 'paidcontent';

        public static function getCurrentPostTypeName()
        {
            return self::DEFAULT_POST_TYPE;
        }
        // register Custom Post Types and taxonomies, the use of the init hook is required!
        public static function customPostTypeInit($post_type = null)
        {
            if (empty($post_type))
                $post_type = self::getCurrentPostTypeName();

            /**
             * add the custom post type "paidcontent"
             * https://codex.wordpress.org/Function_Reference/register_post_type
             */
            $labels = array(
                'name'                => _x( $post_type, 'Post Type General Name', 'paidcontent' ),
                'singular_name'       => _x( 'Paid Content', 'Post Type Singular Name', 'paidcontent' ),
                'menu_name'           => __( 'Paid Content', 'paidcontent' ),
                'parent_item_colon'   => __( 'Parent Item:', 'paidcontent' ),
                'all_items'           => __( 'All Items', 'paidcontent' ),
                'view_item'           => __( 'View Item', 'paidcontent' ),
                'add_new_item'        => __( 'Add New Item', 'paidcontent' ),
                'add_new'             => __( 'Add New', 'paidcontent' ),
                'edit_item'           => __( 'Edit Item', 'paidcontent' ),
                'update_item'         => __( 'Update Item', 'paidcontent' ),
                'search_items'        => __( 'Search Item', 'paidcontent' ),
                'not_found'           => __( 'Not found', 'paidcontent' ),
                'not_found_in_trash'  => __( 'Not found in Trash', 'paidcontent' ),
            );

            $args = array(
                'label'               => __( 'Paid Content', 'paidcontent' ),
                'description'         => __( 'Post Type Description', 'paidcontent' ),
                'labels'              => $labels,
                'supports'            => array( ),
                'hierarchical'        => false,
                'public'              => true,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 5,
                'menu_icon'           => 'dashicons-hidden',
                'can_export'          => true,
                'has_archive'         => true,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'capability_type'     => 'page',
                //'taxonomies' => array('category') // if you also want to add an existing taxonomy like categories or tags, you can add them here
            );
            register_post_type($post_type, $args);


            /**
             * Add new taxonomy, make it hierarchical (like categories) and associate it to the "paidcontent" Custom Post Type
             * https://codex.wordpress.org/Function_Reference/register_taxonomy
             */
            $labels = array(
                'name' => _x('Paid packages', 'taxonomy general name'),
                'singular_name' => _x('Paid package', 'taxonomy singular name'),
                'search_items' => __('Search Paid package'),
                'all_items' => __('All Paid packages'),
                'parent_item' => __('Parent Paid package'),
                'parent_item_colon' => __('Parent Paid package:'),
                'edit_item' => __('Edit Paid package'),
                'update_item' => __('Update Paid package'),
                'add_new_item' => __('Add New Paid package'),
                'new_item_name' => __('New Paid packages Name'),
                'menu_name' => __('Paid package'),
            );
            $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'package'),
            );
            register_taxonomy('package', array($post_type), $args);


            /**
             * Add new taxonomy, NOT hierarchical (like tags)  and associate it to the "paidcontent" Custom Post Type
             * https://codex.wordpress.org/Function_Reference/register_taxonomy
             */
            $labels = array(
                'name' => _x('Authors', 'taxonomy general name'),
                'singular_name' => _x('Author', 'taxonomy singular name'),
                'search_items' => __('Search Author'),
                'popular_items' => __('Popular Authors'),
                'all_items' => __('All Authors'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Edit Author'),
                'update_item' => __('Update Author'),
                'add_new_item' => __('Add New Author'),
                'new_item_name' => __('New Author Name'),
                'separate_items_with_commas' => __('Separate authors with commas'),
                'add_or_remove_items' => __('Add or remove authors'),
                'choose_from_most_used' => __('Choose from the most used authors'),
                'not_found' => __('No authors found.'),
                'menu_name' => __('Authors'),
            );
            $args = array(
                'hierarchical' => false,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'rewrite' => array('slug' => 'author'),
            );
            register_taxonomy('author', $post_type, $args);


        }


        /**
         * this hook will regenerate the permalinks when the plugin is activated. I would recommend that you work with the permalinks OFF until you make
         * your custom post types. After you make the final custom post types you can enable the permalinks and hit save in wp-admin -> settings -> permalinks.
         */
        function regeneratePermalinks()
        {
            $this->customPostTypeInit();
            flush_rewrite_rules();
        }

    }
}