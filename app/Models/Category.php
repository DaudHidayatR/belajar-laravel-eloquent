<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
