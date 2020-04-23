<?php

namespace Triangle\Api;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\Controller\Controller;

class Api extends Controller {

    /**
     * Validate API Params
     * @return  bool    Validation result
     */
    private function validateParams($params, $default, $validated = true){
        foreach($default as $index => $key){
            if(!isset($params[$key]) && !is_array($key)){ $validated = false; break; }
            if(is_array($key)) $validated = $this->validateParams($params[$index], $key, $validated);
        }
        return $validated;
    }

}