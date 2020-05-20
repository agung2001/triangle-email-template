<?php

namespace Triangle\Wordpress\Customizer;

!defined( 'WPINC ' ) or die;

/**
 * Register all actions
 *
 * @package    Triangle
 * @subpackage Triangle\Includes\Wordpress
 */

class Panel extends Customizer {

    /**
     * @access   protected
     * @var      object    $panel    WP Customizer Panel
     */
    protected $panel;

    /**
     * Build
     * @return  void
     */
    public function build($wp_customize){
        $wp_customize->add_panel($this->ID, $this->args);
    }

    /**
     * @return object
     */
    public function getPanel()
    {
        return $this->panel;
    }

    /**
     * @param object $panel
     */
    public function setPanel($panel)
    {
        $this->panel = $panel;
    }

}