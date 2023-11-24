<?php

namespace Database\Seeders;
use App\Models\Category;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::create(['nama_kategori' => 'Kamera']);
        Category::create(['nama_kategori' => 'Lensa']);
        Category::create(['nama_kategori' => 'Random']);
        // Add more categories as needed
    }
}
