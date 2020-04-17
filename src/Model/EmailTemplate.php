<?php

namespace Triangle\Model;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Model
 */

use Triangle\Wordpress\Taxonomy;

class EmailTemplate extends Model {

    /**
     * Model constructor
     * @return void
     * @var    object $plugin Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin)
    {
        /** @backend - Init model */
        $type = $this->init($plugin);
        $args = ['show_in_menu' => false];
        $type->setArgs(array_merge($type->getArgs(), $args));
        $this->types[] = $type;
    }

}