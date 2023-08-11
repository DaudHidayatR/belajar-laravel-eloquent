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
}
