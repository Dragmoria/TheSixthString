<?php

/**
 * When called with a parameter it will dumb the value of the parameter in a pre tag and then die.
 *
 * @param mixed $value The value to dump.
 * @return void
 */
function dumpDie($value): void {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

/**
 * When called with a parameter it will dump the value of the parameter in a pre tag.
 *
 * @param mixed $value The value to dump.
 * @return void
 */
function dump($value): void {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

function cast($className, array $objectArray) {
    $object = (object)$objectArray;

    if (!class_exists($className))
        throw new InvalidArgumentException(sprintf('Inexistant class %s.', $className));

    $new = new $className();

    foreach($object as $property => &$value)
    {
        $new->$property = &$value;
        unset($object->$property);
    }
    unset($value);
    return $new;
}