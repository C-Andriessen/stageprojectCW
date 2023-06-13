<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'Custom Website',
            'address' => 'Atoomweg 2j',
            'city' => 'Groningen',
            'zip_code' => '9743 AK',
            'email' => 'info@customwebsite.nl',
            'phone_number' => '0507520161',
        ]);
        Company::create([
            'name' => 'APdV Supplies',
            'address' => 'Atoomweg 2j',
            'city' => 'Groningen',
            'zip_code' => '9743 AK',
            'email' => 'patrick@apdv.nl',
            'phone_number' => '0507520161',
        ]);
    }
}
