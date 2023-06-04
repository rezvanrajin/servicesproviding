<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProviderController extends Controller
{

 public function booking()
 {
   return view('backend.provider.booking.booking');

 }

public function assignHandyman()
{
  return view('backend.provider.booking.assignhandyman');

}
public function coupons()
{
  return view('backend.provider.coupon.coupon');

}
public function customer()
{
  return view('backend.provider.customers.customer_list');

}
public function handyman()
{
  return view('backend.provider.handyman.handyman');

}
public function UserReview()
{
  return view('backend.provider.review.review');

}
public function SellerReview()
{
  return view('backend.provider.review.sellerReview');

}
public function providerService()
{
  return view('backend.provider.service.service');

}

public function emailSupport()
{
  return view('backend.provider.support.support');

}
public function dashboard()
{
  return view("backend.provider.dashboard");
}

}

