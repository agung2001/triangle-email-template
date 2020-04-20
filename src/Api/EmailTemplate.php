<?php

namespace Triangle\Api;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\Controller\EmailTemplate as EmailTemplateController;

class EmailTemplate extends Api {

    /**
     * User API constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
//        $this->type = $plugin->getModels();
//        $this->type = $this->type['EmailTemplate'];

        /** @backend - Init API */
        $api = parent::__construct($plugin);
        $api->setHook('wp_ajax_triangle-emailtemplate-page-edit');
        $api->setCallback('triangle_emailtemplate_page_edit');
        $this->hooks[] = $api;
    }

    /**
     * API Callback
     * @backend
     * @return  void
     */
    public function callback(){
        $controller = new EmailTemplateController();
        $method = $_POST['method'];
        if(isset($_POST['args'])) $controller->setArgs($_POST['args']);
        if(isset($_POST['method'])) wp_send_json($controller->$method());
    }

    /**
     * Get data
     * @backend
     * @return  void
     */
    public function triangle_emailtemplate_page_edit(){
        $type = $this->plugin->getModels()['EmailTemplate'];
        if(!isset($_POST['args']['post_id'])) exit;
        $type->setID($_POST['args']['post_id']);
        $data = [ 'templates' => $this->plugin->getConfig()->templates ];
        foreach($data['templates'] as $template){
            foreach($template->children as &$children){
                $children->value = $children->id;
                $children->value = $type->getMetas()["template_" . $children->id];
                $children->value = $children->value->get_post_meta();
            }
        }
        wp_send_json((object) $data);
    }

}