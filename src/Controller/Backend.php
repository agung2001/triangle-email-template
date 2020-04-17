<?php

namespace Triangle\Controller;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\View;
use Triangle\Wordpress\Action;

class Backend extends Controller {

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
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
        /** @backend @userPage - Setup scripts and modals */
        $action = clone $action;
        $action->setHook('admin_head');
        $action->setCallback('admin_page_script');
        $action->setAcceptedArgs(0);
        $action->setPriority(1);
        $this->hooks[] = $action;
    }

    /**
     * Eneque scripts in a backend
     * @backend
     * @return  void
     * @var     array   $hook     The current admin page.
     * @reference : http://www.shrinker.ch/
     */
    public function backend_enequeue($hook){
        $path = unserialize(TRIANGLE_PATH);
        $path = $path['plugin_url'] . 'assets/';
        $style = (TRIANGLE_STAGE) ? 'css/style.css' : 'css/style.min.css';
        // Plugins
        wp_enqueue_style('triangle_css', $path . $style);
        wp_enqueue_script('triangle_js', $path . 'js/plugin.js');
        // Assets
        wp_enqueue_style('select2_css', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css');
        wp_enqueue_script('select2_js', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js');
    }

    /**
     * Add setting link in plugin page
     * @backend
     * @return  void
     * @var     array   $links     Plugin links
     */
    public function backend_plugin_setting_link($links){
        $links[] = '<a href="options-general.php?page=' . strtolower(TRIANGLE_NAME). '">Settings</a>';
        return $links;
    }

    /**
     * Setup scripts and modals
     * @backend - @userPage
     * @return  void
     */
    public function admin_page_script(){
        /** Load Assets */
        $path = unserialize(TRIANGLE_PATH);
        $path = $path['plugin_url'] . 'assets/';
        $screen = get_current_screen();
        // Plugin Script
        $view = new View();
        $view->setTemplate('blank');
        $view->setView('backend.script');
        $view->setOptions(['shortcode' => false]);
        $view->build();
        if($screen->base=='users') wp_enqueue_script('triangle_user_js', $path . 'js/backend/user.js');
        if($screen->base=='triangle_page_triangle-contact') wp_enqueue_script('triangle_contact_js', $path . 'js/backend/contact.js');
    }

}