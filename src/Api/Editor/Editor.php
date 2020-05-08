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
     * Load block editor
     */
    public function load_editor(){
        $content = html_entity_decode($_POST['element']);
        $content = preg_replace('/\s+/', ' ', stripslashes($content));

        ob_start();
            wp_editor( $content, 'ngasal', [] );
        $temp = ob_get_clean();
        $temp .= \_WP_Editors::enqueue_scripts();
        $temp .= print_footer_scripts();
        $temp .= \_WP_Editors::editor_js();

        echo $temp;
        exit;
    }

}