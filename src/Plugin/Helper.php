<?php

namespace Triangle;

!defined( 'WPINC ' ) or die;

/**
 * Helper library for Triangle plugins
 *
 * @package    Triangle
 * @subpackage Triangle\Includes
 */

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

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
     * Get files within directory
     * @var     string  $slug   EmailTemplate slug = post name slug
     * @var     string  $html   Html content template
     * @var     string  $css    CSS content template
     * @return  void
     */
    public function buildEmailTemplate($slug, $html, $css) {
        $path = unserialize(TRIANGLE_PATH);
        $dir = $path['upload_dir']['basedir'] . '/EmailTemplate/' . $slug;
        if(!is_dir($dir)) mkdir($dir, 0755, true);
        file_put_contents($dir . '/' . $slug . '.html', stripslashes($html));
        file_put_contents($dir . '/' . $slug . '.css', stripslashes($css));
        if(file_exists($dir . '/standard.html')) unlink($dir . '/standard.html');
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
     * Build inline style html script
     */
    public function standardizeEmailTemplate($slug){
        $path = unserialize(TRIANGLE_PATH);
        $dir = $path['upload_dir']['basedir'] . '/EmailTemplate/' . $slug;
        if(is_dir($dir)){
            /** Get Contents */
            $html = file_get_contents($dir . '/' . $slug . '.html');
            $css = file_get_contents($dir . '/' . $slug . '.css');
            /** Standarize */
            $tool = new CssToInlineStyles();
            $standard = $this->inspectorEmailTemplate($tool, $html, $css, 10);
            if($standard) file_put_contents($dir . '/standard.html', $standard);
        } else return false;
    }

    /**
     * Email template inspector, inline css file into html body
     * @var     string  $html       HTML Template Content
     * @var     string  $css        Style Template Content
     * @var     int     $counter    Counter repeater
     */
    private function inspectorEmailTemplate($tool, $html, $css, $counter){
        ob_start();
            echo $tool->convert( $html, $css );
        $clean = ob_get_clean();
        if(strlen($clean)==1 && $counter>0) {
            sleep(2); $counter--;
            $clean = $this->inspectorEmailTemplate($tool, $html, $css, $counter);
        }
        return $clean;
    }

}