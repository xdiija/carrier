<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';

    protected $fillable = [
        'name',
        'abbreviation',
    ];

    /**
     * Relationship with the PostingPoint model.
     * A state can have multiple posting points.
     */
    public function postingPoints()
    {
        return $this->hasMany(PostingPoint::class, 'state_id');
    }
}
