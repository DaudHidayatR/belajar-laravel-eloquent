<?php

namespace Database\Seeders;

use App\Models\Customers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = new Customers();
        $customer->id = 'Daud';
        $customer->name = 'Daud';
        $customer->email = 'daud28ramadhan@gmail.com';
        $customer->save();
    }
}
