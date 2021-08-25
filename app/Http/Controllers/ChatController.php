<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;
use DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'to_id' => 'required',
            'from_id' => 'required',
            'chat_text' => 'sometimes',
			'property_id' => 'sometimes'
        ]);

        // DB::beginTransaction();

        $chat = Chat::create([
            'to_id' => $request->to_id,
            'from_id' => $request->from_id,
            'property_id' => $request->property_id,
            'chat_text' => $request->chat_text
        ]);
		
		//dd($chat);

        return response()->json([
            'message' => 'Chat Created!',
            'chat' => $chat,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($chat)
    {
        //
        if (Chat::where('id', $chat)->exists()) {
            $chat = Chat::where('from_id', $chat)->get()->toJson(JSON_PRETTY_PRINT);
            return response($chat, 200);
          } else {
            return response()->json([
              "message" => "Chat not found",
            ], 404);
        }

    }

	public function showIndividualChat($id1, $id2)
    {
        //
        if (Chat::where('id', $id1)->exists()) {
            $chat = Chat::where('from_id', $id1)->where('to_id', $id2)->get()->toJson(JSON_PRETTY_PRINT);
            return response($chat, 200);
          } else {
            return response()->json([
              "message" => "Chat not found",
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
