<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoVerificationCode extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'verification_code',
        'verification_code_expires_at',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'verification_code_expires_at' => 'datetime'
    ];
}
