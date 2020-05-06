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
     * Wordpress get screen
     */
    public function getScreen(){
        global $post, $pagenow;
        $screen = get_current_screen();
        $screen->post = $post;
        $screen->pagenow = $pagenow;
        return $screen;
    }

}