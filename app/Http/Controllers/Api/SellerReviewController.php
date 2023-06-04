<?php

namespace App\Http\Controllers\Api;

use App\Models\SellerReview;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerReviewController extends Controller
{
    public function index(Request $request){
        // dd($request->all());
        if ($request->wantsJson()) {
            $SellerReviews = new SellerReview();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = ['provider_id'=>Auth::guard('provider-api')->user()->id];
            $with = ['user'];
            $join = [];
            $orderBy = [];

            if ($request->input('length')) {
                $limit = $request->input('length');
            }

            // dd($request->input('order'));

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }

            if ($request->input('start')) {
                $offset = $request->input('start');
            }

            if ($request->input('search') && $request->input('search')['value'] != "") {
                
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $SellerReviews = $SellerReviews->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($SellerReviews);
        }
        $SellerReviews = SellerReview::latest()->get();

        return response()->json($SellerReviews);
    }
}
