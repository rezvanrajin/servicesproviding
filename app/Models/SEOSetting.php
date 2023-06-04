<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEOSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'meta_title',
        'meta_keyword',
        'meta_description'
    ];
}
