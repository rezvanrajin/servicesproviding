<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory,CommonTrait;
    protected $fillable = [
        'category_id',
        'handyman_id',
        'provider_id',
        'service_id',
        'date_time',
        'price',
        'status',
    ];
    public function user(){
    	return $this->belongsTo('App\Models\User','user_id');
    }
    public function category(){
    	return $this->belongsTo('App\Models\Category','category_id')->select('id','name','featured');
    }
    public function provider(){
    	return $this->belongsTo('App\Models\Provider','provider_id')->select('id','name','email','providerType_id','mobile','address','city');
    }
    public function service(){
    	return $this->belongsTo('App\Models\Service','service_id')->select('id','name','price','discount','price_type','duration','image','description','featured');
    }
    public function handyman(){
    	return $this->belongsTo('App\Models\Handyman','handyman_id')->select('id','name','provider_id','email','mobile','mobile','address','city','photo','status');
    }


}
