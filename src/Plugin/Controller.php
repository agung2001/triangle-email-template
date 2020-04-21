<?php

namespace Triangle\Controller;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\Helper;

class Controller {

    /**
     * @access   protected
     * @var      object    $Plugin  Store plugin object and configuration
     */
    protected $Plugin;

    /**
     * @access   protected
     * @var      object    $helper  Helper object for controller
     */
    protected $Helper;

    /**
     * @access   protected
     * @var      array    $hook    Lists of hooks to register within controller
     */
    protected $hooks;

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        $this->Plugin = $plugin;
        $this->Helper = new Helper();
        $this->hooks = [];
    }

    /**
     * Overloading Method, for multiple arguments
     * @method  loadModel           _ Load model @var string name
     * @method  loadController      _ Load controller @var string name
     */
    public function __call($method, $arguments){
        if(in_array($method, ['loadModel', 'loadController'])){
            $list = ($method=='loadModel') ? $this->Plugin->getModels() : [];
            $list = ($method=='loadController') ? $this->Plugin->getController() : $list;
            if(count($arguments)==1) $this->{$arguments[0]} = $list[$arguments[0]];
            if(count($arguments)==2) $this->{$arguments[0]} = $list[$arguments[1]];
        }
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