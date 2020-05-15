<?php

namespace Triangle\Wordpress\Service;

!defined( 'WPINC ' ) or die;

/**
 * Add extra layer for wordpress functions
 *
 * @package    Triangle
 * @subpackage Triangle\Wordpress
 */

class Page {

    /**
     * Wordpress - Retrieves a modified URL query string.
     * @var  string     $path    Path relative to the home URL.
     * @var  string     $scheme    Scheme to give the home URL context. Accepts 'http', 'https', 'relative', 'rest', or null.
     */
    public function home_url($path = '', $scheme = null){ return home_url($path, $scheme); }

    /**
     * Wordpress - Retrieves a modified URL query string.
     * @var  string     $key    Either a query variable key, or an associative array of query variables.
     * @var  string     $value    Either a query variable value, or a URL to act upon.
     * @var  string     $url    A URL to act upon.
     */
    public function add_query_arg($key, $value = null, $url = null){
        return ($url) ? add_query_arg($key, $value, $url) : add_query_arg($key, $value);
    }

    /**
     * Wordpress redirect
     */
    public function wp_redirect($url){ wp_redirect($url); exit; }

    /**
     * Wordpress get screen
     */
    public function getScreen(){
        global $post, $pagenow;
        $screen = function_exists('get_current_screen') ?
            get_current_screen() : (object)[];
        $screen->post = $post;
        $screen->pagenow = $pagenow;
        return $screen;
    }

}