<?php

namespace Triangle\Controller;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\View;
use Triangle\Wordpress\Action;
use Triangle\Wordpress\MenuPage;
use Triangle\Wordpress\SubmenuPage;

use Parsedown;

class Page extends Base {

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);

        /** @backend - Add custom admin page under settings */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('admin_menu');
        $action->setCallback('page_setting');
        $this->hooks[] = $action;
        /** @backend - Add contact page to send an email */
        $action = clone $action;
        $action->setComponent($this);
        $action->setHook('admin_menu');
        $action->setCallback('page_contact');
        $this->hooks[] = $action;
        /** @backend - Add template submenu link for template cpt */
        $action = clone $action;
        $action->setComponent($this);
        $action->setHook('admin_menu');
        $action->setCallback('link_email_template');
        $this->hooks[] = $action;
    }

    /**
     * Page Setting
     * @backend @submenu setting
     * @return  void
     */
    public function page_setting(){
        // Set View
        $view = new View();
        $view->setTemplate('default');
        $view->setView('backend.setting');
        $view->setOptions(['shortcode' => false]);
        // Set Main Page
        $page = new MenuPage();
        $page->setPageTitle(TRIANGLE_NAME . ' Setting');
        $page->setMenuTitle(TRIANGLE_NAME);
        $page->setCapability('manage_options');
        $page->setMenuSlug(strtolower(TRIANGLE_NAME));
        $page->setIconUrl('dashicons-email');
        $page->setFunction([$page, 'load_view']);
        $page->setView($view);
        $page->setPosition(90);
        $page->build();
        // Set Page
        $page = new SubmenuPage();
        $page->setParentSlug(strtolower(TRIANGLE_NAME));
        $page->setPageTitle(TRIANGLE_NAME . ' Setting');
        $page->setMenuTitle('Setting');
        $page->setCapability('manage_options');
        $page->setMenuSlug(strtolower(TRIANGLE_NAME));
        $page->setView($view);
        $page->build();
    }

    /**
     * Page Contact
     * @backend @submenu Triangle
     * @return  void
     */
    public function page_contact(){
        // Set View
        $view = new View();
        $view->setTemplate('default');
        $view->setView('backend.contact');
        $view->setOptions(['shortcode' => false]);
        // Set Page
        $page = new SubmenuPage();
        $page->setParentSlug(strtolower(TRIANGLE_NAME));
        $page->setPageTitle('Contact User');
        $page->setMenuTitle('Contact');
        $page->setCapability('manage_options');
        $page->setMenuSlug(strtolower(TRIANGLE_NAME) . '-contact');
        $page->setFunction([$page, 'load_view']);
        $page->setView($view);
        $page->build();
    }

    /**
     * Page Contact
     * @backend @submenu Triangle
     * @return  void
     */
    public function link_email_template(){
        $page = new SubmenuPage();
        $page->setParentSlug(strtolower(TRIANGLE_NAME));
        $page->setPageTitle('Email Template');
        $page->setMenuTitle('Template');
        $page->setCapability('manage_options');
        $page->setMenuSlug('edit.php?post_type=emailtemplate');
        $page->build();
    }

}