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
    protected function frontend_load_plugin_libraries($screens = [], $types = []){
        global $post;
        if((isset($post->post_type) && in_array($post->post_type,$types)) ){
            /** Animate.css */
            if($this->Service->Option->get_option('triangle_animation')) $this->Service->Asset->wp_enqueue_style('animatecss', 'animate.min.css');
            /** jQuery Select2 */
            $this->Service->Asset->wp_enqueue_style('select2css', 'select2.min.css');
            $this->Service->Asset->wp_enqueue_script('select2js', 'select2.full.min.js');
            /** Confirm JS */
            $this->Service->Asset->wp_enqueue_style('confirm_css', 'jquery-confirm.min.css');
            $this->Service->Asset->wp_enqueue_script('confirm_js', 'jquery-confirm.min.js','','',true);
            /** Muuri JS */
            $this->Service->Asset->wp_enqueue_script('web-animation_js', 'muuri/web-animations.min.js','','',false);
            $this->Service->Asset->wp_enqueue_script('muuri_js', 'muuri/muuri.min.js','','',false);
            /** Ace JS - Code Editor */
            $this->Service->Asset->wp_enqueue_script('acejs_emmet_core', 'ace/emmet.min.js','','',true);
            $this->Service->Asset->wp_enqueue_script('acejs', 'ace/ace.min.js','','',true);
            $this->Service->Asset->wp_enqueue_script('acejs_mode_html', 'ace/mode-html.min.js','','',true);
            $this->Service->Asset->wp_enqueue_script('acejs_emmet', 'ace/ext-emmet.min.js','','',true);
            $this->Service->Asset->wp_enqueue_script('acejs_search', 'ace/ext-searchbox.min.js','','',true);
        }
    }

    /**
     * @backend - Load plugin libraries
     * @return  void
     * @var     array   $screens     Lists of screen where the library are loaded
     * @var     array   $types       Lists of post_type where the library are loaded
     */
    protected function backend_load_plugin_libraries($screens = [], $types = []){
        $screen = $this->Service->Page->getScreen();
        if(in_array($screen->base,$screens) || (isset($screen->post->post_type) && in_array($screen->post->post_type,$types)) ){
            /** Animate.css */
            if($this->Service->Option->get_option('triangle_animation')) $this->Service->Asset->wp_enqueue_style('animatecss', 'animate.min.css');
            /** jQuery Select2 */
            $this->Service->Asset->wp_enqueue_style('select2css', 'select2.min.css');
            $this->Service->Asset->wp_enqueue_script('select2js', 'select2.full.min.js');
            /** Confirm JS */
            $this->Service->Asset->wp_enqueue_style('confirm_css', 'jquery-confirm.min.css');
            $this->Service->Asset->wp_enqueue_script('confirm_js', 'jquery-confirm.min.js','','',true);
            /** Muuri JS */
            $this->Service->Asset->wp_enqueue_script('web-animation_js', 'muuri/web-animations.min.js','','',false);
            $this->Service->Asset->wp_enqueue_script('muuri_js', 'muuri/muuri.min.js','','',false);
            /** Ace JS - Code Editor */
            $this->Service->Asset->wp_enqueue_script('acejs_emmet_core', 'ace/emmet.min.js','','',true);
            $this->Service->Asset->wp_enqueue_script('acejs', 'ace/ace.min.js','','',true);
            $this->Service->Asset->wp_enqueue_script('acejs_mode_html', 'ace/mode-html.min.js','','',true);
            $this->Service->Asset->wp_enqueue_script('acejs_emmet', 'ace/ext-emmet.min.js','','',true);
            $this->Service->Asset->wp_enqueue_script('acejs_search', 'ace/ext-searchbox.min.js','','',true);
        }
    }

}