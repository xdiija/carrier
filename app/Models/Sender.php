<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'email',
        'phone',
        'street',
        'number',
        'neighborhood',
        'complement',
        'city',
        'state_id',
        'zip_code',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
