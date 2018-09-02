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
use \Pelago\Emogrifier;

class Shortcode extends Modules {

	public $content;

	/*
	* Get plugin and module configuration
	* Note : This setup is important to create module
	*/
	public function __construct($config){
		$this->config 	= $config;
		$this->module 	= $config['modules'][$config['active_module']];
	}

	/*
	* List of callback registered for loader hook
	*/
	public function callback(){
		return array(
			[
				'hook' 		=> 'triangle_column',
				'callback' 	=> 'triangle_column',
				'priority' 	=> 1, 
				'args' 		=> 2
			],
			[
				'hook' 		=> 'triangle_row',
				'callback' 	=> 'triangle_row',
				'priority' 	=> 2, 
				'args' 		=> 2
			],
			[
				'hook' 		=> 'triangle_section',
				'callback' 	=> 'triangle_section',
				'priority' 	=> 3, 
				'args' 		=> 2
			],
			[
				'hook' 		=> 'triangle_gravity',
				'callback' 	=> 'triangle_gravity',
				'priority' 	=> 4, 
				'args' 		=> 2
			],
			[
				'hook' 		=> 'triangle_title',
				'callback' 	=> 'triangle_title',
				'priority' 	=> 5, 
				'args' 		=> 2
			],
			[
				'hook' 		=> 'triangle_function',
				'callback' 	=> 'triangle_function',
				'priority' 	=> 6, 
				'args' 		=> 2
			],
			[
				'hook' 		=> 'triangle_media',
				'callback' 	=> 'triangle_media',
				'priority' 	=> 7, 
				'args' 		=> 2
			],
			[
				'hook' 		=> 'triangle_pet',
				'callback' 	=> 'triangle_pet',
				'priority' 	=> 8, 
				'args' 		=> 2
			],
		);
	}

	/* 
	* 	Function Hook
	*/
	public function triangle_gravity($atts, $content = null){
		$atts = shortcode_atts([
			'request'		=> 'gravity',
			'action'		=> 'notify',
			'title'			=> '',
			'logo'			=> '', 
			'address'		=> '',
			'contact'		=> '',
			'follow'		=> '',
			'unsubscribe'	=> home_url(),
			'template' 		=> 'default'
		], $atts, 'triangle_gravity' );
		ob_start();
			require $this->get_element($atts['template'].'/index.php');
			$template = do_shortcode(ob_get_contents());
		ob_get_clean();
		$style = file_get_contents($this->get_element($atts['template'].'/style.css'));
		// return $template;
		$emogrifier = new Emogrifier($template, $style);
		return $emogrifier->emogrify();
	}

	/* 
	* 	Function Hook
	*/
	public function triangle_section($atts, $content = null){
		$atts = shortcode_atts([
			'request'	=> 'default',
			'action' 	=> 'default',
			'margin'	=> '-10px',
			'template'	=> 'default' 
		], $atts, 'triangle_section' );
		ob_start();
			require $this->get_element($atts['template'].'/section.php');
			$part = do_shortcode(ob_get_contents());
		ob_get_clean();
		return $part;
	}

	/* 
	* 	Function Hook
	*/
	public function triangle_row($atts, $content = null){
		$atts = shortcode_atts([
			'request'	=> 'default',
			'action' 	=> 'default',
			'template'	=> 'default' 
		], $atts, 'triangle_row' );
		ob_start();
			require $this->get_element($atts['template'].'/row.php');
			$part = do_shortcode(ob_get_contents());
		ob_get_clean();
		return $part;
	}

	/* 
	* 	Function Hook
	*/
	public function triangle_column($atts, $content = null){
		$atts = shortcode_atts([
			'request'	=> 'default',
			'action' 	=> 'default',
			'title'		=> '',
			'size'		=> '1',
			'align'		=> 'left',
			'template'	=> 'default' 
		], $atts, 'triangle_column' );
		ob_start();
			require $this->get_element($atts['template'].'/column.php');
			$part = do_shortcode(ob_get_contents());
		ob_get_clean();
		return $part;
	}

	/* 
	* 	Function Hook
	*/
	public function triangle_title($atts, $content = null){
		$atts = shortcode_atts([
			'request'	=> 'default',
			'action' 	=> 'default',
			'align'		=> 'left',
			'template'	=> 'default' 
		], $atts, 'triangle_column' );
		ob_start();
			require $this->get_element($atts['template'].'/title.php');
			$part = do_shortcode(ob_get_contents());
		ob_get_clean();
		return $part;
	}

	/* 
	* 	Function Hook
	*/
	public function triangle_function($atts, $content = null){
		$request = shortcode_atts([
			'request'	=> 'default',
			'action' 	=> 'default',
			'template'	=> 'default' 
		], $atts, 'triangle_function' );
		if('user'==$request['request'] && ''!=$atts['userid']){
			if('address'==$atts['action'])
				return get_field('billing_address_1','user_'.$atts['userid']);
			elseif('phone'==$atts['action'])
				return get_field('billing_phone','user_'.$atts['userid']);
			else
				return get_userdata($atts['userid'])->{$atts['action']};
		} elseif('service'==$request['request']){
			if('title'==$atts['action']){
				return get_post($atts['postid'])->post_title;
			}
		} elseif('booking'==$request['request']){
			if('title'==$atts['action']){
				return get_post($atts['postid'])->post_title;
			} elseif('status'==$atts['action']){
				return ucwords(get_field('booking_status',$atts['postid']));
			} elseif('start'==$atts['action']){
				return get_field('booking_start',$atts['postid']); 
			} elseif('end'==$atts['action']){
				return get_field('booking_end',$atts['postid']); 
			} elseif('checkin'==$atts['action']){
				return get_field('booking_in',$atts['postid']); 
			} elseif('checkout'==$atts['action']){
				return get_field('booking_out',$atts['postid']); 
			} elseif('referral'==$atts['action']){
				return get_field('booking_referral',$atts['postid']); 
			} elseif('junglegym'==$atts['action']){
				$jungle_gym = get_field('booking_jungle_gym_daily',$atts['postid']); 
				if($jungle_gym) return 'Yes'; else return 'No';
			} elseif('junglegymeod'==$atts['action']){
				$jungle_gym = get_field('booking_jungle_gym_every_other_day',$atts['postid']); 
				if($jungle_gym) return 'Yes'; else return 'No';
			} elseif('breeds'==$atts['action']){
				return preg_replace("/[^A-Za-z0-9]/", "", $atts['breeds']);
			}
		} elseif('deducted'==$request['request']){
			return date('d.m.Y', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y')));
		}
	}

	/* 
	* 	Function Hook
	*/
	public function triangle_media($atts, $content = null){
		$atts = shortcode_atts([
			'request'	=> 'default',
			'action' 	=> 'default',
			'src'		=> '',
			'url'		=> '#',
			'style'		=> '', 
			'template'	=> 'default' 
		], $atts, 'triangle_media' );
		if('image'==$atts['request']){
			ob_start();
				require $this->get_element($atts['template'].'/media-image.php');
			return do_shortcode(ob_get_clean());
		} elseif('pdf'==$atts['request']){
			ob_start();
				require $this->get_element($atts['template'].'/media-pdf.php');
			return do_shortcode(ob_get_clean());
		} 
	}

	/*
	* Hide unused pets
	*/
	public function triangle_pet($atts, $content = null){
		$atts = shortcode_atts([
			'request'	=> 'default',
			'action' 	=> 'default',
			'pet'		=> 0,
			'info'		=> 0,
			'style'		=> '', 
			'template'	=> 'default' 
		], $atts, 'triangle_pet' );
		$atts['pet'] += 1;
		if($atts['info']<=$atts['pet']){
			ob_start();
				echo $content;
			return do_shortcode(ob_get_clean());	
		}
	}

}