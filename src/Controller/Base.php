<?php

namespace Triangle\Controller;

!defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

class Base extends Controller {

    /**
     * @backend - Load plugin libraries
     * @return  void
     * @var     array   $screens     Lists of screen where the library are loaded
     * @var     array   $types       Lists of post_type where the library are loaded
     */
    protected function backend_load_plugin_libraries($screens = [], $types = []){
        global $post;
        $screen = get_current_screen();
        $path = unserialize(TRIANGLE_PATH)['plugin_url'] . 'assets/';
        if(in_array($screen->base,$screens) || (isset($post->post_type) && in_array($post->post_type,$types)) ){
            /** jQuery Select2 */
            wp_enqueue_style('select2_css', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css');
            wp_enqueue_script('select2_js', 'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js');
            /** Ace JS - Code Editor */
            wp_enqueue_script('acejs_emmet_core', $path . 'js/ace/emmet-core/emmet.js');
            wp_enqueue_script('acejs', $path . 'js/ace/ace.js');
            wp_enqueue_script('acejs_theme_monokai', $path . 'js/ace/theme-monokai.js');
            wp_enqueue_script('acejs_emmet', $path . 'js/ace/ext-emmet.js');
        }
    }

}