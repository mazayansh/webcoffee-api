<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    Order,
    OrderItem,
    ShippingInformation,
    BillingAddress,
    Payment
};

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory(5)->create()->each(function($order) {
            OrderItem::factory(rand(1,4))->create([
                'order_id' => $order->id
            ]);
    
            ShippingInformation::factory()->create([
                'shippingable_type' => 'App\Models\Order',
                'shippingable_id'  => $order->id
            ]);
    
            BillingAddress::factory()->create([
                'order_id' => $order->id
            ]);
    
            Payment::factory()->create([
                'order_id' => $order->id
            ]);
        });
    }
}
