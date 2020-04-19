<?php

namespace Triangle\Wordpress;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Triangle
 * @subpackage Triangle/Controller
 */

class MetaBox {

    /**
     * @access   protected
     * @var      string    $args    Unique id
     */
    protected $id;

    /**
     * @access   protected
     * @var      string    $title    Box title
     */
    protected $title;

    /**
     * @access   protected
     * @var      array    $callback  Content callback, must be of type callable
     */
    protected $callback;

    /**
     * @access   protected
     * @var      string    $screen  Post type
     */
    protected $screen;

    /**
     * Meta boxes are handy, flexible, modular edit screen elements that can be used to collect information related to the post being edited.
     * @backend
     * @return  void
     */
    public function add_meta_box(){
        add_meta_box(
            $this->id,
            $this->title,
            $this->callback,
            $this->screen
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function getCallback(): array
    {
        return $this->callback;
    }

    /**
     * @param array $callback
     */
    public function setCallback(array $callback): void
    {
        $this->callback = $callback;
    }

    /**
     * @return string
     */
    public function getScreen(): string
    {
        return $this->screen;
    }

    /**
     * @param string $screen
     */
    public function setScreen(string $screen): void
    {
        $this->screen = $screen;
    }

}