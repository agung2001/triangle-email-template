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
     * @var      string    $prev_value   Previous value to check before updating
     */
    protected $prev_value;

    /**
     * @access   protected
     * @var      bool    $unique   Whether the same key should not be added
     */
    protected $unique;

    /**
     * @access   protected
     * @var      bool    $single   	If true, returns only the first value for the specified meta key
     */
    protected $single;

    /**
     * Meta constructor
     * @return void
     */
    public function __construct()
    {
        $this->prev_value = '';
        $this->unique = false;
        $this->single = false;
    }

    /**
     * Retrieves a post meta field for the given post ID.
     * @return array       Will be an array if $single is false. Will be value of the meta field if $single is true
     */
    public function get_post_meta()
    {
        return get_post_meta( $this->type->getID(), $this->key, $this->single );
    }

    /**
     * Adds a meta field to the given post
     * @return int      Meta ID on success, false on failure
     */
    public function add_post_meta()
    {
        return add_post_meta( $this->type->getID(), $this->key, $this->value, $this->unique );
    }

    /**
     * Adds a meta field to the given post
     * @return bool     The new meta field ID if a field with the given key didn't exist and was therefore added, true on successful update, false on failure
     */
    public function update_post_meta()
    {
        return update_post_meta( $this->type->getID(), $this->key, $this->value, $this->prev_value );
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
    public function getPrevValue(): string
    {
        return $this->prev_value;
    }

    /**
     * @param string $prev_value
     */
    public function setPrevValue(string $prev_value): void
    {
        $this->prev_value = $prev_value;
    }

    /**
     * @return bool
     */
    public function isUnique(): bool
    {
        return $this->unique;
    }

    /**
     * @param bool $unique
     */
    public function setUnique(bool $unique): void
    {
        $this->unique = $unique;
    }

    /**
     * @return bool
     */
    public function isSingle(): bool
    {
        return $this->single;
    }

    /**
     * @param bool $single
     */
    public function setSingle(bool $single): void
    {
        $this->single = $single;
    }

}