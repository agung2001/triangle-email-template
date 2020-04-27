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
     * Retrieve list of users matching criteria.
     * @backend
     * @return  object  Lists of user object
     */
    public static function get_users($args){
        return get_users($args);
    }

    /**
     * Retrieve user info by a given field
     * @backend
     * @return  object  User object
     */
    public static function get_user_by($field, $value){
        return get_user_by($field, $value);
    }

    /**
     * Retrieve the current user object.
     * @backend
     * @return  object  User object
     */
    public static function get_current_user(){
        return wp_get_current_user();
    }

}