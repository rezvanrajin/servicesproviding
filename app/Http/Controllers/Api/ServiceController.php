<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use App\Models\Provider;
use App\Models\Booking;
use App\Models\Category;

class ServiceController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $services = new Service();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['category'];
            $join = [];
            $orderBy = [];

            if($request->input('length')){
                $limit = $request->input('length');
            }

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }

            if($request->input('start')){
                $offset = $request->input('start');
            }

            if($request->input('search') && $request->input('search')['value'] != ""){
              
                $search['name'] = $request->input('search')['value'];
            }

            if($request->input('where')){
                $where = $request->input('where');
            }

            $services = $services->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($services);
        }
        $services = Service::with(['category'])->latest()->get();
        return response()->json($services);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rulse =[
            "category_id"  =>'required',
            "provider_id"  =>'required',
            "name"         =>'required|unique:services',
            "price"        =>'required',
            "discount"     =>'required',
            "price_type"   =>'required',
            "duration"     =>'required||integer|min:1|digits_between: 1,9',
            
        ];
        $customMessage = [
            'category_id.required' =>"Category Name is required",
            'provider_id.required' =>"Provider Name is required",
            'name.required'        =>"Name is required",
            'price.required'       =>"Price is required",
            'discount.required'    =>"Discount is required",
            'price_type.required'  =>"Price Type is required",
            'duration.required'    =>"Duration is required",
        ];

        $validator = Validator::make($request->all(), $rulse,$customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
  

         if($request->hasFile('image')){
            $image_tmp = $request->file('image');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = $image_name.'-'.rand(111,99999).'.'.$extension;
                $image_path = 'uploads/service'.'/'.$fileName;

                Image::make($image_tmp)->resize(900, 500)->save($image_path);
                $image_path = '/'.$image_path;
            }
        }

        Service::Create(
        [
            'category_id'        => $request->category_id,
            'provider_id'        => $request->provider_id,
            'name'               => $request->name, 
            'image'              => $image_path, 
            'price'              => $request->price, 
            'discount'           => $request->discount, 
            'price_type'         => $request->price_type, 
            'duration'           => $request->duration,
           
        ]);  

        return response()->json(['success'=>'Service saved successfully.']); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $adminsservice)
    {
       return response()->json($adminsservice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Service $adminsservice)
    {
        $rulse =[
            "category_id"  =>'required',
            "provider_id"  =>'required',
            "name"      => "required",
            "price"        =>'required',
            "discount"     =>'required',
            "price_type"   =>'required',
            "duration"     =>'required||integer|min:1|digits_between: 1,9',
           
            
        ];
        $customMessage = [
            'category_id.required' =>"Category Name is required",
            'provider_id.required' =>"Provider Name is required",
            'name.required'        =>"Name is required",
            'price.required'       =>"Price is required",
            'discount.required'    =>"Discount is required",
            'price_type.required'  =>"Price Type is required",
            'duration.required'    =>"Duration is required",
          
        ];

        $validator = Validator::make($request->all(), $rulse,$customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
    

         $data = [
            'category_id'        => $request->category_id,
            'provider_id'        => $request->provider_id,
            'name'               => $request->name, 
            'price'              => $request->price, 
            'discount'           => $request->discount, 
            'price_type'         => $request->price_type, 
            'duration'           => $request->duration,
            'description'        => $request->description
         ];
         if($request->hasFile('image')){
            $image_tmp = $request->file('image');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = $image_name.'-'.rand(111,99999).'.'.$extension;
                $image_path = 'uploads/service'.'/'.$fileName;

                Image::make($image_tmp)->resize(900, 500)->save($image_path);
                $image_path = '/'.$image_path;
                $data['image'] = $image_path;
            }
        }

        $adminsservice->update($data);  

        return response()->json(['success'=>'Service Update successfully.']); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $adminsservice)
    {
        if (is_null($adminsservice)) {
            return response()->json(["message" => "Recode Not Found !"], 404);
        }

        try {
            //code...
            $image_url = $adminsservice->image;
            $adminsservice->delete();
            unlink($image_url);
        } catch (\Exception $e) {
            //throw $th;
            if ($e->getCode() == 23000) {
                return response()->json([
                    'status'    => false,
                    'message'   => "You can not delete it. Because it has some item",
                ], 405);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => $e->getMessage(),
                ], 405);
            }
        }

        return response()->json([
            'status'    => true,
            'message'   => 'Service has been deleted successfull',
        ], 200);
    }
    public function UpdateadminServiceStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if ($data['status']=="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		Service::where('id',$data['ServiceStatus_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status,'ServiceStatus_id'=>$data['ServiceStatus_id']]);
    	}
    }

 

    public function updateAdminsserviceFeaturedStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if ($data['featured']=="Featured") {
    			$featured = 0;
    		}else{
    			$featured = 1;
    		}
    		Service::where('id',$data['adminsserviceFeatured_id'])->update(['featured'=>$featured]);
    		return response()->json(['featured'=>$featured,'adminsserviceFeatured_id'=>$data['adminsserviceFeatured_id']]);
    	}
    }
    public function getCategory(){
        $categories = Category::select('id','name')->latest()->get();
        return response()->json($categories);
    }
    public function getproviders(){
        $providers = Provider::latest()->get();
        return response()->json($providers);
    }
}
