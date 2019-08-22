<?php 

/**
 * Register all function for plugin
 *
 * @link       https://www.applebydesign.com.au
 * @since      0.1
 *
 * @package    Appleby
 * @subpackage Appleby\includes
 */

namespace Triangle\Includes;

class Cores {

	/*
	* Configuration file setting.php/config.php
	*/
	public $config = array();

	/*
	* Configuration file moudles/config.php
	*/
	public $module = array();	

	/**
	 * The WordPress database class.
	 * @var WPDB
	 */
	public $wpdb;

	/*
	* Used by developer for debuging
	* @data 	can be anything for debug
	*/
	public function debug($data){
	    echo '<pre>';
	    print_r($data);
	}

	/*
	* Get Path (FILE, PATH, URL)
	* Note :
	* return 	don't need '/' because constant already contain it
	*/
	public function get_path($path, $file='',$error=false){
		$path = $this->config[$path].$file;
		if($error) $this->directory_error('path',$path);
		return $path;
	}

	/*
	* Get module resource = CSS || JS file
	*/
	public function get_res($file,$config = array()){
		$config['type'] = 'url';
		return $this->get_module(
			$this->module['name'],
			$file,
			$config
		);
	}

	/*
	* Get module resource = CSS || JS file
	*/
	public function get_element($file,$config = array()){
		$file = 'elements/'.$file;
		return $this->get_module(
			$this->module['name'],
			$file,
			$config
		);
	}

	/*
	* Get MODULE path directory
	* return 	/modules/$dir
	* - path,url
	*/
	public function get_module($module, $file='', $config=array()){
		$config = $this->config_path($config,'module');
		$path 	= $this->config[$config['type']].strtolower($module)."/$file";
		if($config['error']) $this->directory_error('module',$path);
		return $path;
	}

	/*
	* Get ASSET path directory
	* return 	/assets/$dir
	*/
	public function get_asset($module, $file='', $config=array()){
		$config = $this->config_path($config,'asset');
		$path 	= $this->config[$config['type']].strtolower($module)."/$file";
		if($config['error']) $this->directory_error('asset',$path);
		return $path;
	}

	/*
	* Get class name with namespace
	*/
	public function get_class($module_name,$class_name){
		$namespace 	= $this->config['namespace'];
		$module_name= ucwords($module_name);
		$class_name	= ucwords($class_name);
		return '\\'.$namespace.'\\'.$module_name.'\\'.$class_name;
	}

	/*
	* Seperate shortcode by module
	*/
	public function module_shortcode($plugin,$module,$atts,$content){
		ob_start();
			$shortcode = '['.$plugin.'_'.$module.' ';
				foreach($atts as $key => $att){
					$shortcode .= $key.'='."'$att' ";
				}
			$shortcode .= ']';
				echo $content;
			$shortcode .= '[/'.$plugin.'_'.$module.']';
			echo $shortcode;
		return do_shortcode(ob_get_clean());
	}

	/*
	* Truncate text
	*/
	public function truncate($text, $chars = 25) {
	    $text = $text." ";
	    $text = substr($text,0,$chars);
	    $text = substr($text,0,strrpos($text,' '));
	    $text = $text."...";
	    return $text;
	}

	/*
	* Error
	*/
	public function directory_error($directory,$path){
		if(!file_exists($path)){
			if('path' == $directory)
				die('Path not exists, please contact developer!');
			if('module' == $directory)
				die("$module directory not found, please contact developer!");
			if('asset' == $directory)
				die("$asset directory not found, please contact developer!");
		}	
	}

	/*
	* Validate path
	*/
	public function config_path($config,$path){
		//Is set
		if(isset($config['type']))
			$config['type'] = $path.'_'.$config['type'];
		//Not set
		if(!isset($config['error']))
			$config['error'] = false;
		if(!isset($config['type']))
			$config['type'] = $path.'_path';
		return $config;
	}

	/*
	* Validate configuration file on modules
	* - validate name, version
	*/
	public function validate_config($config,$module = null){
		if(!isset($config['name']))
			die('Please specify plugin name in config.php!');
		if(!isset($config['version']))
			die('Please specify plugin version in config.php!');
		if(!isset($config['modules'][$module]['name']) && null != $module)
			die('Please specify module name in config.php!');
	}

	/*
	* Check accessor capability
	* - Check wether the accessor is from the right resource
	* - Check wether the capability is right 
	*/
	public function check_capability($capability){
		if($capability == 'back' && current_user_can( $this->config['capability'] ))
			return true;
		elseif($capability == 'front' && !current_user_can( $this->config['capability'] ))
			return true;
		elseif($capability == 'both')
			return true;
		else
			return false;
	}

}