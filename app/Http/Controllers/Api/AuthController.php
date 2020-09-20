<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Hash;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
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
    public function toggleUser(Request $request, $id){

             \Log::info($request->all());
            $user = User::find($request->id);
            $user->isActivated = $request->isActivated;
            $user->save();

            return response()->json([
                "message" => "User status changed",
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
}
