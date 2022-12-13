<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function business_owner()
    {
        return $this->belongsTo(BusinessOwner::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
