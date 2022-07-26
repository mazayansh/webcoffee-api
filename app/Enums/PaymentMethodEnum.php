<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case BNI = 'bni';
    case BCA = 'bca';
    case BRI = 'bri';
    case MANDIRI = 'mandiri';
    case PERMATA = 'permata';

    public static function random(): string
    {
        return self::cases()[array_rand(self::cases())]->value;
    }
}
