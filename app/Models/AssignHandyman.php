<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignHandyman extends Model
{
    use HasFactory,CommonTrait;
    protected $fillable = [
        'booking_id',
        'user_id',
        'provider_id',
        'handyman_id',
        'status',
    ];

    public function booking(){
    	return $this->belongsTo('App\Models\Booking','booking_id');
    }

    public function service(){
    	return $this->belongsTo('App\Models\Service','service_id');
    }

    public function handyman(){
    	return $this->belongsTo('App\Models\Handyman','handyman_id');
    }
    public function user(){
    	return $this->belongsTo('App\Models\User','user_id');
    }
    

    
}
