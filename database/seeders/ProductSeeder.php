<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++)
        {
            Product::create([
                'name' => 'Product ' . $i,
                'description' => 'Dit is de beschrijving voor product ' . $i,
                'price_excl' => rand(0, 2000),
                'discount_price' => NULL,
                'vat' => 21,
                'image' => 'template.jpg'
            ]);
        }
    }
}
