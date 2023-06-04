<?php

namespace App\Http\Controllers\Api;

use App\Models\Footer;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class SitesettingController extends Controller
{
    public function footerSettingEdit(){
        $setting = Footer::first();
        return response()->json($setting);
    }
        //footer update
    public function footerSettingUpdate(Request $request){
        // dd($request->all());
        $setting = Footer::first();

        if($request->hasFile('logo')){
            $image_tmp = $request->file('logo');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileLogo = $image_name.'-'.rand(111,99999).'.'.$extension;
                $image_path = 'uploads/setting'.'/'.$fileLogo;

                Image::make($image_tmp)->save($image_path);
                $Logo_path = '/'.$image_path;
            }
        }


        $setting = Footer::first();
        $setting->contact_detaile = $request->contact_detaile;
        $setting->email = $request->email;
        $setting->location = $request->location;
        $setting->logo      = $Logo_path;
        $setting->description = $request->description;
        $setting->Update();

        return response()->json($setting);
    }
}
