<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wallets;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomersSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletsSeeder;
use App\Models\Customers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class CustomerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testOneToOne(): void
    {
    $this->seed(CustomersSeeder::class);
    $this->seed(WalletsSeeder::class);
    $customer = Customers::find('Daud');
    $this->assertNotNull($customer);

    $wallet = $customer->wallet;
    $this->assertNotNull($wallet);
    $this->assertEquals(1000000, $wallet->amount);
    }

    public function testOneToOneQuery()
    {
        $customer = new Customers();
        $customer->id = 'DAUD';
        $customer->name = 'Daud';
        $customer->email = 'daud28ramadhan@gmail.com';
        $customer->save();

        $wallet = new Wallets();
        $wallet->amount = 1000000;

        $customer->wallet()->save($wallet);
        self::assertNotNull($wallet->customer_id);
        self::assertEquals('DAUD', $wallet->customer_id);
        assertEquals(1000000, $wallet->amount);


    }

    public function testGasOneThrough()
    {
        $this->seed([CustomersSeeder::class, WalletsSeeder::class, VirtualAccountSeeder::class]);
        $customer = Customers::find('Daud');
        $this->assertNotNull($customer);

        $virtualAccount = $customer->virtualAccount;
        $this->assertNotNull($virtualAccount);
        $this->assertEquals('1234567890', $virtualAccount->va_number);

    }
    public function testManyToMany()
    {
        $this->seed([CustomersSeeder::class, CategorySeeder::class, ProductSeeder::class]);
        $customer = Customers::find('Daud');
        self::assertNotNull($customer);

        $customer->likes()->attach('1');

        $product = $customer->likes;
        self::assertNotNull($product);
        self::assertCount(1, $product);
        self::assertEquals('1', $product[0]->id);



    }
    public function testManyToManyDetach()
    {
        $this->testManyToMany();
        $customer = Customers::find('Daud');
        $customer->likes()->detach('1');
        $product = $customer->likes;
        self::assertNotNull($product);
    }

}
