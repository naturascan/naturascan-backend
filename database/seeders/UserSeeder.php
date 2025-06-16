<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'firstname' => 'admin',
            'email' => 'admin@yopmail.com',
            'password' => Hash::make('123456789'), 
            'mobile_number' => 'admin',
            'adress' => 'Paris',
            'access' => 'admin',  
            'enabled' => true,
        ]);


        $observer = User::create([
            'name' => 'observer',
            'firstname' => 'observer',
            'email' => 'observer@yopmail.com',
            'password' => Hash::make('123456789'), 
            'mobile_number' => 'observer',
            'adress' => 'Paris',
            'access' => 'observer',
            'enabled' => true,
        ]);

         
        $this->command->info('Users created');
    }
}
