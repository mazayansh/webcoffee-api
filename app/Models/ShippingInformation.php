<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Order;

class ShippingInformation extends Model
{
    use HasFactory;

    protected $table = 'shipping_informations';

    protected $fillable = [
        'shippingable_type',
        'shippingable_id',
        'email',
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'city_code',
        'state',
        'postcode',
        'shipping_method',
        'shipping_cost'
    ];

    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return $attributes['first_name'].' '.$attributes['last_name'];
            },
        );
    }

    public function shippingable()
    {
        return $this->morphTo();
    }
}
