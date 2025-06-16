<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Zone;

class ZoneSeeder extends Seeder
{
    public function run()
    {
        $zone = Zone::create([
            'name' => 'zone1',
            'nbre_points' => 3,
        ]);

        $zone = Zone::create([
            'name' => 'zone2',
            'nbre_points' => 3,
        ]);

        $zone = Zone::create([
            'name' => 'zone3',
            'nbre_points' => 3,
        ]);

        $zone = Zone::create([
            'name' => 'zone4',
            'nbre_points' => 3,
        ]);

        $this->command->info('Zones created');
    }
}
