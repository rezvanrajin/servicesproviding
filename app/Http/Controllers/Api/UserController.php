<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function admiindex(Request $request)
    {
        if ($request->wantsJson()) {
            $users = new User();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = ['status'=>1];
            $with = [];
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
                $search['email'] = $request->input('search')['value'];
                $search['mobile'] = $request->input('search')['value'];
            }

            if($request->input('where')){
                $where = $request->input('where');
            }

            $users = $users->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($users);
        }
        $users = User::where(['status'=>1])->latest()->get();
        
        return response()->json($users);
    }

    public function updateUserStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if ($data['status']=="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		User::where('id',$data['user_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status,'user_id'=>$data['user_id']]);
    	}
    }


    public function store(Request $request)
    {
        if($request->isMethod("post")){
            $data = $request->input();
            $rulse =[
                "name"      =>"required",
                "email"     =>'required|email|unique:users',
                "password"  =>'required',
                
            ];
            $customMessage = [
                'name.required'     =>"Name is Required",
                'email.required'    =>"Email is required",
                'email.email'       =>"Valid email is required",
                'password.required' =>"Password is required",
            ];
    
            $validator = Validator::make($request->all(), $rulse,$customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(),422);
            }
    
    
            $user           = new User;
            $user->name     = $data['name'];
            $user->email    = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();
            return response()->json([
                'status'    =>true,
                'message'   =>'User Created Successfull',
                'user'      =>$user,
            ],201);
        }
    }

    public function userDetails($id){
        $user = User::find($id);
        return response()->json($user);
    }

    

    public function update(Request $request, $id)
    {
        if($request->isMethod("post")){
            $data = $request->input();
            $rulse =[
                "name"  =>"required",
                "email" =>'required|email|unique:admins',
                
            ];
            $customMessage = [
                'name.required'     =>"Name is Required",
                'email.required'    =>"Email is required",
                'email.email'       =>"Valid email is required",
            ];
    
            $validator = Validator::make($request->all(), $rulse,$customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(),422);
            }
    
    
            $user           = User::find($id);
            $user->name     = $data['name'];
            $user->email    = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->update();
            return response()->json([
                'status'    =>true,
                'message'   =>'User Updated Successfull',
                'user'      =>$user,
            ],202);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
                return response()->json(["message"=>"Recode Not Found !"],404);
        }
        $user->delete();
        return response()->json([
            'status'    =>true,
            'message'   =>'User has been deleted Successfull',
            'user'      =>$user,
        ],200);
    }

    public function indexUserInactive(Request $request)
    {
        
            if ($request->wantsJson()) {
                $users = new User();
                $limit = 10;
                $offset = 0;
                $search = [];
                $where = ['status'=>0];
                $with = [];
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
                    $search['id'] = $request->input('search')['value'];
                    $search['name'] = $request->input('search')['value'];
                    $search['email'] = $request->input('search')['value'];
                }
    
                if($request->input('where')){
                    $where = $request->input('where');
                }
    
                $users = $users->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
                return response()->json($users);
            }
            $users = User::latest()->get();
            
            return response()->json($users);
       
    }


    public function providerCustomerList($id)
    {
        $booking = Booking::with(['provider','category','user'])->find($id);
        return response()->json($booking);
    }


  

   
}
