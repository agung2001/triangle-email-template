<?php

namespace Triangle\Api;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\Wordpress\Action;
use Triangle\Wordpress\User;

class EmailTemplate extends Api {

    /**
     * User API constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);

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
    }

    /**
     * Get data for Contact page
     * @backend
     * @return  void
     */
    public function page_contact(){
        /** Validate Params */
        $default = ['typeArgs', 'userArgs'];
        if($this->validateParams($_POST, $default)) die('Parameters didnt match the specs!');
        /** Load Data */
        $this->loadModel('EmailTemplate');
        $data = array();
        /** Get Template Data */
        $this->EmailTemplate->setArgs($_POST['typeArgs']);
        $data['templates'] = $this->EmailTemplate->get_posts();
        foreach($data['templates'] as $index => $template){
            if(!$this->get_rendered_src_url($template->post_name))
                unset($data['templates'][$index]);
        }
        /** Get User Data */
        $user = new User();
        $user->setArgs($_POST['userArgs']);
        $data['users'] = $user->get_users();
        $data['currentUser'] = $user->get_current_user();
        wp_send_json($data);
    }

    /**
     * Get data for EmailTemplate page
     * @backend
     * @return  void
     */
    public function page_edit(){
        /** Validate Params */
        $default = ['args' => ['post_id', 'post_name']];
        if($this->validateParams($_POST, $default)) die('Parameters didnt match the specs!');
        /** Load Data */
        $data = array();
        $data['rendered'] = $this->get_rendered_src_url($_POST['args']['post_name']);
        $data['templates'] = $this->get_template_elements_value($_POST['args']['post_id']);
        wp_send_json((object) $data);
    }

    /**
     * Get rendered email template src url : standard.html
     * @page_edit
     * @var         string      Post name slug
     * @return      string      Url where the rendered file located
     */
    private function get_rendered_src_url($slug){
        $path = unserialize(TRIANGLE_PATH)['upload_dir'];
        $path = [
            'basedir' => $path['basedir'] . '/EmailTemplate/' . $slug . '/standard.html',
            'baseurl' => $path['baseurl'] . '/EmailTemplate/' . $slug . '/standard.html'
        ];
        return (file_exists($path['basedir'])) ? $path['baseurl'] : false;
    }

    /**
     * Get EmailTemplate configuration and meta_fields data
     * @var         int         Post ID
     * @return      array       Configurations and meta_fields value
     */
    private function get_template_elements_value($postID){
        $this->loadModel('EmailTemplate');
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