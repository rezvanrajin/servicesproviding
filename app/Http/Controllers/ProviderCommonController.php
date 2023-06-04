<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon; 
use App\Models\User;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Category;
use App\Models\Handyman;
use App\Models\Provider;
use Illuminate\Support\Str;
use App\Models\ProviderType;
use App\Models\City;
use App\Models\SellerReview;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;
use App\Mail\ForgotMail;
use Illuminate\Support\Facades\Session;


class ProviderCommonController extends Controller
{
    public function login(Request $request)
	{
		if (Auth::guard('provider')->check()) {
            return redirect()->route('provider.dashboard');
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
			
    		if (Auth::guard('provider')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])) {
				$provider = Provider::select('providers.*')->find(auth()->guard('provider')->user()->id);
              
                $token =  $provider->createToken('MyApp',['provider'])->accessToken; 
				$token = "Bearer ".$token;
				Session::put('token', $token);
				// return response()->json($token);
    			return redirect()->route('provider.dashboard');
    		}else{
    			Session::flash('message','Invalide Email or Password');
    			return redirect()->back();
    		}
    	}
        return view("backend.provider.login");
    }


    public function logout()
	{
		$user = auth()->guard('provider')->user();        
        Auth::guard('provider')->logout();
		Session::forget('token');
		$user->accessTokens()->delete();
    	return redirect()->route('provider.logout');
    }
}
