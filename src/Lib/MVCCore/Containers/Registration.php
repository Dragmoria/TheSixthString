<?php

namespace Lib\MVCCore\Containers;

/**
 * Class that represents a registration. Is used to chain methods of the container.
 * 
 * @package Lib\MVCCore
 */
class Registration
{
    /**
     * Represents the lifetime of the registration.
     *
     * @var Lifetime
     */
    public Lifetime $lifeTime;
    /**
     * Represents the class name of the registration.
     *
     * @var string
     */
    public string $className;
    /**
     * Holds a resolver function of the registration.
     *
     * @var [type]
     */
    public $resolver;

    /**
     * Creates a basic registration. The registration is transient by default. Adds a resolver function that will create a new instance of the class.
     * 
     * @param string $toRegisterClassName Fully qualified class name of the registration.
     */
    public function __construct(string $toRegisterClassName)
    {
        $this->lifeTime = Lifetime::Transient;
        $this->className = $toRegisterClassName;

        $this->resolver = function () use ($toRegisterClassName) {
            return new $toRegisterClassName;
        };
    }

    /**
     * Sets the registration to transient.
     *
     * @return Registration Returns the registration so that it can be chained.
     */
    public function asTransient(): Registration
    {
        $this->lifeTime = Lifetime::Transient;
        return $this;
    }

    /**
     * Sets the registration to singleton.
     *
     * @return Registration Returns the registration so that it can be chained.
     */
    public function asSingleton(): Registration
    {
        $this->lifeTime = Lifetime::Singleton;
        return $this;
    }

    /**
     * Overwrites the resolver function of the registration.
     *
     * @param callable $resolver Resolver function.
     * @return void
     */
    public function setResolver(callable $resolver): void
    {
        $this->resolver = $resolver;
    }
}
