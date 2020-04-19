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
    }

    /**
     * Eneque scripts in a backend
     * @backend
     * @return  void
     * @var     array   $hook     The current admin page.
     * @reference : http://www.shrinker.ch/
     */
    public function backend_enequeue($hook){
        global $post;
        $screen = get_current_screen();
        $path = unserialize(TRIANGLE_PATH)['plugin_url'] . 'assets/';
        $style = (TRIANGLE_STAGE) ? 'css/style.css' : 'css/style.min.css';
        // Plugin
        wp_enqueue_style('triangle_css', $path . $style);
        wp_enqueue_script('triangle_js', $path . 'js/plugin.js');
        $view = new View();
        $view->setTemplate('blank');
        $view->setView('backend.script');
        $view->setOptions(['shortcode' => false]);
        $view->build();
        // Assets
        $screens = ['triangle_page_triangle-contact']; $types = ['emailtemplate'];
        if(in_array($screen->base,$screens) || (isset($post->post_type) && in_array($post->post_type,$types)) ){
            // jQuery Select2
            wp_enqueue_style('select2_css', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css');
            wp_enqueue_script('select2_js', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js');
            // Ace Js
            wp_enqueue_script('acejs_emmet_core', 'https://cloud9ide.github.io/emmet-core/emmet.js');
            wp_enqueue_script('acejs', $path . 'js/ace/ace.js');
            wp_enqueue_script('acejs_theme_monokai', $path . 'js/ace/theme-monokai.js');
            wp_enqueue_script('acejs_emmet', $path . 'js/ace/ext-emmet.js');
        }
        // Page script
        if($screen->base=='users') wp_enqueue_script('triangle_user_js', $path . 'js/backend/user.js');
        if($screen->base=='triangle_page_triangle-contact') wp_enqueue_script('triangle_contact_js', $path . 'js/backend/contact.js');
        if(isset($post->post_type) && $post->post_type=='emailtemplate') wp_enqueue_script('triangle_emailtemplate_js', $path . 'js/backend/emailtemplate.js');
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