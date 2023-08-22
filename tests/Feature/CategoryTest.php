<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customers;
use App\Models\Product;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomersSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */


    public function testInsert(): void
    {
        $category = new Category();
        $category->id = '1';
        $category->name = 'GADGET';
        $result = $category->save();
        self::assertTrue($result);
    }
    public function testInsertMany(){
        $category = [];
        for ($i = 0; $i < 10; $i++) {
            $category[] = [
                'id' => $i,
                'name' => 'GADGET' . $i,
                'is_active' => true
            ];
        }
        $result = Category::insert($category);
        self::assertTrue($result);
        $total = Category::count();
        self::assertEquals(10, $total);
    }
    public function testFind(){
        $this->seed(CategorySeeder::class);
        $category = Category::find('FOOD');

        self::assertNotNull($category);
        self::assertEquals('FOOD', $category->id);
        self::assertEquals('Food', $category->name);
        self::assertEquals('Food Category', $category->description);
    }
    public function testUpdate(){
        $this->seed(CategorySeeder::class);
        $category = Category::find('FOOD');
        $category->name = 'Food update';
        $result = $category->save();
        self::assertTrue($result);
    }
    public function testSelect(){
        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->id = $i;
            $category->name = 'GADGET' . $i;
            $category->is_active = true;
            $category->save();
        }
        $categories = Category::whereNull('description')->get();
        assertEquals(10, $categories->count());
        $categories->each(function ($item) {
            self::assertNull($item->description);
            $item->description = 'update';
            $item->save();
        });

    }
    public function testUpdateMany(){
        $category = [];
        for ($i = 0; $i < 10; $i++) {
            $category[] = [
                'id' => $i,
                'name' => 'GADGET' . $i,
                'is_active' => true,
            ];
        }
        $result = Category::insert($category);
        self::assertTrue($result);
        Category::whereNull('description')->update(['description' => 'update']);
        $total = Category::where('description', 'update')->count();
        assertEquals(10, $total);
    }
    public function testDelete(){
        $this->seed(CategorySeeder::class);
        $category = Category::find('FOOD');
        $result = $category->delete();
        self::assertTrue($result);
        $total = Category::count();
        assertEquals(0, $total);
    }
    public function testDeleteMany(){
        $category = [];
        for ($i = 0; $i < 10; $i++) {
            $category[] = [
                'id' => $i,
                'name' => 'GADGET' . $i,
                'is_active' => true,
            ];
        }
        $result = Category::insert($category);
        self::assertTrue($result);
        $total = Category::where('description')->count();
        assertEquals(10, $total);
        Category::whereNull('description')->delete();
        self::assertEquals(0, Category::count());
    }
    public function testCreate()
    {
        $request = [
            'id' => 'FOOD',
            'name' => 'food',
            'description' => 'food category',
        ];
        $category = new Category($request);
        $category->save();
        self::assertNotNull($category->id);
        self::assertNotNull($category->name);
        self::assertNotNull($category->description);
    }
    public function testCreateMethod(){
        $request = [
            'id' => 'FOOD',
            'name' => 'food',
            'description' => 'food category',
        ];
        $category = Category::create($request);
        self::assertNotNull($category->id);
        self::assertNotNull($category->name);
        self::assertNotNull($category->description);
    }
    public function testingUpdateMass(){
        $this->seed(CategorySeeder::class);
        $request = [
            'id' => 'FOOD Updated',
            'name' => 'food Updated',
            'description' => 'food category updated',
        ];
        $category = Category::find('FOOD')->fill($request);
        $category->save();
        self::assertNotNull($category->id);
    }

    public function testGlobalScope()
    {
        $category = new Category();
        $category->id = 'Food';
        $category->name = 'Food';
        $category->description = 'Food Category';
        $category->is_active = false;
        $category->save();

        $category = Category::find('Food');
        assertNull($category);

    }
    public function testWithoutGlobalScope()
    {
        $category = new Category();
        $category->id = 'Food';
        $category->name = 'Food';
        $category->description = 'Food Category';
        $category->is_active = false;
        $category->save();

        $category = Category::find('FOOD');
        assertNull($category);
        $category = Category::withoutGlobalScopes([IsActiveScope::class])->find('FOOD');
        self::assertNotNull($category);

    }
    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $category = Category::find('FOOD');
        self::assertNotNull($category);

        $products = $category->products;
        self::assertNotNull($products);
        self::assertCount(2, $products);

    }

    public function testOneToManyQuery()
    {
    $category = new Category();
    $category->id = 'FOOD';
    $category->name = 'Food';
    $category->description = 'Food Category';
    $category->is_active = true;
    $category->save();

    $product = new Product();
    $product->id = '1';
    $product->name = 'Mie Ayam';
    $product->price = 10000;
    $product->description = 'Mie Ayam Enak';

    $category->products()->save($product);
    self::assertNotNull($product->category_id);
    self::assertEquals('FOOD', $product->category_id);
    }
    public function testRelationshipQuery()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $category = Category::find('FOOD');
        $products = $category->products;
        self::assertCount(2, $products);

        $outOfStockProducts = $category->products()->where('stock', 0)->get();
        self::assertCount(2, $outOfStockProducts);

    }
    public function testHasManyThrough()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class,CustomersSeeder::class,ReviewSeeder::class]);
        $category = Category::find('FOOD');
        self::assertNotNull($category);

        $review = $category->reviews;
        self::assertNotNull($review);
        self::assertCount(2, $review);
    }

    public function testQueryingRelations()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $category = Category::find('FOOD');
        $products = $category->products()->where('price', 15000)->get();
        self::assertNotNull($products);
        self::assertCount(1, $products);
        self::assertEquals(15000, $products->first()->price);
    }


}
