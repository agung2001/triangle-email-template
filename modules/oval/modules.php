<?php

/**
 * @link       https://www.applebydesign.com.au
 * @since      0.1
 *
 * @package    Appleby
 * @subpackage Appleby/includes
 */

namespace Triangle\Includes\Oval;

use Triangle\Includes\Cores;

class Modules extends Cores {

	/*
	* Mail Routes
	* - enquiries@divinecreatures.com.au
	* - muhagung2001@gmail.com
	*/
	public function triangle_mailer($to,$subject,$content, $attachments = array()){
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$headers[] = 'From: Enquiries <enquiries@divinecreatures.com.au>';
		//Option Config
		$mode = get_option('triangle_setting_stage');
		$extras = get_option('triangle_setting_extras');
		//Mail setup
		if($mode=='live') 
			wp_mail( $to, $subject, $content, $headers, $attachments );
		foreach(explode(',',$extras) AS $email){
			wp_mail( $email, $subject, $content, $headers, $attachments );
		}
	}

}
