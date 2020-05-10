<?php

namespace Triangle\Api;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\Wordpress\Action;

class Editor extends Api {

    /**
     * User API constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);

        /** @backend - API - Page Contact */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('wp_ajax_triangle-editor');
        $action->setCallback('load_editor');
        $action->setAcceptedArgs(0);
        $this->hooks[] = $action;
    }

    /**
     * Load WP block editor
     * @return  string     Load WP block editor with content
     */
    public function load_editor(){
        /** Validate Params */
        if(!$this->validateParams($_POST, ['element'])) die('Parameters did not match the specs!');

        /** Return block editor */
        $content = html_entity_decode($_POST['element']);
        $content = preg_replace('/\s+/', ' ', stripslashes($content));
        $content = $this->Service->Page->ajax_wp_editor($content, 'wp_element_editor');
        echo $content; exit;
    }

}