<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handyman extends Model
{
    use HasFactory,CommonTrait;
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'address',
        'city',
        'photo',
        'provider_id',
        'status'
    ];
    public function provider(){
    	return $this->belongsTo('App\Models\Provider','provider_id')->select('id','name','email','mobile');
    }
    public function city(){
        return $this->belongsTo('App\Models\City','city');
    }
  
}
