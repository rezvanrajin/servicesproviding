<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\Models\Handyman;
use App\Models\City;
use Illuminate\Support\Facades\Auth;

class HandymanController extends Controller
{
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex(Request $request)
    {
        if ($request->wantsJson()) {
            $handymen = new Handyman();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['provider'];
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
                $search['name'] = $request->input('search')['value'];
                $search['email'] = $request->input('search')['value'];
                $search['mobile'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $handymen = $handymen->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($handymen);
        }
        $handymen = Handyman::with(['provider', 'city'])->latest()->get();

        return response()->json($handymen);
    }


    public function updateHandymanStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if ($data['status']=="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		Handyman::where('id',$data['handyman_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status,'handyman_id'=>$data['handyman_id']]);
    	}
    }

    public function handymanShow(Handyman $handyman){
        $handyman = $handyman->with(['provider'])->find($handyman->id);
        return response()->json($handyman);
    }

    public function handymanDestroy(Handyman $handyman){
        if (is_null($handyman)) {
            return response()->json(["message" => "Recode Not Found !"], 404);
        }

        try {
            //code...
            $image_url = $handyman->photo;
            $handyman->delete();
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
            'message'   => 'Category has been deleted successfull',
        ], 200);
    }
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $handymen = new Handyman();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = ['provider_id' => Auth::guard('provider-api')->user()->id];
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
                $search['name'] = $request->input('search')['value'];
                $search['email'] = $request->input('search')['value'];
                $search['mobile'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $handymen = $handymen->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($handymen);
        }
        $handymen = Handyman::where(['provider_id' => Auth::guard('provider-api')->user()->id])->latest()->get();

        return response()->json($handymen);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rulse = [
            "name"     => 'required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|unique:handymen',
            "email"    => 'required|email',
            "mobile"   => 'required|min:11|numeric',
            "address"  => 'required',
            "city"     => 'required',

        ];
        $customMessage = [
            'name.required'    => "Name is required",
            'email.required'   => "Email is required",
            'mobile.required'  => "Mobile is required",
            'address.required' => "Address is required",
            'city.required'    => "City is required",
        ];

        $validator = Validator::make($request->all(), $rulse, $customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->status == 1) {
            $status = $request->status;
        } else {
            $status = 0;
        }
        if ($request->hasFile('photo')) {
            $image_tmp = $request->file('photo');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
                $image_path = 'uploads/handyman' . '/' . $fileName;

                Image::make($image_tmp)->resize(150, 150)->save($image_path);
                $image_path = '/' . $image_path;
            }
        }

        Handyman::Create(
            [
                 'provider_id' => Auth::guard('provider-api')->user()->id,
                'name'    => $request->name,
                'email'   => $request->email,
                'mobile'  => $request->mobile,
                'address' => $request->address,
                'city'    => $request->city,
                'photo'   => $image_path,
                'status'  => $status,

            ]
        );
        return response()->json(['success' => 'Handyman Create successfully.']);
    }

    public function edit(Handyman $handyman)
    {
        return response()->json($handyman);
    }
    public function update(Request $request, Handyman $handyman)
    {

        // dd($request->all());
        $rulse = [
            "name"      => "required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|unique:handymen,id,".$handyman->id,
            "email"    => 'required|email',
            "mobile"   => 'required|min:11|numeric',
            "address"  => 'required',
            "city"     => 'required',

        ];
        $customMessage = [
            'name.required'     => "Name is Required",
            'email.required'   => "Email is required",
            'mobile.required'  => "Mobile is required",
            'address.required' => "Address is required",
            'city.required'    => "City is required",
        ];

        $validator = Validator::make($request->all(), $rulse, $customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->status == 1) {
            $status = $request->status;
        } else {
            $status = 0;
        }
        


        $data = [
           
                'name'    => $request->name,
                'email'   => $request->email,
                'mobile'  => $request->mobile,
                'address' => $request->address,
                'city'    => $request->city,
                'status'  => $status,
        ];

        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
                $image_path = 'uploads/handyman' . '/' . $fileName;

                Image::make($image_tmp)->resize(300, 300)->save($image_path);

                $image_path = '/' . $image_path;

                $data['image'] = $image_path;
            }
        }


        $handyman->update($data);

        return response()->json(['success' => 'Handyman Updated successfully.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Handyman $handyman)
    {
        if (is_null($handyman)) {
            return response()->json(["message" => "Recode Not Found !"], 404);
        }

        try {
            //code...
            $image_url = $handyman->photo;
            $handyman->delete();
            unlinkFile($image_url);
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
            'message'   => 'Category has been deleted successfull',
        ], 200);

    }


    public function show(Handyman $handyman)
    {
        // $city = City::with('city')->find($id);
        return response()->json($handyman);
    }
    public function getCity()
    {
        $citys = City::select('id', 'name')->latest()->get();
        return response()->json($citys);
    }
}
