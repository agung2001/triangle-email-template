<?php 

/**
 * Setup modular plugin system
 *
 * @link       https://twitter.com/agung2001
 *
 * @package    ASU
 * @subpackage ASU/includes
 */

namespace Triangle\Includes;

use Triangle\Includes\Loader;
use Triangle\Includes\Cores;

class Plugins extends Cores {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power the plugin.
	 *
	 * @access   protected
	 * @var      loader   Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	* Consist of all active module and configuration
	*
	* @access	private
	* @var		modules - lists of modules used by plugin
	*/
	private $modules;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @access	public
	 */
	public function __construct($cap,$config,$path){
		$this->load_dependencies($cap,$config,$path);
		$this->load_modules();
		$this->loader->run(); 
	}

	/**
	* Set variable, setting file and path
	*
	* @access	public
	* @var 		cap - minimum capability to access plugin
	* @var 		config - plugin configuration
	* @var 		path - core module path
	* @note 	define global accessed variable
	*/
	private function load_dependencies($cap,$config,$path){
		$this->loader 				= new Loader();
		$this->config 				= json_decode($config,true);
		$this->config['capability']	= $cap;
		$this->config['namespace'] 	= __NAMESPACE__;
		$this->config['path']		= plugin_dir_path($path);
		$this->config['url']		= plugin_dir_url($path);
		$this->config['asset_path']	= $this->config['path'].'assets/';
		$this->config['asset_url']	= $this->config['url'].'assets/';
		$this->config['module_path']= $this->config['path'].'modules/';
		$this->config['module_url']	= $this->config['url'].'modules/';
		$this->validate_config($this->config);
	}

	/**
	* Load Modules 
	*
	* @access 	private
	* - Load config.json file from the module directory
	* - Load 'load_ajax' function for ajax module handler
	* - Load 'load_cores' function for module 
	* - (Controller, Post, Menu, Action, Filter, Shortcode, API)
	*/
	private function load_modules(){
		$modules = scandir($this->config['module_path']);
		$modules = array_diff($modules, array('.', '..','.DS_Store'));
		foreach($modules as $module){
			$module = file_get_contents($this->get_module($module,'config.json'));
			$module = json_decode($module,true);
			if(false == $module['active']) continue;
			$this->config['modules'][$module['name']] = $module;
			$this->config['active_module'] = $module['name'];
			$this->validate_config($this->config,$module['name']);
			$this->load_cores($this->config,'controller');
			$this->load_cores($this->config,'post');
			$this->load_cores($this->config,'menu');
			$this->load_cores($this->config,'action');
			$this->load_cores($this->config,'filter');
			$this->load_cores($this->config,'shortcode');
			$this->load_cores($this->config,'api');
			$this->modules[$module['name']] = $module;
		}
	}

	/**
	* Load CoreWP (Action, Filter, Shortcode) - within modules callback
	*
	* @access	private
	* @var		config - module configuration
	* @var 		core - core (Controller, Post, Menu, Action, Filter, Shortcode, API)
	* - Register loader from module callback
	*/
	private function load_cores($config,$core){
		$paths = $this->get_module($config['active_module'],$core);
		$paths = (is_dir($paths)) ? glob($paths.'/*.php') : ["{$paths}.php"];
		foreach($paths as $path){
			if(!file_exists($path)) continue;
			$module = $this->get_class($config['active_module'],basename($path,".php"));
			$module = new $module($config);
			$this->load_core_callback($module,$core,$config);
		}
	}

	/**
	* Load callback for registration to loader hook
	*
	* @access	public
	* @var		module - module name
	* @var 		core - core (Controller, Post, Menu, Action, Filter, Shortcode, API)
	* @var 		config - module configuration
	* @note 	module callback return 'array' of core function like Action, Filter, Shortcodes
	*/
	private function load_core_callback($module,$core,$config){
		$default_cores = array('action','filter','shortcode');
		if(!empty($module->callback())){
			$core = (in_array($core,$default_cores)) ? $core : 'action'; 
			foreach($module->callback() as $loader){
				$loader['module'] = $module;
				$function = (isset($loader['core'])) ? "add_{$loader['core']}" : "add_$core";
				$capability = (isset($loader['caps'])) ? current_user_can($loader['caps']) : true;
				if($capability)
					$this->loader->$function(
						$loader['hook'], 
						$loader['module'], 
						$loader['callback'],
						$loader['priority'],
						$loader['args']
					);
			}
		}
	}

}