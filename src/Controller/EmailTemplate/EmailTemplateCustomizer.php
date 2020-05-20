<?php

namespace Triangle\Controller;

!defined( 'WPINC ' ) or die;

/**
 * Plugin hooks in a backend
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\View;
use Triangle\Customizer\Range;
use Triangle\Wordpress\Hook\Action;
use Triangle\Wordpress\Customizer\Panel;
use Triangle\Wordpress\Customizer\Section;
use Triangle\Wordpress\Customizer\Setting;
use Triangle\Wordpress\Customizer\Control;

class EmailTemplateCustomizer extends Customizer {

    /**
     * Admin constructor
     * @return void
     * @var    object   $plugin     Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin){
        parent::__construct($plugin);
        $this->loadModel('EmailTemplate');

        /** @backend - Eneque scripts */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook('admin_enqueue_scripts');
        $action->setCallback('backend_enequeue');
        $action->setAcceptedArgs(1);
        $this->hooks[] = $action;

        /** @backend - Create custom page template for customizer */
        $action = clone $action;
        $action->setHook('template_include');
        $action->setCallback('customizer_custom_page');
        $action->setAcceptedArgs(1);
        $action->setPriority(999);
        $this->hooks[] = $action;

        /** @backend - Register customizer (Panels, Sections, Settings, Controls) */
        $action = clone $action;
        $action->setHook('customize_register');
        $action->setCallback('customizer_register');
        $action->setAcceptedArgs(1);
        $this->hooks[] = $action;

        /** @backend - Remove customizer section */
        $action = clone $action;
        $action->setHook('customize_section_active');
        $action->setCallback('customizer_remove_section');
        $action->setAcceptedArgs(2);
        $this->hooks[] = $action;

        /** @backend - Remove customizer panel */
        $action = clone $action;
        $action->setHook('customize_panel_active');
        $action->setCallback('customizer_remove_panel');
        $action->setAcceptedArgs(2);
        $this->hooks[] = $action;
    }

    /**
     * Eneque scripts @backend
     * @return  void
     * @param   array   $hook_suffix     The current admin page
     */
    public function backend_enequeue($hook_suffix){
        $screen = unserialize(TRIANGLE_SCREEN);
        if($this->Service->Page->is_customize_preview()){
            $this->Service->Asset->wp_enqueue_script('triangle_customizer', 'backend/customizer.js', [], false, true);
        }
    }

    /**
     * Create custom page for customizer and template
     */
    public function customizer_custom_page($template){
        $default = ['post_id', 'triangle_customize'];
        $specs = $this->validateParams($_GET, $default);
        $user = $this->Service->User->get_current_user();
        $user = (isset($user->ID) && $user->ID) ? true :false;
//        $this->Service->Page->is_customize_preview() &&
        if( $user && $specs && $_GET['triangle_customize'] == 'true') {
            $this->EmailTemplate->setID($_GET['post_id']);
            $this->EmailTemplate->getMetas()['template_html']->setArgs(['single' => true]);
            $post = $this->EmailTemplate->get_post();
            $post->template = $this->EmailTemplate->getMetas()['template_html']->get_post_meta();
            ob_start();
                $view = new View($this->Plugin);
                $view->setTemplate('emailtemplate.default');
                $view->addData(compact('post'));
                $view->setSections([
                    'EmailTemplate.backend.customizer' => ['name' => 'Customize', 'active' => true]
                ]);
                $view->build();
            echo ob_get_clean(); return;
        } else {
            return $template;
        }
    }

    /**
     * Load customizer panels
     */
    public function loadPanels($wp_customize){}

    /**
     * Load customizer sections
     */
    public function loadSections($wp_customize){
        /** @section @setting */
        $ID = 'section_triangle_setting';
        $section = new Section();
        $section->setID($ID);
        $section->setArgs([
            'title'     =>  'Setting',
            'priority'  =>  10,
        ]);
        $section->build($wp_customize);
        $this->sections[$ID] = $section;

        /** @section @css */
//        $ID = 'section_triangle_css';
//        $section = new Section();
//        $section->setID($ID);
//        $section->setArgs([
//            'title'     =>  'Additional CSS',
//            'priority'  =>  10,
//        ]);
//        $this->sections[$ID] = $section;
    }

    /**
     * Load customizer settings
     */
    public function loadSettings($wp_customize){
        /** @section @setting - Background Color */
        $ID = 'setting_triangle_background';
        $setting = new Setting();
        $setting->setID($ID);
        $setting->setArgs([
            'default' => '#fff',
            'transport' => 'refresh',
        ]);
        $setting->build($wp_customize);
        $this->settings[$ID] = $setting;

        /** @section @setting - Background Color */
        $ID = 'setting_triangle_container_width';
        $setting = new Setting();
        $setting->setID($ID);
        $setting->setArgs([
            'default' => '800',
            'transport' => 'postMessage',
        ]);
        $setting->build($wp_customize);
        $this->settings[$ID] = $setting;

        /** @section @css - Custom CSS Style */
//        $ID = 'setting_triangle_css';
//        $setting = new Setting();
//        $setting->setID($ID);
//        $setting->setArgs(['default' => 'a']);
//        $setting->build($wp_customize);
//        $this->settings[$ID] = $setting;
    }

    /**
     * Load customizer controls
     */
    public function loadControls($wp_customize){
        /** @section @setting */
        $section = 'section_triangle_setting'; $setting = 'setting_triangle_background';
        if( in_array($section, array_keys($this->sections)) && in_array($setting, array_keys($this->settings)) ){
            $ID = 'control_triangle_background';
            $control = new Control();
            $control->setHandler($control->createColor(
                $wp_customize, $ID, [
                    'label' => 'Background Color',
                    'section' => $section,
                    'settings' => $setting,
                ]
            ));
            $control->build($wp_customize);
            $this->controls[$ID] = $control;
        }

        /** @section @setting */
        $section = 'section_triangle_setting'; $setting = 'setting_triangle_container_width';
        if( in_array($section, array_keys($this->sections)) && in_array($setting, array_keys($this->settings)) ){
            $ID = 'control_triangle_container_width';
            $args = [
                'label' => 'Container Body Size',
                'section' => $section,
                'settings' => $setting,
            ];
            $control = new Control();
            $control->setHandler(new Range($wp_customize, $ID, $args));
            $control->getHandler()->setView(new View($this->Plugin));
            $control->getHandler()->getView()->addData([
                'range'         => [
                    'min'   => 600,
                    'max'   => 1280
                ],
            ]);
            $control->build($wp_customize);
            $this->controls[$ID] = $control;
        }

        /** @section @setting */
//        $section = 'section_triangle_css'; $setting = 'setting_triangle_css';
//        if( in_array($section, array_keys($this->sections)) && in_array($setting, array_keys($this->settings)) ){
//            $ID = 'control_triangle_css';
//            $control = new Control();
//            $control->setID($ID);
//            $control->setArgs([
//                'label'     => 'Text',
//                'type'      => 'textarea',
//                'section'   => $section,
//                'settings'  => $setting,
//            ]);
//            $this->controls[$ID] = $control;
//        }
    }

    /**
     * Register Customizer Panel
     * - Register Panel
     * - Register Sections
     * - Register Settings
     * - Register Control
     */
    public function customizer_register($wp_customize){
        /** Load Customizer Elements */
        $this->loadPanels($wp_customize);
        $this->loadSections($wp_customize);
        $this->loadSettings($wp_customize);
        $this->loadControls($wp_customize);
    }

    /**
     * Filters response of WP_Customize_Section::active()
     * @param   bool    $active     Whether the Customizer section is active.
     * @param   mixed   $section    (WP_Customize_Section) WP_Customize_Section instance.
     * @return  bool
     */
    public function customizer_remove_section( $active, $section ) {
        $sections = array_keys($this->sections); $resolve = true;
        if(isset($_GET['triangle_template']) && $_GET['triangle_template']=='true'){
            $resolve = (in_array($section->id, $sections)) ? true : false;
        }
        return $resolve;
    }

    /**
     * Filters response of WP_Customize_Section::active()
     * @param   bool    $active     Whether the Customizer section is active.
     * @param   mixed   $panel      (WP_Customize_Section) WP_Customize_Section instance.
     * @return  bool
     */
    public function customizer_remove_panel( $active, $panel ){
        $panels = array_keys($this->panels); $resolve = true;
        if(isset($_GET['triangle_template']) && $_GET['triangle_template']=='true'){
            $resolve = (in_array($panel->id, $panels)) ? true : false;
        }
        return $resolve;
    }

}