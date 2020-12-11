<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = auth('api')->user();

        if(!isset($this->user)){

            return response()->json([
                'message' => 'Authentication Failed',
                'data'=>[]
            ], 403);

        }
    }
    
    public function index(){        
      
        return response()->json([
            'message' => 'Notice',
            'data'=>$this->user->notices()->get()
        ], 200);
 
    }

    public function noticeCount(){      
         
        return response()->json([
            'message' => 'Notice',
            'data'=>$this->user->notices()->count()
        ], 200);

    }

    public function read(){

        $user = auth('api')->user();        
         
        return response()->json([
            'message' => 'Notice',
            'data'=>$user->notices()->whereNotNull('read_at')->get()
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
