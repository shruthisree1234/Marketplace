<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'price'
    ];

    public function carts()
    {
        return $this->hasMany(ClubUser::class);
    }
}
