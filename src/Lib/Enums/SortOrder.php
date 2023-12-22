<?php

namespace Lib\Enums;

enum SortOrder: string
{
    case Asc = 'asc';
    case Desc = 'desc';

    public function toString()
    {
        switch ($this->value) {
            case 'asc':
                return "Ascending";
            case 'desc':
                return "Descending";
            default:
                return "Unknown";
        }
    }
}
