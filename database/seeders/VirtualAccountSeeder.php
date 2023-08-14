<?php

namespace Database\Seeders;

use App\Models\VirtualAccount;
use App\Models\Wallets;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $wallets = Wallets::where('customer_id', 'Daud')->firstOrFail();
        $virtualAccount = new VirtualAccount();
        $virtualAccount->bank = 'BCA';
        $virtualAccount->va_number = '1234567890';
        $virtualAccount->wallet_id = $wallets->id;
        $virtualAccount->save();
    }
}
