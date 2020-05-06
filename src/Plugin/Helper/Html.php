<?php

namespace Triangle\Helper;

!defined( 'WPINC ' ) or die;

/**
 * Helper library for Triangle plugins
 *
 * @package    Triangle
 * @subpackage Triangle\Includes
 */

class Html {

    /**
     * Wordpress enqueue script
     * @var   string    $handle     Name of the script. Should be unique
     * @var   string    $src        Full URL of the script, or path of the script relative to the WordPress root directory
     * @var   array     $deps       An array of registered script handles this script depends on
     * @var   string    $ver        String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes
     * @var   bool      $in_footer  	Whether to enqueue the script before </body> instead of in the <head>
     */
    public function script($src, $async = false){
        $path = unserialize(TRIANGLE_PATH)['plugin_url'] . 'assets/js/';
        if(!strpos($src, '//')) $src = $path . $src;
        $async = ($async) ? 'async' : '';
        echo "<script src='$src' $async></script>";
    }

}