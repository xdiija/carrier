<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_id',
        'width',
        'height',
        'length',
        'weight',
        'value',
    ];

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }
}
