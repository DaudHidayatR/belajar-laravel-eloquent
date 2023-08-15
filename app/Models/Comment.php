<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    protected $attributes = [
        'title' => 'sample title',
        'comment' => 'sample comment',
        'commentable_id' => 1,
        'commentable_type' => Product::class ,
    ];
    public function commentable()
    {
        return $this->morphTo();
    }
}
