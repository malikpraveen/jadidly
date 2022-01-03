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

/* For run migrate on server */
Route::get('/dump', function () {
    system('composer dump-autoload');
});
Route::get('/refreshSeed', function () {
    echo Artisan::call('migrate:refresh --seed');
});
Route::get('/migrate', function () {
    echo Artisan::call('migrate');
});
Route::get('/seed', function () {
    echo Artisan::call('db:seed');
});
Route::get('/optimize', function () {
    echo Artisan::call('optimize');
});
Route::get('/composer-update', function () {
    echo Artisan::call('composer update');
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
});
Route::get('/clear-config', function() { 
    Artisan::call('config:clear');
});
Route::get('/m-i-g-r-a-t-e-rollback', function() {
    Artisan::call('migrate:rollback');
});
/* For run migrate on server */


// Route::get('/', function () {
// 	// dd('a');
// 	return redirect('admin/login');
// });

/* * *********Localization*********** */

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('/', 'Web\WebController@index');
Route::get('/home', 'Web\WebController@index');
Route::get('/about-us', 'Web\WebController@about_us');
Route::get('/privacy-policy', 'Web\WebController@privacy_policy');
Route::get('/terms-n-conditions', 'Web\WebController@terms_conditions');
Route::get('/subcategory-list/{id}', 'Web\UserController@subcategory_list');
Route::get('/service', 'Web\UserController@service_list');
Route::get('/service/{id}', 'Web\UserController@service_list');


Route::get('/login', 'Web\WebController@login');
Route::get('/registration', 'Web\WebController@registration');
Route::get('/verification', 'Web\WebController@verification');
Route::get('/verify', 'Web\WebController@verify');
Route::get('/forgot-password', 'Web\WebController@forgot_password');
Route::get('/reset-password', 'Web\WebController@reset_password');
Route::get('/contact-us', 'Web\WebController@contact_us');
Route::get('/offers', 'Web\WebController@offer_list');
Route::post('web/setSession', [
        'uses' => 'Web\WebController@set_session_keys',
    ]);
Route::post('web/unsetSession', [
        'uses' => 'Web\WebController@unset_session_keys',
    ]);
Route::group(['prefix' => 'my-account','namespace' => 'Web'], function () {
    Route::get('/profile', 'UserController@index');
    Route::get('/edit-profile', 'UserController@edit_profile');
    Route::get('/change-password', 'UserController@change_password');
    Route::get('/my-cart', 'UserController@my_cart');
    Route::get('/checkout-order', 'UserController@checkout_order');
    Route::get('/add-car', 'UserController@add_car');
    Route::get('/my-cars', 'UserController@my_cars');
    Route::get('/my-bookings', 'UserController@my_bookings');
    Route::get('/booking-detail/{id}', 'UserController@booking_detail');
});


Route::get('/admin', 'Admin\AdminController@login');
Route::get('/admin/login', 'Admin\AdminController@login')->name('login');
Route::post('/admin/dologin', 'Admin\AdminController@authenticate');
Route::post('/admin/forget', 'Admin\AdminController@forget');
Route::get('/admin/logout', 'Admin\AdminController@getLogout');
Route::get('/admin/forgot-password', 'Admin\AdminController@forgotPassword')->name('forgot-password');
Route::get('/admin/openOTPScreen/{id}', 'Admin\AdminController@openOTPScreen')->name('openOTPScreen');
Route::get('/admin/resetPasswordScreen/{id}', 'Admin\AdminController@resetPasswordScreen')->name('resetPasswordScreen');
Route::post('/admin/checkOTP', 'Admin\AdminController@checkOTP');
Route::post('/admin/resetPassword', 'Admin\AdminController@resetPassword');
Route::get('/admin/new-password', 'Admin\AdminController@newPassword');
Route::get('/admin/first-password', 'Admin\AdminController@firstPassword');
Route::post('/admin/update-password', 'Admin\AdminController@updatePassword')->name('update-password');
Route::post('/admin/first-password', 'Admin\AdminController@updateFirstPassword')->name('first-password');
Route::get('/admin/error', 'Admin\AdminController@error')->name('error');
Route::get('/admin/unauthenticated', 'Controller@auth');
Route::group(['middleware' => ['\App\Http\Middleware\AdminAuth'], 'prefix' => 'admin'], function () {
    Route::get('/home', 'Admin\AdminController@index')->name('home');
    Route::get('/user-management', 'Admin\AdminController@user_list');
    Route::get('/user-detail/{id}', 'Admin\AdminController@user_detail');
    Route::get('/category-management', 'Admin\CategoryController@index');
    Route::get('/subcategory-management', 'Admin\CategoryController@subcategory_management');
    Route::post('category/store', [
        'uses' => 'Admin\CategoryController@store',
        'as' => 'admin.category.store'
    ]);
    Route::get('edit-category/{id}', 'Admin\CategoryController@edit');
    Route::get('edit-subcategory/{id}', 'Admin\CategoryController@edit_subcategory');
    Route::post('category/update/{id}', [
        'uses' => 'Admin\CategoryController@update',
        'as' => 'admin.category.update'
    ]);
    Route::post('/category/change_category_status', 'Admin\CategoryController@change_category_status');
    Route::post('/category/getSubcategory', 'Admin\CategoryController@getSubcategory');
    Route::get('/service-management', 'Admin\ServiceController@index');
    Route::get('/add-service', 'Admin\ServiceController@add');
    Route::post('service/store', [
        'uses' => 'Admin\ServiceController@store',
        'as' => 'admin.service.store'
    ]);
    Route::get('service-detail/{id}', 'Admin\ServiceController@show');
    Route::get('edit-service/{id}', 'Admin\ServiceController@edit');
    Route::post('service/update/{id}', [
        'uses' => 'Admin\ServiceController@update',
        'as' => 'admin.service.update'
    ]);
    Route::post('/service/change_service_status', 'Admin\ServiceController@change_service_status');

    Route::get('/brand-management', 'Admin\CarsController@brand_list');
    Route::get('/car-management', 'Admin\CarsController@car_list');
    Route::get('/model-management', 'Admin\CarsController@model_list');
    Route::post('brand/store', [
        'uses' => 'Admin\CarsController@brand_store',
        'as' => 'admin.brand.store'
    ]); 
    Route::post('car/store', [
        'uses' => 'Admin\CarsController@car_store',   
        'as' => 'admin.car.store'
    ]);
    Route::post('model/store', [
        'uses' => 'Admin\CarsController@model_store',
        'as' => 'admin.model.store'
    ]);
    
    Route::post('brand/update/{id}', [
        'uses' => 'Admin\CarsController@brand_update',
        'as' => 'admin.brand.update'
    ]); 
    
    Route::post('car/update/{id}', [
        'uses' => 'Admin\CarsController@car_update',
        'as' => 'admin.car.update'
    ]);
    
    Route::post('model/update/{id}', [
        'uses' => 'Admin\CarsController@model_update',
        'as' => 'admin.model.update'
    ]);
    
    Route::get('/edit-brand/{id}', 'Admin\CarsController@edit_brand');
    Route::get('/edit-car/{id}', 'Admin\CarsController@edit_car');
    Route::get('/edit-model/{id}', 'Admin\CarsController@edit_model');
    Route::post('/cars/change_status', 'Admin\CarsController@change_status');
    Route::get('help-n-support', 'Admin\AdminController@help_n_support');
    Route::get('help-n-support-detail/{id}', 'Admin\AdminController@help_n_support_detail');
    Route::post('query/reply/{id}', [
        'uses' => 'Admin\AdminController@query_reply',
        'as' => 'admin.query.reply'
    ]);
    Route::get('content-management', 'Admin\AdminController@content_management');
    Route::get('edit-content', 'Admin\AdminController@edit_content');
    Route::post('content/update', [
        'uses' => 'Admin\AdminController@content_update',
        'as' => 'admin.content.update'
    ]);
    Route::any('support-reason-management', 'Admin\AdminController@help_n_support_subject');
    Route::any('cancel-reason-management', 'Admin\AdminController@cancel_reason');
    Route::any('edit-cancel-reason/{id}', 'Admin\AdminController@edit_cancel_reason');
    Route::any('edit-support-reason/{id}', 'Admin\AdminController@edit_support_reason');
    Route::post('change_status', 'Admin\AdminController@change_status');
    Route::post('cancel-reason/update/{id}', [
        'uses' => 'Admin\AdminController@reason_update',
        'as' => 'admin.cancel-reason.update'
    ]); 
    
    Route::get('booking-request-management', 'Admin\BookingController@request_list');
    Route::get('booking-request-details/{id}', 'Admin\BookingController@request_detail');
    
    Route::get('booking-management', 'Admin\BookingController@index');
    Route::get('booking-details/{id}', 'Admin\BookingController@booking_details');
    Route::post('/booking/action', [
        'uses' => 'Admin\BookingController@booking_action',
        'as' => 'admin.booking.action'
    ]);
    
    Route::any('offer-management', 'Admin\OfferController@index');
    Route::any('edit-offer/{id}', 'Admin\OfferController@edit');
    
    Route::any('branch-management', 'Admin\AdminController@branch_list');


    Route::any('edit_employee_list/{id}', 'Admin\AdminController@edit_employee');
    Route::get('employee_details/{id}', 'Admin\AdminController@employee_details');
    Route::get('employee-management', 'Admin\AdminController@employee_list');
    Route::post('employee/submit', [
        'uses' => 'Admin\AdminController@employee_submit',
        'as' => 'admin.employee.submit'
    ]);
    Route::post('employee/update/{id}', [
        'uses' => 'Admin\AdminController@employee_update',
        'as' => 'admin.employee.update'
    ]);

    Route::post('change_employee_status','Admin\AdminController@change_employee_status');
    //Route::any('employee.submit', 'Admin\AdminController@employee_submit');

    Route::any('edit-branch/{id}', 'Admin\AdminController@edit_branch');
    
    Route::get('subadmin-management', 'Admin\SubadminController@index');
    Route::any('add-subadmin', 'Admin\SubadminController@add');
    Route::get('subadmin-detail/{id}', 'Admin\SubadminController@show');
    Route::any('edit-subadmin/{id}', 'Admin\SubadminController@edit_subadmin');
    
    Route::get('payment-management', 'Admin\AdminController@transactions');
    Route::get('charges-management', 'Admin\AdminController@charges_management');
    Route::post('update_amount', 'Admin\AdminController@update_amount');
    Route::get('booking-cancellation', 'Admin\BookingController@cancellation_request');
    Route::post('/request/action', [
        'uses' => 'Admin\BookingController@request_action',
        'as' => 'admin.request.action'
    ]);
});

