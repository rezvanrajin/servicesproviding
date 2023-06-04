<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,CommonTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'google_name',
        'password',
        'mobile',
        'birth_date',
        'address',
        'city',
        'state',
        'post_code',
        'country',
        'photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function booking(){
    	return $this->hasMany('App\Models\Booking','id');
    }

    public function category(){
    	return $this->hasMany('App\Models\Category','id');
    }
    public function provider(){
    	return $this->hasMany('App\Models\Provider','id');
    }
    public function service(){
    	return $this->hasMany('App\Models\Service','id');
    }
}
