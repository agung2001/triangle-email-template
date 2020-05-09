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

        /** @backend - API - Editor Grid Setting */
        $action = clone $action;
        $action->setHook('wp_ajax_triangle-editor-grid-setting');
        $action->setCallback('editor_grid_setting');
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

        /** Load Data */
        $this->loadModel('EmailTemplate');
        $data = array();

        /** Get Template Data */
        $this->EmailTemplate->setArgs($_POST['typeArgs']);
        $data['templates'] = [];
        foreach($this->EmailTemplate->get_posts() as $template){
            $this->EmailTemplate->setID($template->ID);
            $meta = $this->EmailTemplate->getMetas()['template_standard']->get_post_meta();
            if($meta) $data['templates'][] = $template;
        }

        /** Get User Data */;
        $data['users'] = User::get_users($_POST['userArgs']);
        $data['currentUser'] = User::get_current_user();
        $data['defaultUser'] = User::get_user_by('ID',$_POST['user_id']);
        /** Get default user */
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
        if(!$this->validateParams($_POST, $default)) die('Parameters did not match the specs!');

        /** Load Data */
        $this->loadModel('EmailTemplate');
        $data = array();
        $this->EmailTemplate->setID($_POST['args']['post_id']);
        $data['templates'] = $this->get_template_elements_value($_POST['args']['post_id']);
        $data['options'] = ['inliner' => $this->Service->Option->get_option('triangle_builder_inliner')];
        wp_send_json((object) $data);
    }

    /**
     * Get data for EmailTemplate page
     * @backend
     * @return  void
     */
    public function editor_grid_setting(){
        ob_start();
            $view = new View($this->Plugin);
            $view->setTemplate('backend.jconfirm');
            $view->setOptions(['shortcode' => false]);
            $view->addData(['background'    => 'bg-amethyst']);
            $view->setSections([
                'EmailTemplate.element.grid-setting' => ['name' => 'Setting', 'active' => true],
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