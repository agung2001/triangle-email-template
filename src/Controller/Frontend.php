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

class Frontend extends Base {

    /**
     * Frontend constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);

        /** @backend - Eneque scripts */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('wp_head');
        $action->setCallback('frontend_enequeue');
        $action->setAcceptedArgs(0);
        $this->hooks[] = $action;
    }

    /**
     * Eneque scripts @frontend
     * @return  void
     * @var     array   $hook_suffix     The current admin page
     */
    public function frontend_enequeue(){
        define('TRIANGLE_SCREEN', serialize( $this->Service->Page->getScreen() ));
//        $this->loadModel('EmailTemplate');
//        $screens = ['toplevel_page_triangle','triangle_page_triangle-setting'];
//        $this->backend_load_plugin_assets();
//        $types = [$this->EmailTemplate->getName()];
//        $this->frontend_load_plugin_libraries([], $types);
//        $this->backend_load_plugin_scripts();
    }

    /**
     * @frontend - Load plugin assets
     * @return  void
     */
    private function frontend_load_plugin_assets(){
        /** Plugin configuration */
        $view = new View($this->Plugin);
        $view->setTemplate('backend.blank');
        $view->setSections(['Backend.script' => []]);
        $view->setOptions(['shortcode' => false]);
        $view->addData(['screen' => unserialize(TRIANGLE_SCREEN)]);
        $view->addData(['options' => [
            'animation_tab' => $this->Service->Option->get_option('triangle_animation_tab'),
            'animation_content' => $this->Service->Option->get_option('triangle_animation_content'),
        ]]);
        $view->build();
        /** Styles and Scripts */
        $min = (TRIANGLE_PRODUCTION) ? '.min' : '';
        $this->Service->Asset->wp_enqueue_style('triangle_css', "style$min.css" );
        $this->Service->Asset->wp_enqueue_script('triangle_js_footer', "backend/plugin$min.js",'', '', true);
    }

    /**
     * @frontend - Load plugin scripts in a page
     * @return  void
     */
    private function frontend_load_plugin_scripts(){
        $screen = unserialize(TRIANGLE_SCREEN);
        if($screen->base=='users') $this->Service->Asset->wp_enqueue_script('triangle_user_js', 'backend/user.js');
        if($screen->base=='toplevel_page_triangle') $this->Service->Asset->wp_enqueue_script('triangle_contact_js', 'backend/contact/contact.js', '', '', true);
        if($screen->base=='triangle_page_triangle-setting') $this->Service->Asset->wp_enqueue_script('triangle_setting_js', 'backend/setting.js', '', '', true);
    }

}