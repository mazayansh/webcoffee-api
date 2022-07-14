<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roasts')->insert([
            [
                'name' => 'Light',
                'slug' => 'light'
            ],
            [
                'name' => 'Medium',
                'slug' => 'medium'
            ],
            [
                'name' => 'Dark',
                'slug' => 'dark'
            ]
        ]);
    }
}
