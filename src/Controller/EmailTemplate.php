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
use Triangle\Wordpress\Email;
use Triangle\Wordpress\Service;
use Triangle\Wordpress\User;

class EmailTemplate extends Base {

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);
        $this->loadModel('EmailTemplate');

        /** @backend - Eneque scripts */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('admin_enqueue_scripts');
        $action->setCallback('backend_enequeue');
        $action->setAcceptedArgs(1);
        $this->hooks[] = $action;

        /** @backend @emailTemplate - Setup editor script */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('edit_form_after_title');
        $action->setCallback('edit_emailtemplate');
        $action->setAcceptedArgs(0);
        $this->hooks[] = $action;
    }

    /**
     * Eneque scripts @backend
     * @return  void
     * @var     array   $hook_suffix     The current admin page
     */
    public function backend_enequeue($hook_suffix){
        $screen = Service::getScreen();
        $this->backend_load_plugin_libraries([],[$this->EmailTemplate->getName()]);
        if(isset($screen->post->post_type) && $screen->post->post_type==$this->EmailTemplate->getName()) {
            Service::wp_enqueue_style('triangle_emailtemplate_css', 'backend/emailtemplate.css');
            Service::wp_enqueue_script('triangle_emailtemplate_js', 'backend/emailtemplate.js', [], false, true);
        }
    }

    /**
     * Setup scripts and metabox
     * @backend - @emailtemplate
     * @return  void
     */
    public function edit_emailtemplate(){
        $screen = Service::getScreen();
        if(isset($screen->post->post_type) && $screen->post->post_type==$this->EmailTemplate->getName()){
            /** Emailtemplate Code Editor */
            $view = new View();
            $view->setTemplate('box');
            $view->setSections(['EmailTemplate.edit-codeeditor' => ['name' => 'Code editor', 'active' => true]]);
            $view->setOptions(['shortcode' => false]);
            $view->addData(compact('screen'));
            $view->addData(['background' => 'bg-wetasphalt']);
            $view->addData(['nav' => 'EmailTemplate.edit-nav']);
            $view->build();
        }
    }

    /**
     * Send template email
     * @backend - @emailtemplate from [@contactPage]
     * @return  void
     */
    public function send($params){
        /** Validate Params */
        $default = ['field_template', 'field_users', 'field_from_name', 'field_from_email', 'field_email_subject'];
        if($this->validateParams($_POST, $default)) die('Parameters is not match the specs!');

        /** Prepare Data */
        $this->loadModel('EmailTemplate');
        $template = $this->EmailTemplate::get_post($params['field_template']);
        $template = $this->Helper->getStandardEmailTemplate($template->post_name);
        $users = explode(',',$params['field_users']);
        foreach($users as &$user) $user = User::get_user_by('ID', $user)->data->user_email;

        /** Send Email */
        $email = new Email();
        $headers = $email->getHeaders();
        $headers[] = 'From: '.$params['field_from_name'].' <'.$params['field_from_email'].'> ';
        $email->setHeaders($headers);
        $email->setTo($users);
        $email->setSubject($params['field_email_subject']);
        $email->setMessage($template);
        return $email->send();
    }

}