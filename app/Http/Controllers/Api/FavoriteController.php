<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
       /*------------------------------------------
    Favorite list
--------------------------------------------*/
public function index(Request $request) {
    if ($request->wantsJson()) {
        $favorites = new Favorite();
        $limit = 10;
        $offset = 0;
        $search = [];
        $where = [];
        $with = ['service'];
        $join = [];
        $orderBy = [];

        if($request->input('length')){
            $limit = $request->input('length');
        }

        if ($request->input('order')[0]['column'] != 0) {
            $column_name = $request->input('columns')[$request->input('order')[0]['column']]['id']['column']['name'];
            $sort = $request->input('order')[0]['dir'];
            $orderBy[$column_name] = $sort;
        }

        if($request->input('start')){
            $offset = $request->input('start');
        }

        if($request->input('search') && $request->input('search')['value'] != ""){
            $search['id'] = $request->input('search')['value'];
            $search['service_id'] = $request->input('search')['value'];
        }

        if($request->input('where')){
            $where = $request->input('where');
        }

        $favorites = $favorites->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
        return response()->json($favorites);
    }

    $favorites = Favorite::latest()->get();
    return response()->json($favorites);
}

  /*------------------------------------------
    buyer favorite destroy
--------------------------------------------*/
public function destroy($id)
{
    $favorite = Favorite::find($id);
    if (is_null($favorite)) {
            return response()->json(["message"=>"Recode Not Found !"],404);
    }
   
    $favorite->delete();
    return response()->json([
        'status'    =>false,
        'message'   =>'Service has been deleted from favorite list',
        'favorite'  =>$favorite,
    ],200);
}
public function show(Favorite $favorite){
    $favorite = $favorite->with(['service'])->find($favorite->id);
    return response()->json($favorite);
}

}
