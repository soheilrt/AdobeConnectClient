<?php


namespace AdobeConnectClient\Traits;


use AdobeConnectClient\Helpers\StringCaseTransform as SCT;
use BadMethodCallException;

trait PropertyCaller
{
    /**
     * magic caller method for on fly attribute setting or getting as function
     *
     * @param $name
     * @param $arguments
     * @return static
     */
    public function __call($name, $arguments)
    {
        if ($this->callGetter($name, $arguments) && method_exists($this, "__get")) {
            $name = SCT::toCamelCase($this->getPureNameOfCaller($name));
            return $this->__get($name);
        } else if ($this->callSetter($name, $arguments) && method_exists($this, "__set")) {
            return $this->__set($this->getPureNameOfCaller($name), $arguments[0]);
        }
        throw new BadMethodCallException("Called Method Not Found!");
    }


    /**
     * Determine if user has called a getter method
     *
     * @param $name
     * @param $arguments
     * @return bool
     */
    private final function callGetter($name, $arguments)
    {
        return preg_match("/(?<=^get)(\w+)/m", $name) && count($arguments) == 0;
    }

    /**
     * Extract Attribute Pure Name form Called Method Name
     *
     * @param $name
     * @return mixed
     */
    private final function getPureNameOfCaller($name)
    {
        preg_match("/(?<=^get|^set)(\w+)/m", $name, $matches);
        return $matches[0];
    }

    /**
     * Determine if user called a setter method
     *
     * @param $name
     * @param $arguments
     * @return bool
     */
    private final function callSetter($name, $arguments)
    {
        return preg_match("/(?<=^set)(\w+)/m", $name) && count($arguments) == 1;
    }
}