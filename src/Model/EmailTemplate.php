<?php

namespace Triangle\Model;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Model
 */

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
        $args = $type->getArgs();
        $args['publicly_queryable'] = false;
        $args['has_archive'] = false;
        $args['show_in_menu'] = false;
        $args['labels'] = ['name' => 'Email Template'];
        $args['supports'] = ['title', 'thumbnail'];
        $type->setArgs($args);
        $this->type = $type;
    }

}