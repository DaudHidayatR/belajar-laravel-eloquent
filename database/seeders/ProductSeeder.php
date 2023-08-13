<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = new Product();
        $product->id = '1';
        $product->name = 'bakso';
        $product->price = 15000;
        $product->category_id = 'FOOD';
        $product->description = 'bakso enak';
        $product->save();

        $product = new Product();
        $product->id = '2';
        $product->name = 'Mie Ayam';
        $product->price = 12000;
        $product->category_id = 'FOOD';
        $product->description = 'Mie Ayam enak';
        $product->save();
    }
}
