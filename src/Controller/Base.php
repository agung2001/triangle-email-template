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
        $screen = unserialize(TRIANGLE_SCREEN);
        if(in_array($screen->base,$screens) || (isset($screen->post->post_type) && in_array($screen->post->post_type,$types)) ){
            /** Font Awesome */
            Service::wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css');
            /** Animate.css */
            if(Service::get_option('triangle_animation')) Service::wp_enqueue_style('animatecss', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css');
            /** jQuery Select2 */
            Service::wp_enqueue_style('select2css', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css');
            Service::wp_enqueue_script('select2js', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js');
            /** Ace JS - Code Editor */
            Service::wp_enqueue_script('acejs_emmet_core', 'ace/emmet-core/emmet.min.js','','',true);
            Service::wp_enqueue_script('acejs', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.11/ace.min.js','','',true);
            Service::wp_enqueue_script('acejs_mode_html', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.11/mode-html.min.js','','',true);
            Service::wp_enqueue_script('acejs_emmet', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.11/ext-emmet.min.js','','',true);
        }
    }

}