<?php

namespace App\Models;

use App\Helpers\CpfHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoaFisica extends Model
{
    use HasFactory;

    protected $table = 'pessoa_fisica';

    protected $fillable = [
        'user_id',
        'cpf',
        'name',
        'birthdate',
    ];

    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = CpfHelper::sanitize($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}