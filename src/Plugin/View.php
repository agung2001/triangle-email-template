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
     * @var      array    $sections    	Lists of view path callback to load
     */
    protected $sections;

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
     * View constructor
     * @return void
     */
    public function addData($data){
        foreach($data as $key => $value) $this->data[$key] = $value;
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
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param array $sections
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
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
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
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