<?php

namespace Triangle\Model;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Model
 */

use Triangle\Wordpress\Type;

class Model {

    /**
     * @access   protected
     * @var      array    $hook    Lists of hooks to register within controller
     */
    protected $types = [];

    /**
     * Initialize Model
     * @return void
     * @var    object $plugin Plugin configuration
     * @pattern prototype
     */
    public function init($plugin)
    {
        $name = substr(strrchr(get_called_class(), "\\"), 1);
        $name = strtolower($name);
        $type = new Type();
        $type->setName($name);
        $type->setArgs([
            'public'			=> true,
            'labels' 			=> array('name' => ucwords($name)),
        ]);
        return $type;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param array $types
     */
    public function setTypes(array $types): void
    {
        $this->types = $types;
    }

}