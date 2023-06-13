<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate(['id' => Role::ADMIN, 'name' => 'admin']);
        Role::updateOrCreate(['id' => Role::USER, 'name' => 'gebruiker']);
    }
}
