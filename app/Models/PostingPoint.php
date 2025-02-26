<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostingPoint extends Model
{
    use HasFactory;

    protected $table = 'posting_points';

    protected $fillable = [
        'name',
        'street',
        'number',
        'neighborhood',
        'complement',
        'city',
        'state_id',
        'zip_code',
    ];

    /**
     * Relationship with the State model.
     * Assuming there is a `State` model for the `state_id` foreign key.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
