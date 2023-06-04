<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::with(['parent'])->get();
        // dd($menu);
        return response()->json($menu);
    }

    public function getsubmenu()
    {
        $getMenu = Menu::select('id', 'name', 'parent_id')->get();

        return response()->json($getMenu);
    }
    public function store(Request $request)
    {
        $rulse =[
            "name"      =>"required",
            "url"     =>"required",
            
        ];
        $customMessage = [
            'name.required'     =>"Header Menu is Required",
            'url.required'    =>"Header Menu Url is Required"
        ];

        $validator = Validator::make($request->all(), $rulse,$customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        if ($request->parent_id) {
            $submenu = $request->parent_id;
        } else {
            $submenu = 'Root';
        }
        Menu::Create(['name' => $request->name, 'parent_id' =>$submenu, 'url' => $request->url,'serial' => $request->serial]);  

        return response()->json(['success'=>'Header Menu saved successfully.']);
    }
    public function edit(Menu $menu)
    {
        return response()->json($menu);
    }


    public function update(Request $request, Menu $menu)
    {
        $rulse = [
            "name"      => "required",
            "url"     => "required",

        ];
        $customMessage = [
            'name.required'     => "Named is Required",
            'url.required'    => "Url is Required"
        ];

        $validator = Validator::make($request->all(), $rulse, $customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->parent_id) {
            $submenu = $request->parent_id;
        } else {
            $submenu = 'Root';
        }
        $data = [
        'name' => $request->name, 
        'parent_id' => $submenu,
        'url' => $request->url,
        'serial' => $request->serial,
    ];
        $menu->Update($data);

        return response()->json(['success' => 'Menu Updated successfully.']);
    }

    public function destroy(Menu $menu)
    {
        if (is_null($menu)) {
            return response()->json(["message" => "Recode Not Found !"], 404);
        }

        try {
            //code...
            $menu->delete();
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
            'message'   => 'Menu has been deleted successfull',
        ], 200);

    }


    public function updateMenuStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if ($data['status']=="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		Menu::where('id',$data['menu_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status,'menu_id'=>$data['menu_id']]);
    	}
    }
}
