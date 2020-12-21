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
Route::post('/admin-login', 'Api\AuthController@AdminLogin');
Route::post('register', 'Api\AuthController@register')->name('register');
Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend');
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
Route::get('properties/{page?}', 'PropertyController@paginate');
Route::get('/locations', 'LocationController@index');
Route::get('/features', 'FeatureController@index');
Route::get('/property-category', 'PropertyCategoryController@index');
Route::get('/category', 'CategoryController@index');
Route::get('/blog-categories', 'BlogCategoryController@index');
Route::get('/blogs', 'BlogController@index');
Route::get('/about', 'AboutUsController@index');
Route::get('/policy', 'PrivacyPolicyController@index');
Route::get('/property-cats', 'PropertyCategoryController@index');
Route::get('/property-types', 'PropertyTypeController@index');
Route::get('/property-locations', 'PropertyLocationController@index');
Route::get('/terms', 'TermsConditionsController@index');
Route::get('/filter', 'PropertyController@searchByStateAreaCity');
Route::match(['get', 'post'], '/search', 'PropertyController@filter');
Route::get('/search/history', 'PropertyController@searchHistory'); 
Route::get('/users', 'Api\AuthController@users');
Route::post('/create-category', 'CategoryController@store');
Route::get('/manage', 'Api\AuthController@manageAdmin');
Route::post('/disable-user/{id}','Api\AuthController@disableUser');
Route::post('/enable-user/{id}','Api\AuthController@enableUser');
Route::get('/account','Api\AuthController@account');
Route::get('/property-count','PropertyController@propertyCount');
Route::get('/plans', 'PlanController@index');
Route::get('/plan/{id}', 'PlanController@show');
Route::delete('plan/{id}', 'PlanController@destroy');
Route::put('plan/{id}', 'PlanController@update');
Route::get('plan/{id}', 'PlanController@edit');

//Subscribe
// Route::post('/subscribe', 'PaymentController@redirectToGateway')->name('pay');
// Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');
// Route::get('/subscriptions', 'SubscriptionController@index');

Route::group(['middleware' => 'auth:api'], function(){
    //Property Api Controller Routes
    Route::post('/property/create', 'PropertyController@store');
    Route::post('/property/image-upload', 'PropertyController@imageUpload');
    Route::get('/user-detail', 'Api\AuthController@userDetail');
    Route::post('/profile-update', 'Api\AuthController@updateProfile');
    Route::post('/profile/image/upload', 'Api\AuthController@ProfileImageUpload');
    Route::post('/admin-profile-update', 'Api\AuthController@adminUpdate');
    Route::post('/plan/create', 'PlanController@store');
    Route::post('/change-password', 'Api\AuthController@changePassword');
    Route::post('/shortlist/add', 'PropertyController@shortlist');        
    Route::delete('/shortlist/remove', 'PropertyController@shortlistRemove');        
    Route::get('/user/shortlist/count', 'PropertyController@user_shortlist_count');
    Route::get('/user/shortlists/', 'PropertyController@user_shortlist');
    Route::get('/user/property/count','PropertyController@user_property_count');
    Route::get('/user/property/list','PropertyController@user_property_list');
    Route::get('user/{id}', 'Api\AuthController@singleUser');


    /**
     * Notice EndPoints
     */

     Route::post('notice/create','NoticeController@create');
     Route::get('notice','NoticeController@index'); //return all notice read and unread
     Route::get('notice/count','NoticeController@noticeCount');
     Route::get('notice/read','NoticeController@read');
     Route::get('notice/read/count','NoticeController@readCount');
     Route::get('notice/unread/count','NoticeController@unreadCount');  
     Route::get('notice/unread','NoticeController@unread');  
     Route::post('notice/mark-read','NoticeController@markRead'); //mark notice as read 


     /**
      * Payment Endpoints 
      */

      Route::post('payment-plan','PlanController@store');
      Route::get('payment-plans','PlanController@getPlans');

      Route::post('make-payment','PaymentController@makePayment');
    //   Route::post('make-payment-mobile','PaymentController@makePaymentMobile');

      Route::post('make-payment-mobile','PaymentController@makePayment');
    
     

});

Route::get('payment-response','PaymentController@paymentResponse'); //Remove from API auth


//Type Api Controller Routes
Route::post('/type/create', 'TypeController@store');
Route::get('/types/{id}', 'TypeController@show');
Route::put('/types/{id}', 'TypeController@update');
Route::delete('types/{id}', 'TypeController@destroy');

Route::get('/property/{id}', 'PropertyController@edit');
Route::put('/property/{id}', 'PropertyController@update');
Route::delete('property/{id}', 'PropertyController@destroy');

//Property Category Controller Routes
Route::post('/propertyCat/create', 'PropertyCategoryController@store');
Route::post('/propertyCat/{id}', 'PropertyCategoryController@edit');
Route::put('/propertyCat/{id}', 'PropertyCategoryController@update');
Route::delete('/propertyCat/{id}', 'PropertyCategoryController@destroy');

//Property Type Controller Routes
Route::post('/propertyType/create', 'PropertyTypeController@store');
Route::post('/propertyType/{id}', 'PropertyTypeController@edit');
Route::put('/propertyType/{id}', 'PropertyTypeController@update');
Route::delete('/propertyType/{id}', 'PropertyTypeController@destroy');

//Property Location Controller Routes
Route::post('/propertyLoc/create', 'PropertyLocationController@store');
Route::post('/propertyLoc/{id}', 'PropertyLocationController@edit');
Route::put('/propertyLoc/{id}', 'PropertyLocationController@update');
Route::delete('/propertyLoc/{id}', 'PropertyLocationController@destroy');

//Location Api Controller Routes
Route::post('/location/create', 'LocationController@store');
Route::get('/locations/{id}', 'LocationController@show');
Route::put('/locations/{id}', 'LocationController@update');
Route::delete('locations/{id}', 'LocationController@destroy');

//Feature Api Controller Routes
Route::post('/feature/create', 'FeatureController@store');
Route::get('/features/{id}', 'FeatureController@show');
Route::put('/features/{id}', 'FeatureController@update');
Route::delete('features/{id}', 'FeatureController@destroy');

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


//About Page
Route::post('/about/create', 'AboutUsController@store');
Route::get('/about/{id}', 'AboutUsController@edit');
Route::put('/about/{id}', 'AboutUsController@update');
Route::delete('about/{id}', 'AboutUsController@destroy');

//Terms
Route::post('/terms/create', 'TermsConditionsController@store');
Route::get('/term/{id}', 'TermsConditionsController@edit');
Route::put('/term/{id}', 'TermsConditionsController@update');
Route::delete('term/{id}', 'TermsConditionsController@destroy');

//Privacy Policy
Route::post('/policy/create', 'PrivacyPolicyController@store');
Route::get('/policy/{id}', 'PrivacyPolicyController@edit');
Route::put('/policy/{id}', 'PrivacyPolicyController@update');
Route::delete('policy/{id}', 'PrivacyPolicyController@destroy');

