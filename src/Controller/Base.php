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
        $screen = $this->Helper->getConst('TRIANGLE_SCREEN');
        if(in_array($screen->base,$screens) || (isset($screen->post->post_type) && in_array($screen->post->post_type,$types)) ){
            /** jQuery Select2 */
            Service::wp_enqueue_style('select2_css', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css');
            Service::wp_enqueue_script('select2_js', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js');
            /** Ace JS - Code Editor */
            Service::wp_enqueue_script('acejs_emmet_core', 'ace/emmet-core/emmet.js');
            Service::wp_enqueue_script('acejs', 'ace/ace.js');
            Service::wp_enqueue_script('acejs_emmet', 'ace/ext-emmet.js');
            Service::wp_enqueue_script('acejs_jquery', 'ace/jquery-ace.min.js');
        }
    }

}