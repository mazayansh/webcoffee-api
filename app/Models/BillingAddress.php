<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'first_name', 'last_name', 'phone', 'address', 'city', 'state', 'postcode'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
