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
     * @var      object    $plugin  Store plugin object and configuration
     */
    protected $plugin;

    /**
     * @access   protected
     * @var      object    $type    Model object that will used and controlled
     */
    protected $type;

    /**
     * @access   protected
     * @var      array    $hook    Lists of hooks to register within controller
     */
    protected $hooks;

    /**
     * Initalize API
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->hooks = [];

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
     * @return object
     */
    public function getPlugin(): object
    {
        return $this->plugin;
    }

    /**
     * @param object $plugin
     */
    public function setPlugin(object $plugin): void
    {
        $this->plugin = $plugin;
    }

    /**
     * @return object
     */
    public function getType(): object
    {
        return $this->type;
    }

    /**
     * @param object $type
     */
    public function setType(object $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getHooks(): array
    {
        return $this->hooks;
    }

    /**
     * @param array $hooks
     */
    public function setHooks(array $hooks): void
    {
        $this->hooks = $hooks;
    }

}