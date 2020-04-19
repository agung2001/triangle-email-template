<?php

namespace Triangle\Wordpress;

!defined( 'WPINC ' ) or die;

/**
 * Abstract class for wordpress model
 *
 * @package    Triangle
 * @subpackage Triangle\Includes\Wordpress
 */

class Type extends Model {

    /**
     * @access   protected
     * @var      int    $ID    Post ID
     */
    protected $ID;

    /**
     * @access   protected
     * @var      array    $metas    Lists of post type metas
     */
    protected $metas;

    /**
     * @access   protected
     * @var      array    $taxonomies    Taxonomies array trees
     */
    protected $taxonomies;

    /**
     * @access   protected
     * @var      array    $hooks    Lists of hooks to register within model
     */
    protected $hooks;

    /**
     * Construct type
     * @return void
     * @var    object $plugin Plugin configuration
     * @pattern prototype
     */
    public function __construct($plugin)
    {
        $this->name = substr(strrchr(get_called_class(), "\\"), 1);
        $this->name = strtolower($this->name);
        $this->taxonomies = [];
        $this->hooks = [];
        $this->metas = [];
        $this->args = [];
        $this->args['public'] = true;
        $this->args['labels'] = ['name' => ucwords($this->name)];
    }

    /**
     * Get Post Type
     * @return object   Post Type object
     */
    public function get_posts(){
        return get_posts($this->args);
    }

    /**
     * Method to model
     * @return void
     */
    public function build(){
        $this->args['taxonomies'] = array_keys($this->taxonomies);
        register_post_type($this->name, $this->args);
        foreach($this->taxonomies as $taxonomy){
            $taxonomy->setType($this);
            $taxonomy->build();
        }
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @param int $ID
     */
    public function setID(int $ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @return array
     */
    public function getMetas(): array
    {
        return $this->metas;
    }

    /**
     * @param array $metas
     */
    public function setMetas(array $metas): void
    {
        $this->metas = $metas;
    }

    /**
     * @return array
     */
    public function getTaxonomies(): array
    {
        return $this->taxonomies;
    }

    /**
     * @param array $taxonomies
     */
    public function setTaxonomies(array $taxonomies): void
    {
        $this->taxonomies = $taxonomies;
    }

    /**
     * @return array
     */
    public function getHooks(): array
    {
        return $this->hooks;
    }

    /**
     * @param array $hooks
     */
    public function setHooks(array $hooks): void
    {
        $this->hooks = $hooks;
    }

}