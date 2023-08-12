<?php

namespace Tests\Feature;

use App\Models\Voucher;
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
}
