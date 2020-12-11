<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notice;

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
      
        return $this->user->notices()->get();

        return response()->json([
            'message' => 'Notice',
            'data'=>$this->user->notices()->get()
        ], 200);
 
    }

    public function noticeCount(){      
         
        return response()->json([
            'message' => 'Notice Count',
            'data'=>$this->user->notices()->count()
        ], 200);

    }

    public function read(){

        $user = auth('api')->user();        
         
        return response()->json([
            'message' => 'Notice Read',
            'data'=>$user->notices()->whereNotNull('read_at')->get()
        ], 200);

    }

    public function readCount(){

        $user = auth('api')->user();        
         
        return response()->json([
            'message' => 'Notice Read Count',
            'data'=>$user->notices()->whereNotNull('read_at')->count()
        ], 200);

    }

    public function unread(){

        $user = auth('api')->user();        
         
        return response()->json([
            'message' => 'Notice Unread',
            'data'=>$user->notices()->whereNull('read_at')->get()
        ], 200);

    }

    public function unreadCount(){

        $user = auth('api')->user();        
         
        return response()->json([
            'message' => 'Notice Unread Count',
            'data'=>$user->notices()->whereNull('read_at')->count()
        ], 200);

    }

    public function markRead(Request $request){

        if($this->user->id != $request->user_id){

            return response()->json([
                'message' => 'Authentication Failed',
                'data'=>[]
            ], 403);

        }

        $findNotice = Notice::find($request->notice_id);

        if(!$findNotice){

            return response()->json([
                'message' => 'Notice Not Found',
                'data'=>[]
            ], 404);

        }

        $findNotice->read_at = now();
        $findNotice->save();

        return response()->json([
            'message' => 'Notice Marked as Read',
            'data'=>[]
        ], 200);

    }

    public function create(Request $request){
        

        $data = $request->validate([
            'user_id' => 'required|integer',
            'title' => 'string',
            'content' => 'required|string',
            'send_to' => 'required|integer'
        ]);

        if($this->user->id != $data['user_id']){

            return response()->json([
                'message' => 'Authentication Failed',
                'data'=>[]
            ], 403);

        }

        if($this->user->userType != 'admin'){

            return response()->json([
                'message' => 'Only admin can create notice',
                'data'=>[]
            ], 406);

        }

        if($data['send_to'] == 0){

            // send to everyone

            $allNoneAdminUsers = User::where('userType','!=','admin')->get();

            foreach($allNoneAdminUsers as $userind){

                Notice::create([
                        'title'=>$data['title'],
                        'sender_id'=>$data['user_id'],
                        'receiver_id'=>$userind->id,
                        'content'=>$data['content']
                        ]);
            }

        }else if(is_array($data['send_to'])){

            foreach($data['send_to'] as $singleId){

                Notice::create([
                    'title'=>$data['title'],
                    'sender_id'=>$data['user_id'],
                    'receiver_id'=>$singleId,
                    'content'=>$data['content']
                    ]);
            }           

        }else{
            
            Notice::create([
                'title'=>$data['title'],
                'sender_id'=>$data['user_id'],
                'receiver_id'=>$data['send_to'],
                'content'=>$data['content']
                ]);

        }


        return response()->json([
            'message' => 'Notice Created',
            'data'=>[]
        ], 200);

   
    }


}
