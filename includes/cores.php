<?php 

/**
 * Plugin core function
 *
 * @link       https://www.applebydesign.com.au
 *
 * @package    Appleby
 * @subpackage Appleby\includes
 */

namespace Triangle\Includes;

class Cores {

	/**
	* Configuration file for each module
	* 
	* @access	public
	* @var		array collection of module configuration
	*/
	public $config = array();

	/**
	* Configuration file modules/config.php
	* 
	* @access	public
	* @var		array save plugin configuration
	*/
	public $module = array();	

	/**
	 * The WordPress database class.
	 * 
	 * @access	public
	 * @var 	WPDB wordpress database class
	 */
	public $wpdb;

	/** 
	* Used by developer for debuging
	*
	* @access	public
	* @var 		data - can be anything for debugging purpose
	*/
	public function debug($data){
	    echo '<pre>';
	    print_r($data);
	}

	/** 
	* Get Path (FILE, PATH, URL)
	*
	* @access	public
	* @var		path - module path
	* @var		file - filename to get
	* @var		error - error message, if occur
	* @return 	path
	* @note		dont need '/' because constant already contain it
	*/
	// public function get_path($path, $file='',$error=false){
	// 	$path = $this->config[$path].$file;
	// 	if($error) $this->directory_error('path',$path);
	// 	return $path;
	// }

	/**
	* Validate path configuration
	*
	* @access	public
	* @var		config - path configuration
	* @var 		path
	* @return 	validatedPath
	*/
	public function config_path($config,$path){
		return [
			'type'	=> (isset($config['type'])) ? $path.'_'.$config['type'] : $path.'_path',
			'error' => (isset($config['error'])) ? $config['error'] : false
		];
	}

	/**
	* Get module asset path
	*
	* @access	public
	* @var		module - module name
	* @var		file - filaneme to get
	* @var		config - path configuration
	* @return	/module/assets/$dir
	*/
	public function get_asset($module, $file='', $config=array()){
		$config = $this->config_path($config,'asset');
		$path 	= $this->config[$config['type']].strtolower($module)."/$file";
		if($config['error']) $this->directory_error('asset',$path);
		return $path;
	}

	/**
	* Get module path 
	*
	* @access	public
	* @var 		module - module name
	* @var		file - filename to get
	* @var		config - path configuration
	* @return 	/modules/$dir
	*/
	public function get_module($module, $file='', $config=array()){
		$config = $this->config_path($config,'module');
		$path 	= $this->config[$config['type']].strtolower($module)."/$file";
		if($config['error']) $this->directory_error('module',$path);
		return $path;
	}

	/** 
	* Get module resource (CSS or JS) 
	*
	* @access	public
	* @var		file - filename to get
	* @var 		config - path configuration
	* @return 	/modules/_name/_filepath
	* @note		dont need '/' because constant already contain it
	*/
	public function get_res($file,$config = array()){
		$config['type'] = 'url';
		return $this->get_module( $this->module['name'], $file, $config );
	}

	/** 
	* Get module element (PHP, HTML)
	*
	* @access	public
	* @var		file - filename to get
	* @var 		config - path configuration
	* @return	/modules/_name/elements
	* @note		dont need '/' because constant already contain it
	*/
	public function get_element($file,$config = array()){
		$file = 'elements/'.$file;
		return $this->get_module( $this->module['name'], $file, $config );
	}

	/**
	* Get class name with namespace
	*
	* @access	public
	* @var		module - module name
	* @var		class - class name
	* @return	ClassName
	*/
	public function get_class($module,$class){
		$namespace 	= $this->config['namespace'];
		$module = ucwords($module);
		$class	= ucwords($class);
		return '\\'.$namespace.'\\'.$module.'\\'.$class;
	}

	/**
	* Include Resources
	*
	* @access	public
	* @var		type - (CSS or JS)
	* @var 		link - resource link (local or external)
	* @var		config - resource configuration
	* @return 	resource
	*/
	public function inc_res($type,$link, $config = array()){
		$config['id'] 		= (isset($config['id'])) ? $config['id'] : '';
		$config['async'] 	= (isset($config['async'])) ? $config['async'] : false;
		$config['async']	= ($config['async']==true) ? 'async' : '';
		if(strpos($link, "http://") === false && strpos($link, "https://") === false)
			$link = $this->get_res($type.'/'.$link);
		elseif($type=='css')
			return "<link rel='stylesheet' id='{$config['id']}' type='text/css' href='{$link}'>";
		elseif($type=='js')
			return "<script src='{$link}' {$config['async']}></script>";
	}

	/**
	* Directory Error
	*
	* @access	public
	* @var 		directory - type of path
	* @var		path - specific path to file
	*/
	private function directory_error($directory,$path){
		if(!file_exists($path)){
			if('path' == $directory)
				die('Path not exists, please contact developer!');
			elseif('module' == $directory)
				die("$module directory not found, please contact developer!");
			elseif('asset' == $directory)
				die("$asset directory not found, please contact developer!");
			else
				die("Critical error, please contact developer!");
		}	
	}

	/**
	* Validate configuration file on modules
	*
	* @access	public
	* @var		config - module configuration file
	* @var 		module - module name
	*/
	public function validate_config($config,$module = null){
		if(!isset($config['name']))
			die('Please specify plugin name in config.php!');
		elseif(!isset($config['version']))
			die('Please specify plugin version in config.php!');
		elseif(!isset($config['modules'][$module]['name']) && null != $module)
			die('Please specify module name in config.php!');
	}

}