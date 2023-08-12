<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateVoucher(): void
    {
        $voucher = new Voucher();
        $voucher->name = 'sample voucher';
        $voucher->voucher_code = '123456';
        $voucher->save();
        self::assertNotNull($voucher->id);
    }
    public function testCreateVoucherUUID(){
        $voucher = new Voucher();
        $voucher->name = 'sample voucher';
        $voucher->save();
        self::assertNotNull($voucher->id);
        self::assertNotNull($voucher->voucher_code);
    }
    public function testSoftDelete()
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::where('name', '=', 'Sample Voucher')->first();
        $voucher->delete();

        $voucher = Voucher::where('name', '=', 'Sample Voucher')->first();
        self::assertNull($voucher);

        $voucher = Voucher::withTrashed()->where('name', '=', 'Sample Voucher')->first();
//        self::assertNull($voucher);
        self::assertNotNull($voucher->deleted_at);
    }

    public function testLocalScope()
    {
        $voucher = new Voucher();
        $voucher->name = 'sample voucher';
        $voucher->is_active = true;
        $voucher->save();
        $total = Voucher::active()->count();
        self::assertEquals(1, $total);
        $total = Voucher::nonActive()->count();
        self::assertEquals(0, $total);
    }

}
