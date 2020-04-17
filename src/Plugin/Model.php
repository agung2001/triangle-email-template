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
     * @var      object    $type    Wordpress CPT Type
     */
    protected $type;

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

}