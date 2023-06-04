<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory,CommonTrait;
    protected $fillable = [
        'user_id',
        'service_id',
        'ratting',
        'review',
        'status',

    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function service(){
        return $this->belongsTo('App\Models\Service','service_id')->select('id','name','price','discount','price_type','duration','image','description','featured');
    }
}
