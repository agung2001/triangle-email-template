<?php 

/**
 * @link       https://www.applebydesign.com.au
 * @since      0.1
 *
 * @package    Appleby
 * @subpackage Appleby/includes
 */

namespace Triangle\Includes\Gravity;

use Triangle\Includes\Cores;

class Controller extends Modules {

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
			[
				'hook' 		=> 'init',
				'callback' 	=> 'dashboard',
				'priority' 	=> 10, 
				'args' 		=> 0
			],
		);
	}

	public function dashboard(){
	}

}