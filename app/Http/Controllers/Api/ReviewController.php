<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function review(Request $request,$id){
        if($request->isMethod("post")){
            $data = $request->input();
            $rulse =[
                "ratting" =>"required",
                "review" =>'required',
                
            ];
            $customMessage = [
                'ratting.required' =>"Ratting is Required",
                'review.required' =>"Review is Required",
            ];
    
            $validator = Validator::make($request->all(), $rulse,$customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(),400);
            }

            // $booking = Booking::find($id);

            $review = new Review;
            $review->user_id = Auth::user()->id;
            $review->service_id = $data['service_id'];
            $review->ratting = $data['ratting'];
            $review->review = $data['review'];
            $review->save();

            return response()->json([
                'status'=>true,
                'message'=>'Thank You for your Review',
                'review'=>$review,
            ],201);
        }
    }

    public function providerReview(Request $request){
        if ($request->wantsJson()) {
            $reviews = new Review();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
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

    public function ReviewDetails($id){
        $review = Review::with(['user','service'])->find($id);
        return response()->json($review);
    }
}
