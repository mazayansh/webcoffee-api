<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_variants')->insert([
            [
                'product_id' => 1,
                'weight' => '250',
                'price' => mt_rand(37000, 54000),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 1,
                'weight' => '500',
                'price' => mt_rand(59500, 68500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 1,
                'weight' => '1000',
                'price' => mt_rand(71000, 83500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 2,
                'weight' => '250',
                'price' => mt_rand(37000, 54000),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 2,
                'weight' => '500',
                'price' => mt_rand(59500, 68500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 2,
                'weight' => '1000',
                'price' => mt_rand(71000, 83500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 3,
                'weight' => '250',
                'price' => mt_rand(37000, 54000),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 3,
                'weight' => '500',
                'price' => mt_rand(59500, 68500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 4,
                'weight' => '250',
                'price' => mt_rand(37000, 54000),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 4,
                'weight' => '1000',
                'price' => mt_rand(71000, 83500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 5,
                'weight' => '500',
                'price' => mt_rand(59500, 68500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 5,
                'weight' => '1000',
                'price' => mt_rand(71000, 83500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 6,
                'weight' => '250',
                'price' => mt_rand(37000, 54000),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 6,
                'weight' => '500',
                'price' => mt_rand(59500, 68500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 7,
                'weight' => '250',
                'price' => mt_rand(37000, 54000),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 7,
                'weight' => '500',
                'price' => mt_rand(59500, 68500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 7,
                'weight' => '1000',
                'price' => mt_rand(71000, 83500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 8,
                'weight' => '250',
                'price' => mt_rand(37000, 54000),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 8,
                'weight' => '500',
                'price' => mt_rand(59500, 68500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 8,
                'weight' => '1000',
                'price' => mt_rand(71000, 83500),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 9,
                'weight' => '250',
                'price' => mt_rand(37000, 54000),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 9,
                'weight' => '500',
                'price' => mt_rand(59500, 68500),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
