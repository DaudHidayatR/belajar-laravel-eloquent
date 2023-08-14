<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{

    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected  $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function wallet()
    {
        return $this->hasOne(Wallets::class, 'customer_id', 'id');
    }
    public function virtualAccount()
    {
        return $this->hasOneThrough(VirtualAccount::class, Wallets::class, 'customer_id', 'wallet_id', 'id', 'id');
    }
}
