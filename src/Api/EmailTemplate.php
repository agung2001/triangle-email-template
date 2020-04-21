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

class EmailTemplate extends Api {

    /**
     * User API constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);

        /** @backend - Init API */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('wp_ajax_triangle-emailtemplate-page-edit');
        $action->setCallback('page_edit');
        $action->setAcceptedArgs(0);
        $this->hooks[] = $action;
    }

    /**
     * Get data
     * @backend
     * @return  void
     */
    public function page_edit(){
        $this->loadModel('EmailTemplate');
        if(!isset($_POST['args']['post_id'])) exit;
        $this->EmailTemplate->setID($_POST['args']['post_id']);
        $data = [ 'templates' => $this->Plugin->getConfig()->templates ];
        foreach($data['templates'] as $template){
            foreach($template->children as &$children){
                $children->value = $children->id;
                $children->value = $this->EmailTemplate->getMetas()["template_" . $children->id];
                $children->value = $children->value->get_post_meta();
            }
        }
        wp_send_json((object) $data);
    }

}