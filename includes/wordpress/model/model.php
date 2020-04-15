<?php

namespace Triangle\Includes\Wordpress;

!defined( 'WPINC ' ) or die;

/**
 * Abstract class for wordpress model
 *
 * @package    Triangle
 * @subpackage Triangle\Includes\Wordpress
 */

abstract class Model {

    /**
     * @access   protected
     * @var      string    $name    The name of post_type
     */
    protected $name;

    /**
     * @access   protected
     * @var      array    $args    Post type args
     */
    protected $args;

    /**
     * Method to build model
     * @return  void
     */
    abstract function build();

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @param array $args
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }

}