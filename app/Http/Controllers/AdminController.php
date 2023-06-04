<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('layout.admin.layout');
    }
    public function CategoryShow()
    {
        return view('backend.admin.category.category');
    }
    public function CityShow()
    {
        return view('backend.admin.city.city');

    }
    public function bookings()
    {
        return view('backend.admin.booking.bookings');
    }
    public function handymans()
    {
        return view('backend.admin.handyman.handymans');

    }
    public function provider()
    {
        return view('backend.admin.provider.provider');
    }
    public function providerType()
    {
        return view('backend.admin.providerType.providerType');
    }
    public function services()
    {
        return view('backend.admin.service.service');
    }
    public function menu()
    {
        return view('backend.admin.Headermenu.headermenu');

    }
    public function page()
    {
        return view('backend.admin.pages.page');

    }
    public function coupon()
    {
        return view('backend.admin.coupon.coupon');

    }
    public function footer()
    {
        return view('backend.admin.footer_setting.footer_setting');
    }
    public function social()
    {
        return view('backend.admin.social.social');

    }
    public function users()
    {
        return view('backend.admin.user.user');

    }
    public function Inactiveusers()
    {
        return view('backend.admin.user.userIactive');

    }
    public function dashboard()
    {
        return view('backend.admin.dashboard');   
    }
    public function SEOSetting()
    {
        return view('backend.admin.setting.seo-setting');   

    }
    public function generalSetting()
    {
        return view('backend.admin.setting.general-setting');   

    }
    public function systemSetting()
    {
        return view('backend.admin.setting.system-setting');   

    }
}
