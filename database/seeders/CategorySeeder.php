<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    { 

        $categories = [
            ['name' => 'Mammifères'],
            ['name' => 'Oiseaux'],
            ['name' => 'Reptiles'],
            ['name' => 'Poissons'],
            ['name' => 'Insectes'],
            ['name' => 'Crustacés'],
            ['name' => 'Mollusques'],
            ['name' => 'Plantes'],
            ['name' => 'Champignons'],
            ['name' => 'Autres'],
        ];

        foreach ($categories as $category) {
            if (!Category::where('name', $category['name'])->exists()){
                Category::create($category);
            }
        }
        $this->command->info('Categories created');
    }
}
