<?php

namespace Triangle\Controller;

!defined( 'WPINC ' ) or die;

/**
* Initiate plugins
*
* @package    Triangle
* @subpackage Triangle/Controller
*/

use Triangle\Includes\View;
use Triangle\Includes\Wordpress\Shortcode;

class FrontendController extends BaseController {

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        /** @backend - Triangle Shortcode */
        $name = strtolower($plugin->getName());
        $shortcode = new Shortcode();
        $shortcode->setComponent($this);
        $shortcode->setHook($name);
        $shortcode->setCallback('plugin_shortcode');
        $shortcode->setAcceptedArgs(2);
        $this->hooks[] = $shortcode;
    }

    /**
     * Plugin shortcode
     * @var     array  $atts        Shortcode attributes
     * @var     string $content     Shortcode content
     * @return  string              Generated html page
     */
    public function plugin_shortcode($atts, $content = null){
        $atts = shortcode_atts([ 'request' => 'default' ], $atts, strtolower(TRIANGLE_NAME) );
        if($atts['request']) {
            $view = new View();
            $view->setTemplate('blank');
            $view->setView('frontend.welcome');
            $view->setOptions(['shortcode' => true]);
            $view->build();
        }
    }

}