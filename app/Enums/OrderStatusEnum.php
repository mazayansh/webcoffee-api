<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case SETTLEMENT = 'settlement';
    case PENDING = 'pending';
    case EXPIRE = 'expire';
    case CANCEL = 'cancel';
    case DENY = 'deny';
}
