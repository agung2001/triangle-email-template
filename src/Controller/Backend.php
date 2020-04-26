<?php

namespace Triangle\Controller;

!defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\View;
use Triangle\Wordpress\Action;
use Triangle\Wordpress\Service;

class Backend extends Base {

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);

        /** @backend - Eneque scripts */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('phpmailer_init');
        $action->setCallback('phpmailerConfig');
        $action->setAcceptedArgs(1);
        $this->hooks[] = $action;

        /** @backend - Eneque scripts */
        $action = clone $action;
        $action->setHook('admin_enqueue_scripts');
        $action->setCallback('backend_enequeue');
        $this->hooks[] = $action;

        /** @backend - Add setting link for plugin in plugins page */
        $pluginName = strtolower($plugin->getName());
        $action = clone $action;
        $action->setHook("plugin_action_links_$pluginName/$pluginName.php");
        $action->setCallback('backend_plugin_setting_link');
        $this->hooks[] = $action;
    }

    /**
     * Eneque scripts @backend
     * @return  void
     * @var     array|object   $phpmailer     PHPMailer configuration
     */
    public function phpmailerConfig($phpmailer){
        if(Service::get_option('triangle_smtp')){
            $phpmailer = !is_object($phpmailer) ? (object) $phpmailer : $phpmailer;
            $phpmailer->Mailer     = 'smtp';
            $phpmailer->Host       = Service::get_option('triangle_smtp_host');
            $phpmailer->SMTPAuth   = (Service::get_option('triangle_smtp_auth')) ? true : false;
            $phpmailer->Port       = Service::get_option('triangle_smtp_port');
            $phpmailer->Username   = Service::get_option('triangle_smtp_username');
            $phpmailer->Password   = Service::get_option('triangle_smtp_password');
            if(Service::get_option('triangle_smtp_tls') && Service::get_option('triangle_smtp_tls')!='None'){
                $phpmailer->SMTPSecure = Service::get_option('triangle_smtp_encryption');
            }
        }
    }

    /**
     * Eneque scripts @backend
     * @return  void
     * @var     array   $hook_suffix     The current admin page
     */
    public function backend_enequeue($hook_suffix){
        define('TRIANGLE_SCREEN', serialize(Service::getScreen()));
        $screens = ['toplevel_page_triangle','triangle_page_triangle-setting'];
        $this->backend_load_plugin_assets();
        $this->backend_load_plugin_libraries($screens);
        $this->backend_load_plugin_scripts();
    }

    /**
     * @backend - Load plugin assets
     * @return  void
     */
    private function backend_load_plugin_assets(){
        /** Plugin configuration */
        $view = new View();
        $view->setTemplate('blank');
        $view->setSections(['Backend.script' => []]);
        $view->setOptions(['shortcode' => false]);
        $view->addData(['screen' => $this->Helper->getScreen()]);
        $view->addData(['options' => [
            'animation_tab' => Service::get_option('triangle_animation_tab'),
            'animation_content' => Service::get_option('triangle_animation_content'),
        ]]);
        $view->build();
        /** Styles and Scripts */
        $min = (TRIANGLE_PRODUCTION) ? '.min' : '';
        Service::wp_enqueue_style('triangle_css', "style$min.css" );
        Service::wp_enqueue_script('triangle_js_footer', "backend/plugin$min.js", '', '', true);
    }

    /**
     * @backend - Load plugin scripts in a page
     * @return  void
     */
    private function backend_load_plugin_scripts(){
        $screen = $this->Helper->getScreen();
        if($screen->base=='users') Service::wp_enqueue_script('triangle_user_js', 'backend/user.js');
        if($screen->base=='toplevel_page_triangle') Service::wp_enqueue_script('triangle_contact_js', 'backend/contact.js', '', '', true);
        if($screen->base=='triangle_page_triangle-setting') Service::wp_enqueue_script('triangle_contact_js', 'backend/setting.js', '', '', true);
    }

    /**
     * Add setting link in plugin page
     * @backend
     * @return  array   $links     Combined links with the new added one
     * @var     array   $links     Plugin links
     */
    public function backend_plugin_setting_link($links){
        return array_merge($links, ['<a href="options-general.php?page=' . strtolower(TRIANGLE_NAME). '">Settings</a>']);
    }

    /**
     * Save given options to database
     * @backend - @pageSetting
     * @return  bool
     */
    public function saveSettings($params){
        $options = $params;

        /** Set Default Values for checkbox */
        $checkboxes = [ 'triangle_smtp', 'triangle_smtp_auth', 'triangle_smtp_tls', 'triangle_animation'];
        $checkboxes = array_flip($checkboxes);
        foreach($checkboxes as &$check) $check = false;
        $options = array_merge($checkboxes, $options);

        /** Transform field key to triangle */
        unset($options['field_menu_slug']);
        foreach($options as $key => $value){
            unset($options[$key]);
            $key = str_replace('field_option','triangle',$key);
            $options[$key] = $value;
        }

        /** Save settings */
        foreach($options as $key => $option){
            Service::update_option($key, $option);
        }
        return $options;
    }

}