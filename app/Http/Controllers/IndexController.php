<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function dashboard()
    {
        return view('layout.user.layout');
    }

    public function favorites()
    {
        return view('backend.user.favourite.favourite');
    }

    public function order()
    {
        return view('backend.user.order.order');
    }
    public function reviews()
    {
        return view('backend.user.review.review');

    }
    public function support()
    {
        return view('backend.user.support.support');
    }
}
