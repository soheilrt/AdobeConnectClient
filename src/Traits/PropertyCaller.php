<?php


namespace AdobeConnectClient\Traits;


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
        if ($this->isCallableGetter($name, $arguments)) {
            return $this->__get($this->getAttributeName($name));
        }
        if ($this->isCallableSetter($name, $arguments)) {
            return $this->__set($this->getAttributeName($name), $arguments[0]);
        }
        throw new BadMethodCallException("Called Method Not Found!");
    }

    /**
     * Determine if called function is getter method and current object has magic getter function
     *
     * @param $name
     * @param $arguments
     * @return bool
     */
    private final function isCallableGetter($name, $arguments)
    {
        return ($this->isMatchWithGetterMethodPattern($name, $arguments) && $this->hasMagicGetter());
    }

    /**
     * Determine if user has called a getter method
     *
     * @param $name
     * @param $arguments
     * @return bool
     */
    private final function isMatchWithGetterMethodPattern($name, $arguments)
    {
        return preg_match("/(?<=^get)(\w+)/m", $name) && count($arguments) == 0;
    }

    /**
     * Determine if current class has magic getter function
     *
     * @return bool
     */
    private final function hasMagicGetter()
    {
        return method_exists($this, "__get");
    }

    /**
     * Extract Attribute Pure Name form Called Method Name
     *
     * @param $name
     * @return mixed
     */
    private final function getAttributeName($name)
    {
        preg_match("/(?<=^get|^set)(\w+)/m", $name, $matches);
        return $matches[0];
    }

    /**
     * Determine if called function if setter method and current object has magic setter function
     * @param $name
     * @param $arguments
     * @return bool
     */
    private final function isCallableSetter($name, $arguments)
    {
        return ($this->isMatchWithSetterMethodPattern($name, $arguments) and $this->hasMagicSetter());
    }

    /**
     * Determine if user called a setter method and passed
     *
     * @param string $name method name
     * @param $arguments
     * @return bool
     */
    private final function isMatchWithSetterMethodPattern($name, $arguments)
    {
        return preg_match("/(?<=^set)(\w+)/m", $name) && count($arguments) == 1;
    }

    /**
     * Determine if current object has magic setter method
     *
     * @return bool
     */
    private final function hasMagicSetter()
    {
        return method_exists($this, "__set");
    }
}
