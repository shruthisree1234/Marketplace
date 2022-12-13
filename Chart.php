<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'receiver_id',
        'receiver_bs_id',
        'business_owner_id',
        'message',
        'read'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function businessOwner()
    {
        return $this->belongsTo(BusinessOwner::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function receiverBs()
    {
        return $this->belongsTo(BusinessOwner::class, 'receiver_bs_id');
    }
}
