<?php

namespace Lib\MVCCore;

/**
 * Ensures that all components have a get method.
 * 
 * @package Lib\MVCCore
 */
interface Component {
    /**
     * Will be used to render the component html inside a view.
     *
     * @return string
     */
    public function get(): string;
}