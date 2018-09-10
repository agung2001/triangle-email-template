<?php 

/** *
 * @link       https://twitter.com/agung2001
 *
 * @package    ASU
 * @subpackage ASU\includes
 */

namespace Triangle\Includes\Triangle;

use Triangle\Includes\Cores;

class Menu extends Modules {

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
				'callback' 	=> 'admin_menu',
				'priority' 	=> 10, 
				'args' 		=> 0
			],
		);
	}

	/**
	 * Load core plugin menu
	 * 
	 * @access	public
	 * @menu	preview
	 * @menu	setting
	 */
	public function admin_menu(){
		//Menu Preview
		add_submenu_page(
			'options-general.php',
			'Triangle Preview', 
			'Triangle', 
            $this->config['capability'], 
            'triangle-preview',
			array(	$this , 'menu_preview')
		);
		//Menu Template
		add_submenu_page(
			null,
			'Triangle Theme', 
			'Triangle', 
            $this->config['capability'], 
            'triangle-theme',
			array(	$this , 'menu_theme')
		);
		//Menu Setting
		add_submenu_page(
			null,
			'Triangle Setting', 
			'Triangle', 
            $this->config['capability'], 
            'triangle-setting',
			array(	$this , 'menu_setting')
		);
	}

	/** 
	 * Menu Preview
	 * 
	 * @access	public
	*/
	public function menu_preview(){
		ob_start();
			require $this->get_element('menu/header.php');
			require $this->get_element('menu/preview.php');
			require $this->get_element('menu/footer.php');
		echo do_shortcode(ob_get_clean());
	}

	/** 
	 * Menu Template
	 * 
	 * @access	public
	*/
	public function menu_theme(){
		ob_start();
			require $this->get_element('menu/header.php');
			require $this->get_element('menu/theme.php');
			require $this->get_element('menu/footer.php');
		echo do_shortcode(ob_get_clean());
	}

	/** 
	 * Menu Setting
	 * 
	 * @access	public
	*/
	public function menu_setting(){
		ob_start();
			require $this->get_element('menu/header.php');
			require $this->get_element('menu/setting.php');
			require $this->get_element('menu/footer.php');
		echo do_shortcode(ob_get_clean());
	}
	
}