<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'phone',
        'street',
        'number',
        'neighborhood',
        'complement',
        'instructions',
        'city',
        'state_id',
        'zip_code',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
