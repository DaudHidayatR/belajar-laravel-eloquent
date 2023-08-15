<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customers;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomersSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotNull;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testOneToMany(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::find('1');
        self::assertNotNull($product);

       $category = $product->category;
        self::assertNotNull($category);
        self::assertEquals('FOOD', $category->id);
    }

    public function testHasOneOfMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $category = Category::find('FOOD');
        self::assertNotNull($category);

        $cheapestProduct = $category->cheapestProduct;
        self::assertNotNull($cheapestProduct);
        self::assertEquals('2', $cheapestProduct->id);

        $mostExpensiveProduct = $category->mostExpensiveProduct;
        self::assertNotNull($mostExpensiveProduct);
        self::assertEquals('1', $mostExpensiveProduct->id);

    }
    public function testOneToOnePolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        $product = Product::find("1");
        self::assertNotNull($product);

        $image = $product->images;
        self::assertNotNull($image);
        self::assertEquals('https://www.freecodecamp.org/news/content/images/size/w2000/2022/06/helloWorld.png', $image->url);
    }

}
