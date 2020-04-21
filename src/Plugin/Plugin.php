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

class Plugin {

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
     * Plugin stage (true = production, false = development)
     * @var     boolean
     */
    protected $production;

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
     * Lists of plugin controllers
     * @var     object
     */
    protected $api;

    /**
     * Lists of plugin controllers
     * @var     array
     */
    protected $controllers;

    /**
     * Lists of plugin models
     * @var     array
     */
    protected $models;

    /**
     * Plugin configuration
     * @var     object
     */
    protected $config;

    /**
     * Define the core functionality of the plugin.
     *
     * @param   array   $path     Wordpress plugin path
     * @return void
     */
    public function __construct($config){
        $this->name = $config->name;
        $this->version = $config->version;
        $this->production = $config->production;
        $this->enableHooks = $config->enableHooks;
        $this->controllers = [];
        $this->models = [];
        $this->path = Service::getPath($config->path);
        $this->config = $config;
    }

    /**
     * Run the plugin
     * - Load plugin model
     * - Load plugin API
     * - Load plugin controller
     * @return  void
     */
    public function run(){
        Helper::defineConst($this);
        $this->loadModels();
        $this->loadHooks('Controller');
        $this->loadHooks('Api');
    }

    /**
     * Load registered models
     * @return  void
     */
    public function loadModels(){
        $models = Helper::getDirFiles($this->path['plugin_path'] . 'src/Model');
        $allow = ['.', '..','.DS_Store','index.php'];
        foreach($models as $model){
            if(in_array(basename($model), $allow)) continue;
            $name = basename( $model, '.php' );
            $model = '\\Triangle\\Model\\'.$name;
            $model = new $model($this);
            $model->build();
            $this->models[$name] = $model;
            foreach($model->getHooks() as $hook){
                $class = str_replace( 'Triangle\\Wordpress\\' , '', get_class($hook) );
                if(in_array(strtolower($class), $this->enableHooks)) $hook->run();
            }
        }
    }

    /**
     * Load registered hooks in a controller
     * @return  void
     * @var     string  $dir   plugin hooks directory (API, Controller)
     * @pattern bridge
     */
    private function loadHooks($dir){
        $controllers = Helper::getDirFiles($this->path['plugin_path'] . 'src/' . $dir);
        $allow = ['.', '..','.DS_Store','index.php'];
        foreach($controllers as $controller){
            if(in_array(basename($controller), $allow)) continue;
            $name = basename( $controller, '.php' );
            $controller = '\\Triangle\\'.ucwords($dir).'\\'.$name;
            $controller = new $controller($this);
            $this->controllers[$name] = $controller;
            foreach($controller->getHooks() as $hook){
                $class = str_replace( 'Triangle\\Wordpress\\' , '', get_class($hook) );
                if(in_array(strtolower($class), $this->enableHooks)) $hook->run();
            }
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return bool
     */
    public function isProduction(): bool
    {
        return $this->production;
    }

    /**
     * @param bool $production
     */
    public function setProduction(bool $production): void
    {
        $this->production = $production;
    }

    /**
     * @return array
     */
    public function getEnableHooks(): array
    {
        return $this->enableHooks;
    }

    /**
     * @param array $enableHooks
     */
    public function setEnableHooks(array $enableHooks): void
    {
        $this->enableHooks = $enableHooks;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return object
     */
    public function getApi(): object
    {
        return $this->api;
    }

    /**
     * @param object $api
     */
    public function setApi(object $api): void
    {
        $this->api = $api;
    }

    /**
     * @return array
     */
    public function getControllers(): array
    {
        return $this->controllers;
    }

    /**
     * @param array $controllers
     */
    public function setControllers(array $controllers): void
    {
        $this->controllers = $controllers;
    }

    /**
     * @return array
     */
    public function getModels(): array
    {
        return $this->models;
    }

    /**
     * @param array $models
     */
    public function setModels(array $models): void
    {
        $this->models = $models;
    }

    /**
     * @return object
     */
    public function getConfig(): object
    {
        return $this->config;
    }

    /**
     * @param object $config
     */
    public function setConfig(object $config): void
    {
        $this->config = $config;
    }

}