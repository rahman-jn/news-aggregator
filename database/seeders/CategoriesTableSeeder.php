<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Source;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'politics'],
            ['name' => 'world'],
            ['name' => 'environment'],
            ['name' => 'sport'],
            ['name' => 'general'],
            ['name' => 'usa'],
        ]);
    }
}
