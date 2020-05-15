<?php

namespace Triangle\Wordpress;

!defined( 'WPINC ' ) or die;

/**
 * Abstract class for wordpress model
 *
 * @package    Triangle
 * @subpackage Triangle\Includes\Wordpress
 */

class Meta {

    /**
     * @access   protected
     * @var      object    $type     Post Type Object
     */
    protected $type;

    /**
     * @access   protected
     * @var      string    $key     Metadata key
     */
    protected $key;

    /**
     * @access   protected
     * @var      string    $value   Metadata value
     */
    protected $value;

    /**
     * @access   protected
     * @var      string    $args   Generalize metadata arguments
     */
    protected $args;

    /**
     * Metadata constructor
     */
    public function __construct(){
        $this->args = [];
    }

    /**
     * Clear args for the next function call - dynamic args usage
     */
    public function clearArgs($data){ $this->args = []; return $data; }

    /**
     * Retrieves a post meta field for the given post ID.
     * @var      bool    $single   	If true, returns only the first value for the specified meta key
     * @return array       Will be an array if $single is false. Will be value of the meta field if $single is true
     */
    public function get_post_meta()
    {
        $this->args['single'] = (!isset($this->args['single']) || !is_bool($this->args['single'])) ? false : $this->args['single'];
        return $this->clearArgs(get_post_meta( $this->type->getID(), $this->key, $this->args['single'] ));
    }

    /**
     * Adds a meta field to the given post
     * @var      bool    $unique   Whether the same key should not be added
     * @return int      Meta ID on success, false on failure
     */
    public function add_post_meta()
    {
        $this->args['unque'] = (!isset($this->args['unque']) || !is_bool($this->args['unique'])) ? false : $this->args['unque'];
        return $this->clearArgs(add_post_meta( $this->type->getID(), $this->key, $this->value, $this->args['unique'] ));
    }

    /**
     * Adds a meta field to the given post
     * @var      string    $prev_value   Previous value to check before updating
     * @return bool     The new meta field ID if a field with the given key didn't exist and was therefore added, true on successful update, false on failure
     */
    public function update_post_meta()
    {
        $this->args['prev_value'] = (!isset($this->args['prev_value']) || !is_bool($this->args['prev_value'])) ? false : $this->args['prev_value'];
        return $this->clearArgs(update_post_meta( $this->type->getID(), $this->key, $this->value, $this->args['prev_value'] ));
    }

    /**
     * @return object
     */
    public function getType(): object
    {
        return $this->type;
    }

    /**
     * @param object $type
     */
    public function setType(object $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @param string $args
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }

}