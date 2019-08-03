<?php


namespace AdobeConnectClient\Traits;


use AdobeConnectClient\Helpers\StringCaseTransform as SCT;

trait Setter
{
    /**
     * store properties which has not property in parent class
     */
    protected $attributes = [];


    /**
     * magic getter function for attributes that don't exist or inaccessible
     *
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (method_exists($this, $getter = 'get' . SCT::toUpperCamelCase($name))) {
            return $this->$getter();
        } else {
            $attribute = SCT::toCamelCase($name);
            if (property_exists($this, $attribute)) {
                return $this->$name;
            } else {
                return isset($this->attributes[$attribute]) ? $this->attributes[$attribute] : null;
            }
        }
    }

    /**
     * magic setter function for attributes that don't exist or inaccessible
     *
     * @param $name
     * @param $value
     * @return static
     */
    public function __set($name, $value)
    {
        $setter = 'set' . SCT::toUpperCamelCase($name);
        if (method_exists($this, $setter)) {
            $this->$setter($value);
            return $this;
        } else {
            $this->attributes[SCT::toCamelCase($name)] = $value;
            return $this;
        }
    }
}
