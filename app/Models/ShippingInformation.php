<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class ShippingInformation extends Model
{
    use HasFactory;

    protected $table = 'shipping_informations';

    protected $fillable = [
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

    public function shippingable()
    {
        return $this->morphTo();
    }
}
