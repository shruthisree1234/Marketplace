<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'image',
        'advertised'
    ];

    protected $with = ['carts'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
