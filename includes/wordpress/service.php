<?php

namespace Triangle\Includes\Wordpress;

!defined( 'WPINC ' ) or die;

/**
 * Add extra layer for wordpress functions
 *
 * @package    Triangle
 * @subpackage Triangle\Includes\Wordpress
 */

class Service {

    /**
     * Wordpress path function
     */
    public static function getPath($path){
        if(!function_exists( 'get_home_path' )) include_once ABSPATH . '/wp-admin/includes/file.php';
        $path = [
            'path' => $path,
            'home_path' => get_home_path(),
            'home_url' => get_home_url(),
            'plugin_path' => plugin_dir_path($path),
            'plugin_url' => plugin_dir_url($path)
        ];
        $path['view_path'] = $path['plugin_path'] . 'view/';
        define('TRIANGLE_PATH', serialize($path));
        return $path;
    }

}