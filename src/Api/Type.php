<?php

namespace Triangle\Api;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\Wordpress\Type as WPType;

class Type extends Api {

    /**
     * User API constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        /** @backend - Init API */
        $api = $this->init($plugin);
        $api->setHook('wp_ajax_triangle-type');
        $this->hooks[] = $api;
    }

    /**
     * API Callback
     * @backend
     * @return  void
     */
    public function callback(){
        $type = new WPType();
        $method = $_POST['method'];
        if(isset($_POST['args'])) $type->setArgs($_POST['args']);
        if(isset($_POST['method'])) wp_send_json($type->$method());
    }

}