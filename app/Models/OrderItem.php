<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Order;
use App\Models\ProductVariant;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_variant_id', 'quantity', 'grind_size', 'subtotal_price'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
