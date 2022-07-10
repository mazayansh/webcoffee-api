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
                'name' => 'Decaffeinated'
            ],
            [
                'name' => 'Flavored'
            ],
            [
                'name' => 'Ground'
            ],
            [
                'name' => 'Organic'
            ],
            [
                'name' => 'Regular'
            ],
            [
                'name' => 'Reserved'
            ],
            [
                'name' => 'Seasonal'
            ],
            [
                'name' => 'Single Origin'
            ],
        ]);
    }
}
