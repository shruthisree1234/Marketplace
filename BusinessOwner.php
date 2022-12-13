<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\BusinessOwner;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BusinessOwner extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sir_name',
        'other_names',
        'email',
        'phone_number',
        'gender',
        'dob',
        'profile_photo',
        'password',
    ];

    public function business()
    {
        return $this->hasOne(Business::class);
    }

    public function charts()
    {
        return $this->hasMany(Chart::class);
    }

    public function received_charts()
    {
        return $this->hasMany(Chart::class, 'receiver_bs_id');
    }
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'datetime',
    ];
    
}








