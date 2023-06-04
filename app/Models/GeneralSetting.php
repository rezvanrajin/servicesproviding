<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'website_name',
        'contact_details',
        'web_description',
        'mobile',
        'service_location',
        'logo',
        'favicon',
        'icon'
    ];
}
