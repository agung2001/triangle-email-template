<?php

namespace Triangle\Model;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Model
 */

use Triangle\Helper;
use Triangle\Wordpress\Type;

class Model extends Type {

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
     * Construct type
     * @return void
     * @var    object $plugin Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin)
    {
        $this->name = substr(strrchr(get_called_class(), "\\"), 1);
        $this->name = strtolower($this->name);
        $this->Plugin = $plugin;
        $this->Helper = new Helper();
        $this->taxonomies = [];
        $this->hooks = [];
        $this->metas = [];
        $this->args = [];
        $this->args['public'] = true;
        $this->args['labels'] = ['name' => ucwords($this->name)];
    }

}