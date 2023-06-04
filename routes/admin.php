<?php

use App\Models\SEOSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('/admin')->namespace('App\Http\Controllers\Api')->group(function(){

 Route::group( ['middleware' => ['auth:admin-api','scopes:admin'] ],function(){

Route::resource('categories', CategoryController::class);
Route::get('category/subcategory','CategoryController@getSubcategory')->name('admin.category.getSubcategory');
Route::post('update-category-status','CategoryController@updateCategoryStatus')->name('categories.updateCategoryStatus');
Route::post('update-categoryFeatured-status','CategoryController@updateCategoryFeaturedStatus')->name('categories.updateCategoryFeaturedStatus');

Route::resource('cities', CityController::class);
Route::post('update-city-status','CityController@updateCityStatus')->name('cities.updateCityStatus');

        //handyman view
Route::get('handymen','HandymanController@adminIndex')->name('handymen.adminIndex');
Route::post('update-handyman-status','HandymanController@updateHandymanStatus')->name('handymen.updateHandymanStatus');
Route::get('handymen/{handyman}/show','HandymanController@handymanShow')->name('handymen.handymanShow');
Route::delete('handymen/{handyman}/destroy','HandymanController@handymanDestroy')->name('handyman.handymanDestroy');

Route::resource('providerTypes', ProviderTypeController::class);


Route::resource('providers', ProviderController::class);

Route::get('provider-types','ProviderController@getProviderType')->name('admin.provider.getProvider');
Route::get('citys','ProviderController@getCity')->name('admin.provider.getCity');
Route::post('update-provider-status','ProviderController@updateProviderStatus')->name('providers.updateProviderStatus');

Route::resource('adminsservices', ServiceController::class);
Route::post('update-adminsservice-status','ServiceController@UpdateadminServiceStatus')->name('adminsservices.UpdateadminServiceStatus');
Route::post('update-adminsserviceFeatured-status','ServiceController@updateAdminsserviceFeaturedStatus')->name('adminsservice.updateAdminsserviceFeaturedStatus');
Route::get('category/getCategory','ServiceController@getCategory')->name('admin.service.getCategory');
Route::get('category/getproviders','ServiceController@getproviders')->name('admin.service.getproviders');


        //bookind details
Route::get('adminbookings','BookingsController@adminIndex')->name('adminbookings.adminIndex');
Route::delete('adminbookings/{booking}','BookingsController@admindestroy')->name('adminbookings.admindestroy');
Route::get('adminbookings/{booking}/show','BookingsController@adminShow')->name('adminbookings.adminShow');

      
Route::get('booking/invoice/{id}','BookingsController@bookingInvoice')->name('admin.booking.invoice');
Route::get('booking/invoicePDFdownload{id}','BookingsController@invoicePDFdownload')->name('admin.invoicePDFdownload');

// header menu
Route::resource('menus', MenuController::class);
Route::get('menu/submenu','MenuController@getsubmenu')->name('admin.menu.getsubmenu');

Route::post('update-menu-status','MenuController@updateMenuStatus')->name('menus.updateMenuStatus');

Route::resource('pages', PageController::class);

        //coupon
Route::resource('coupons', CouponController::class);
Route::post('update-coupon-status','CouponController@updateCouponStatus')->name('coupons.updateCouponStatus');
Route::get('getServices','CouponController@getService')->name('coupons.getService');
 

    //footer setting 
Route::get('footer-setting','SitesettingController@footerSettingEdit')->name('admin.footer-setting.edit');
Route::post('footer-setting-update','SitesettingController@footerSettingUpdate')->name('admin.footer-setting.update');

// social links
Route::resource('social_links', SocialLinkController::class);

// user

Route::get('all-users','UserController@admiindex')->name('user.admiindex');
Route::get('users-inactive','UserController@indexUserInactive')->name('admin.user.indexIactive');
Route::post('update-user-status','UserController@updateUserStatus')->name('users.updateUserStatus');
Route::get('user/detaisl/{id}','UserController@userDetails')->name('admin.user.details');
Route::delete('users/{id}','UserController@destroy')->name('admin.user.destroy');

// SEOSetting
Route::get('seo-setting','SettingController@SEOget')->name('admin.getting.SEOget');
Route::post('seo-setting-store','SettingController@SEOUpdate')->name('admin.getting.SEOUpdate');

 //general setting 
 Route::get('general-setting','SettingController@generalSettingEdit')->name('admin.getting-setting.edit');
 Route::post('general-setting-update','SettingController@generalSettingUpdate')->name('admin.getting-setting.update');
});

});

