<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Booking;
use App\Models\SellerReview;

class Provider extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens,CommonTrait;
    protected $fillable = [
        'name',
        'providerType_id',
        'email',
        'mobile',
        'address',
        'city',
        'about',
        'photo',
        'status',
        'password'
    ];
    public function accessTokens(){
        return $this->hasMany('App\Models\OauthAccessToken','user_id');
    }
    
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function providerType(){
    	return $this->belongsTo('App\Models\ProviderType','providerType_id');
    }
    public function city(){
        return $this->belongsTo('App\Models\City','city');
    }
   
    public function handman(){
    	return $this->belongsTo('App\Models\Handyman','id');
    }

    public function service(){
    	return $this->hasMany('App\Models\Service','id');
    }

    public function bookings(){
        return $this->hasMany(Booking::class,'provider_id');
    }

    public function booking(){
        return $this->hasMany(Booking::class,'provider_id')->select('id','provider_id');
    }

    public function rating(){
        return $this->hasMany(SellerReview::class,'provider_id');
    }
    public function ratings(){
        return $this->hasMany(SellerReview::class,'provider_id')->select('id','provider_id');
    }


}
