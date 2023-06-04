<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mailbox;
use App\Models\Admin;

class ProviderSupportController extends Controller
{
    public function index(Request $request)
    {

        if ($request->wantsJson()) {

            $mailbox = new Mailbox();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = ['provider_id'=>Auth::guard('provider-api')->user()->id];
            $with = ['provider'];
            $join = [];
            $orderBy = [];

            if ($request->input('length')) {
                $limit = $request->input('length');
            }

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['id']['column']['email']['column']['subject'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }

            if ($request->input('start')) {
                $offset = $request->input('start');
            }

            if ($request->input('search') && $request->input('search')['value'] != "") {
                $search['id'] = $request->input('search')['value'];
                $search['email'] = $request->input('search')['value'];
                $search['subject'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $mailbox = $mailbox->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($mailbox);
        }
    }

    public function store(Request $request)
    {
        if ($request->isMethod("post")) {
            $replayMail = new Mailbox;
            $replayMail->user_id = 0;
            $replayMail->provider_id = Auth::guard('provider-api')->user()->id;
            $replayMail->admin_id = 0;
            $replayMail->email = $request->email;
            $replayMail->subject = $request->subject;
            $replayMail->description = $request->description;
            $replayMail->status = 0;
            $replayMail->save();
    }

    return response()->json($replayMail);

}




    public function destroy(Mailbox $sellersupport)
    {
        if (is_null($sellersupport)) {
            return response()->json(["message" => "Recode Not Found !"], 404);
        }
    
        try {
            //code...
            $sellersupport->delete();
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
            'message'   => 'Mail has been deleted successfull',
        ], 200);
    }
    


    public function show(Mailbox $sellersupport)
{

    return response()->json($sellersupport);
}


public function adminData()
{
    $admin = Admin::Select('id','email')->get();
    return response()->json($admin);

}

}
