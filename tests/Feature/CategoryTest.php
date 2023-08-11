<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
