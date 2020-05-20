<?php

namespace Triangle\Wordpress\Customizer;

!defined( 'WPINC ' ) or die;

/**
 * Register all actions
 *
 * @package    Triangle
 * @subpackage Triangle\Includes\Wordpress
 */

class Setting extends Customizer {

    /**
     * Build
     * @return  void
     */
    public function build($wp_customize){
        $wp_customize->add_setting($this->ID, $this->args);
    }

}