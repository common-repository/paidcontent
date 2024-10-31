<?php

if (!class_exists('PaidContentSetAccess')) {

    class PaidContentSetAccess
    {
        // Checking contains an array of predetermined values or not
        protected function contains($str, array $arr)
        {
            foreach ($arr as $a) {
                if (stripos($str, $a) !== false) return true;
            }
            return false;
        }


        // If current URL isn't in the customer's orders -  blocking access to the content.
        public function getAccessToPaidContent()
        {
            global $wp;
            $current_url = home_url(add_query_arg(array(), $wp->request));
            $include = array('/paidcontent/', '/package/');
            if ($this->contains($current_url, $include)) {
                if (!$this->checkURL($current_url)) {
                    global $post;
                    $terms = wp_get_post_terms($post->ID, 'package');
                    $current_url = home_url() . '/' . current($terms)->taxonomy . '/' . current($terms)->slug;
                    if (!$this->checkURL($current_url)) {
                        $url = $this->getAccessDenyPage();
                        wp_safe_redirect($url);
                        ob_end_flush();
                        exit;
                    }
                }
            }
        }


        // Checking the is contained whether the current URL in the customer's orders.
        protected function checkURL($current_url)
        {
            $wc = new WC_Customer;
            $array = $wc->get_downloadable_products();
            if (!empty($array)) {
                foreach ($array as $a1) {
                    if (trim($a1['file']['file'], '/') == $current_url) {
                        return true;
                    }
                }
            }

            return false;
        }

        public function getAccessDenyPage()
        {
            $access_deny_page_id = PaidContentAdmin::getAccessDenyPage();
            if ($access_deny_page_id == '') {
                require_once plugin_dir_path(dirname(__FILE__)) . 'templates/access-deny-page.php';
            } else {
                $url = get_page_link($access_deny_page_id);
                return $url;
            }

        }

        public function doOutputBuffer()
        {
            ob_start();
        }
    }

}