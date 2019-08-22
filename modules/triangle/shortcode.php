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

class Shortcode extends Modules {

	private $post;
	private $user;

	/*
	* Mail Informations
	*/
	
	private $terms = WP_CONTENT_DIR . '/uploads/2018/08/Divine-Creatures-Terms-conditions-2018.pdf';

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
				'hook' 		=> 'triangle_booking_add',
				'callback' 	=> 'triangle_booking_add',
				'priority' 	=> 30,
				'args' 		=> 2
			],
			[
				'hook' 		=> 'triangle_oval_notifier',
				'callback' 	=> 'triangle_oval_notifier',
				'priority' 	=> 31,
				'args' 		=> 2
			],
			[
				'hook' 		=> 'triangle_oval_backend_notifier',
				'callback' 	=> 'triangle_oval_backend_notifier',
				'priority' 	=> 32,
				'args' 		=> 2
			],
		);
	}

	/*
	* 	Function Hook
	*/
	public function triangle_booking_add($atts, $content = null){
		ob_start();
			require $this->get_module('triangle','templates/booking_add.php');
		return do_shortcode(ob_get_clean());
	}

	/*
	* 	Function Hook
	* 	Access in front, by Email Notifier page
	*/
	public function triangle_oval_notifier($atts, $content = null){
		if( isset($_GET['b']) && isset($_GET['r']) ){
			$post 				= get_post($_GET['b']);
			$user 				= get_field('booking_user',$post->ID);
			$user 				= !isset($user['ID']) ? (array)get_userdata($user)->data : $user;
			$validate 			= $this->triangle_validator($post,$user);
			$atts['page'] = true;
			if(true!=$validate) return $validate;
			if('notify' == $_GET['r']){
				$atts['page'] = false;
				$this->triangle_oval_resend($atts,$content,$post,$user);
			} elseif('resend' == $_GET['r']){
				$this->triangle_oval_resend($atts,$content,$post,$user);
			} elseif('confirm' == $_GET['r']){
                update_field('booking_status','Confirmed',$post->ID);
				$this->triangle_oval_confirm($atts,$content,$post,$user);
			} elseif('cancel' == $_GET['r']){
                update_field('booking_status','Cancelled',$post->ID);
				$this->triangle_oval_cancel($atts,$content,$post,$user);
			} 
		} 
	}

	/*
	* 	Function Hook
	* 	Access in back, by Staff when update the post
	*/
	public function triangle_oval_backend_notifier($atts, $content = null){
		if( isset($atts['b']) && isset($atts['r'])){
			$atts['page'] = false;
			$post 		= get_post($atts['b']);
			$user 		= get_field('booking_user',$post->ID);
			$user 		= !isset($user['ID']) ? (array)get_userdata($user)->data : $user;
			$validate 	= $this->triangle_validator($post,$user);
			if(true!=$validate) return $validate;
			if('resend'==$atts['r'])
				$this->triangle_oval_resend($atts,$content,$post,$user);
			elseif('confirm' == $atts['r'])
				$this->triangle_oval_confirm($atts,$content,$post,$user);
			elseif('cancel' == $atts['r'])
				$this->triangle_oval_cancel($atts,$content,$post,$user);
		}
	}

	/*
	* Oval
	* Resend customer details informations
	*/
	private function triangle_oval_resend($atts,$content,$post,$user){
		if($atts['page']==true) require $this->get_element('page_loading.php');
		ob_start();
			require $this->get_module('triangle','templates/notify_info.php');
		$content = do_shortcode(ob_get_clean());
		if($this->module['debug']==true)
			$to = $this->module['default'];
		else
			$to = $user['user_email'];
		//Pets
		$pets = get_field('booking_additional_pets',$post->ID);
		$pets = $this->pet_lists($pets,$user['ID']);
		$pets = $this->pet_subject($pets);
		$subject = 'Divine Creatures Pending Booking: '.$post->post_title.$pets;
		$attachments = array($this->terms);
		$this->triangle_mailer($to,$subject,$content,$attachments);
	}

	/*
	* Oval
	* Confirm the payment has been confirmed to the customer
	*/
	private function triangle_oval_confirm($atts,$content,$post,$user){
		if($atts['page']==true && 'notify' != $_GET['r']) 
			require $this->get_element('page_loading.php');
		ob_start();
			require $this->get_module('triangle','templates/notify_payment.php');
		$content = do_shortcode(ob_get_clean());
		if($this->module['debug']==true)
			$to = $this->module['default'];
		else
			$to = $user['user_email'];
		//Pets
		$pets = get_field('booking_additional_pets',$post->ID);
		$pets = $this->pet_lists($pets,$user['ID']);
		$pets = $this->pet_subject($pets);
		$subject = 'Divine Creatures Booking Confirmed: '.$post->post_title.$pets;
		$attachments = array($this->terms,$attachments);
		$this->triangle_mailer($to,$subject,$content);
	}

	/*
	* Oval
	* Cancel the booking
	*/
	private function triangle_oval_cancel($atts,$content,$post,$user){
		if($atts['page']==true) require $this->get_element('page_loading.php');
		ob_start();
			require $this->get_module('triangle','templates/notify_cancel.php');
		$content = do_shortcode(ob_get_clean());
		if($this->module['debug']==true)
			$to = $this->module['default'];
		else
			$to = $user['user_email'];
		//Pets
		$pets = get_field('booking_additional_pets',$post->ID);
		$pets = $this->pet_lists($pets,$user['ID']);
		$pets = $this->pet_subject($pets);
		$subject = 'Divine Creatures Booking Cancelled: '.$post->post_title.$pets;
		$this->triangle_mailer($to,$subject,$content);
	}

	private function pet_lists($pets, $user_id){
		if(!empty($pets)) {
			$pets = explode(',', $pets);
			$lists = array();
			foreach($pets as $pet){
				if(get_post($pet))
					$lists[] = get_post($pet);
				else {
					global $wpdb;
					$sql = "SELECT * FROM pets_backup WHERE ID = $pet LIMIT 1";
					$tmp = $wpdb->get_results($sql);
					if(isset($tmp[0])) {
						$name = $tmp[0]->post_title; 
						$sql = "
							SELECT
								pets.ID AS ID
							FROM
								dc17_posts AS pets
							LEFT JOIN dc17_postmeta AS pet_user ON pet_user.post_id = pets.ID AND pet_user.meta_key = 'pet_user'
							WHERE
								pets.post_title = '{$name}' AND
								pet_user.meta_value = {$user_id} 
							ORDER BY pets.post_date DESC
							LIMIT 1
						";
						$tmp = $wpdb->get_results($sql);
						if(isset($tmp[0])) $lists[] = get_post($tmp[0]->ID);
					}
				}
				$count++;
			}
			return $lists;
		} else {
			$args = array(
				'numberposts'	=> 4,
				'post_type'     => 'pets',
				'meta_key'    	=> 'pet_user',
				'meta_value'  	=> $user_id,
				'orderby'       => 'date',
				'order'         => 'DESC',
			);
			$pets = array();
			foreach(get_posts($args) as $key => $value){
				$pets[$value->post_title] = $value;
			}
			return $pets;
		}
	}

	private function pet_subject($pets){
		$tmp = array();
		if(!empty($pets)){
			foreach($pets as $pet){
				$tmp[] = $pet->post_title;
			}
			$tmp = implode(' ,',$tmp);
			return ' - '.$tmp;
		} else {
			return '';
		}
	}

	private function triangle_validator($post,$user){
		if(empty($this->post)) return 'Post not found, please contact admin!';
		if(empty($this->user)) return 'User not found, please contact admin!';
		return true;
	}

}
