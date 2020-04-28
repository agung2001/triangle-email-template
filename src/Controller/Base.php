<?php

namespace Triangle\Controller;

!defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\Wordpress\Service;

class Base extends Controller {

    /**
     * @backend - Load plugin libraries
     * @return  void
     * @var     array   $screens     Lists of screen where the library are loaded
     * @var     array   $types       Lists of post_type where the library are loaded
     */
    protected function backend_load_plugin_libraries($screens = [], $types = []){
        $screen = Service::getScreen();
        if(in_array($screen->base,$screens) || (isset($screen->post->post_type) && in_array($screen->post->post_type,$types)) ){
            /** Font Awesome */
            Service::wp_enqueue_style('fontawesome', 'fontawesome.min.css');
            /** Animate.css */
            if(Service::get_option('triangle_animation')) Service::wp_enqueue_style('animatecss', 'animate.min.css');
            /** jQuery Select2 */
            Service::wp_enqueue_style('select2css', 'select2.min.css');
            Service::wp_enqueue_script('select2js', 'select2.full.min.js');
            /** Ace JS - Code Editor */
            Service::wp_enqueue_script('acejs_emmet_core', 'ace/emmet.min.js','','',true);
            Service::wp_enqueue_script('acejs', 'ace/ace.min.js','','',true);
            Service::wp_enqueue_script('acejs_mode_html', 'ace/mode-html.min.js','','',true);
            Service::wp_enqueue_script('acejs_emmet', 'ace/ext-emmet.min.js','','',true);
            Service::wp_enqueue_script('acejs_search', 'ace/ext-searchbox.min.js','','',true);
        }
    }

}