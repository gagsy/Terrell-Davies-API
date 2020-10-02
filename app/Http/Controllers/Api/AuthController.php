<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Hash;
use App\User;
use App\Subscription;
use Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'isActivated'=> 'Active'])) {
             $user = $request->user();
             $data['token'] = $user->createToken('MyApp')->accessToken;
             $data['name']  = $user->name;
             $data['userType'] = $user->userType;
             return response()->json($data, 200);
         }

       return response()->json(['error'=>'Unauthorized'], 401,);
    }

    public function AdminLogin(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'userType' => 'admin', 'isActivated'=> 'active'])) {
             $user = $request->user();
             $data['token'] = $user->createToken('MyApp')->accessToken;
             $data['name']  = $user->name;
             $data['userType'] = $user->userType;
             return response()->json($data, 200);
         }

       return response()->json(['error'=>'Unauthorized'], 401,);
    }
    public function adminUpdate(Request $request, $id=null){
        $user_id = Auth::user()->id;
        //$user = Auth::user();
        $user->name = $request['name'];
        $user->address = $request['address'];
        $user->locality = $request['locality'];
        $user->state = $request['state'];
        $user->country = $request['country'];
        $user->phone = $request['phone'];
        $user->company_name = $request['company_name'];
        $user->save();

        $affected_row = $user->save();

        if (!empty($affected_row)) {
             return response()->json([
                'message' => 'Profile Updated',
            ], 200);
        } else {
              return response()->json([
                 "message" => "Operation Failed",
               ], 404);
            }
    }

    public function updateProfile(){
        $user = Auth::user();
        $user->fname = $request['fname'];
        $user->lname = $request['lname'];
        $user->email = $request['email'];
            // $user->address = $request['address'];
        $user->phone = $request['phone'];
        $user->avatar = $avatarPath;
        $user->save();

        $affected_row = $user->save();

        if (!empty($affected_row)) {
             return response()->json([
                'message' => 'Profile Updated',
            ], 200);
        } else {
              return response()->json([
                 "message" => "Operation Failed",
               ], 404);
            }

    }

    public function register(Request $request)
    {

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|',
        'phone' => 'required|unique:users',
        'userType' => 'required'
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      $user = $request->all();
      $user['password'] = Hash::make($user['password']);
      $user = User::create($user);
      $success['token'] =  $user->createToken('MyApp')-> accessToken;
      $success['name'] =  $user->name;
      $success['userType'] = $user->userType;
      $success['address'] = $user->address;
      $success['phone'] = $user->phone;
      $success['company_name'] = $user->company_name;
      $success['locality'] = $user->locality;
      $success['state'] = $user->state;
      $success['country'] = $user->country;
      $success['mobile'] = $user->mobile;
      $success['services'] = $user->services;
      $success['facebook_profile'] = $user->facebook_profile;
      $success['twitter_profile'] = $user->twitter_profile;
      $success['linkedin_profile'] = $user->linkedin_profile;
      $success['socialType'] = $user->socialType;

      return response()->json(['success'=>$success], 200);
    }

    public function userDetail()
    {
        $user = Auth::user();

        return response()->json(['user' => $user], 200);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();

            return response()->json(['data' => 'User logged out.'], 200);
        }

        return response()->json(['state' => 0, 'message' => 'Unauthenticated'], 401);
    }
    public function checkAuth(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user && $user->userType) {
            return response()->json(['state' => 'admin'], 200);
        }

        return response()->json(['state' => 0], 401);
    }
    public function users()
    {
        $userCount = User::count();
        $users = User::all()->except('1');
        return response()->json(['users' => $users,'userCount' => $userCount], 200);
    }
    public function disableUser(Request $request, $id){

             \Log::info($request->all());
            $user = User::find($request->id);
            User::where('id', $id)->update(array('isActivated' => 'Inactive'));


            return response()->json([
                "message" => "User is disabled",
            ], 200);

    }
    public function enableUser(Request $request, $id){

        \Log::info($request->all());
       $user = User::find($request->id);
       User::where('id', $id)->update(array('isActivated' => 'Active'));


       return response()->json([
           "message" => "User is enabled",
       ], 200);

}
    public function manageAdmin(){
        $admin = User::where(['userType'=> 'admin'])->first();
        return response()->json(['admin'=> $admin], 200);
    }

    //User Accounts
    public function updateAccount(Request $request, $id){
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id);
        return response()->json(['userDetails'=>$userDetails], 200);
    }

    public function forgot() {
        $credentials = request()->validate(['email' => 'required|email']);

        Password::sendResetLink($credentials);

        return response()->json(["msg" => 'Reset password link sent on your email id.'], 200);
    }

    public function reset() {
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json(["msg" => "Invalid token provided"], 400);
        }

        return response()->json(["msg" => "Password has been successfully changed"], 200);
    }

    public function sub_history(){
        $user = Auth::User();
        $histories = Subscription::where('user_id' , $user->id)->get();
        return response()->json(['data' => $histories], 200);
    }
}
