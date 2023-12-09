<?php

namespace Lib\Database\Entity;

abstract class SaveableObject {
    public int $id;

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