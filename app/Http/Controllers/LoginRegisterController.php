<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Socialite;
use App\Models\User;



class LoginRegisterController extends Controller
{
    public function login(Request $request){
		if (Auth::check()) {
            return redirect()->route('buyer.dashboard');
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

    		if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])) {
				$user = User::select('users.*')->find(auth()->user()->id);
              
                $token =  $user->createToken('MyApp',['user'])->accessToken; 
				$token = "Bearer ".$token;
				Session::put('token', $token);
				Session::put('user', auth()->user()->id);
				// return response()->json($token);
    			return redirect()->route('buyer.dashboard');
    		}else{
    			Session::flash('message','Invalide Email or Password');
    			return redirect()->back();
    		}
    	}
        return view("backend.user.login");
    }
	public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
	
	public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $google_id = $user->getId();
        $email = $user->getEmail();
        
        $data = User::where('google_id',$google_id)->where('email',$email)->first();
        
        if($data)
            {
            auth()->login($data);
            }
         else
             {
               User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'google_id' => $user->getId(),
                    'google_name' => 'google'
                ]);
             }
             return redirect()->route('buyer.dashboard');
// $user->token;
    }

	public function dashboard(){
		return view('backend.user.dashboard');
	}
	
    public function logout(){   
        Auth::logout();
        Session::forget('user');
    	return redirect()->route('buyer.login');
    }

	public function register(){
		return view('backend.user.register');
	}

	
    public function forgotPassword(){
        return view('backend.user.forget');
    }    

    public function restPassword($token){
		return view("backend.user.reset_password",['token' => $token]);
    }

}
