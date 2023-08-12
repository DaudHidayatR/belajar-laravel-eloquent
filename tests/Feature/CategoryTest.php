<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

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
}
