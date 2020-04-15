<?php

namespace Triangle\Controller;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\Includes\View;
use Triangle\Includes\Wordpress\Action;

class BackendController extends BaseController {

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
        $action->setCallback('backend_users_index');
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
        if(TRIANGLE_STAGE){
            wp_enqueue_style('triangle_css', $path . 'css/style.min.css');
            wp_enqueue_script('triangle_js', $path . 'js/script.min.js');
        } else {
            wp_enqueue_style('triangle_css', $path . 'scss/style.css');
            wp_enqueue_script('triangle_admin_js', $path . 'js/backend/admin.js');
        }
    }

    /**
     * Add setting link in plugin page
     * @backend
     * @return  void
     * @var     array   $links     Plugin links
     */
    public function backend_plugin_setting_link($links){
        $links[] = '<a href="options-general.php?page=' . strtolower(TRIANGLE_NAME) . '-setting">Settings</a>';
        return $links;
    }

    /**
     * Setup scripts and modals
     * @backend - @userPage
     * @return  void
     */
    public function backend_users_index(){
        /** Load Assets */
        $path = unserialize(TRIANGLE_PATH);
        $path = $path['plugin_url'] . 'assets/';
        $screen = get_current_screen();
        if($screen->base=='users') wp_enqueue_script('triangle_user_js', $path . 'js/backend/user.js');
    }

}