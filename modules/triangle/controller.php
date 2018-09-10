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

class Controller extends Modules {

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
				'hook' 		=> 'admin_head',
				'callback' 	=> 'Admin_Head_Asset',
				'priority' 	=> 10,
				'args' 		=> 0
			],
			[
				'hook' 		=> 'wp_ajax_triangle_theme_template',
				'callback' 	=> 'ajax_triangle_theme_template',
				'priority' 	=> 10,
				'args' 		=> 0
			],
			[
				'hook' 		=> 'wp_mail',
				'callback' 	=> 'triangle_wp_mail_filter',
				'priority' 	=> 10,
				'args' 		=> 0
			],
		);
	}

	/**
	 * Load custom CSS & JS on admin_head
	 * 
	 * @access	public
	 */
	public function Admin_Head_Asset(){
		global $pagenow;
	    if($pagenow == 'options-general.php'){
			echo $this->inc_res('css', 'menu.css' );
			echo $this->inc_res('css', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css' );
		}
	}

	/**
	 * Get theme template
	 * 
	 * @access	public
	 * @return	0
	 * @note	set exit so it wont return 0
	 */
	public function ajax_triangle_theme_template(){
		$theme = $this->get_active_theme();
		$title = 'Triangle Mail - Subject';
		ob_start();
			require $this->get_module('triangle',"themes/$theme/template.php");
		echo do_shortcode(ob_get_clean());
		exit; //Preset so it wont return 0
	}

	
	public function triangle_wp_mail_filter( $args ) {
		$stage = get_option('triangle_stage');
		if($stage=='live'){
			$theme = $this->get_active_theme();
			$title = $args['subject'];
			$content = $args['message'];
			ob_start();
				require $this->get_module('triangle',"themes/$theme/template.php");
			$args['message'] = do_shortcode(ob_get_clean());
		} 
		return $args;
	}

}