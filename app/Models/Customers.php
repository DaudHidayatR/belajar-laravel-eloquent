<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\Date;

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
        return $this->belongsToMany(Product::class, 'customer_like_products', 'customer_id', 'product_id')->withPivot('created_at')->using(Like::class);
    }
    public function likeslast(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'customer_like_products', 'customer_id', 'product_id')->withPivot('created_at')->using(Like::class)
//            ->wherePivot('created_at', '>=', Date::now()->subDay(-7));
            ->wherePivot('created_at', '>=', Carbon::now()->subDay(-7));
    }

}
