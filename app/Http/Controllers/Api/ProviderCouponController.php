<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use App\Models\User;

class ProviderCouponController extends Controller
{
    public function index(request $request)
    {
        if ($request->wantsJson()) {
            $coupons = new Coupon();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = ['provider_id'=>Auth::guard('provider-api')->user()->id];
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
        $coupons = Coupon::latest()->get();
        return response()->json($coupons);
    }

    public function getUserAll(){
        $users = User::select('id','email')->latest()->get();
        return response()->json($users);
    }


    public function store(Request $request){
        // dd($request->all());
        if (isset($request->user_id)) {
            $user_id = implode(',', $request->user_id);
        }
        Coupon::Create(
            [
                'provider_id'          => Auth::guard('provider-api')->user()->id, 
                'user_id'              => $user_id,
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

    public function show(Coupon $providersCoupon){

        return response()->json($providersCoupon);
    }

    public function destroy(Coupon $providersCoupon)
    {
        if (is_null($providersCoupon)) {
            return response()->json(["message" => "Recode Not Found !"], 404);
        }

        try {
            //code...
            $providersCoupon->delete();
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

    public function edit(Coupon $providersCoupon){

        return response()->json($providersCoupon);
    }

    public function update(Request $request,Coupon $providersCoupon){
        // dd($request->all());
        if (isset($request->user_id)) {
            $user_id = implode(',', $request->user_id);
        }
        $providersCoupon->update(
            [
                'provider_id'          => Auth::guard('provider-api')->user()->id, 
                'user_id'              => $user_id,
                'coupon_code'          => $request->coupon_code,
                'discount_type'        => $request->discount_type,
                'discount_amount'      => $request->discount_amount,
                'start_date'           => date('Y-m-d', strtotime($request->start_date)),
                'end_date'             => date('Y-m-d', strtotime($request->end_date)),
                'description'          => $request->description
            ]
        );
        return response()->json(['success' => 'Coupon update successfully!']);   
    }

}
