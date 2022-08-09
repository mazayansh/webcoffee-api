<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'payment_method', 'status', 'total_price'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
        });
    }

    protected function statusTranslated(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                switch ($attributes['status']) {
                    case 'pending':
                        return 'Menunggu Pembayaran';
                        break;
                    
                    case 'settlement':
                        return 'Pembayaran Diterima';
                        break;

                    case 'deny':
                        return 'Pembayaran Ditolak';
                        break;

                    default:
                        return 'Dibatalkan';
                        break;
                }
            },
        );
    }

    protected function orderDate(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return Carbon::parse($attributes['created_at'])->isoFormat('dddd, D MMMM Y HH:mm');
            },
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shipping()
    {
        return $this->morphOne(ShippingInformation::class, 'shippingable');
    }

    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
