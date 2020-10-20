<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Subscription;
use Input;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Image;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
             $user = $request->user();
             $data['token'] = $user->createToken('MyApp')->accessToken;
             $data['name']  = $user->name;
             $data['userType'] = $user->userType;
             $data['address'] = $user->address;
             $data['phone'] = $user->phone;
             $data['company_name'] = $user->company_name;
             $data['locality'] = $user->locality;
             $data['state'] = $user->state;
             $data['country'] = $user->country;
             $data['phone'] = $user->phone;
             $data['services'] = $user->services;
             $data['facebook_profile'] = $user->facebook_profile;
             $data['twitter_profile'] = $user->twitter_profile;
             $data['linkedin_profile'] = $user->linkedin_profile;
             $data['socialType'] = $user->socialType;
             $data['avatar'] = $user->avatar;
             return response()->json($data, 200);
         }

       return response()->json(['error'=>'Wrong Email or Password'], 401);
    }

    public function AdminLogin(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'userType' => 'admin'])) {
             $user = $request->user();
             $data['token'] = $user->createToken('MyApp')->accessToken;
             $data['name'] =  $user->name;
             $data['userType'] = $user->userType;

             return response()->json($data, 200);
         }

       return response()->json(['error'=>'Unauthorized'], 401,);
    }
    public function adminUpdate(Request $request, $id=null){
        $user_id = auth('api')->user()->id;
        $user = User::find($user_id);
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

    public function updateProfile(Request $request, $id=null){
        $user_id = Auth::user()->id;
        $users = User::find($user_id);

        $users->name = $request->name;
        $users->address = $request->address;
        $users->locality = $request->locality;
        $users->state = $request->state;
        $users->country = $request->country;
        $users->phone = $request->phone;
        $users->company_name = $request->company_name;
        $users->userType = $request->userType;
        $users->services = $request->services;
        $users->facebook_profile = $request->facebook_profile;
        $users->twitter_profile = $request->twitter_profile;
        $users->linkedin_profile = $request->linkedin_profile;
        $users->socialType = $request->socialType;
        $users->save();

        $data[] = [
            'id'=>$users->id,
            'name'=>$users->name,
            'address' => $users->address,
            'locality' => $users->locality,
            'state' => $users->state,
            'country' => $users->country,
            'phone' => $users->phone,
            'company_name' => $users->company_name,
            'userType' => $users->userType,
            'services' => $users->services,
            'facebook_profile' => $users->facebook_profile,
            'twitter_profile' => $users->twitter_profile,
            'linkedin_profile' => $users->linkedin_profile,
            'socialType' => $users->socialType,
            'message'=> 'Your Account settings are saved',
        ];
        return response()->json($data);
    }

    public function ProfileImageUpload(Request $request, $id=null){
        $user_id = Auth::user()->id;
        $users = User::find($user_id);
        $request->validate([
            'avatar' => 'nullable|image|max:4096',
        ]);
        $avatar = $request->file('avatar');
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        $image_path = public_path('/Avatar_images');
        $avatar->move($image_path,$filename);

        $image_path1 = public_path('Avatar_images/'.$users->avatar);
        if(File::exists($image_path1)) {
            File::delete($image_path1);
        }

        $users->avatar = $filename;
        $users->save();

        $data[] = [
            'id'=>$users->id,
            'avatar'=>$users->avatar,
            'message'=>'Image Uploaded',
        ];
        return response()->json($data);
    }

    public function register(Request $request)
    {

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|',
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


      return response()->json(['success'=>$success], 200);
    }

    public function userDetail()
    {
        $user_id = auth('api')->user()->id;
        $userDetails = User::find($user_id);

        return response()->json(['data' => $userDetails], 200);
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

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return response()->json(["msg" => "Your current password does not matches with the password you provided. Please try again."], 400);
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return response()->json(["msg" => "New Password cannot be same as your current password. Please choose a different password."], 400);
        }

        if(strcmp($request->get('new-password'), $request->get('new-password_confirmation')) != 0){
            //new password and confirm password are  not the same
            return response()->json(["msg" => "New Password and Confirm password are not the same. Please try again."], 400);
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return response()->json(["msg" => "Password changed successfully!"], 200);
    }
}
