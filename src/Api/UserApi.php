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

class UserApi extends Api {

    /**
     * User API constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        /** @backend - Eneque scripts */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('wp_ajax_nopriv_get_users');
        $action->setCallback('get_users');
        $action->setAcceptedArgs(1);
        $this->hooks[] = $action;
    }

    /**
     * Get All Users
     * @backend
     * @return  void
     */
    public function get_users(){
        wp_send_json('test');
        exit;
    }

}