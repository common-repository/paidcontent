<?php

if (!class_exists('PaidContentAdmin')) {

    class PaidContentAdmin
    {

        private $version;

        public function __construct($version)
        {
            $this->version = $version;
        }

        public function enqueueStyles()
        {

            wp_enqueue_style(
                'paidcontent-admin-css',
                plugin_dir_url(__FILE__) . '../assets/css/paidcontent-admin.css',
                array(),
                $this->version,
                FALSE
            );

        }

        /**
         * Add options page
         */

        public function addToAdminMenuOptionsPage()
        {
            add_options_page(
                __( 'Admin Settings', 'paidcontent' ),
                'PaidContent',
                'manage_options',
                'paidContent-settings',
                array($this, 'createOptionsPage')
            );

        }

        /**
         * Options page callback
         */
        public function createOptionsPage()
        {
            if ( !current_user_can( 'manage_options' ) )  {
                wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
            }
            ?>
            <div class="wrap">
                <h1><?php echo __( 'PaidContent Settings', 'paidcontent' ); ?></h1>
                <form method="post" action="options.php">
                    <?php
                    // This prints out all hidden setting fields
                    settings_fields('option_group');
                    do_settings_sections('paidContent-settings');
                    submit_button();
                    ?>
                </form>
            </div>
            <?php
        }

        /**
         * Register and add settings
         */
        public function initOptionsPage()
        {

            register_setting(
                'option_group', // Option group
                'accessDenyPage' // Option name
            );



            add_settings_section(
                'settings_section_access_page', // ID
                'Access Deny Settings', // Title
                array($this, 'printSectionInfo'), // Callback
                'paidContent-settings' // Page
            );

            add_settings_field(
                'accessDenyPage', // ID
                'Access Deny Page: ', // Title
                array($this, 'selectAccessDenyPage'), // Callback
                'paidContent-settings', // Page
                'settings_section_access_page', // Section
                array( // The $args
                    'accessDenyPage', // Should match Option ID
                    'Will be presented in the tag HEAD every time.'
                )
            );


        }


        /**
         * Print the Section text
         */
        public function printSectionInfo()
        {
            print __('Here you can select the Access Denied Page (should be created before). If page isn\'t selected, will be displayed the Access Denied Page by default.','paidcontent');
        }


        /**
         * Display and fill the form field. Texfield Callback
         */

        function selectAccessDenyPage($args)
        {

            wp_dropdown_pages( array(
                'name' => $args[0],
                'show_option_none' => __( '— Select —' ),
                'option_none_value' => null,
                'selected' => get_option($args[0]),
            ));
        }

        public static function getAccessDenyPage()
        {

            $access_deny_page_id = get_option('accessDenyPage');
            return $access_deny_page_id;
        }

    }
}
