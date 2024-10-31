<?php
/**
 * PaidContent Uninstall
 *
 * Uninstalling Paid Content custom post types, taxonomies and options.
 *
 * @author      Viktor Demianenko
 * @category    Core
 * @package     PaidContent/Uninstaller
 * @version     1.0.2
 */

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
function unregisterCustomPostType(){
    unregister_post_type( 'paidcontent' );
}
add_action('init','unregisterCustomPostType');