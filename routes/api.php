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

Route::post('/login', 'Api\AuthController@login')->name('login');

Route::post('register', 'Api\AuthController@register')->name('register');

Route::get('check-auth', 'Api\AuthController@checkAuth')->name('logout');

Route::post('password/email', 'Api\AuthController@forgot');

Route::post('password/reset', 'ForgotPasswordController@reset');

Route::get('logout', 'Api\AuthController@logout')->name('logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/types', 'TypeController@index');


Route::post('/submit-request', 'PropertyRequestController@store');

Route::get('/property-type', 'PropertyTypeController@index');
Route::get('/property-locations', 'PropertyLocationController@index');
Route::get('/property-features', 'PropertyFeatureController@index');

Route::get('/properties', 'PropertyController@index');
Route::get('properties/{page?}', 'PropertyController@index');

Route::get('/locations', 'LocationController@index');

Route::get('/features', 'FeatureController@index');


Route::post('create-subscription', 'SubscriptionController@store');

Route::get('/property-category', 'PropertyCategoryController@index');

Route::get('/category', 'CategoryController@index');

Route::get('/blog-categories', 'BlogCategoryController@index');

Route::get('/blogs', 'BlogController@index');

Route::get('/search', 'PropertyController@getSearchResults');

Route::get('/users', 'Api\AuthController@users');
Route::post('/create-category', 'CategoryController@store');

Route::get('/manage', 'Api\AuthController@manageAdmin');

Route::post('/toggle-active/{id}','Api\AuthController@toggleUser');

Route::get('/account','Api\AuthController@account');
Route::get('/property-count','PropertyController@propertyCount');

Route::get('/plans', 'PlanController@index');
Route::post('/plan', 'PlanController@store');
Route::get('/plan/{id}', 'PlanController@show');
Route::delete('plan/{id}', 'PlanController@destroy');
Route::put('plan/{id}', 'PlanController@update');
Route::get('plan/{id}', 'PlanController@edit');

//Subscribe
Route::post('/subscribe', 'PaymentController@redirectToGateway')->name('pay');
Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');
Route::get('/subscriptions', 'SubscriptionController@index');




Route::group(['middleware' => 'auth:api'], function(){

});


Route::post('/admin-profile-update', 'Api\AuthController@adminUpdate');
Route::put('/toggle-user', 'Api\AuthController@toggleUser');
Route::get('/user-detail', 'Api\AuthController@userDetail');
//Type Api Controller Routes
Route::post('/create-type', 'TypeController@store');
Route::get('/types/{id}', 'TypeController@show');
Route::put('/types/{id}', 'TypeController@update');
Route::delete('types/{id}', 'TypeController@destroy');

//PropertyType Api Controller Routes
Route::post('/create-property-type', 'PropertyTypeController@store');
Route::get('/property-type/{id}', 'PropertyTypeController@show');
Route::put('/property-type/{id}', 'PropertyTypeController@update');
Route::delete('property-type/{id}', 'PropertyTypeController@destroy');

//PropertyLocation Api Controller Routes
Route::post('/create-property-locations', 'PropertyLocationController@store');
Route::get('/property-locations/{id}', 'PropertyLocationController@show');
Route::put('/property-locations/{id}', 'PropertyLocationController@update');
Route::delete('property-locations/{id}', 'PropertyLocationController@destroy');

//PropertyFeature Api Controller Routes
Route::post('/create-property-features', 'PropertyFeatureController@store');
Route::get('/property-features/{id}', 'PropertyFeatureController@show');
Route::put('/property-features/{id}', 'PropertyFeatureController@update');
Route::delete('property-features/{id}', 'PropertyFeatureController@destroy');

//Property Api Controller Routes
Route::post('/create-property', 'PropertyController@store');
Route::get('/properties/{id}', 'PropertyController@edit');
Route::put('/properties/{id}', 'PropertyController@update');
Route::delete('properties/{id}', 'PropertyController@destroy');

//Location Api Controller Routes
Route::post('/create-locations', 'LocationController@store');
Route::get('/locations/{id}', 'LocationController@show');
Route::put('/locations/{id}', 'LocationController@update');
Route::delete('locations/{id}', 'LocationController@destroy');

//Feature Api Controller Routes
Route::post('/create-features', 'FeatureController@store');
Route::get('/features/{id}', 'FeatureController@show');
Route::put('/features/{id}', 'FeatureController@update');
Route::delete('features/{id}', 'FeatureController@destroy');

//Subscription Plan Api Controller Routes
Route::post('/create-subscription-plan', 'SubscriptionPlansController@store');
Route::get('/subscription-plans/{id}', 'SubscriptionPlansController@edit');
Route::put('/subscription-plans/{id}', 'SubscriptionPlansController@update');
Route::delete('subscription-plans/{id}', 'SubscriptionPlansController@destroy');

//PropertyCategory Api Controller Routes
Route::post('/create-property-category', 'PropertyCategoryController@store');
Route::get('/property-category/{id}', 'PropertyCategoryController@edit');
Route::put('/property-category/{id}', 'PropertyCategoryController@update');
Route::delete('property-category/{id}', 'PropertyCategoryController@destroy');

//Category Api Controller Routes

Route::get('/category/{id}', 'CategoryController@edit');
Route::put('/category/{id}', 'CategoryController@update');
Route::delete('category/{id}', 'CategoryController@destroy');

//Blog Category Api Controller Routes
Route::post('/blog-category', 'BlogCategoryController@store');
Route::get('/blog-category/{id}', 'BlogCategoryController@edit');
Route::put('/blog-category/{id}', 'BlogCategoryController@update');
Route::delete('blog-category/{id}', 'BlogCategoryController@destroy');

//Blog Api Controller Routes
Route::post('/create-blog', 'BlogController@store');
Route::get('/blog/{id}', 'BlogController@edit');
Route::put('/blog/{id}', 'BlogController@update');
Route::delete('blog/{id}', 'BlogController@destroy');

//property Request Api Controller Routes
Route::get('/property-requests', 'PropertyRequestController@index');
Route::delete('property-request/{id}', 'PropertyRequestController@destroy');
Route::get('/request-count', 'PropertyRequestController@countRequest');
Route::get('/request-notify', 'PropertyRequestController@notifyRequest');

//Subscription Api Controller Routes
Route::get('subscriptions', 'SubscriptionController@index');

//CMS Contact
Route::get('/contacts', 'CmsController@contact');
Route::post('/contact', 'CmsController@addMap');
Route::get('/contact/{id}', 'CmsController@editMap');
Route::put('/contact/{id}', 'CmsController@updateMap');

Route::post('/sendMail','ContactFormController@store');

//Subscription History Api Routes
Route::get('/sub-history','Api\AuthController@sub_history');

// Newsletter Subscription Api Routes
Route::get('/sub-newsletter','NewsletterController@index');
Route::post('/create-newsletter','NewsletterController@store');

Route::get('/galleries', 'PropertyGalleryController@index');
Route::post('/upload', 'PropertyGalleryController@store');
