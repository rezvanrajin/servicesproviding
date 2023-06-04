<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Booking;
use App\Mail\AssignMail;
use App\Mail\StatusMail;
use App\Models\Handyman;
use Illuminate\Http\Request;
use App\Models\AssignHandyman;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class ProviderBookingController extends Controller
{
    public function index(Request $request){
        if ($request->wantsJson()) {
            $bookings = new Booking();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = ['provider_id' => Auth::guard('provider-api')->user()->id];
            $with = ['category', 'service', 'handyman'];
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
           
            //   $search['bookings.service.name'] = $request->input('search')['value'];
         
            }
      
            if ($request->input('where')) {
              $where = $request->input('where');
            }
      
            $bookings = $bookings->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($bookings);
          }
          $bookings = Booking::with(['category', 'service', 'handyman'])->where(['provider_id' => Auth::guard('provider-api')->user()->id])->latest()->get();
      
          return response()->json($bookings);
    }

    public function destroy(Booking $providersbooking){
        if (is_null($providersbooking)) {
            return response()->json(["message"=>"Recode Not Found !"],404);
      }
      $providersbooking->delete();
      return response()->json([
        'status'        =>false,
        'message'       =>'Booking has been deleted Successfull',
        'booking'  =>$providersbooking,
      ],200); 
    }

    public function show(Booking $providersbooking){
        $providersbooking = $providersbooking->with(['user', 'service', 'provider', 'category', 'handyman'])->find($providersbooking->id);
        return response()->json($providersbooking);
    }

    public function providersbookingStatus(Booking $providersbooking){
      return response()->json($providersbooking);
    }

    public function bookingStatus(Request $request, Booking $providersbooking){

      
      $providersbooking->find($providersbooking->id)->update(['status' => $request->status]);
      $booking = Booking::find($providersbooking->id)->with(['service'])->first();
      $user = User::where('id', $providersbooking->user_id)->first();
   
      Mail::to($user->email)->send(new StatusMail($user,$booking));
      
      return response()->json($booking);
    }

    public function getHandyman(){
      $handyman = Handyman::where('provider_id', Auth::guard('provider-api')->user()->id)->where('status', 1)->select('id', 'name')->latest()->get();
      return response()->json($handyman);
    }

    public function providersbookingAssignHandyman(Booking $providersbooking){
      return response()->json($providersbooking);
    }

    // public function bookingAssignHandyman(){

    // }

    public function handymanAssign(Request $request)
    {
        if ($request->isMethod('post')) {
            $rulse = [
                "handyman_id"      => 'required',

            ];
            $customMessage = [
                'handyman_id.required'   => "Handuman ID is required",
            ];

            $validator = Validator::make($request->all(), $rulse, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $assign = new AssignHandyman;
            $assign->booking_id =  $request->booking_id;
            $assign->user_id =  $request->user_id;
            $assign->service_id = $request->service_id;
            $assign->handyman_id = $request->handyman_id;
            $assign->provider_id = $request->provider_id;
            $assign->status = 0;
            $assign->save();

            Booking::where('id', $request->booking_id)->update(['handyman_id' => $request->handyman_id]);

            $user = User::where('id', $request->user_id)->first();
            $email = $user['email'];
            $booking_id = $request->booking_id;

            $handyman = Handyman::where('id', $request->handyman_id)->first();
            
            // dd($user);
            Mail::to($email)->send(new AssignMail($handyman,$user,$booking_id));

            return response()->json($assign);
        }
    }
   
}
