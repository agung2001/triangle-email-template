<?php

namespace Triangle\Api;

!defined( 'WPINC ' ) or die;

/**
 * Type API
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\Wordpress\Action;
use Triangle\Wordpress\Type as WPType;

class Type extends Api {

    /**
     * User API constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);

        /** @backend - Init API */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('wp_ajax_triangle-type');
        $action->setCallback('callback');
        $action->setAcceptedArgs(0);
        $this->hooks[] = $action;
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