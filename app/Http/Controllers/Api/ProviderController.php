<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
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
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;
use App\Mail\ForgotMail;


class ProviderController extends Controller
{
  

  
    public function register(Request $request)
    {
        if ($request->isMethod("post")) {
            $input = $request->only(['name', 'email', 'password', 'providerType_id', 'city']);
            $rulse = [
                "name" => 'required',
                "email" => 'required|email',
                "password" => 'required|min:6',
                "providerType_id" => 'required',
                "city" => 'required',

            ];
            $customMessage = [
                'name.required' => "Email is required",
                'providerType_id.required' => "Provider Type is required",
                'email.required' => "Email is required",
                'email.email' => "Valid email is required",
                'password.required' => "Password is required",


            ];

            $validator = Validator::make($request->all(), $rulse, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $admin = Provider::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'providerType_id' => $input['providerType_id'],
                'city' => $input['city'],
                'password' => bcrypt($input['password']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Provider registered succesfully, Use Login method to receive token.',
                'user' => $admin,
            ], 200);
        }
    }

    public function login(Request $request)
    {

        $input = $request->only(['email', 'password']);
        $rulse = [
            "email" => 'required|email',
            "password" => 'required|min:6',

        ];
        $customMessage = [
            'email.required' => "Email is required",
            'email.email' => "Valid email is required",
            'password.required' => "Password is required",
        ];

        $validator = Validator::make($request->all(), $rulse, $customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (auth()->guard('provider')->attempt(['email' => request('email'), 'password' => request('password')])) {

            config(['auth.guards.api.provider' => 'provider']);

            $provider = Provider::select('providers.*')->find(auth()->guard('provider')->user()->id);
            $success = $provider;
            $success['token'] = $provider->createToken('MyApp', ['provider'])->accessToken;

            return response()->json($success, 200);
        } else {
            return response()->json(['error' => ['Email and Password are Wrong.']], 422);
        }


    }

    public function dashboard()
    {
        $handyman = Handyman::where('provider_id',Auth::guard('provider-api')->user()->id)->count();
        return response()->json([
            'status' => false,
            'handyman' => $handyman
        ], 200);
    }

    public function profileUpdate(Request $request)
    {
        // dd($request->name);
        if ($request->isMethod('post')) {
            $data = $request->input();
            $rulse = [
                'name'      => 'required',
                'mobile'     => 'required|min:11|numeric',
                'address'   => 'required',
                'city'      => 'required',
                'about'      => 'required',
            ];

            $customMessage = [
                'name.required' => 'name is required',
                'address.required' => 'address is required',
                'city.required' => 'city is required',
                'mobile.required' => 'mobile is required',
                'mobile.numeric' => 'Valid mobile is required',
                'about.required' => 'Bio is required',
            ];

            $this->validate($request, $rulse, $customMessage);
            $provider = Provider::where('photo', Auth::guard('provider-api')->user()->photo)->first();

            if ($request->hasFile('photo')) {
                $image_tmp = $request->file('photo');

                if ($image_tmp->isValid()) {
                    // Upload Images after Resize
                    $image_name = $image_tmp->getClientOriginalName();
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
                    $image_path = 'uploads/provider' . '/' . $fileName;

                    Image::make($image_tmp)->resize(150, 150)->save($image_path);

                    $image_path = '/' . $image_path;
                }
            } else {
                $image_path = $provider->photo;
            }


            $provider = Provider::where('email', Auth::guard('provider-api')->user()->email)->update(['name' => $data['name'], 'mobile' => $data['mobile'], 'address' => $data['address'], 'city' => $data['city'], 'about' => $data['about'], 'photo' => $image_path]);

            return response()->json([
                'success' => true,
                'message' => 'Your Profile Has been Updated successfully.',
                'status' => $provider,
            ], 202);
        }
    }

    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            if (Hash::check($data['current_pwd'], Auth::guard('provider-api')->user()->password)) {
                if ($data['new_pwd'] == $data['confirm_pwd']) {
                    Provider::where('id', Auth::guard('provider-api')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    return response()->json([
                        'status' => true,
                        'message' => "Password has been updated Successfully",
                    ], 202);
                } else {
                    return response()->json([
                        "status" => false,
                        "message" => "new Password & confirm password not match!",
                    ], 422);
                }
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Incorrect Current Password!",
                ], 422);
            }
        }
    }

    /*------------------------------------------
    admin forgot password 
    --------------------------------------------*/
    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email|exists:providers',
            ]);

            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);


            $url = "http://localhost:8000/seller/reset-password/".$token;
            
            Mail::to($request->email)->send(new ForgotMail($url));


            return response()->json([
                'status' => true,
                'message' => 'please check your email for new password!',
            ], 200);
        }
    }


    // ...........reset password............ 
    public function resetPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:providers',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return response()->json(['error', 'Invalid token!']);
        }

        $user = Provider::where('email', $request->email)->update(['password' => bcrypt($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();


        return response()->json([
            'status' => true,
            'message' => 'Your password has been changed!',
        ], 200);

    }



    public function logout()
    {

        $access_token = auth()->user()->token();

        // logout from only current device
        $tokenRepository = app(TokenRepository::class);
        $tokenRepository->revokeAccessToken($access_token->id);


        return response()->json([
            'success' => true,
            'message' => 'User logout successfully.'
        ], 200);

    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $providers = new Provider();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['providerType', 'city'];
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
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $providers = $providers->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy, $request->all());

            return response()->json($providers);
        }
        $providers = Provider::with(['providerType', 'city'])->latest()->get();

        return response()->json($providers);
    }



    public function store(Request $request)
    {
        // dd($request->all());
        $rulse =[
            "name"       =>'required',
            "email"        =>'required|unique:providers',
            "providerType_id"     =>'required',
            "mobile"       =>'required|min:11|numeric',
            "address"       =>'required',
            "city"       =>'required',
            "about"       =>'required',
            "password"    =>'required|min:6',

        ];
        $customMessage = [
            'name.required' => "Name is required",
            'email.required' => "Email is required",
            'providerType_id.required' => "Provider Type is required",
            'mobile.required' => "Mobile is required",
            'address.required' => "Address is required",
            'city.required' => "City is required",
            'about.required' => "About is required",

        ];

        $validator = Validator::make($request->all(), $rulse, $customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('photo')) {
            $image_tmp = $request->file('photo');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
                $image_path = 'uploads/provider' . '/' . $fileName;

                Image::make($image_tmp)->resize(150, 150)->save($image_path);
                $image_path = '/' . $image_path;
            }
        } 

        Provider::Create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'providerType_id' => $request->providerType_id,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'city' => $request->city,
                'about' => $request->about,
                'photo' => $image_path,
                'status' => 1,
            ]
        );

        return response()->json(['success' => 'Provider Create successfully!']);

    }

    public function edit(Provider $provider)
    {
        return response()->json($provider);
    }

    public function update(Request $request, Provider $provider)
    {
        $rulse =[
            "name"       =>'required',
            "email"        =>'required|unique:providers,id,'.$provider->id,
            "providerType_id"     =>'required',
            "mobile"       =>'required|min:11|numeric',
            "address"       =>'required',
            "city"       =>'required',
            "about"       =>'required',

        ];
        $customMessage = [
            'name.required' => "Name is required",
            'email.required' => "Email is required",
            'providerType_id.required' => "Provider Type is required",
            'mobile.required' => "Mobile is required",
            'address.required' => "Address is required",
            'city.required' => "City is required",
            'about.required' => "About is required",

        ];

        $validator = Validator::make($request->all(), $rulse, $customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'providerType_id' => $request->providerType_id,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'city' => $request->city,
            'about' => $request->about,
            'status' => 1,
        ];

        if ($request->hasFile('photo')) {
            $image_tmp = $request->file('photo');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
                $image_path = 'uploads/provider' . '/' . $fileName;

                Image::make($image_tmp)->resize(150, 150)->save($image_path);
                $image_path = '/' . $image_path;
                $data['photo'] = $image_path;
            }
        } 

        $provider->update($data);

        return response()->json(['success' => 'Provider Update successfully!']);

    }

    public function destroy(Provider $provider)
    {
        if (is_null($provider)) {
            return response()->json(["message" => "Recode Not Found !"], 404);
        }

        try {
            //code...
            $image_url = $provider->photo;
            $provider->delete();
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
            'status' => false,
            'message' => 'Provider has been deleted Successfull',
        ], 200);
    }




    public function getProviderType()
    {
        $providerTypes = ProviderType::select('id', 'provider_type')->latest()->get();
        return response()->json($providerTypes);
    }

    public function getCity()
    {
        $citys = City::select('id', 'name')->latest()->get();
        return response()->json($citys);
    }


    public function show(Provider $provider)
    {
        $total_handyman = Handyman::where('provider_id', $provider->id)->count();
        $total_service = Service::where('provider_id', $provider->id)->count();
        $reviews = SellerReview::where('provider_id', $provider->id)->with(['service'])->get();
        $handyman = Handyman::where('provider_id', $provider->id)->latest()->get();
        $service = Service::where('provider_id', $provider->id)->latest()->get();
        $provider = $provider->with(['providerType'])->find($provider->id);
        return response()->json(['provider' => $provider,'total_handyman'=>$total_handyman,'total_service'=>$total_service,'service'=>$service,'handyman'=>$handyman,'reviews'=>$reviews]);
    }

        
    public function updatePrviderReviewStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if ($data['status']=="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		SellerReview::where('id',$data['StatusReview_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status,'StatusReview_id'=>$data['StatusReview_id']]);
    	}
    }

    public function providerServiceDetails(Service $service){
        $service = $service->with(['category'])->find($service->id);
        return response()->json($service);
    }

    public function profileWidget()
    {
        $provider = Provider::first();
        $total_handyman = Handyman::where('provider_id', $provider->id)->count();
        $total_service = Service::where('provider_id', $provider->id)->count();
        // $booking = Booking::where('provider_id',$provider->id)->first();
        // $total_customer = User::where('id',$booking->user_id)->count();
        return response()->json(['total_handyman' => $total_handyman, 'total_service' => $total_service]);
    }

    //resent booking list dashboard
    public function resentBooking()
    {
        $booking = Booking::with(['service'])->where('provider_id', Auth::guard('provider-api')->user()->id)->latest()->limit(10)->get();

        return response()->json($booking);
    }

    public function topSellService(){

        $booking = Booking::where(['provider_id'=>Auth::guard('provider-api')->user()->id,'status'=>'Complete'])->first();
        $topsell = Service::where('id',$booking->service_id)->latest()->limit(6)->get();
        
       return response()->json($topsell);

    }

    public function resentReview()
    {
        $review = Review::with(['service'])->latest()->get();
        return response()->json($review);
    }

    public function dashboardWidget(){
        $total_handyman = Handyman::where('provider_id',Auth::guard('provider-api')->user()->id)->count();
        $total_order    = Booking::where(['provider_id'=>Auth::guard('provider-api')->user()->id])->count();
        $total_service  = Service::where(['provider_id'=>Auth::guard('provider-api')->user()->id])->count();
        $total_revinew  = Booking::where(['provider_id'=>Auth::guard('provider-api')->user()->id,'status'=>'Complete'])->sum('price');

        return response()->json([
            'total_handyman'=>$total_handyman,
            'total_order'=>$total_order,
            'total_service'=>$total_service,
            'total_revinew'=>$total_revinew,
        ]);
    }

    public function serviceProfile()
    {
        $Profile_service = Service::where('provider_id',Auth::guard('provider-api')->user()->id)->with(['category'])->latest()->limit(6)->get();
         return response()->json(['Profile_service'=>$Profile_service]);
    }


    public function updateProviderStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if ($data['status']=="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		Provider::where('id',$data['provider_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status,'provider_id'=>$data['provider_id']]);
    	}
    }


    

    
}
