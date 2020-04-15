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
use Triangle\Includes\Wordpress\Action;
use Triangle\Includes\Wordpress\SubmenuPage;

use Parsedown;

class PageController extends BaseController {

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        /** @backend - Add custom admin page under settings */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('admin_menu');
        $action->setCallback('page_setting');
        $this->hooks[] = $action;
    }

    /**
     * Page Settings - Add custom admin page under settings
     * @backend @submenu setting
     * @return  void
     */
    public function page_setting(){
        // Set View
        $view = new View();
        $view->setTemplate('default');
        $view->setView('backend.setting');
        $view->setOptions(['shortcode' => false]);
        // Set Page
        $page = new SubmenuPage();
        $page->setParentSlug('options-general.php');
        $page->setPageTitle(Triangle_NAME . ' Setting');
        $page->setMenuTitle(Triangle_NAME);
        $page->setCapability('manage_options');
        $page->setMenuSlug(strtolower(Triangle_NAME) . '-setting');
        $page->setFunction([$page, 'load_view']);
        $page->setView($view);
        $page->build();
    }



}