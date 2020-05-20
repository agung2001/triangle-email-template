<?php

namespace Triangle\Api;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\View;
use Triangle\Wordpress\Email;
use Triangle\Wordpress\Hook\Action;

class EmailTemplate extends Api {

    /**
     * User API constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);
        $this->loadModel('EmailTemplate');

        /** @backend - API - Page Contact */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('wp_ajax_triangle-emailtemplate-page-contact');
        $action->setCallback('page_contact');
        $action->setAcceptedArgs(0);
        $this->hooks[] = $action;

        /** @backend - API - Page Contact */
        $action = clone $action;
        $action->setHook('wp_ajax_triangle-emailtemplate-page-edit');
        $action->setCallback('page_edit');
        $this->hooks[] = $action;

        /** @backend - API - Editor Grid Setting */
        $action = clone $action;
        $action->setHook('wp_ajax_triangle-editor-row-setting');
        $action->setCallback('editor_row_setting');
        $this->hooks[] = $action;

        /** @backend - API - Editor Grid Setting */
        $action = clone $action;
        $action->setHook('wp_ajax_triangle-editor-element-setting');
        $action->setCallback('editor_element_setting');
        $this->hooks[] = $action;

        /** @backend - API - Page Contact */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('wp_ajax_triangle-emailtemplate-send');
        $action->setCallback('send_email');
        $action->setAcceptedArgs(0);
        $this->hooks[] = $action;
    }

    /**
     * Get data for Contact page
     * @backend
     * @return  void
     */
    public function page_contact(){
        /** Validate Params */
        $default = ['typeArgs', 'userArgs'];
        if(!$this->validateParams($_POST, $default)) die('Parameters did not match the specs!');

        /** Get Template Data */
        $data = array();
        $this->EmailTemplate->setArgs($_POST['typeArgs']);
        $data['templates'] = [];
        foreach($this->EmailTemplate->get_posts() as $template){
            $this->EmailTemplate->setID($template->ID);
            $meta = $this->EmailTemplate->getMetas()['template_standard']->get_post_meta();
            if($meta) $data['templates'][] = $template;
        }

        /** Get User Data */;
        $data['users'] = $this->Service->User->get_users($_POST['userArgs']);
        $data['currentUser'] = $this->Service->User->get_current_user();
        $data['defaultUser'] = $this->Service->User->get_user_by('ID',$_POST['user_id']);
        /** Get default user */
        $this->Service->API->wp_send_json($data);
    }

    /**
     * Get data for EmailTemplate page
     * @backend
     * @return  void
     */
    public function page_edit(){
        /** Validate Params */
        $default = ['args' => ['post_id', 'post_name']];
        if(!$this->validateParams($_POST, $default)) die('Parameters did not match the specs!');

        /** Load Data */
        $data = array();
        $this->EmailTemplate->setID($_POST['args']['post_id']);
        $data['templates'] = $this->get_template_elements_value($_POST['args']['post_id']);
        $data['options'] = ['inliner' => $this->Service->Option->get_option('triangle_builder_inliner')];
        $this->Service->API->wp_send_json((object) $data);
    }

    /**
     * Ajax - Load editor row setting
     * @backend
     * @return  void
     */
    public function editor_row_setting(){
        /** Load Page */
        ob_start();
        $view = new View($this->Plugin);
        $view->setTemplate('backend.jconfirm');
        $view->setOptions(['shortcode' => false]);
        $view->addData([
            'background'    => 'bg-amethyst',
        ]);
        $view->setSections([
            'EmailTemplate.element.row-setting' => ['name' => 'Setting', 'active' => true],
        ]);
        $view->build();
        $content = ob_get_clean();
        echo $content; exit;
    }

    /**
     * Ajax - Load editor element setting
     * @backend
     * @return  void
     */
    public function editor_element_setting(){
        /** Validate Params */
        $default = ['column'];
        if(!$this->validateParams($_POST, $default)) die('Parameters did not match the specs!');
        /** Sanitize Params */
        $default = array_flip($default);
        $default['column'] = 'text';
        $params = $this->sanitizeParams($_POST, $default);

        /** Load Page */
        ob_start();
            $view = new View($this->Plugin);
            $view->setTemplate('backend.jconfirm');
            $view->setOptions(['shortcode' => false]);
            $view->addData([
                'background'    => 'bg-amethyst',
                'column'        => $params['column'],
            ]);
            $view->setSections([
                'EmailTemplate.element.element-editor' => ['name' => 'Editor', 'active' => true],
                'EmailTemplate.element.element-setting' => ['name' => 'Setting'],
            ]);
            $view->build();
        $content = ob_get_clean();
        echo $content; exit;
    }

    /**
     * Get EmailTemplate configuration and meta_fields data
     * @var         int         Post ID
     * @return      array       Configurations and meta_fields value
     */
    public function send_email(){
        /** Validate attributes */
        $default = ['template', 'users', 'from' => ['name', 'email'], 'subject'];
        if(!$this->validateParams($_POST, $default)) die('Parameters did not match the specs!');

        /** Sanitize Params */
        $default = ['name' => 'text','email' => 'text'];
        $params = $this->sanitizeParams($_POST['from'], $default);
        $params = array('from' => $params);
        $default = ['template' => 'html', 'users' => 'text', 'subject' => 'text'];
        $params = array_merge($params, $this->sanitizeParams($_POST, $default));

        /** Prepare Data */
        $users = explode(',',$params['users']);
        foreach($users as &$user) $user = $this->Service->User->get_user_by('ID', $user)->data->user_email;
        $params['template'] = str_replace('\"','"', $params['template']);

        /** Send Email */
        $email = new Email();
        $headers = $email->getHeaders();
        $headers[] = 'From: '.$params['from']['name'].' <'.$params['from']['email'].'> ';
        $email->setHeaders($headers);
        $email->setTo($users);
        $email->setSubject($params['subject']);
        $email->setMessage($params['template']);
        $status = $email->send();

        wp_send_json($status);
    }

    /**
     * Get EmailTemplate configuration and meta_fields data
     * @var         int         Post ID
     * @return      array       Configurations and meta_fields value
     */
    private function get_template_elements_value($postID){
        $templates = $this->Plugin->getConfig()->templates;
        $this->EmailTemplate->setID($postID);
        foreach($templates as $template){
            foreach($template->children as &$children){
                $children->value = $children->id;
                $children->value = $this->EmailTemplate->getMetas()["template_" . $children->id];
                $children->value = $children->value->get_post_meta();
            }
        }
        return $templates;
    }

}