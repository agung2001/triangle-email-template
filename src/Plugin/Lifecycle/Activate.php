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
     * Activate constructor
     * @return void
     */
    public function __construct($config){
        $this->Plugin = new Plugin($config);
        $this->Helper = new Helper();
        $this->Service = new Service();
        $this->config = $config;
        $this->initDemoTheme();
        $this->initOptions();
    }

    /**
     * Initiate demo theme
     * @return void
     */
    public function initDemoTheme(){
        $path = $this->Service->Asset->getPath($this->config->path);
        $themes = $this->Helper->getDir($path['plugin_path'] . 'assets/demo');
        foreach($themes as $theme){
            /** Copy Directories */
            $src = $path['plugin_path'] . 'assets/demo/' . $theme;
            $dst = $path['upload_dir']['basedir'] . '/emailtemplate/' . $theme;
            if(!is_dir($dst)) {
                mkdir($dst, 0755, true);
                $this->Helper->copyDir($src,$dst);
                /** Remove files */
                if(file_exists($dst . '/' . $theme . '.css')) unlink($dst . '/' . $theme . '.css');
                if(file_exists($dst . '/' . $theme . '.html')) unlink($dst . '/' . $theme . '.html');
                if(file_exists($dst . '/standard.html')) unlink($dst . '/standard.html');
            }
            /** Setup Theme Data */
            $this->setupThemeData($theme, $src);
        }
    }

    /**
     * Setup theme data
     * @return void
     */
    private function setupThemeData($theme, $src){
        $path = $this->Service->Asset->getPath($this->config->path);
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
            foreach($EmailTemplate->getMetas() as $key => $meta){
                $filePath = $src . '/' . $theme . '.html';
                if(file_exists($filePath)){
                    $value = $this->Helper->convertImagesRelativetoAbsolutePath(
                        $path['upload_dir']['baseurl'] . '/emailtemplate/' . $theme . '/',
                        file_get_contents($filePath)
                    );
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
            if(!$this->Service->Option->get_option($key)){
                $this->Service->Option->update_option($key, $value);
            }
        }
    }

}