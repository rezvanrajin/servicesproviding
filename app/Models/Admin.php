<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use KawsarJoy\RolePermission\Permissible;

class Admin extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens,CommonTrait,Permissible;
    protected $fillable = [
        'name',
        'user_type',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'photo',
    ];

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

    public function role(){
        return $this->belongsTo('KawsarJoy\RolePermission\Models\Role','user_type');
    }

    public function accessTokens(){
        return $this->hasMany('App\Models\OauthAccessToken','user_id');
    }
}
