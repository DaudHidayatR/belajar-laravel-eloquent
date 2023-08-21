<?php

namespace Database\Seeders;

use App\Models\Customers;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $image1 = new Image();
        $image1->url = 'https://www.udacity.com/blog/wp-content/uploads/2020/11/Hello-World_Blog-scaled.jpeg';
        $image1->imageable_id = 'Daud';
        $image1->imageable_type = 'customer';
        $image1->save();

        $image2 = new Image();
        $image2->url = 'https://www.freecodecamp.org/news/content/images/size/w2000/2022/06/helloWorld.png';
        $image2->imageable_id = '1';
        $image2->imageable_type = 'product';
        $image2->save();
    }
}
