<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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
        'admission_number',
        'gender',
        'dob',
        'profile_picture',
        'password',
    ];

    protected $with = ['carts'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function clubs()
    {
        return $this->hasMany(Club::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function clubUsers()
    {
        return $this->hasMany(ClubUser::class);
    }

    public function charts()
    {
        return $this->hasMany(Chart::class);
    }

    public function received_charts()
    {
        return $this->hasMany(Chart::class, 'receiver_id');
    }

    public function inquiries()
    {
        return $this->hasMany(Query::class);
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
