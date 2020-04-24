<?php

namespace Triangle\Wordpress;

!defined( 'WPINC ' ) or die;

/**
 * Add extra layer for wordpress functions
 *
 * @package    Triangle
 * @subpackage Triangle\Includes\Wordpress
 */

class Service {

    /**
     * Search content for shortcodes and filter shortcodes through their hooks.
     * @var     string      $content        Content to search for shortcodes.
     * @var     bool        $ignore_html    When true, shortcodes inside HTML elements will be skipped.
     */
    public static function do_shortcode($content, $ignore_html = false){
        do_shortcode($content, $ignore_html);
    }

    /**
     * Wordpress enqueue style
     * @var   string    $handle     Name of the script. Should be unique
     * @var   string    $src        Full URL of the script, or path of the script relative to the WordPress root directory
     * @var   array     $deps       An array of registered script handles this script depends on
     * @var   string    $ver        String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes
     * @var   bool      $media  	The media for which this stylesheet has been defined.
     */
    public static function wp_enqueue_style($handle, $src, $deps = [], $ver = false, $media = 'all'){
        $path = unserialize(TRIANGLE_PATH)['plugin_url'] . 'assets/css/';
        if(!strpos($src, '//')) $src = $path . $src;
        wp_enqueue_style($handle, $src, $deps, $ver, $media);
    }

    /**
     * Wordpress enqueue script
     * @var   string    $handle     Name of the script. Should be unique
     * @var   string    $src        Full URL of the script, or path of the script relative to the WordPress root directory
     * @var   array     $deps       An array of registered script handles this script depends on
     * @var   string    $ver        String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes
     * @var   bool      $in_footer  	Whether to enqueue the script before </body> instead of in the <head>
     */
    public static function wp_enqueue_script($handle, $src, $deps = [], $ver = false, $in_footer = false){
        $path = unserialize(TRIANGLE_PATH)['plugin_url'] . 'assets/js/';
        if(!strpos($src, '//')) $src = $path . $src;
        wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);
    }

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
            'plugin_url' => plugin_dir_url($path),
            'upload_dir' => wp_upload_dir()
        ];
        $path['view_path'] = $path['plugin_path'] . 'src/View/';
        define('TRIANGLE_PATH', serialize($path));
        return $path;
    }

    /**
     * Wordpress get screen
     */
    public static function getScreen(){
        global $post;
        $screen = get_current_screen();
        $screen->post = $post;
        return $screen;
    }

}