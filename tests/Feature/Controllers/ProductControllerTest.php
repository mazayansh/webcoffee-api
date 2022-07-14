<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Database\Seeders\{
    RoastSeeder,
    TypeSeeder,
    ProductSeeder, 
    ProductVariantSeeder
};
use Illuminate\Support\Facades\Log;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed([
            RoastSeeder::class,
            TypeSeeder::class,
            ProductSeeder::class,
            ProductVariantSeeder::class
        ]);
    }

    public function test_get_product_index_paginate_success()
    {   
        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['links','meta'])
                    ->has('data', 9, fn ($json) => 
                        $json->hasAll(['id','name','aftertaste','price'])
                            ->where('id', 1)
                            ->where('name', 'BALI BLUE MOON SINGLE ORIGIN DARK ROAST COFFEE')
                            ->etc()
                    )
            );
    }

    public function test_get_products_sort_by_name_desc_success()
    {
        $response = $this->getJson('/api/v1/products?sort=%2Dname');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['links','meta'])
                    ->has('data', 9, fn ($json) => 
                        $json->hasAll(['id','name','aftertaste','price'])
                            ->where('id', 6)
                            ->where('name', 'JAMAICA BLUE MOUNTAIN SINGLE ORIGIN RESERVE COFFEE 100%')
                            ->etc()
                    )
            );
    }

    public function test_get_products_search_by_name_success()
    {
        $response = $this->getJson('/api/v1/products?search=hazelnut');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['links','meta'])
                    ->has('data', 1, fn ($json) => 
                        $json->hasAll(['id','name','aftertaste','price'])
                            ->where('id', 9)
                            ->where('name', 'HAZELNUT COFFEE')
                            ->etc()
                    )
            );
    }

    public function test_get_products_filter_success()
    {
        $response = $this->getJson('/api/v1/products?filter=type_flavored%2Broast_medium');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['links','meta'])
                    ->has('data', 3, fn ($json) => 
                        $json->hasAll(['id','name','aftertaste','price'])
                            ->where('id', 7)
                            ->where('name', 'COLD BREW COARSE GROUND COFFEE BLEND WITH CHICORY')
                            ->etc()
                    )
            );
    }

    public function test_get_single_product_by_id_success()
    {
        $response = $this->getJson('/api/v1/products/3');

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn ($json) =>
                    $json->hasAll([
                            'id',
                            'name',
                            'slug',
                            'aftertaste',
                            'description',
                            'roast',
                            'type',
                            'product_variants'
                        ])
                        ->where('id', 3)
                        ->where('name', 'DECAF ESPRESSO ROAST COFFEE')
                        ->etc()
                )
            );
    }

    public function test_get_single_product_by_id_not_found()
    {
        $response = $this->getJson('/api/v1/products/1003');

        $response->assertStatus(404)->assertJson(['message' => 'Product not found']);
    }
}
