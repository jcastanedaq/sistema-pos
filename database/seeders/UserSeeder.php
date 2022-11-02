<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jorge Castañeda',
            'phone' => '8331276309',
            'email' => 'jorge@jcastaneda.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => Hash::make('Code2017'),
        ]);
        User::create([
            'name' => 'Adela Torres',
            'phone' => '8331271234',
            'email' => 'aleli@jcastaneda.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => Hash::make('Code2017'),
        ]);
    }
}
