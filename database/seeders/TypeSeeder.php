<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            [
                'name' => 'Decaffeinated',
                'slug' => 'decaffeinated'
            ],
            [
                'name' => 'Flavored',
                'slug' => 'flavored'
            ],
            [
                'name' => 'Ground',
                'slug' => 'ground'
            ],
            [
                'name' => 'Organic',
                'slug' => 'organic'
            ],
            [
                'name' => 'Regular',
                'slug' => 'regular'
            ],
            [
                'name' => 'Reserved',
                'slug' => 'reserved'
            ],
            [
                'name' => 'Seasonal',
                'slug' => 'seasonal'
            ],
            [
                'name' => 'Single Origin',
                'slug' => 'single-origin'
            ],
        ]);
    }
}
