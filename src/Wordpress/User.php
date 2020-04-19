<?php

namespace Triangle\Wordpress;

!defined( 'WPINC ' ) or die;

/**
 * Retrieve wordpress user data
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

class User {

    /**
     * @access   protected
     * @var      array    $args    Arguments to retrieve users
     * Wordpress : @get_users
     */
    protected $args = [];

    /**
     * Retrieve list of users matching criteria.
     * @backend
     * @return  void
     */
    public function get_users(){
        return get_users($this->args);
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param array $args
     */
    public function setArgs(array $args): void
    {
        $this->args = $args;
    }

}