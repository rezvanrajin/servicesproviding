<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /*------------------------------------------
    admin category list
--------------------------------------------*/
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $categories = new Category();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['parent'];
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
                $search['name'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $categories = $categories->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($categories);
        }
        $categories = Category::with(['parent'])->latest()->get();

        return response()->json($categories);
    }

    /*------------------------------------------
    admin category create and update
--------------------------------------------*/
    public function store(Request $request)
    {

        $rulse = [
            "name"      => "required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|unique:categories",

        ];
        $customMessage = [
            'name.required'     => "Name is Required"
        ];

        $validator = Validator::make($request->all(), $rulse, $customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        if ($request->parent_id) {
            $subcategory = $request->parent_id;
        } else {
            $subcategory = 'Root';
        }

        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
                $image_path = 'uploads/category' . '/' . $fileName;

                Image::make($image_tmp)->resize(150, 150)->save($image_path);

                $image_path = '/' . $image_path;
            }
        }

        Category::Create(
            [
                'name'          => $request->name,
                'parent_id'     => $subcategory,
                'image'         => $image_path,
            ]
        );

        return response()->json(['success' => 'Category saved successfully.']);
    }

    /*------------------------------------------
    admin category edit
--------------------------------------------*/

    public function edit(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {

        // dd($request->all());
        $rulse = [
            "name"      => "required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|unique:categories,id,".$category->id,

        ];
        $customMessage = [
            'name.required'     => "Name is Required"
        ];

        $validator = Validator::make($request->all(), $rulse, $customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->parent_id) {
            $subcategory = $request->parent_id;
        } else {
            $subcategory = 'Root';
        }

        $data = [
            'name'          => $request->name,
            'parent_id'     => $subcategory,
        ];

        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');

            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = $image_name . '-' . rand(111, 99999) . '.' . $extension;
                $image_path = 'uploads/category' . '/' . $fileName;

                Image::make($image_tmp)->resize(300, 300)->save($image_path);

                $image_path = '/' . $image_path;

                $data['image'] = $image_path;
            }
        }


        $category->update($data);

        return response()->json(['success' => 'Category Updated successfully.']);
    }
    /*------------------------------------------
    admin category destroy
--------------------------------------------*/
    public function destroy(Category $category)
    {
        if (is_null($category)) {
            return response()->json(["message" => "Recode Not Found !"], 404);
        }

        try {
            //code...
            $image_url = $category->image;
            $category->delete();
            unlink($image_url);
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
            'message'   => 'Category has been deleted successfull',
        ], 200);
    }

    public function getSubcategory()
    {
        $getCategories = Category::select('id', 'name', 'parent_id')->get();

        return response()->json($getCategories);
    }
    public function updateCategoryStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if ($data['status'] =="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		Category::where('id',$data['category_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
    	}
    }

    public function updateCategoryFeaturedStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if ($data['featured']=="Featured") {
    			$featured = 0;
    		}else{
    			$featured = 1;
    		}
    		Category::where('id',$data['categoryFeatured_id'])->update(['featured'=>$featured]);
    		return response()->json(['featured'=>$featured,'categoryFeatured_id'=>$data['categoryFeatured_id']]);
    	}
    }

}
