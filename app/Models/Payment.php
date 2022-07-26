<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Order;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'transaction_id', 'transaction_time', 'payment_type', 'va_number', 'pdf_url', 'bill_key', 'biller_code'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
