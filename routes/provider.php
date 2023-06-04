<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('/provider')->namespace('App\Http\Controllers\Api')->group(function(){
    Route::post('register','ProviderController@register');
    Route::post('login','ProviderController@login');
    
    Route::post('forgot-password','ProviderController@forgotPassword')->name('provider.forgot.password');
    Route::post('reset-password','ProviderController@resetPassword')->name('provider.reset.password');
    
    Route::group( ['middleware' => ['auth:provider-api','scopes:provider'] ],function(){
     Route::get('dashboard','ProviderController@dashboard');
     Route::post('logout','ProviderController@logout');


    Route::resource('providersbookings', ProviderBookingController::class);
    Route::resource('assign_handymen', AssignHandymanController::class);
    Route::resource('providersCoupons', ProviderCouponController::class);
    Route::resource('handymen', HandymanController::class);
Route::get('getUserAll','ProviderCouponController@getUserAll')->name('providersCoupons.getUserAll');
Route::get('getAllCity','HandymanController@getAllCity')->name('handyman.getAllCity');
Route::get('provider/customer-list/{id}','UserController@providerCustomerList')->name('provider.providerCustomerList');
Route::get('buyer-booking-list','BookingsController@sellerUserList')->name('provider.sellerUserList');
Route::get('review/detaisl/{id}','ReviewController@ReviewDetails')->name('provider.review.details');
Route::get('reviews','ReviewController@providerReview')->name('provider.review.index');
Route::resource('sellerReviews', SellerReviewController::class);
Route::resource('services', ServiceController::class);
Route::post('update-serviceFeatured-status','ServiceController@updateServiceFeaturedStatus')->name('services.updateServiceFeaturedStatus');
Route::get('category','ServiceController@getCategory')->name('provider.service.getCategory');
Route::get('getproviders','ServiceController@getproviders')->name('provider.service.getproviders');
Route::resource('sellersupport', ProviderSupportController::class);









    
});
});