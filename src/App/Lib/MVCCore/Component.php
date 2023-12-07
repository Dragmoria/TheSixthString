<?php

namespace Lib\MVCCore;

/**
 * Ensures that all components have a get method.
 * 
 * @package Lib\MVCCore
 */
interface Component {
     /**
      * Undocumented function
      *
      * @param array|null $data Data to pass to the component.
      * @return string
      */
    public function get(?array $data): string;
}