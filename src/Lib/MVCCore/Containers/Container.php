<?php

namespace Lib\MVCCore\Containers;

use \Exception;

/**
 * Container class. This is where all the services are registered and resolved.
 * Enforced singleton pattern.
 * 
 * @package Lib\MVCCore
 */
class Container
{
    /**
     * Array that holds all the registrations.
     *
     * @var array
     */
    private array $registrations = [];
    /**
     * Array that holds all the instances. Used for singleton registrations.
     *
     * @var array
     */
    private array $instances = [];

    /**
     * Registers a new interface to a class.
     *
     * @param string $interfaceName Fully qualified name of the interface.
     * @param string $className Fully qualified name of the class.
     * @return Registration Returns the registration so that it can be chained.
     */
    public function registerInterface(string $interfaceName, string $className): Registration
    {
        // Check if the interface name already has a registration
        if (array_key_exists($interfaceName, $this->registrations)) {
            throw new Exception("The name of {$interfaceName} already has a registration.");
        }

        // Adds a new registration to the registrations array
        $this->registrations[$interfaceName] = new Registration($className);
        // Returns the last element of the registrations array for chaining
        return end($this->registrations);
    }

    /**
     * Registers a class. The class name is used as the name of the registration.
     *
     * @param string $className Fully qualified name of the class.
     * @return Registration Returns the registration so that it can be chained.
     */
    public function registerClass(string $className): Registration
    {
        // Check if the class name already has a registration
        if (array_key_exists($className, $this->registrations)) {
            throw new Exception("The name of {$className} already has a registration.");
        }

        // Adds a new registration to the registrations array
        $this->registrations[$className] = new Registration($className);
        // Returns the last element of the registrations array for chaining
        return end($this->registrations);
    }

    /**
     * Resolve a registration. 
     *
     * @param string $target Fully qualified name of the registration.
     * @return mixed Returns the resolved registration.
     */
    public function resolve(string $target): mixed
    {
        // Check if the target has a registration
        if (!array_key_exists($target, $this->registrations)) {
            throw new Exception("No matching binding found for {$target}");
        }

        /** @var Registration $registration */
        $registration = $this->registrations[$target];

        // Check if the registration is a singleton
        if ($registration->lifeTime === Lifetime::Singleton) {
            // Check if the instance doesn't exists yet
            if (!array_key_exists($target, $this->instances)) {
                // Create a new instance and add it to the instances array
                $this->instances[$target] = call_user_func($registration->resolver);
            }
            // Return the instance
            return $this->instances[$target];
        }
        // Return a new instance since it's a transient registration
        return call_user_func($registration->resolver);
    }


    // region Singleton pattern
    // singleton pattern is a way to enforce that only one instance of a class is created. If you still try to call new on the class, you will get an exception.
    private static ?Container $instance = null;

    // blocks the use of new
    private function __construct()
    {
    }

    public static function getInstance(): Container
    {
        if (self::$instance === null) {
            self::$instance = new Container();
        }

        return self::$instance;
    }

    // blocks the use of clone
    private function __clone()
    {
        throw new Exception("Cannot clone a singleton instance.");
    }
    // endregion Singleton pattern
}
