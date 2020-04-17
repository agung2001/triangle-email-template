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
     * @var      array    $taxonomies    Taxonomies array trees
     */
    protected $taxonomies = [];

    /**
     * Get Post Type
     */
    public function get_all(){
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
     * @return array
     */
    public function getTaxonomies()
    {
        return $this->taxonomies;
    }

    /**
     * @param array $taxonomies
     */
    public function setTaxonomies($taxonomies)
    {
        $this->taxonomies = $taxonomies;
    }

}