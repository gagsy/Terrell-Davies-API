<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(){

        $user_id = auth('api')->user()->id;

        $messages = Message::where('user_id',$user_id)->get();

        return response()->json([
            'message' => 'Messages',
            'data'=>$messages
        ], 200);
 
    }

    public function create(Request $request){

        //check that the user is admin
        //create messages
        //send message to selected set of people
        //Send message to all users

        $array = $request->validate();

        if(!$request->validated){

        }

        $this->store($array);

    }


}
