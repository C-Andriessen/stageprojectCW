<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@customwebsite.nl',
            'role_id' => Role::ADMIN,
            'password' => Hash::make('welkom123'),
            'email_verified_at' => now()
        ]);
        User::updateOrCreate([
            'id' => 2,
            'name' => 'Patrick',
            'email' => 'patrick@customwebsite.nl',
            'role_id' => Role::ADMIN,
            'password' => Hash::make('welkom123'),
            'email_verified_at' => now()
        ]);
        User::updateOrCreate([
            'id' => 3,
            'name' => 'Collin',
            'email' => 'collin@customwebsite.nl',
            'role_id' => Role::ADMIN,
            'password' => Hash::make('welkom123'),
            'email_verified_at' => now()
        ]);
        User::updateOrCreate([
            'id' => 4,
            'name' => 'User',
            'email' => 'user@customwebsite.nl',
            'role_id' => Role::USER,
            'password' => Hash::make('welkom123'),
            'email_verified_at' => now()
        ]);
        User::updateOrCreate([
            'id' => 5,
            'name' => 'Aiden',
            'email' => 'aiden@customwebsite.nl',
            'role_id' => Role::USER,
            'password' => Hash::make('welkom123'),
            'email_verified_at' => now()
        ]);
    }
}
