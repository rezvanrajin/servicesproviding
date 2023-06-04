<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory,CommonTrait;
    protected $fillable = [
        'service_id',
        'provider_id',
        'user_id',
        'coupon_code',
        'discount_type',
        'discount_amount',
        'start_date',
        'end_date',
        'description',
        'status'
    ];
    public function service(){
    	return $this->belongsTo('App\Models\Service','service_id')->select('id','name');
    }
}
