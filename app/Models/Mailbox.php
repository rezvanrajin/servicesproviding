<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model
{
    use HasFactory,CommonTrait;


    protected $fillable = [
        'user_id',
        'admin_id',
        'provider_id',
        'subject',
        'description',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id')->select('id','name','email','mobile');
        
    }

    public function provider(){
        return $this->belongsTo('App\Models\Provider','provider_id')->select('id','name','email','photo');
    }

    public function admin(){
        return $this->belongsTo('App\Models\Admin','admin_id')->select('id','name','email','photo');
    }
}
