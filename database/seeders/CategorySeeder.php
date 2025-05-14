<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // Import model Category

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'user_id' => 1, // Ganti dengan user_id yang sesuai (atau sesuaikan dengan kebutuhan Anda)
            'title' => 'Category A',
        ]);

        Category::create([
            'user_id' => 1,
            'title' => 'Category B',
        ]);

        Category::create([
            'user_id' => 1,
            'title' => 'Category C',
        ]);
    }
}