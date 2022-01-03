<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

/* Set API Lang */
\App::setlocale(!empty(request()->header('Lang')) ? request()->header('Lang') : 'en');

/* Services Without token */
Route::post('register', 'Api\AuthController@register');
Route::post('otp', 'Api\AuthController@otp');
Route::post('login', 'Api\AuthController@login')->name('login');
Route::post('forgotPassword', 'Api\AuthController@forgotPassword');
Route::post('updatePassword', 'Api\AuthController@updatePassword');
Route::get('subjectList', 'Api\AuthController@subjectList');
Route::get('adminSettings', 'Api\AuthController@adminSettings');
 Route::post('contactUs', 'Api\AuthController@contactUs');
Route::get('about-us', 'Api\AuthController@aboutUs');
Route::get('privacy-policy', 'Api\AuthController@privacyPolicy');
Route::get('terms-conditions', 'Api\AuthController@termsConditons');
Route::get('dashboard', 'Api\AuthController@dashboard');
Route::get('offerList', 'Api\AuthController@offerList');


Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function() {
    Route::get('profileDetail', 'AuthController@profileDetail');
    Route::post('changePassword', 'AuthController@changePassword');
    
    
    Route::post('updateProfile', 'AuthController@updateProfile');
    Route::post('logout', 'AuthController@logout');
   
    Route::post('ourServices', 'AuthController@ourServices');
    Route::post('serviceList', 'AuthController@serviceList');
    Route::post('addToCart', 'AuthController@addToCart');
    Route::post('removeFromCart', 'AuthController@removeFromCart');
    Route::get('myCart', 'AuthController@myCart');
    Route::post('addCar', 'AuthController@addCar');
    Route::get('myCars', 'AuthController@myCars');
    Route::post('deleteCar', 'AuthController@deleteCar');
    Route::post('editCar', 'AuthController@editCar');
    Route::post('bookService', 'AuthController@bookService');
    Route::get('myBookings', 'AuthController@myBookings');
    Route::post('bookingDetails', 'AuthController@bookingDetails');
    Route::post('cancelBooking', 'AuthController@cancelBooking');
    Route::post('cancelCancellationRequest', 'AuthController@cancelCancellationRequest');
    Route::post('updatePaymentStatus', 'AuthController@updatePaymentStatus');
    Route::post('branchList', 'AuthController@branchList');

   
    
});




