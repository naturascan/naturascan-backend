<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Espece;

class EspeceSeeder extends Seeder
{
    public function run()
    {
        // 'common_name',
        // 'scientific_name',
        // 'description',
        // 'category_id',

        // genere 12 especes pour chaque categorie

        $espece = Espece::create([
            'common_name' => 'Lion',
            'scientific_name' => 'Panthera leo',
    'description'=>'des',
                'category_id' => 1,

        ]);

        $espece = Espece::create([
            'common_name' => 'Tigre',
            'scientific_name' => 'Panthera tigris',
    'description'=>'des',
                'category_id' => 1,

        ]);

        $espece = Espece::create([
            'common_name' => 'Gorille',
            'scientific_name' => 'Gorilla',
    'description'=>'des',
                'category_id' => 1,

        ]);

        $espece = Espece::create([
            'common_name' => 'Ours',
            'scientific_name' => 'Ursidae',
    'description'=>'des',
                'category_id' => 1,

        ]);

        $espece = Espece::create([
            'common_name' => 'Aigle',
            'scientific_name' => 'Aquila',
    'description'=>'des',
                'category_id' => 2,
        ]);

        $espece = Espece::create([
            'common_name' => 'Faucon',
            'scientific_name' => 'Falco',
    'description'=>'des',
                'category_id' => 2,
        ]);

        $espece = Espece::create([
            'common_name' => 'Hibou',
            'scientific_name' => 'Bubo',
    'description'=>'des',
                'category_id' => 2,
        ]);

        $espece = Espece::create([
            'common_name' => 'Perroquet',
            'scientific_name' => 'Psittacidae',
    'description'=>'des',
                'category_id' => 2,
        ]);

        $espece = Espece::create([
            'common_name' => 'Serpent',
            'scientific_name' => 'Serpentes',
    'description'=>'des',
                'category_id' => 3,
        ]);

        $espece = Espece::create([
            'common_name' => 'Tortue',
            'scientific_name' => 'Testudines',
    'description'=>'des',
                'category_id' => 3,
        ]);

        $espece = Espece::create([
            'common_name' => 'Lézard',
            'scientific_name' => 'Lacertilia',
    'description'=>'des',
                'category_id' => 3,
        ]);

        $espece = Espece::create([
            'common_name' => 'Crocodile',
            'scientific_name' => 'Crocodylidae',
    'description'=>'des',
                'category_id' => 3,
        ]);

        $espece = Espece::create([
            'common_name' => 'Poisson rouge',
            'scientific_name' => 'Carassius auratus',
    'description'=>'des',
                'category_id' => 4,
        ]);

        $espece = Espece::create([
            'common_name' => 'Poisson-clown',
            'scientific_name' => 'Amphiprioninae',
            'description'=>'des',

            'category_id' => 4,
        ]);


        $this->command->info('Especes created');
    }
}
