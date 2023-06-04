<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function resentBooking()
    {
        $booking = Booking::where('user_id',Auth::user('api')->id)->select('id','status','price','date_time')->latest()->limit(10)->get();
        return response()->json($booking);
    }

    public function index(Request $request){
        if ($request->wantsJson()) {
            $bookings = new Booking();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = ['user_id'=>Auth::guard('api')->user()->id];
            $with = ['user','service'];
            $join = [];
            $orderBy = [];
            
            if($request->input('length')){
                $limit = $request->input('length');
            }

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]
                ['column']]['id']['column']['user.name']['column']['service.name']['column']['ratting']['column']['review'];

                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }

            if($request->input('start')){
                $offset = $request->input('start');
            }

            if($request->input('search') && $request->input('search')['value'] != ""){
                $search['id'] = $request->input('search')['value'];
                $search['user_id'] = $request->input('search')['value'];
                // $search['user.name'] = $request->input('search')['value'];

            }

            if($request->input('where')){
                $where = $request->input('where');
            }

            $bookings = $bookings->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($bookings);
        }
        $bookings = Booking::latest()->get();
        return response()->json($bookings);
    }

    public function show(Booking $usersbooking)
    { 
            $usersbooking = $usersbooking->with(['user', 'service', 'provider', 'category', 'handyman'])->find($usersbooking->id);
            return response()->json($usersbooking);
        
    }
}
