<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Booking;
use App\Mail\StatusMail;
use App\Models\Handyman;
use Illuminate\Http\Request;
use App\Models\AssignHandyman;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class AssignHandymanController extends Controller
{
    public function index(Request $request)
    {

        if ($request->wantsJson()) {
            $assign_handymen = new AssignHandyman();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = ['provider_id' => Auth::guard('provider-api')->user()->id];
            $with = ['handyman', 'service'];
            $join = [];
            $orderBy = [];

            if ($request->input('length')) {
                $limit = $request->input('length');
            }

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['id']['column']['booking_id ']['column']['provider_id ']['column']['handyman_id'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }

            if ($request->input('start')) {
                $offset = $request->input('start');
            }

            if ($request->input('search') && $request->input('search')['value'] != "") {
                $search['id'] = $request->input('search')['value'];
                $search['booking_id'] = $request->input('search')['value'];
                $search['provider_id'] = $request->input('search')['value'];
                $search['handyman_id'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $assign_handymen = $assign_handymen->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($assign_handymen);
        }
        $assign_handymen = AssignHandyman::where('provider_id', Auth::guard('provider-api')->user()->id)->latest()->get();
        return response()->json($assign_handymen);
    }



    public function handymanAssignEdit(AssignHandyman $assign_handymen,$id)
    {
        $booking = Booking::find($id);
        return response()->json($booking);
    }

    public function show(AssignHandyman $assign_handyman)
    {
        $assign_handyman = $assign_handyman-> with(['booking', 'handyman', 'service', 'user'])->find($assign_handyman->id);
        return response()->json($assign_handyman);
    }

    // public function getHandyman()
    // {
    //     $handyman = Handyman::where('provider_id', Auth::guard('provider-api')->user()->id)->where('status', 1)->select('id', 'name')->latest()->get();
    //     return response()->json($handyman);
    // }
}
