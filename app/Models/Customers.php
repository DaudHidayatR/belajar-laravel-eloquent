<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

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
    public function virtualAccount() :HasOneThrough
    {
        return $this->hasOneThrough(VirtualAccount::class, Wallets::class, 'customer_id', 'wallet_id', 'id', 'id');
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'customer_id', 'id');
    }
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'customer_like_products', 'customer_id', 'product_id');
    }
}
