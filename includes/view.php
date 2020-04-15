<?php

namespace Triangle\Includes;

!defined( 'WPINC ' ) or die;

/**
 * Helper library for Triangle plugins
 *
 * @package    Triangle
 * @subpackage Triangle\Includes
 */

class View {

    /**
     * Provide page information page_title, menu_title, etc
     * @var     object  $page   Page object where the view is located
     */
    protected $page;

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
     * Enable/Disable (Shortcode, etc)
     * @var     array   $options    View options
     */
    protected $options = [];

    /**
     * Page callback - load view
     * @backend
     * @var     object  $page   Page object where the view is located
     * @return  void
     */
    public function build(){
        echo $this->load_content('template/' . $this->template);
    }

    /**
     * Helper to load content
     * @backend
     * @return  content
     */
    public function load_content($content){
        ob_start();
            $path = unserialize(Triangle_PATH);
            include_once $path['view_path'] . str_replace('.','/',$content) . '.php';
        $content = ob_get_clean();
        if(isset($this->options['shortcode']) && $this->options['shortcode']) $content = do_shortcode($content);
        return $content;
    }

    /**
     * @return object
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param object $page
     */
    public function setPage($page)
    {
        $this->page = $page;
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