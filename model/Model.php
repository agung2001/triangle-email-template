<?php

namespace Triangle\Model;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Model
 */

use Triangle\Includes\Wordpress\Type;

class Model {

    /**
     * Model constructor
     * @return void
     * @var    object $plugin Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin)
    {
        $name = substr(strrchr(get_called_class(), "\\"), 1);
        $name = strtolower($name);
        $type = new Type();
        $type->setName($name);
        $type->setArgs([
            'public'			=> true,
            'labels' 			=> array('name' => ucwords($name)),
        ]);
        $type->build();
        return $type;
    }

}