<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Order;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'transaction_id', 'transaction_time', 'payment_type', 'bank', 'va_number', 'pdf_url', 'bill_key', 'biller_code'
    ];

    protected function paymentMethod(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                switch ($attributes['bank']) {
                    case 'bri':
                        return 'BRI Virtual Account';
                        break;
                    
                    case 'bni':
                        return 'BNI Virtual Account';
                        break;

                    case 'bca':
                        return 'BCA Virtual Account';
                        break;

                    case 'mandiri':
                        return 'Mandiri Bill Payment';
                        break;

                    case 'permata':
                        return 'Permata Virtual Account';
                        break;
                }
            },
        );
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
