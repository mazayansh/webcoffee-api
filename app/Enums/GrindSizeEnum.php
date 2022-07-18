<?php

namespace App\Enums;

enum GrindSizeEnum: string
{
    case SUPERFINE = 'superfine';
    case FINE = 'fine';
    case MEDIUM_FINE = 'medium fine';
    case MEDIUM = 'medium';
    case COARSE = 'coarse';
    case EXTRACOARSE = 'extracoarse';

    public static function random(): string
    {
        return self::cases()[array_rand(self::cases())]->value;
    }
}