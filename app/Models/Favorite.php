<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory,CommonTrait;
    protected $fillable = [
        'user_id',
        'service_id',
    ];
    public function service(){
    	return $this->belongsTo('App\Models\Service','service_id')->select('id','name','category_id','price','discount','price_type','duration','image','description','featured','status');
    }


}