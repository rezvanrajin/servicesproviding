<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;


class UserReviewController extends Controller
{
    
    public function index(Request $request){
        if ($request->wantsJson()) {
            $reviews = new Review();
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
                $search['ratting'] = $request->input('search')['value'];
                $search['review'] = $request->input('search')['value'];
            }

            if($request->input('where')){
                $where = $request->input('where');
            }

            $reviews = $reviews->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($reviews);
        }
        $reviews = Review::latest()->get();
        return response()->json($reviews);
    }

    public function destroy($id)
    {
        $review = Review::find($id);
        if (is_null($review)) {
                return response()->json(["message"=>"Recode Not Found !"],404);
        }
       
        $review->delete();
        return response()->json([
            'status'    =>false,
            'message'   =>'Review has been deleted successfull',
            'review'  =>$review,
        ],200);
    }

       public function show(Review $usersreview){
        $usersreview = $usersreview->with(['user','service'])->find($usersreview->id);
        return response()->json($usersreview);
    }
}
