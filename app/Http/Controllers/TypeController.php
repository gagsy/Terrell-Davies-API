<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        return response()->json(['types' => $types], 200);
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
            'name' => 'required'
        ]);

        $type = Type::create($request->all());
        return response()->json([
            'message' => 'Type Created',
            'type' => $type,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Type::where('id', $id)->exists()) {
            $type = Type::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($type, 200);
          } else {
            return response()->json([
              "message" => "Type not found",
              'type' => $type,
            ], 404);
          }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Type::where('id', $id)->exists()) {
            $type = Type::findorFail($id);
            $type->update($request->all());

            return response()->json([
                "message" => "Type updated successfully",
            ], 200);
            } else {
            return response()->json([
                "message" => "Record not found",
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(Type::where('id', $id)->exists()) {
            $type = Type::find($id);
            $type->delete();

            return response()->json([
              "message" => "record deleted",
            ], 202);
          } else {
            return response()->json([
              "message" => "record not found",
            ], 404);
          }
    }
}
