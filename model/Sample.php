<?php

namespace Triangle\Model;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Model
 */

use Triangle\Includes\Wordpress\Taxonomy;

class Sample extends Model {

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
        /** @backend */
        $taxonomy = new Taxonomy();
        $taxonomy->setName('category');
        $taxonomy->setType($type);
        $taxonomy->setArgs([
            'labels'		=> [
                'name'			=> 'Categories',
                'singular_name'	=> 'Category'
            ],
        ]);
        $taxonomy->build();
    }

}