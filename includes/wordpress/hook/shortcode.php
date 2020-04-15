<?php

namespace Triangle\Includes\Wordpress;

!defined( 'WPINC ' ) or die;

/**
 * Abstract class for hook
 *
 * @package    Triangle
 * @subpackage Triangle\Includes\Wordpress
 */

class Shortcode extends Hook {

    /**
     * Run hook
     * @return  void
     */
    public function run(){
        add_shortcode(
            $this->hook,
            array( $this->component, $this->callback )
        );
    }



}