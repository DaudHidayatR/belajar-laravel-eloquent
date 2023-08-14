<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'description',
    ];
    public function products():HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new Scopes\IsActiveScope);
    }
    public function cheapestProduct():HasOne
    {
        return $this->hasOne(Product::class, 'category_id', 'id')->oldest('price');
    }
    public function mostExpensiveProduct():HasOne
    {
        return $this->hasOne(Product::class, 'category_id', 'id')->latest('price');
    }
    public function reviews():HasManyThrough
    {
        return $this->hasManyThrough(Review::class, Product::class, 'category_id', 'product_id', 'id', 'id');
    }
}
