<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all();
        return response()->json(['statuses' => $statuses], 200);
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
            'statusName' => 'required'
        ]);

        $status = Status::create($request->all());
        return response()->json([
            'message' => 'Status Created',
            'status' => $status,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $id)
    {
        if (Status::where('id', $id)->exists()) {
            $status = Status::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($status, 200);
          } else {
            return response()->json([
              "message" => "Status not found",
              'status' => $status,
            ], 404);
          }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $id)
    {
        if (Status::where('id', $id)->exists()) {
            $status = Status::find($id);
            $status->statusName = is_null($request->statusName) ? $status->statusName : $request->statusName;
            $status->save();

            return response()->json([
                "message" => "Status updated successfully",
                'status' => $status,
            ], 200);
            } else {
            return response()->json([
                "message" => "Record not found",
                'status' => $status,
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $id)
    {
        if(Status::where('id', $id)->exists()) {
            $status = Status::find($id);
            $status->delete();

            return response()->json([
              "message" => "record deleted",
              'status' => $status,
            ], 202);
          } else {
            return response()->json([
              "message" => "record not found",
              'status' => $status,
            ], 404);
          }
    }
}
