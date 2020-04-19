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

class Emailtemplate extends Controller {

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        /** @backend @emailTemplate - Setup editor script */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('edit_form_after_title');
        $action->setCallback('edit_email_template');
        $action->setAcceptedArgs(0);
        $action->setPriority(1);
        $this->hooks[] = $action;
    }

    /**
     * Setup scripts and modals
     * @backend - @emailtemplatePage
     * @return  void
     */
    public function edit_email_template(){
        global $post;
        $type = 'emailtemplate';
        if(isset($post->post_type) && $post->post_type==$type){
            // Plugin Script
            $view = new View();
            $view->setTemplate('blank');
            $view->setView('emailtemplate.edit-action');
            $view->setOptions(['shortcode' => false]);
            $view->build();
            // Add custom meta box
            $metabox = new MetaBox();
            $metabox->setId($type . '-editor');
            $metabox->setTitle('Template Editor');
            $metabox->setCallback([$this, 'metabox_emailtemplate_editor']);
            $metabox->setScreen($type);
            $metabox->add_meta_box();
        }
    }

    /**
     * Metabox callback - @emailtemplate-editor
     * @backend - @emailtemplatePage
     * @return  void
     */
    public function metabox_emailtemplate_editor(){
        global $post;
        $type = 'emailtemplate';
        if(isset($post->post_type) && $post->post_type==$type){
            // Plugin Script
            $view = new View();
            $view->setTemplate('blank');
            $view->setView('element.editor');
            $view->setOptions(['shortcode' => false]);
            $view->build();
        }
    }

}