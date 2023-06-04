<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Service;


class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $coupons = new Coupon();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = [];
            $join = [];
            $orderBy = [];

            if ($request->input('length')) {
                $limit = $request->input('length');
            }

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }

            if ($request->input('start')) {
                $offset = $request->input('start');
            }

            if ($request->input('search') && $request->input('search')['value'] != "") {
                $search['coupon_code'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $coupons = $coupons->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($coupons);
        }
        $coupons = Coupon::with(['user'])->latest()->get();
        return response()->json($coupons);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        // $rulse = [
        //     "coupon_code"       => 'required',
        //     "discount_type"     => 'required',
        //     "discount_amount"   => 'required',
        //     "start_date"        => 'required',
        //     "end_date"          => 'required',

        // ];
        // $customMessage = [
        //     'coupon_code.required'      => "Coupon Code is required",
        //     'discount_type.required'    => "Discount Type is required",
        //     'discount_amount.required'  => "Discount Amount is required",
        //     'start_date.required'       => "Start Date is required",
        //     'end_date.required'         => "End Date is required",
        // ];

        // $validator = Validator::make($request->all(), $rulse, $customMessage);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }
        // $rulse = [
        //     'name' => 'required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',

        // ];
        // $customMessage = [
        //     'name.required'     => "Name is Required"
        // ];

        // $validator = Validator::make($request->all(), $rulse, $customMessage);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }
        if (isset($request->service_id)) {
            $services = implode(',', $request->service_id);
        }
        Coupon::Create(
            [
                'service_id'           => $services,
                'coupon_code'          => $request->coupon_code,
                'discount_type'        => $request->discount_type,
                'discount_amount'      => $request->discount_amount,
                'start_date'           => date('Y-m-d', strtotime($request->start_date)),
                'end_date'             => date('Y-m-d', strtotime($request->end_date)),
                'description'          => $request->description
            ]
        );
        return response()->json(['success' => 'Coupon create successfully!']);    
    }



    public function edit(Coupon  $coupon)
    {
        return response()->json($coupon);
    }


    public function update(Request $request,Coupon $coupon)
    {
        // dd($request->all());
        // $rulse = [
        //     "coupon_code"       => 'required',
        //     "service_id"        => 'required',
        //     "discount_type"     => 'required',
        //     "discount_amount"   => 'required',
        //     "start_date"        => 'required',
        //     "end_date"          => 'required',

        // ];
        // $customMessage = [
        //     'coupon_code.required'      => "Coupon Code is required",
        //     'service_id.required'       => "Service Name is required",
        //     'discount_type.required'    => "Discount Type is required",
        //     'discount_amount.required'  => "Discount Amount is required",
        //     'start_date.required'       => "Start Date is required",
        //     'end_date.required'         => "End Date is required",
        // ];

        // $validator = Validator::make($request->all(), $rulse, $customMessage);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }
   

        if (isset($request->service_id)) {
            $services = implode(',', $request->service_id);
        }


        $data = [
            'service_id'           => $services,
            'coupon_code'          => $request->coupon_code,
            'discount_type'        => $request->discount_type,
            'discount_amount'      => $request->discount_amount,
            'start_date'           => date('Y-m-d', strtotime($request->start_date)),
            'end_date'             => date('Y-m-d', strtotime($request->end_date)),
            'description'          => $request->description
        ];

        $coupon->update($data);

        return response()->json(['success' => 'Coupon Update successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        if (is_null($coupon)) {
            return response()->json(["message" => "Recode Not Found !"], 404);
        }

        try {
            //code...
            $coupon->delete();
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
    }

    public function show(Coupon $coupon)
    {
        return response()->json($coupon);
    }

    public function getService()
    {
        $services = Service::latest()->get();
        return response()->json($services);
    }

    public function updateCouponStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if ($data['status']=="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status,'coupon_id'=>$data['coupon_id']]);
    	}
    }
}


// $profile = Profile::where(['user_id',$user->id])->first();
        // DB::beginTransaction();
        // try {
        
        //     if($request->isMethod('POST')){
       
    
        //         $user  = User::first();
        //         $user->name = $request->name;
        //         $user->email = $request->email;
        //         $user->update();
    
        //         $profile = Profile::where(['id'=>$user->id])->first();
        //         if ($request->hasFile('image')) {
        //             $image_tmp = $request->file('image');
    
        //             if ($image_tmp->isValid()) {
        //                 // Upload Images after Resize
        //                 $image_name = $image_tmp->getClientOriginalName();
        //                 $extension = $image_tmp->getClientOriginalExtension();
        //                 $fileName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
        //                 $image_path = 'uploads' . '/' . $fileName;
    
        //                 Image::make($image_tmp)->resize(150, 150)->save($image_path);
    
        //             }
        //         }elseif($profile->image){
        //             $image_path = $profile->image;
        //         }

        //         $profile->phone = $request->phone;
        //         $profile->address = $request->address;
        //         $profile->image = $image_path;
        //         $profile->update();
                
    
                
        //     }
        //     return redirect()->route('profile');    
        
        //     DB::commit();
        //     // all good
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // something went wrong
        // }


        // return view('Admin.Profile.profile',compact('user'));