<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender_id',
        'recipient_id',
        'posting_point_id',
        'tracking_code',
        'status',
        'estimated_delivery',
        'actual_delivery',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(Sender::class);
    }

    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }

    public function postingPoint()
    {
        return $this->belongsTo(PostingPoint::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}