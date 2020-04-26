<?php

namespace Triangle;

!defined( 'WPINC ' ) or die;

/**
 * Helper library for Triangle plugins
 *
 * @package    Triangle
 * @subpackage Triangle\Includes
 */

use Triangle\Wordpress\Service;

class Helper {

    /**
     * Define const which will be used within the plugin
     * @param   object   $plugin     Wordpress plugin object
     * @return void
     */
    public static function defineConst($plugin){
        define('TRIANGLE_NAME', $plugin->getName());
        define('TRIANGLE_VERSION', $plugin->getVersion());
        define('TRIANGLE_PRODUCTION', $plugin->isProduction());
    }

    /**
     * Get files within directory
     * @return  void
     * @var     string  $dir   plugin hooks directory (Api, Controller)
     * @pattern bridge
     */
    public static function getDirFiles($dir, &$results = array()) {
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                self::getDirFiles($path, $results);
            }
        }
        return $results;
    }

    /**
     * Get standard.html content from EmailTemplate dir
     * @var     string  $slug   EmailTemplate slug = post name slug
     * @return  void
     */
    public function getStandardEmailTemplate($slug){
        $path = unserialize(TRIANGLE_PATH);
        $dir = $path['upload_dir']['basedir'] . '/EmailTemplate/' . $slug;
        ob_start(); echo file_get_contents($dir . '/' . 'standard.html');
        return ob_get_clean();
    }

    /**
     * Extract templates from config files
     * @var     array   $config         Lists of config templates
     * @var     array   $templates      Lists of templates, to return
     */
    public function getTemplatesFromConfig($config, $templates = []){
        foreach($config as $template){
            foreach($template->children as $children){
                $templates[$children->id] = $children;
            }
        }
        return $templates;
    }

    /**
     * Wordpress get screen
     */
    public function getScreen(){
        return Service::getScreen();
    }

}