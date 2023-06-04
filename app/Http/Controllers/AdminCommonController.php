<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Illuminate\Support\Facades\Session;
use Laravel\Passport\RefreshTokenRepository;

class AdminCommonController extends Controller
{
    public function login(Request $request){
		if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if ($request->isMethod('post')) {
    		$data = $request->all();
            // echo "<pre>"; print_r($data); die;
    		$rulse = [
    			'email' => 'required|email|max:255',
		        'password' => 'required',
    		];

    		$customMessage = [
    			'email.required' =>'Email is required',
    			'email.email' =>'Valid Email is password',
    			'password.required' =>'password is required',
    		];

    		$this->validate($request,$rulse,$customMessage);

    		if (Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])) {
				$admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
              
                $token =  $admin->createToken('MyApp',['admin'])->accessToken; 
				$token = "Bearer ".$token;
				Session::put('token', $token);
				// return response()->json($token);
    			return redirect()->route('admin.dashboard');
    		}else{
    			Session::flash('message','Invalide Email or Password');
    			return redirect()->back();
    		}
    	}
        return view('backend.admin.login');
    }
	public function logout(){
		$user = auth()->guard('admin')->user();        
        Auth::guard('admin')->logout();
		Session::forget('token');
		$user->accessTokens()->delete();
    	return redirect()->route('admin.login');
    }
}
