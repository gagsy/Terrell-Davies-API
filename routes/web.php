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

Route::get('/plans', 'WebController@index');
Route::get('/planInfo/{id}', 'WebController@plan')->name('plan');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');
Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');

//Admin Route
Route::get('/admin/{path?}','AdminController@index');
