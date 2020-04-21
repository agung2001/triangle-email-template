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
use Triangle\Wordpress\MetaBox;
use Triangle\Wordpress\Service;

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
            /** Plugin script */
            $view = new View();
            $view->setTemplate('blank');
            $view->setView('EmailTemplate.edit-action');
            $view->setOptions(['shortcode' => false]);
            $view->build();

            /** Add custom meta box */
            $metabox = new MetaBox();
            $metabox->setId($this->EmailTemplate->getName() . '-editor');
            $metabox->setTitle('Template Editor');
            $metabox->setCallback([$this, 'metabox_emailtemplate_editor']);
            $metabox->setScreen($this->EmailTemplate->getName());
            $metabox->add_meta_box();
        }
    }

    /**
     * Metabox callback - @emailtemplate-editor
     * @backend - @emailtemplate
     * @return  void
     */
    public function metabox_emailtemplate_editor(){
        $screen = Service::getScreen();
        if(isset($screen->post->post_type) && $screen->post->post_type==$this->EmailTemplate->getName()){
            $view = new View();
            $view->setTemplate('blank');
            $view->setView('EmailTemplate.edit-template_editor');
            $view->setOptions(['shortcode' => false]);
            $view->build();
        }
    }

}