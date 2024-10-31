<?php

if (!class_exists('PaidContent')) {

    class PaidContent
    {

        protected $loader;

        protected $plugin_slug;

        protected $version;

        protected $textdomain;

        public function __construct()
        {

            $this->plugin_slug = 'paidcontent';
            $this->version = '1.1.0';

            $this->loadDependencies();
            $this->defineAdminHooks();
            $this->defineExtraHooks();

        }

        private function loadDependencies()
        {

            require_once plugin_dir_path(__FILE__) . 'class.paidcontent-admin.php';
            require_once plugin_dir_path(__FILE__) . 'class.paidcontent-custom-post-type-taxonomy.php';
            require_once plugin_dir_path(__FILE__) . 'class.paidcontent-set-access.php';
            require_once plugin_dir_path(__FILE__) . 'class.paidcontent-loader.php';
            $this->loader = new PaidContentLoader();

        }


        private function defineAdminHooks()
        {

            $admin = new PaidContentAdmin($this->getVersion());
            $this->loader->addAction('admin_enqueue_scripts', $admin, 'enqueueStyles');
            $this->loader->addAction('admin_menu',$admin, 'addToAdminMenuOptionsPage');
            $this->loader->addAction('admin_init',$admin, 'initOptionsPage');



        }

        private function defineExtraHooks()
        {

            $access = new PaidContentSetAccess($this->getVersion());
            $this->loader->addAction('init', $access, 'doOutputBuffer');
            $this->loader->addAction('wp_head', $access, 'getAccessToPaidContent');

            $custom_post_type = new PaidContentCustomPostTypeTaxonomy($this->getVersion());
            $this->loader->addAction('init', $custom_post_type, 'customPostTypeInit');
            $this->loader->registerActivationHook(__FILE__, $custom_post_type, 'regeneratePermalinks');

        }

        public function run()
        {
            $this->loader->run();
        }

        public function getVersion()
        {
            return $this->version;
        }

    }

}