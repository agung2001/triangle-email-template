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
        /** @backend - Auto create sample post type */
        $type = parent::__construct($plugin);
        $args = ['show_in_menu' => false];
        $type->setArgs(array_merge($type->getArgs(), $args));
        $type->build();
    }

}