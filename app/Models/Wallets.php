<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallets extends Model
{

    protected $table = 'wallets';
    protected $primaryKey = 'id';
    protected  $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    public function customer():BelongsTo
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }

}
