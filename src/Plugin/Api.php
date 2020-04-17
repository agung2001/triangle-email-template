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

class Api {

    /**
     * @access   protected
     * @var      array    $hook    Lists of hooks to register within controller
     */
    protected $hooks = [];

    /**
     * Initalize API
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function init($plugin){
        /** @backend - Eneque scripts */
        $name = substr(strrchr(get_called_class(), "\\"), 1);
        $name = strtolower($name);
        $action = new Action();
        $action->setCallback('callback');
        $action->setComponent($this);
        $action->setAcceptedArgs(0);
        return $action;
    }

    /**
     * @return array
     */
    public function getHooks()
    {
        return $this->hooks;
    }

    /**
     * @param array $hooks
     */
    public function setHooks($hooks)
    {
        $this->hooks = $hooks;
    }

}