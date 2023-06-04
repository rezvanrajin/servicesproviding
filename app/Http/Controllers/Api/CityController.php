<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use Intervention\Image\Facades\Image;

class CityController extends Controller
{
    /*------------------------------------------
    city list
--------------------------------------------*/
public function index(Request $request) {
    if ($request->wantsJson()) {
        $cities = new City();
        $limit = 10;
        $offset = 0;
        $search = [];
        $where = [];
        $with = [];
        $join = [];
        $orderBy = [];

        if($request->input('length')){
            $limit = $request->input('length');
        }

        if ($request->input('order')[0]['column'] != 0) {
            $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name']['column']['id'];
            $sort = $request->input('order')[0]['dir'];
            $orderBy[$column_name] = $sort;
        }

        if($request->input('start')){
            $offset = $request->input('start');
        }

        if($request->input('search') && $request->input('search')['value'] != ""){
            $search['name'] = $request->input('search')['value'];
            $search['id'] = $request->input('search')['value'];
        }

        if($request->input('where')){
            $where = $request->input('where');
        }

        $cities = $cities->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
        return response()->json($cities);
    }

    $cities = City::latest()->get();
    return response()->json($cities);
}
/*------------------------------------------
admin city create and update
--------------------------------------------*/
public function store(Request $request){
   
        request()->validate([
            'name' => 'required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
        ]);

        if($request->status==1){
            $status = $request->status;
         }else{
             $status =0;
         }

        if($request->hasFile('image')){
            $image_tmp = $request->file('image');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = $image_name.'-'.rand(111,99999).'.'.$extension;
                $image_path = 'uploads/city'.'/'.$fileName;

                Image::make($image_tmp)->resize(300, 300)->save($image_path);
                $image_path = '/'.$image_path;
            }
        }else if($request->city_id){
            $city = City::where('id',$request->city_id)->select('id','image')->first();
            $image_path = $city->image;
        }else{
            $image_path = '';
        }
        City::updateOrCreate(['id' => $request->city_id],
        [
            'name'   => $request->name, 
            'image'   => $image_path, 
            'status' => $status, 
        ]); 

    return Response()->json(['message'=>'Cite Create Successfully !']);
}

/*------------------------------------------
admin city edit
--------------------------------------------*/
public function edit($id){
    $cities = City::find($id);
    return response()->json($cities);
 }
 public function update(Request $request,City $city)
 {
     request()->validate([
         "name"      => "required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|unique:cities,id," . $city->id,
     ]); 

   
     $data = [
         'name'          => $request->name,
     ];
     if ($request->hasFile('image')) {
         $image_tmp = $request->file('image');

         if ($image_tmp->isValid()) {
             // Upload Images after Resize
             $image_name = $image_tmp->getClientOriginalName();
             $extension = $image_tmp->getClientOriginalExtension();
             $fileName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
             $image_path = 'uploads/city' . '/' . $fileName;

             Image::make($image_tmp)->resize(300, 300)->save($image_path);
             $image_path = '/' . $image_path;
             $data['image'] = $image_path;
         }
     }
     $city->update($data);

     return Response()->json(['message' => 'City Update Successfully !']);
 }
/*------------------------------------------
admin city destroy
--------------------------------------------*/
public function destroy($id)
{
    $city = City::select('image')->where('id',$id)->first();

    if (is_null($city)) {
        return response()->json(["message"=>"Recode Not Found !"],404);
    }

    if(!empty($city['image'])){
            
        if (file_exists($city->image)) {
            unlink($city->image);
        }
            
    }

    City::where('id',$id)->delete();
    
    return response()->json([
        'status' =>false,
        'message'=>'City Deleted has been Succefull',
    ],200);
}

public function updateCityStatus(Request $request){
    if ($request->ajax()) {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        if ($data['status']=="Active") {
            $status = 0;
        }else{
            $status = 1;
        }
        City::where('id',$data['city_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'city_id'=>$data['city_id']]);
    }
}

}
