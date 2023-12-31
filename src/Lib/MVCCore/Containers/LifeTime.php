<?php

namespace Lib\MVCCore\Containers;

/**
 * Enum of lifetime types.
 * 
 * @package Lib\MVCCore
 */
enum LifeTime
{
    /**
     * Every request resolves the same instance.
     */
    case Singleton;
    /**
     * Every request resolves a new instance.
     */
    case Transient;
}
