<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nama' => '8 Ball',
                'thumbnail' => null
            ],
            [
                'nama' => '9 Ball',
                'thumbnail' => null
            ],
            [
                'nama' => 'Meja VIP',
                'thumbnail' => null
            ],
            [
                'nama' => 'Snooker',
                'thumbnail' => null
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
