<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    BillingAddress,
    Order,
    OrderItem,
    Payment,
    ShippingInformation,
    User
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
        User::factory(5)->create()->each(function ($user) {
            Order::factory(rand(1,3))->create([
                    'user_id' => $user->id
                ])
                ->each(function($order) {
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
            });
    }
}
