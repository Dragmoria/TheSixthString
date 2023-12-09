<?php

namespace Lib\Database\Entity;

abstract class SaveableObject {
    public string $tableName;
    public int $id = 0;

    public function isEmptyObject(): bool {
        foreach((array)$this as $property) {
            if(!empty($property)) {
                return false;
            }
        }

        return true;
    }

    public function getCurrentDateAsString(string $format): string {
        $currentDate = new \DateTime();
        return $currentDate->format($format);
    }
}