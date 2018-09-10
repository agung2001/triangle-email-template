<?php 

/**
 * Plugin core function
 *
 * @link       https://twitter.com/agung2001
 *
 * @package    ASU
 * @subpackage ASU\includes
 */

namespace Triangle\Includes\Triangle;

use Triangle\Includes\Cores;

class Shortcode extends Modules {

	/**
	* Get plugin and module configuration
	*
	* @access	public
	* @var		config - plugin configuration
	* @note		This setup is important to create module
	*/
	public function __construct($config){
		$this->config = $config;
		$this->module = $config['modules'][$config['active_module']];
    }
    
	/**
	* List of callback registered for loader hook
	*
	* @access	public
	*/
	public function callback(){
		return array(
			[
				'hook' 		=> 'triangle',
				'callback' 	=> 'triangle_shortcode',
				'priority' 	=> 10, 
				'args' 		=> 2
			],
		);
	}

	public function triangle_shortcode($atts, $content = null){
        $atts = shortcode_atts([
			'request'   => 'default',
            'action'    => 'default',
			'ID'        => '',
			'title'		=> ''
		], $atts, 'triangle' );
		if('title' == $atts['request']){
			if($atts['ID']) return get_post($atts['ID'])->post_title;
			else return $atts['title'];
        } elseif('logo' == $atts['request']){
			if(get_option('triangle_theme_logo')) return get_option('triangle_theme_default_logo');
			else return $this->get_asset('img','appleby.png',array('type' => 'url'));
		}
    }

}