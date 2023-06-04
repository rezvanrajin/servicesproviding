<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory,CommonTrait;
    protected $fillable = [
        'name',
        'provider_id',
        'category_id',
        'price',
        'discount',
        'price_type',
        'duration',
        'image',
        'description',
        'featured',
        'status',
    ];
    public function category(){
    	return $this->belongsTo('App\Models\Category','category_id')->select('id','name');
    }
    public function provider(){
    	return $this->belongsTo('App\Models\Provider','provider_id')->select('id','name','email','mobile','providerType_id','address','city','photo','about');
    }
    public function service(){
        return $this->hasMany('App\Models\Service','id');
    }
}
