<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('medias')->insert([
            [
                'product_id' => 1,
                'name' => 'Bali Blue Moon Dark Roast Coffee Bean',
                'path' => '/images/products/Bali-Blue-Moon-Dark-Roast-Coffee-Coffee-Bean-_-Tea-Leaf-Store-1619088898_540x.jpg',
                'type' => 'image',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 2,
                'name' => 'Brazil Cerrado Coffee',
                'path' => '/images/products/brazil-cerrado-coffee-1lb-whole-bean_540x.jpg',
                'type' => 'image',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 3,
                'name' => 'Decaf Espresso Roast Coffe',
                'path' => '/images/products/decaf-espresso-roast-coffee-1lb-whole-bean_540x.jpg',
                'type' => 'image',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 4,
                'name' => 'Brazil Cerrado Light Coffee',
                'path' => '/images/products/brazil-cerrado-coffee-1lb-whole-bean_540x.jpg',
                'type' => 'image',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 5,
                'name' => 'Costa Rica La Minta Reserve Coffee',
                'path' => '/images/products/costa-rica-la-minita-reserve-coffee-8oz-whole-bean_540x.jpg',
                'type' => 'image',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 6,
                'name' => 'Jamaica Blue Mountain Coffee 100%',
                'path' => '/images/products/jamaica-blue-mountain-coffee-100-8oz-whole-bean_540x.jpg',
                'type' => 'image',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 7,
                'name' => 'Cold Brew Coffee',
                'path' => '/images/products/cold-brew-coffee-12oz-bag-ground-back_540x.jpg',
                'type' => 'image',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 8,
                'name' => 'Cookie Butter Coffee',
                'path' => '/images/products/Cookie-Butter-Coffee-Coffee-Bean-Tea-Leaf-Front_540x.jpg',
                'type' => 'image',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 9,
                'name' => 'Hazelnut Coffee',
                'path' => '/images/products/hazelnut-coffee-12oz-ground_540x.jpg',
                'type' => 'image',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
