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
use Triangle\Wordpress\Service;

class Backend extends Base {

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);

        /** @backend - Eneque scripts */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('admin_enqueue_scripts');
        $action->setCallback('backend_enequeue');
        $action->setAcceptedArgs(1);
        $this->hooks[] = $action;

        /** @backend - Add setting link for plugin in plugins page */
        $pluginName = strtolower($plugin->getName());
        $action = clone $action;
        $action->setHook("plugin_action_links_$pluginName/$pluginName.php");
        $action->setCallback('backend_plugin_setting_link');
        $this->hooks[] = $action;
    }

    /**
     * Eneque scripts @backend
     * @return  void
     * @var     array   $hook_suffix     The current admin page
     */
    public function backend_enequeue($hook_suffix){
        define('TRIANGLE_SCREEN', serialize(Service::getScreen()));
        $screens = ['toplevel_page_triangle','triangle_page_triangle-contact'];
        $this->backend_load_plugin_assets();
        $this->backend_load_plugin_libraries($screens);
        $this->backend_load_plugin_scripts();
    }

    /**
     * @backend - Load plugin assets
     * @return  void
     */
    private function backend_load_plugin_assets(){
        /** Styles and Scripts */
        $style = (TRIANGLE_PRODUCTION) ? 'style.min.css' : 'style.css';
        Service::wp_enqueue_style('triangle_css', $style );
        Service::wp_enqueue_script('triangle_js_footer', 'backend/plugin_footer.js', '', '', true);

        /** Plugin configuration */
        $view = new View();
        $view->setTemplate('blank');
        $view->setView('Backend.script');
        $view->setOptions(['shortcode' => false]);
        $view->build();
    }

    /**
     * @backend - Load plugin scripts in a page
     * @return  void
     */
    private function backend_load_plugin_scripts(){
        $screen = unserialize(TRIANGLE_SCREEN);
        if($screen->base=='users') Service::wp_enqueue_script('triangle_user_js', 'backend/user.js');
        if($screen->base=='triangle_page_triangle-contact') Service::wp_enqueue_script('triangle_contact_js', 'backend/contact.js');
    }

    /**
     * Add setting link in plugin page
     * @backend
     * @return  void
     * @var     array   $links     Plugin links
     */
    public function backend_plugin_setting_link($links){
        return array_merge($links, ['<a href="options-general.php?page=' . strtolower(TRIANGLE_NAME). '">Settings</a>']);
    }

}