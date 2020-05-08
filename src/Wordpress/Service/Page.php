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
     * Wordpress redirect
     */
    public function wp_redirect($url){
        wp_redirect($url); exit;
    }

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