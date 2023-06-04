<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    
    //Pages Date shows
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $pages = new Page();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = [];
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
                $search['title'] = $request->input('search')['value'];
                $search['description'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $pages = $pages->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($pages);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rulse = [
            "title"      => "required",
            "description"     => "required",

        ];
        $customMessage = [
            'title.required'     => "Title is Required",
            'description.required'    => "Description is Required"
        ];

        $validator = Validator::make($request->all(), $rulse, $customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        Page::Create(
            ['title' => $request->title, 'description' => $request->description]
        );

        return response()->json(['success' => 'Page saved successfully.']);
    }

public function update(Request $request, Page $page){
    // dd($request->all());
            $rulse = [
                "title"      => "required",
                "description"     => "required",
    
            ];
            $customMessage = [
                'title.required'     => "Title is Required",
                'description.required'    => "Description is Required"
            ];
    
            $validator = Validator::make($request->all(), $rulse, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $data = [
            'title' => $request->title, 
            'description' => $request->description
            ];
            $page->Update($data);
    
            return response()->json(['success' => 'Page saved successfully.']);
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Page $page)
    {

        return response()->json($page);
    }




    public function destroy(Page $page)
    {
   
        if (is_null($page)) {
            return response()->json(["message" => "Recode Not Found !"], 404);
        }

        try {
            //code...
            $page->delete();
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
            'status'    => true,
            'message'   => 'Page has been deleted successfull',
        ], 200);


    }

    public function show(Page $page)
    {

        return response()->json($page);
    }
}
