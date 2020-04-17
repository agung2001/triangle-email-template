<?php

namespace Triangle\Api;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

class User extends Api {

    /**
     * User API constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        /** @backend - Init API */
        $this->hooks[] = $this->init($plugin);
    }

    /**
     * API Callback
     * @backend
     * @return  void
     */
    public function callback(){
        wp_send_json(['SUCCESS!']);
        exit;
    }

}