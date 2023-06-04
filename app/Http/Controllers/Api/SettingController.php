<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\HeaderMenu;
use App\Models\SEOSetting;
use App\Models\LinksWidget;
use Illuminate\Http\Request;
use App\Models\FooterSetting;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use File;

class SettingController extends Controller
{
    public function SEOget(){
        $seo = SEOSetting::first();
        return response()->json($seo);
    }
    public function SEOUpdate(Request $request){
        $seo = SEOSetting::first();
        if($request->isMethod('post')){
            if(empty($seo))
            {
                $seo = new SEOSetting;
                $seo->meta_title        = $request->meta_title;
                $seo->meta_keyword      = $request->meta_keyword;
                $seo->meta_description  = $request->meta_description;
                $seo->save();
            }
           else
           {
            $seo = SEOSetting::first();
            $seo->meta_title        = $request->meta_title;
            $seo->meta_keyword      = $request->meta_keyword;
            $seo->meta_description  = $request->meta_description;
            $seo->update();
           }
        }
        return response()->json([
            'message' => 'Update Successfully !',
           ],202);
    }
    

    public function generalSettingEdit(){
        $setting = GeneralSetting::first();
        return response()->json($setting);
    }

    public function generalSettingUpdate(Request $request){
        // dd($request->all());
        $setting = GeneralSetting::first();
       if($request->isMethod(("post"))){
        if($request->hasFile('logo')){
            $image_tmp = $request->file('logo');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileLogo = $image_name.'-'.rand(111,99999).'.'.$extension;
                $image_path = 'uploads/setting'.'/'.$fileLogo;

                Image::make($image_tmp)->resize(214, 51)->save($image_path);
                $Logo_path = '/'.$image_path;
            }
        }else{
            $Logo_path = $setting->logo;
        }

        if($request->hasFile('favicon')){
            $image_tmp = $request->file('favicon');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileFavicon = $image_name.'-'.rand(111,99999).'.'.$extension;
                $image_path = 'uploads/setting'.'/'.$fileFavicon;

                Image::make($image_tmp)->resize(150, 150)->save($image_path);
                $Favicon_path = '/'.$image_path;
            }
        }else{
            $Favicon_path = $setting->favicon;
        }

        if($request->hasFile('icon')){
            $image_tmp = $request->file('icon');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileIcon = $image_name.'-'.rand(111,99999).'.'.$extension;
                $image_path = 'uploads/setting'.'/'.$fileIcon;

                Image::make($image_tmp)->resize(150, 150)->save($image_path);
                $Icon_path = '/'.$image_path;
            }
        }else{
            $Icon_path = $setting->icon;
        }
        
        if(empty($setting)){
            $setting = new GeneralSetting;
            $setting->website_name              = $request->website_name;
            $setting->contact_details           = $request->contact_details;
            $setting->web_description           = $request->web_description;
            $setting->copyright_info           = $request->copyright_info;
            $setting->mobile                    = $request->mobile;
            $setting->service_location          = $request->service_location;
            $setting->logo                      = $Logo_path;
            $setting->favicon                   = $Favicon_path;
            $setting->icon                      = $Icon_path;
            $setting->save();
        }else{
            $setting = GeneralSetting::first();
            $setting->website_name              = $request->website_name;
            $setting->contact_details           = $request->contact_details;
            $setting->web_description           = $request->web_description;
            $setting->copyright_info           = $request->copyright_info;
            $setting->mobile                    = $request->mobile;
            $setting->service_location          = $request->service_location;
            $setting->logo                      = $Logo_path;
            $setting->favicon                   = $Favicon_path;
            $setting->icon                      = $Icon_path;
            $setting->update();
        }


    }
       return response()->json([
        'message' => 'Update Successfully !',
       ],202);
    }

    public function footerSettingEdit(){
        $setting = FooterSetting::first();
        return response()->json($setting);
    }
        //footer update
    public function footerSettingUpdate(Request $request){
        // dd($request->all());
        $setting = FooterSetting::first();

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


        $setting = FooterSetting::first();
        $setting->contact_detaile = $request->contact_detaile;
        $setting->email = $request->email;
        $setting->location = $request->location;
        $setting->email = $request->email;
        $setting->logo      = $Logo_path;
        $setting->description = $request->description;
        $setting->Update();

        return response()->json($setting);
    }


    // public function HeaderEdit(){
    //     $head = Header::first();
    //     return response()->json($head);
    // }
    // public function HeaderUpdate(Request $request){
    //     if($request->isMethod('post')){
    //         $head = Header::first();
    //           $head->language       = $request->language;
    //           $head->currency       = $request->currency;
    //           $head->steic_header   = $request->steic_header;
            
    //         $head->update();
    //     }
    //     return response()->json([
    //         'message' => 'Update Successfully !',
    //        ],202);
    // }

}
