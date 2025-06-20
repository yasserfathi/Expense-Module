<?php

namespace App\Modules\Expenses\Enums;

enum Category: string
{
    case CAT1 = 'cat1';
    case CAT2 = 'cat2';
    case CAT3 = 'cat3';
    case OTHER = 'other';
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}