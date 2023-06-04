<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use PDF;


class BookingsController extends Controller
{
    
  /*------------------------------------------
    admin booking list
--------------------------------------------*/
  public function adminIndex(Request $request)
  {
    if ($request->wantsJson()) {
      $bookings = new Booking();
      $limit = 10;
      $offset = 0;
      $search = [];
      $where = [];
      $with = ['service', 'handyman'];
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
        $search['service.name'] = $request->input('search')['value'];
  
      }

      if ($request->input('where')) {
        $where = $request->input('where');
      }

      $bookings = $bookings->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
      return response()->json($bookings);
    }
    $bookings = Booking::with(['service', 'handyman'])->latest()->get();

    return response()->json($bookings);
  }

  /*------------------------------------------
    admin booking destroy
--------------------------------------------*/
  public function admindestroy(Booking $booking)
  {
    if (is_null($booking)) {
          return response()->json(["message"=>"Recode Not Found !"],404);
    }
    $booking->delete();
    return response()->json([
      'status'        =>false,
      'message'       =>'Booking has been deleted Successfull',
      'booking'  =>$booking,
    ],200); 
  }

  public function adminShow(Booking $booking)
  {
    $booking = $booking->with(['user', 'service', 'provider', 'category', 'handyman'])->find($booking->id);
    return response()->json($booking);
  }

  public function bookingStatusShow($id)
  {
    $booking = Booking::find($id);
    return response()->json($booking);
  }



  public function bookingInvoice($id)
  {
    $invoice = Booking::with(['user', 'service', 'provider', 'category', 'handyman'])->find($id);
    return response()->json($invoice);
  }


  // booking invoice PDF download

  public function invoicePDFdownload($id)
  {
    $invoice = Booking::with(['user', 'service', 'provider', 'category', 'handyman'])->find($id);
    $demo = ' <div class="card mb-5 card-print print-me">
        <div class="card-body">
          <div class="row d-flex flex-row align-items-center">
            <div class="col-12 col-md-6">
              <img src="https://img.freepik.com/free-vector/branding-identity-corporate-vector-logo-design_460848-8717.jpg?w=2000" class="sw-17" alt="logo">
            </div>
            <div class="col-12 col-md-6 text-end">
              <div class="mb-2">' . $invoice['id'] . '</div>
              <div class="text-small text-muted">' . $invoice->provider['email'] . $invoice->provider['address'] . '</div>
              <div class="text-small text-muted">' . $invoice->provider['mobile'] . '</div>
            </div>
          </div>
          <div class="separator separator-light mt-5 mb-5"></div>
          <div class="row g-1 mb-5">
            <div class="col-12 col-md-8">
              <div class="py-3">
                <div>' . $invoice->user['name'] . '</div>
                <div>' . $invoice->user['mobile'] . $invoice->user['address'] . $invoice->user['post_code'] . '</div>
                <div>' . $invoice->user['state'] . $invoice->user['city'] . '</div>
                <div> ' . $invoice->user['country'] . '</div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="py-3 text-md-end">
                <div>Invoice #:' . $invoice['id'] . '</div>
                <div>' . $invoice['created_at'] . '</div>
              </div>
            </div>
          </div>

          <div>
            <div class="row mb-4 d-none d-sm-flex">
              <div class="col-6">
                <p class="mb-0 text-small text-muted">ITEM NAME</p>
              </div>
              <div class="col-3">
                <p class="mb-0 text-small text-muted">COUNT</p>
              </div>
              <div class="col-3 text-end">
                <p class="mb-0 text-small text-muted">PRICE</p>
              </div>
            </div>

            <div class="row mb-4 mb-sm-2">
              <div class="col-12 col-sm-6">
                <h6 class="mb-0">' . $invoice->service['name'] . '</h6>
              </div>
              <div class="col-12 col-sm-3">
                <p class="mb-0 text-alternate">1 Service</p>
              </div>
              <div class="col-12 col-sm-3 text-sm-end">
                <p class="mb-0 text-alternate">' . $invoice['price'] . $invoice->service['price_type'] . '</p>
              </div>
            </div>
           
          </div>

          <div class="separator separator-light mt-5 mb-5"></div>

          <div class="row">
            <div class="col text-sm-end text-muted">
              <div>Subtotal :</div>
              <div>Tax :</div>
              <div>Shipping :</div>
              <div>Total :</div>
            </div>
            <div class="col-auto text-end">
              <div>' . $invoice->service['price_type'] . $invoice['price'] . '</div>
              <div>' . $invoice->service['price_type'] . ' 0.0</div>
              <div>' . $invoice->service['price_type'] . ' 0.0</div>
              <div>' . $invoice->service['price_type'] . $invoice['price'] . '</div>
            </div>
          </div>

          <div class="separator separator-light"></div>

          <div class="text-small text-muted text-center">Invoice was created on a computer and is valid without the signature and seal.</div>
        </div>
      </div>';
    $pdf = PDF::loadHtml($demo);

    $fileName =  time() . '.' . 'pdf';
    $pdf->save($fileName);
    $pdf = public_path('/' . $fileName);
    return response()->download($pdf);
  }

  //provider bookingList PDF Download
  public function bookingPDFdownload($id)
  {
  }

  public function sellerUserList(Request $request)
  {

    if ($request->wantsJson()) {
      $users = new Booking();
      $limit = 10;
      $offset = 0;
      $search = [];
      // $where = ['provider_id' => Auth::guard('provider-api')->user()->id];
      $with = ['user'];
      $join = [];
      $orderBy = [];

      if ($request->input('length')) {
        $limit = $request->input('length');
      }

      if ($request->input('order')[0]['column'] != 0) {
        $column_name = $request->input('columns')[$request->input('order')[0]['column']]['id']['column']['user_id']['column']['user.email'];
        $sort = $request->input('order')[0]['dir'];
        $orderBy[$column_name] = $sort;
      }

      if ($request->input('start')) {
        $offset = $request->input('start');
      }

      if ($request->input('search') && $request->input('search')['value'] != "") {
        $search['id'] = $request->input('search')['value'];
        $search['user_id'] = $request->input('search')['value'];
        $search['user.email'] = $request->input('search')['value'];
      }

      // if ($request->input('where')) {
      //   $where = $request->input('where');
      // }

      $users = $users->getDataForDataTable($limit, $offset, $search, $with, $join, $orderBy,  $request->all());
      return response()->json($users);
    }
  }
}
