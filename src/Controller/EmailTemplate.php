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
use Triangle\Wordpress\Shortcode;
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
        $action = clone $action;
        $action->setHook('edit_form_after_title');
        $action->setCallback('edit_emailtemplate');
        $action->setAcceptedArgs(0);
        $this->hooks[] = $action;

        /** @backend @emailTemplate - Setup editor script */
        $shortcode = new Shortcode();
        $shortcode->setComponent($this);
        $shortcode->setHook('triangle_send');
        $shortcode->setCallback('shortcode_send');
        $shortcode->setAcceptedArgs(2);
        $this->hooks[] = $shortcode;
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
            if($screen->pagenow=='post.php' || $screen->pagenow=='post-new.php'){
                Service::wp_enqueue_script('triangle_emailtemplate_js', 'backend/emailtemplate/edit.js', [], false, true);
                Service::wp_enqueue_script('juice_js', 'backend/juice.build.js', [], false, true);
            }
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
            $view = new View();
            $view->setTemplate('box');
            $view->setOptions(['shortcode' => false]);
            $view->addData([
                'screen'        => $screen,
                'background'    => 'bg-wetasphalt',
                'options'       => [
                    'triangle_builder_inliner' => Service::get_option('triangle_builder_inliner')
                ],
            ]);
            $view->setSections([
                'EmailTemplate.edit-codeeditor' => ['name' => 'Code editor', 'active' => true],
                'EmailTemplate.edit-preview' => ['name' => 'Preview'],
            ]);
            $view->build();
        }
    }

    /**
     * Send template email
     * @backend - @emailtemplate from [@contactPage]
     * @return  void
     */
    public function shortcode_send($atts, $content = null){
        /** Validate attributes */
        $default = ['field_template', 'field_users', 'field_from_name', 'field_from_email', 'field_email_subject'];
        if(!$this->validateParams($atts, $default)) { echo ('Parameters did not match the specs!'); return; }

        /** Prepare Data */
        $this->loadModel('EmailTemplate');
        $this->EmailTemplate->setID($atts['field_template']);
        $this->EmailTemplate->getMetas()['template_standard']->setSingle(true);
        $template = $this->EmailTemplate->getMetas()['template_standard']->get_post_meta();
        $template = isset($template) ? $template : '';
        $users = explode(',',$atts['field_users']);
        foreach($users as &$user) $user = User::get_user_by('ID', $user)->data->user_email;

        /** Send Email */
        $email = new Email();
        $headers = $email->getHeaders();
        $headers[] = 'From: '.$atts['field_from_name'].' <'.$atts['field_from_email'].'> ';
        $email->setHeaders($headers);
        $email->setTo($users);
        $email->setSubject($atts['field_email_subject']);
        $email->setMessage($template);
        $status = $email->send();

        /** Show status */
        ob_start();
            $view = new View();
            $view->setTemplate('blank');
            $view->addData([
                'status' => ($status) ? 'Email send successfully!' : 'Email failed to send, please turn off conflicting plugin and try again!',
            ]);
            $view->setSections(['Backend.contact.send-status' => ['name' => 'Send Notification']]);
            $view->build();
        echo ob_get_clean();
    }

}