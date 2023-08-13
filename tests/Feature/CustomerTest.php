<?php

namespace Tests\Feature;

use Database\Seeders\CustomersSeeder;
use Database\Seeders\WalletsSeeder;
use App\Models\Customers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
