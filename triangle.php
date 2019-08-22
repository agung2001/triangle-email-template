<?php
/*
 * @wordpress-plugin
 * Plugin Name:       Triangle
 * Plugin URI:        http://www.applebydesign.com.au
 * Description:       Mail engine system by applebydesign
 * Version:           0.1
 * Author:            Agung Sundoro
 * Author URI:        https://applebydesign.com.au
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
*/

/*
* Load composer and system plugin file
*/
require plugin_dir_path(__FILE__) . 'vendor/autoload.php'; 

/*
 * Load Settings, Call plugin, Call modules
 */
function triangle_run(){
	$cap		= apply_filters( 'triangle_capability', 'publish_pages' );	
	$config 	= file_get_contents (plugin_dir_path(__FILE__) . 'composer.json');
	$plugins 	= new \Triangle\Includes\Plugins($cap,$config,__FILE__);
}
add_action('after_setup_theme','triangle_run');

