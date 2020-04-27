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
            if($screen->pagenow=='post.php' || $screen->pagenow=='post-new.php'){
                Service::wp_enqueue_script('triangle_emailtemplate_js', 'backend/emailtemplate/edit.js', [], false, true);
                if(Service::get_option('triangle_builder_inliner')=='juice') Service::wp_enqueue_script('juice_js', 'backend/juice.build.js', [], false, true);
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
            $option_builder_inliner = Service::get_option('triangle_builder_inliner');

            /** Configure Sections */
            $sections = ['EmailTemplate.edit-codeeditor' => ['name' => 'Code editor', 'active' => true]];
            if($option_builder_inliner=='juice') $sections['EmailTemplate.edit-preview'] = ['name' => 'Preview'];

            /** Emailtemplate Code Editor */
            $view = new View();
            $view->setTemplate('box');
            $view->setSections($sections);
            $view->setOptions(['shortcode' => false]);
            $view->addData(compact('screen'));
            $view->addData([
                /** Section Options */
                'background' => 'bg-wetasphalt',
                'nav' => 'EmailTemplate.edit-nav',
                /** Setting Options */
                'options' => [ 'triangle_builder_inliner' => $option_builder_inliner ],
            ]);
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

    /**
     * Build Email Template, write html and css file into /EmailTemplate dir
     * @var     string  $slug   EmailTemplate slug = post name slug
     * @var     string  $html   Html content template
     * @var     string  $css    CSS content template
     * @return  void
     */
    public function buildEmailTemplate($slug, $html, $css) {
        $path = unserialize(TRIANGLE_PATH);
        $dir = $path['upload_dir']['basedir'] . '/EmailTemplate/' . $slug;
        if(!is_dir($dir)) mkdir($dir, 0755, true);
        if($html) file_put_contents($dir . '/' . $slug . '.html', stripslashes($html));
        if($css) file_put_contents($dir . '/' . $slug . '.css', stripslashes($css));
        if(file_exists($dir . '/standard.html')) unlink($dir . '/standard.html');
    }

    /**
     * Standardize Email Template - InlineCSS
     * @var     string  $slug   EmailTemplate slug = post name slug
     */
    public function standardizeEmailTemplate($slug){
        $path = unserialize(TRIANGLE_PATH);
        $dir = $path['upload_dir']['basedir'] . '/EmailTemplate/' . $slug;
        if(is_dir($dir)){
            /** Get Contents */
            ob_start();
                echo file_get_contents($dir . '/' . $slug . '.html');
            $html = Service::do_shortcode(ob_get_clean());
            $css = file_get_contents($dir . '/' . $slug . '.css');
            file_put_contents($dir . '/standard.html', $html);
        } else return false;
    }

}