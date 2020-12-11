<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(){

        
        $user = auth('api')->user();        
         
        return response()->json([
            'message' => 'Notice',
            'data'=>$user->notices()->get()
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
