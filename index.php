<?php 
/*
Plugin Name: N-Media Post and Meta Saving from Frontend
Plugin URI: http://www.najeebmedia.com
Description: This plugin allow users to save a post and post meta from frontend. Upload featured image and attach categories if needed.
Version: 1.1
Author: Najeeb Ahmad
Author URI: http://www.najeebmedia.com/
Text Domain: nm-postfront
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Lets start from here
*/

/*
 * loading plugin config file
 */
$_config = dirname(__FILE__).'/config.php';
if( file_exists($_config))
	include_once($_config);
else
	die('Reen, Reen, BUMP! not found '.$_config);


/* ======= the plugin main class =========== */
$_plugin = dirname(__FILE__).'/classes/plugin.class.php';
if( file_exists($_plugin))
	include_once($_plugin);
else
	die('Reen, Reen, BUMP! not found '.$_plugin);

/*
 * [1]
 * TODO: just replace class name with your plugin
 */
$postfront = new NM_PLUGIN_PostFront();


if( is_admin() ){

	$_admin = dirname(__FILE__).'/classes/admin.class.php';
	if( file_exists($_admin))
		include_once($_admin );
	else
		die('file not found! '.$_admin);

	$postfront_admin = new NM_PLUGIN_PostFront_Admin();
}

/*
 * activation/install the plugin data
*/
register_activation_hook( __FILE__, array('NM_PLUGIN_PostFront', 'activate_plugin'));
register_deactivation_hook( __FILE__, array('NM_PLUGIN_PostFront', 'deactivate_plugin'));


