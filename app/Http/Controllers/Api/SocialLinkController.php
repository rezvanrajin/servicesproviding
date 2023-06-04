<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialLink;


class SocialLinkController extends Controller
{
        
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $social_links = new SocialLink();
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
                $search['link'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }


            $social_links = $social_links->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($social_links);
        }

        $social_links = SocialLink::latest()->get();
        return response()->json($social_links);
    }
    public function store(Request $request)
    {

        // dd($request->all());
        request()->validate([
            'icon' => 'required',
            'link' => 'required',
        ]);

        SocialLink::Create(
            [
                'icon'   => $request->icon,
                'link'   => $request->link,
            ]
        );

        return Response()->json(['message' => 'SocialLinks Create Successfully !']);
    }
    public function edit(SocialLink $social_link)
    {
        return response()->json($social_link);
    }
    public function update(Request $request, SocialLink $social_link)
    {

        request()->validate([
            'icon' => 'required',
            'link' => 'required',
        ]);

   
        $data = [
            'icon'   => $request->icon,
            'link'   => $request->link,

        ];
        $social_link->Update($data);

        return Response()->json(['message' => 'SocialLinks Create Successfully !']);

    }
    public function destroy(SocialLink $social_link)
    {
        if (is_null($social_link)) {
            return response()->json(["message" => "Recode Not Found !"], 404);
        }

        try {
            //code...
            $social_link->delete();
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
            'message'   => 'SocailLink has been deleted successfull',
        ], 200);
    }
}
