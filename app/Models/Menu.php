<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory,CommonTrait;
    protected $fillable = [
      'name',
      'parent_id',
        'url',
        'serial',
        'status',
      ];

        
      public function parentmenu(){
        return $this->belongsTo('App\Models\Menu','parent_id')->where('status',1);
    }
    public function parent(){
      return $this->belongsTo('App\Models\Menu','parent_id');
  }
}
