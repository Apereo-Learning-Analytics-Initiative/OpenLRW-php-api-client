<?php

/**
 *
 * Model class
 *
 * @copyright Apereo
 * @category OpenLRW
 * @package  Entity
 * @author   Xavier Chopin <bonjour@xavierchop.in>
 * @license  http://www.osedu.org/licenses/ECL-2.0 ECL-2.0 License
 */

namespace OpenLRW\Model;

abstract class Model
{

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = array();


    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'sourcedId';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array();


    /**
     * Create a new model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = array())
    {
        $this->fill($attributes);
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     */
    public function fill(array $attributes)
    {
        foreach ($this->fillableFromArray($attributes) as $key => $value)
        {
                $this->setAttribute($key, $value);
        }
        return $this;
    }

    /**
     * Get the fillable attributes of a given array.
     *
     * @param  array  $attributes
     * @return array
     */
    protected function fillableFromArray(array $attributes)
    {
        if (count($this->fillable) > 0)
        {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }
        return $attributes;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function setAttribute($key, $value)
    {
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set on
        // the model, such as "json_encoding" an listing of data for storage.
        if ($this->hasSetMutator($key)) {
            $method = 'set'.$this->studly_case($key).'Attribute';
            return $this->{$method}($value);
        }


        $this->attributes[$key] = $value;
    }


    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasSetMutator($key)
    {
        return method_exists($this, 'set'.$this->studly_case($key).'Attribute');
    }

    /**
    * Convert a value to studly caps case.
    *
    * @param  string  $value
    * @return string
    */
    public function studly_case($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        return str_replace(' ', '', $value);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }


    /**
     * Convert the model instance to JSON.
     *
     * @param  int $options
     * @return string
     *
     */
    public function toJson($options = 0)
    {
        return json_encode($this->attributes, $options);
    }



    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }


    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasGetMutator($key)
    {
        return method_exists($this, 'get'.$this->studly_case($key).'Attribute');
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (! $key) {
            return;
        }
        // If the attribute exists in the attribute array or has a "get" mutator we will
        // get the attribute's value. Otherwise, we will proceed as if the developers
        // are asking for a relationship's value. This covers both types of values.
        if (array_key_exists($key, $this->attributes) ||
            $this->hasGetMutator($key)) {
            return $this->getAttributeValue($key);
        }
        // Here we will determine if the model base class itself contains this given key
        // since we don't want to treat any of those methods as relationships because
        // they are all intended as helper methods and none of these are relations.
        if (method_exists(self::class, $key)) {
            return;
        }
    }


    /**
     * Get a plain attribute (not a relationship).
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        return $this->attributes[$key];
    }

    /**
     * Get the value of the model's primary key.
     * @return mixed
     */
    public function getPrimaryKeyValue()
    {
        return $this->getAttributeValue($this->primaryKey);
    }


    /**
     * Handle dynamic method calls into the model.
     *
     * @param $attribute
     * @param $method
     * @return mixed
     */
    public function __call($attribute, $method)
    {
        return $this->attributes[$attribute];
    }


}