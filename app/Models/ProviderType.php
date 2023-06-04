<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderType extends Model
{
    use HasFactory,CommonTrait;
    protected $fillable = [
        'provider_type',
        'comission_rate',
    ];
    public function provider(){
    	return $this->belongsTo('App\Models\Provider','id')->select('id','name');
    }
}
