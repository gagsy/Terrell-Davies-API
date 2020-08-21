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

Route::post('login', 'Api\AuthController@login')->name('login');

Route::post('register', 'Api\AuthController@register')->name('register');

Route::get('check-auth', 'Api\AuthController@checkAuth')->name('logout');

Route::get('logout', 'Api\AuthController@logout')->name('logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/user-detail', 'Api\AuthController@userDetail');

    //Type Api Controller Routes
    Route::get('/types', 'TypeController@index');
    Route::post('/create-types', 'TypeController@store');
    Route::get('/types/{id}', 'TypeController@show');
    Route::put('/types/{id}', 'TypeController@update');
    Route::delete('types/{id}', 'TypeController@destroy');

    //Status Api Controller Routes
    Route::get('/status', 'StatusController@index');
    Route::post('/create-status', 'StatusController@store');
    Route::get('/status/{id}', 'StatusController@show');
    Route::put('/status/{id}', 'StatusController@update');
    Route::delete('status/{id}', 'StatusController@destroy');

    //PropertyType Api Controller Routes
    Route::get('/property-type', 'PropertyTypeController@index');
    Route::post('/create-property-type', 'PropertyTypeController@store');
    Route::get('/property-type/{id}', 'PropertyTypeController@show');
    Route::put('/property-type/{id}', 'PropertyTypeController@update');
    Route::delete('property-type/{id}', 'PropertyTypeController@destroy');

    //PropertyStatus Api Controller Routes
    Route::get('/property-status', 'PropertyStatusController@index');
    Route::post('/create-property-status', 'PropertyStatusController@store');
    Route::get('/property-status/{id}', 'PropertyStatusController@show');
    Route::put('/property-status/{id}', 'PropertyStatusController@update');
    Route::delete('property-status/{id}', 'PropertyStatusController@destroy');

    //PropertyLocation Api Controller Routes
    Route::get('/property-locations', 'PropertyLocationController@index');
    Route::post('/create-property-locations', 'PropertyLocationController@store');
    Route::get('/property-locations/{id}', 'PropertyLocationController@show');
    Route::put('/property-locations/{id}', 'PropertyLocationController@update');
    Route::delete('property-locations/{id}', 'PropertyLocationController@destroy');

    //PropertyFeature Api Controller Routes
    Route::get('/property-features', 'PropertyFeatureController@index');
    Route::post('/create-property-features', 'PropertyFeatureController@store');
    Route::get('/property-features/{id}', 'PropertyFeatureController@show');
    Route::put('/property-features/{id}', 'PropertyFeatureController@update');
    Route::delete('property-features/{id}', 'PropertyFeatureController@destroy');

    //Property Api Controller Routes
    Route::get('/properties', 'PropertyController@index');
    Route::post('/create-properties', 'PropertyController@store');
    Route::get('/properties/{id}', 'PropertyController@edit');
    Route::put('/properties/{id}', 'PropertyController@update');
    Route::delete('properties/{id}', 'PropertyController@destroy');

    //Location Api Controller Routes
    Route::get('/locations', 'LocationController@index');
    Route::post('/create-locations', 'LocationController@store');
    Route::get('/locations/{id}', 'LocationController@show');
    Route::put('/locations/{id}', 'LocationController@update');
    Route::delete('locations/{id}', 'LocationController@destroy');

    //Feature Api Controller Routes
    Route::get('/features', 'FeatureController@index');
    Route::post('/create-features', 'FeatureController@store');
    Route::get('/features/{id}', 'FeatureController@show');
    Route::put('/features/{id}', 'FeatureController@update');
    Route::delete('features/{id}', 'FeatureController@destroy');

    //Subscription Plan Api Controller Routes
    Route::get('/subscription-plans', 'SubscriptionPlansController@index');
    Route::post('/create-subscription-plan', 'SubscriptionPlansController@store');
    Route::get('/subscription-plans/{id}', 'SubscriptionPlansController@edit');
    Route::put('/subscription-plans/{id}', 'SubscriptionPlansController@update');
    Route::delete('subscription-plans/{id}', 'SubscriptionPlansController@destroy');

    //PropertyCategory Api Controller Routes
    Route::get('/property-category', 'PropertyCategoryController@index');
    Route::post('/create-property-category', 'PropertyCategoryController@store');
    Route::get('/property-category/{id}', 'PropertyCategoryController@edit');
    Route::put('/property-category/{id}', 'PropertyCategoryController@update');
    Route::delete('property-category/{id}', 'PropertyCategoryController@destroy');

});



