<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('/admin')->namespace('App\Http\Controllers')->group(function(){

    Route::match(['get','post'],'/','AdminCommonController@login')->name('admin.login');
    
Route::group(['middleware' => ['admin']], function () {
Route::get('dashboard','AdminController@dashboard')->name('admin.dashboard');
Route::get('admin-logout','AdminCommonController@logout')->name('admin.logout');
Route::get('/admin-category','AdminController@CategoryShow')->name('admin.category');
Route::get('/admin-city','AdminController@CityShow')->name('admin.city');
Route::get('/admin-bookings','AdminController@bookings')->name('admin.bookings');
Route::get('/admin-handymans','AdminController@handymans')->name('admin.handymans');
Route::get('/admin-provider','AdminController@provider')->name('admin.provider');
Route::get('/admin-providerType','AdminController@providerType')->name('admin.providerType');
Route::get('/admin-services','AdminController@services')->name('admin.services');
Route::get('/admin-menu','AdminController@menu')->name('admin.menu');
Route::get('/admin-page','AdminController@page')->name('admin.page');
Route::get('/admin-coupon','AdminController@coupon')->name('admin.coupon');
Route::get('/admin-footer','AdminController@footer')->name('admin.footer');
Route::get('/admin-social','AdminController@social')->name('admin.social');
Route::get('/admin-users','AdminController@users')->name('admin.users');
Route::get('/admin-Inactiveusers','AdminController@Inactiveusers')->name('admin.Inactiveusers');
Route::get('/admin-SEOSetting','AdminController@SEOSetting')->name('admin.SEOSetting');
Route::get('/admin-generalSetting','AdminController@generalSetting')->name('admin.generalSetting');
Route::get('/admin-systemSetting','AdminController@systemSetting')->name('admin.systemSetting');

});
});

Route::prefix('/provider')->namespace('App\Http\Controllers')->group(function(){
    Route::match(['get','post'],'/','ProviderCommonController@login')->name('provider.login');

    Route::group(['middleware' => ['provider']], function () {

    Route::get('dashboard','ProviderController@dashboard')->name('provider.dashboard');
    Route::get('logout','ProviderCommonController@logout')->name('provider.logout');

    
    Route::get('/provider-bookings','ProviderController@booking')->name('provider.booking');
    Route::get('/provider-assignHandyman','ProviderController@assignHandyman')->name('provider.assignHandyman');
    Route::get('/provider-coupons','ProviderController@coupons')->name('provider.coupons');
    Route::get('/provider-customer','ProviderController@customer')->name('provider.customer');
    Route::get('/provider-handyman','ProviderController@handyman')->name('provider.handyman');
    Route::get('/provider-UserReview','ProviderController@UserReview')->name('provider.UserReview');
    Route::get('/provider-SellerReview','ProviderController@SellerReview')->name('provider.SellerReview');
    Route::get('/provider-Service','ProviderController@providerService')->name('provider.service');
    Route::get('/provider-emailSupport','ProviderController@emailSupport')->name('provider.emailSupport');

});
});

Route::prefix('/buyer')->namespace('App\Http\Controllers')->group(function(){

 Route::get('forgot-password','LoginRegisterController@forgotPassword')->name('buyer.forgotPassword');
 Route::get('reset-password/{token}','LoginRegisterController@restPassword')->name('buyer.resetPassword');
 Route::match(['get','post'],'/login','LoginRegisterController@login')->name('buyer.login');
 Route::get('register','LoginRegisterController@register')->name('buyer.register');
 Route::get('login/google', 'LoginRegisterController@redirectToGoogle')->name('buyer.redirectToGoogle');
 Route::get('login/google/callback', 'LoginRegisterController@handleGoogleCallback')->name('handleGoogleCallback');
 Route::group(['middleware' => ['auth']], function () {
    
    
Route::get('/dashboard','IndexController@dashboard')->name('buyer.dashboard');
Route::get('/user-favorites','IndexController@favorites')->name('user.favorites');
Route::get('/user-order','IndexController@order')->name('user.allOrder');
Route::get('/user-reviews','IndexController@reviews')->name('user.reviews');
Route::get('/user-support','IndexController@support')->name('user.support');
    



});
});