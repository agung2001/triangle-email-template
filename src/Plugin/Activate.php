<?php

namespace Triangle\Lifecycle;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

use Triangle\Plugin;
use Triangle\Helper;
use Triangle\Model\EmailTemplate;
use Triangle\Wordpress\Service;
use Triangle\Wordpress\User;

class Activate {

    /**
     * @access   protected
     * @var      object    $plugin  Plugin object
     */
    protected $Plugin;

    /**
     * @access   protected
     * @var      object    $helper  Helper object for controller
     */
    protected $Helper;

    /**
     * Plugin configuration
     * @var     object
     */
    protected $config;

    /**
     * Activate constructor
     * @return void
     */
    public function __construct($config){
        $this->Plugin = new Plugin($config);
        $this->Helper = new Helper();
        $this->config = $config;
        $this->initDemoTheme();
        $this->initOptions();
    }

    /**
     * Initiate demo theme
     * @return void
     */
    public function initDemoTheme(){
        $path = Service::getPath($this->config->path);
        $themes = $this->Helper->getDir($path['plugin_path'] . 'assets/demo');
        foreach($themes as $theme){
            /** Copy Directories */
            $src = $path['plugin_path'] . 'assets/demo/' . $theme;
            $dst = $path['upload_dir']['basedir'] . '/EmailTemplate/' . $theme;
            if(!is_dir($dst)) {
                mkdir($dst, 0755, true);
                $this->Helper->copyDir($src,$dst);
            }
            /** Setup Theme Data */
            $this->setupThemeData($theme, $src);
        }
    }

    /**
     * Setup theme data
     * @return void
     */
    private function setupThemeData($theme, $path){
        $EmailTemplate = new EmailTemplate($this->Plugin);
        $EmailTemplate->setArgs([
            'name'        => $theme,
            'numberposts' => 1
        ]);
        if(!$EmailTemplate->get_posts()){
            $currentUser = User::get_current_user();
            $EmailTemplate->setArgs([
                'post_title'    => ucwords($theme),
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_author'   => $currentUser->ID,
            ]);
            $post_id = $EmailTemplate->insert_post();
            $EmailTemplate->setID($post_id);
            $templates = $this->Plugin->getConfig()->templates;
            $templates = $this->Helper->getTemplatesFromConfig($templates);
            $results = [];
            foreach($EmailTemplate->getMetas() as $meta){
                $key = $meta->getKey();
                $name = str_replace('template_', '', $key);
                $mode = explode('/',$templates[$name]->mode)[2];
                $filePath = $path . '/' . $theme . '.' . $mode;
                if(file_exists($filePath)){
                    $value = file_get_contents($filePath);
                    $meta->setValue($value);
                    $results[] = $meta->update_post_meta();
                }
            }
        }
    }

    /**
     * Initiate plugin options
     * @return void
     */
    public function initOptions(){
        $defaultOptions = [
            'triangle_animation' => 'on',
            'triangle_animation_tab' => 'heartBeat',
            'triangle_animation_content' => 'fadeIn',
            'triangle_builder_inliner' => 'juice'
        ];
        foreach($defaultOptions as $key => $value){
            if(!Service::get_option($key)){
                Service::update_option($key, $value);
            }
        }
    }

}