<?php
/*
 * Plugin Name:       PaidContent
 * Plugin URI:        https://wordpress.org/plugins/paidcontent
 * Description:       PaidContent allows you to sell of access to a particular page or post through WooCommerce plugin. You can sell content as one item and as items package. For selling of package you just need to insert a link to the package. In this case all contained items in a package  will be available for view.
 * Version:           1.1.0
 * Author:            Victor Demianenko
 * Author URI:        http://
 * Text Domain:       paidcontent
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:       /languages
 */
 
// Exit if accessed directly
if (  ! defined( 'ABSPATH' ) ){
	exit; 
}
 
if ( ! defined( 'WPINC' ) ) {
    die;
}


require_once plugin_dir_path( __FILE__ ) . 'includes/class.paidcontent.php';

function runPaidContent() {

	$pc = new PaidContent();
	$pc->run();

}

runPaidContent();

function paidContentLoadTexDomain() {
	
  load_plugin_textdomain( 'paidcontent', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
  
}
add_action( 'init', 'paidContentLoadTexDomain' );
