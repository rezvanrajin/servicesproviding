<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Provider;
use App\Models\Service;
use App\Models\User;

class SellerReview extends Model
{
    use HasFactory,CommonTrait;
    protected $fillable = [
        'user_id',
        'provider_id',
        'rating',
        'review',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function service(){
        return $this->belongsTo(Service::class,'service_id');
    }
    public function provider(){
        return $this->belongsTo(Provider::class,'provider_id');
    }
}
