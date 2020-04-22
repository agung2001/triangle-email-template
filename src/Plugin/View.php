<?php

namespace Triangle;

!defined( 'WPINC ' ) or die;

/**
 * Helper library for Triangle plugins
 *
 * @package    Triangle
 * @subpackage Triangle\Includes
 */

use Triangle\Helper;

class View {

    /**
     * Provide page information page_title, menu_title, etc
     * @var     object  $Page   Page object where the view is located
     */
    protected $Page;

    /**
     * @var     object  $Helper   Helper object for view
     */
    protected $Helper;

    /**
     * @access   protected
     * @var      string    $view    	View path callback to load
     */
    protected $view;

    /**
     * @access   protected
     * @var      string    $template    	View template callback to load
     */
    protected $template;

    /**
     * View data send from the controller
     * @var     array   $data    View data
     */
    protected $data;

    /**
     * Enable/Disable (Shortcode, etc)
     * @var     array   $options    View options
     */
    protected $options;

    /**
     * View constructor
     * @return void
     */
    public function __construct()
    {
        $this->Helper = new Helper();
        $this->data = [];
        $this->options = [];
    }

    /**
     * Overloading Method, for multiple arguments
     * @method  setData     _ Set view data
     * @method  build       _ Set build method
     */
    public function __call($method, $arguments){
        if($method=='setData'){
            if (count($arguments) == 1) $this->data = array_merge($this->data, $arguments);
            if (count($arguments) == 2) $this->data[$arguments[0]] = $arguments[1];
        }
    }

    /**
     * Helper to load content
     * @backend
     * @return  content
     */
    public function loadContent($content, $args = []){
        ob_start();
            extract($this->data);
            $path = unserialize(TRIANGLE_PATH);
            require $path['view_path'] . str_replace('.','/',$content) . '.php';
        $content = ob_get_clean();
        if(isset($this->options['shortcode']) && $this->options['shortcode']) $content = do_shortcode($content);
        return $content;
    }

    /**
     * Build view
     * @return  void
     */
    public function build(){
        echo $this->loadContent('Template/' . $this->template);
//        echo $this->loadContent('Frontend.support-cloud');
    }

    /**
     * @return object
     */
    public function getPage()
    {
        return $this->Page;
    }

    /**
     * @param object $Page
     */
    public function setPage($Page)
    {
        $this->Page = $Page;
    }

    /**
     * @return object
     */
    public function getHelper()
    {
        return $this->Helper;
    }

    /**
     * @param object $Helper
     */
    public function setHelper($Helper)
    {
        $this->Helper = $Helper;
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param string $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

}