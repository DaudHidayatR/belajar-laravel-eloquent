<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Voucher extends Model
{
    use HasUlids, SoftDeletes;
    protected $table = 'vouchers';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public function uniqueIds():array
    {
        return [
            $this->primaryKey,
            'voucher_code'
        ];
    }
    public function scopeActive(Builder $query):void
    {
        $query->where('is_active', true);
    }
    public function scopeNonActive(Builder $query):void
    {
        $query->where('is_active', false);
    }
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
