<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Customers;
use App\Models\Product;
use App\Models\Voucher;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CustomersSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
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
    public function testOneToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class,VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::find("1");
        self::assertNotNull($product);

        $comments = $product->comments;
        foreach ($comments as $comment) {
            self::assertNotNull($comment);
            self::assertEquals('product', $comment->commentable_type);
            self::assertEquals($product->id, $comment->commentable_id);
        }
    }

    public function testOneOfManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class,VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::find("1");
        self::assertNotNull($product);

        $comment = $product->lastestComment;
        self::assertNotNull($comment);

        $comment = $product->OldComments;
        self::assertNotNull($comment);
    }

    public function testManyToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class,VoucherSeeder::class, TagSeeder::class]);

        $product = Product::find("1");
        self::assertNotNull($product);

        $tags = $product->tags;
        self::assertNotNull($tags);
        self::assertCount(1, $tags);

        foreach ($tags as $tag) {
            self::assertNotNull($tag->id);
            self::assertEquals('Daud', $tag->name);

            $voucher = $tag->vouchers;
            self::assertNotNull($voucher);
            self::assertCount(1, $voucher);
        }
    }

    public function testEloquentCollection()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $products = Product::query()->get();
        $products = $products->toQuery()->where('price', 15000)->get();
        self::assertCount(1, $products);
        self::assertEquals('1', $products[0]->id);

    }

    public function testSerialization()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $product = Product::query()->get();
        self::assertCount(2, $product);

        $json = $product->toJson(JSON_PRETTY_PRINT);
        Log::info($json);

    }
    public function testSerializationRelation()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);
        $product = Product::query()->get();
        $product->load(['category', 'images']);
        self::assertCount(2, $product);

        $json = $product->toJson(JSON_PRETTY_PRINT);
        Log::info($json);

    }


}
