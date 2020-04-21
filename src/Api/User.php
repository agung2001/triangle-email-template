<?php

namespace Triangle\Api;

!defined( 'WPINC ' ) or die;

/**
 * User API
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\Wordpress\Action;
use Triangle\Wordpress\User as WPUser;

class User extends Api {

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
        $action->setHook('wp_ajax_triangle-user');
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
        $user = new WPUser();
        $method = $_POST['method'];
        if(isset($_POST['args'])) $user->setArgs($_POST['args']);
        if(isset($_POST['method'])) wp_send_json($user->$method());
    }

}