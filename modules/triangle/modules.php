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

namespace Triangle\Includes\Triangle;

use Triangle\Includes\Cores;

class Modules extends Cores {

    /** 
     * Get plugin active theme
     * @access  public
     * @return  activeTheme
    */
    public function get_active_theme(){
        if(get_option('triangle_theme')) return get_option('triangle_theme');
        else return $this->config['modules']['triangle']['theme'];
    }

    /** 
     * Get theme element [header,footer,etc]
     * @access  public
     * @return  themeElement
    */
    public function get_theme_element($theme,$element){
        return file_get_contents( $this->get_module('triangle',"themes/$theme/$element.php") );
    }

    /** 
     * Send test mail
     * @access  public
    */
    public function test_mail($sendto){
        $theme = $this->get_active_theme();
        $title = 'Triangle Test Mail';
        $content = "<p style='text-align:center;'>Thank you for using triangle plugin, you're rock!</p>";
		ob_start();
            require $this->get_module('triangle',"themes/$theme/template.php");
		$body = do_shortcode(ob_get_clean());
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$headers[] = "From: ".get_bloginfo('name')." <".get_bloginfo('admin_email').">";
		return wp_mail( $sendto, $title, $body, $headers );
	}
	
}