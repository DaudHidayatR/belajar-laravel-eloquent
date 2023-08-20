<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tag = new Tag();
        $tag->id = 'Daud';
        $tag->name = 'Daud';
        $tag->save();

        $products = Product::find('1');
        $products->tags()->attach($tag);

        $vouchers = Voucher::first();
        $vouchers->tags()->attach($tag);

    }
}
