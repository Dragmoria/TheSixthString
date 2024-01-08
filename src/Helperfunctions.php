<?php

use Lib\Database\DatabaseContext;
use Lib\Enums\Role;

/**
 * When called with a parameter it will dumb the value of the parameter in a pre tag and then die.
 *
 * @param mixed $value The value to dump.
 * @return void
 */
function dumpDie($value): void
{
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
function dump($value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

function cast($className, array $objectArray)
{
    $object = (object) $objectArray;

    if (!class_exists($className))
        throw new InvalidArgumentException(sprintf('Inexistant class %s.', $className));

    $new = new $className();

    foreach ($object as $property => &$value) {
        $new->$property = &$value;
        unset($object->$property);
    }
    unset($value);
    return $new;
}

function currentRole(): ?Role
{

    if (isset($_SESSION["user"]["role"])) {
        return $_SESSION["user"]["role"];
    }

    return null;
}

function formatPrice(float $price): string
{
    return "€" . number_format($price, 2, ",", ".");
}

function getGUID()
{
    if (function_exists('com_create_guid')) {
        return trim(com_create_guid(), '{}');
    } else {
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
        return $uuid;
    }
}

function checkDatabaseStatus()
{
    $_ = new DatabaseContext();
    $_->checkStatus();
}