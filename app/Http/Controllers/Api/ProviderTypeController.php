<?php

namespace App\Http\Controllers\Api;

use App\Models\ProviderType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProviderTypeController extends Controller
{
 
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $provider_type = new ProviderType();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = [];
            $join = [];
            $orderBy = [];

            if($request->input('length')){
                $limit = $request->input('length');
            }
            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }
            if($request->input('start')){
                $offset = $request->input('start');
            }

            if($request->input('search') && $request->input('search')['value'] != ""){
                $search['provider_type'] = $request->input('search')['value'];
            }

            if($request->input('where')){
                $where = $request->input('where');
            }
            $provider_type = $provider_type->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($provider_type);
        }
        $provider_type = ProviderType::latest()->get();
        return response()->json($provider_type);
    }

    public function store(Request $request)
    {
        $rulse =[
            "provider_type"      =>"required|string|unique:provider_types|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/",
            "comission_rate"     =>"required",
            
        ];
        $customMessage = [
            'provider_type.required'     =>"Provider Type is Required",
            'comission_rate.required'    =>"Comission Rate is Required"
        ];

        $validator = Validator::make($request->all(), $rulse,$customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        ProviderType::Create(
        ['provider_type' => $request->provider_type, 'comission_rate' => $request->comission_rate]);  

        return response()->json(['success'=>'Provider Type Create successfully.']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProviderType $providerType)
    {
        return response()->json($providerType);
    }

    public function update(Request $request,ProviderType $providerType)
    {
        // dd($request->all());
        $rulse =[
            "provider_type"      =>"required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|unique:provider_types,id,".$providerType->id,
            "comission_rate"     =>"required",
            
        ];
        $customMessage = [
            'provider_type.required'     =>"Provider Type is Required",
            'comission_rate.required'    =>"Comission Rate is Required"
        ];

        $validator = Validator::make($request->all(), $rulse,$customMessage);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $data = [
            'provider_type' => $request->provider_type, 
            'comission_rate' => $request->comission_rate
        ];

        $providerType->update($data);  

        return response()->json(['success'=>'Provider Type Update successfully.']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProviderType $providerType)
    {
        
        if (is_null($providerType)) {
                return response()->json(["message"=>"Recode Not Found !"],404);
        }
        $providerType->delete();
        return response()->json([
            'status'        =>false,
            'message'       =>'Provider Type has been deleted Successfull',
            'providerType'  =>$providerType,
        ],200); 
    }
}
