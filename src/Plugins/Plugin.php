<?php

namespace Triangle;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle\Includes
 */

use Triangle\Wordpress\Service;

class Plugins {

    /**
     * Plugin name
     * @var     string
     */
    protected $name;

    /**
     * Plugin version
     * @var     string
     */
    protected $version;

    /**
     * Plugin stage (0 = development, 1 = production)
     * @var     bool
     */
    protected $stage;

    /**
     * Enable/Disable plugins hook (Action, Filter, Shortcode)
     * @var     array   ['action', 'filter', 'shortcode']
     */
    protected $enableHooks;

    /**
     * Plugin path
     * @var     string
     */
    protected $path;

    /**
     * Plugin path
     * @var     string
     */
    protected $helper;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and that can be used throughout the plugin.
     * Load the dependencies, and set the hooks for backend and frontend.
     *
     * @param   array   $path     Wordpress plugin path
     * @return void
     */
    public function __construct($path){
        $this->enableHooks = ['action', 'filter', 'shortcode'];
        $this->path = Service::getPath($path);
        $this->helper = new Helper();
    }

    /**
     * Load hook in a api
     * @return void
     */
    public function load_api(){
        $this->load_hooks('api');
    }

    /**
     * Load hook in a controller
     * @return void
     */
    public function load_controller(){
        $this->load_hooks('controller');
    }

    /**
     * Load registered hooks in a controller
     * @return  void
     * @var     string  $dir   plugin hooks directory (Api, Controller)
     * @pattern bridge
     */
    private function load_hooks($dir){
        $controllers = $this->helper->getDirFiles($this->path['plugin_path'] . 'src/' . $dir);
        $allow = ['.', '..','.DS_Store','index.php','BaseController.php'];
        foreach($controllers as $controller){
            if(in_array(basename($controller), $allow)) continue;
            $controller = '\\Triangle\\'.ucwords($dir).'\\'.basename( $controller, '.php' );
            $controller = new $controller($this);
            foreach($controller->getHooks() as $hook){
                $class = str_replace( 'Triangle\\Wordpress\\' , '', get_class($hook) );
                if(in_array(strtolower($class), $this->enableHooks)) $hook->run();
            }
        }
    }

    /**
     * Load registered models
     * @return  void
     */
    public function load_model(){
        $models = scandir( $this->path['plugin_path'] . 'src/model/' );
        $models = array_diff($models, array('.', '..','.DS_Store','index.php','Model.php'));
        foreach($models as $model){
            $model = '\\Triangle\\Model\\'.basename( $model, '.php' );
            new $model($this);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        define('TRIANGLE_NAME', $name);
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
        define('TRIANGLE_VERSION', $version);
    }

    /**
     * @return bool
     */
    public function isStage()
    {
        return $this->stage;
    }

    /**
     * @param bool $stage
     */
    public function setStage($stage)
    {
        $this->stage = $stage;
        define('TRIANGLE_STAGE', $stage);
    }

    /**
     * @return array
     */
    public function getEnableHooks()
    {
        return $this->enableHooks;
    }

    /**
     * @param array $enableHooks
     */
    public function setEnableHooks($enableHooks)
    {
        $this->enableHooks = $enableHooks;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

}