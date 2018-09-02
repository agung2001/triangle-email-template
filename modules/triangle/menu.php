<?php 

/**
 * @link       https://www.applebydesign.com.au
 * @since      0.1
 *
 * @package    Appleby
 * @subpackage Appleby/includes
 */

namespace Triangle\Includes\Triangle;

use Triangle\Includes\Cores;

class Menu extends Cores {

	/*
	* Get plugin and module configuration
	* Note : This setup is important to create module
	*/
	public function __construct($config){
		$this->config = $config;
		$this->module = $config['modules'][$config['active_module']];
	}

	/*
	* Callback function for administration menu
	*/
	public function callback(){
		return array(
			//Menu
			[
				'hook' 		=> 'admin_menu',
				'callback' 	=> 'load_plugin',
				'priority' 	=> 10, 
				'args' 		=> 0
			],
		);
	}

	/*
	* Load core plugin menu and replace the submenu
	*/
	public function load_plugin(){
		add_submenu_page(
			'options-general.php',
			'Triangle Setting', 
			'Triangle', 
            $this->config['capability'], 
            'triangle-setting',
			array(	$this , 'menu_setting')
		);
	}

	public function menu_setting(){
		ob_start();
			require $this->get_element('menu/setting.php');
			require $this->get_element('menu/footer.php');
		echo do_shortcode(ob_get_clean());
	}
	
}