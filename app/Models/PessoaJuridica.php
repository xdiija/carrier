<?php

namespace App\Models;

use App\Helpers\CnpjHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoaJuridica extends Model
{
    use HasFactory;

    protected $table = 'pessoa_juridica';

    protected $fillable = [
        'user_id',
        'cnpj',
        'razao_social',
        'nome_fantasia',
        'inscricao_estadual',
        'inscricao_municipal',
    ];

    public function setCnpjAttribute($value)
    {
        $this->attributes['cnpj'] = CnpjHelper::sanitize($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}