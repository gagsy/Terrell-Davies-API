<?php

namespace App\Http\Controllers;

use App\PropertyRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PropertyRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $requestCount = PropertyRequest::whereDate('created_at', Carbon::today())->count();
        $requests = PropertyRequest::all();
        return response()->json(['requests' => $requests, "requestCount" => $requestCount ], 200);
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
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'category' => 'required',
            'type' => 'required',
            'user_type' => 'required',
            'state' => 'required',
            'locality' => 'required',
            'area' => 'required',
            'bedrooms' => 'required',
            'budget' => 'required',
            'comment' => 'required'
        ]);

        $prop_request = PropertyRequest::create($request->all());
        return response()->json([
            'message' => 'Property Request Created',
            'property_requests' => $prop_request,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PropertyRequest  $propertyRequest
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (PropertyRequest::where('id', $id)->exists()) {
            $request = PropertyRequest::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($request, 200);
          } else {
            return response()->json([
              "message" => "Property Request not found",
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PropertyRequest  $propertyRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyRequest $propertyRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PropertyRequest  $propertyRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyRequest $propertyRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PropertyRequest  $propertyRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(PropertyRequest::where('id', $id)->exists()) {
            $request = PropertyRequest::findOrFail($id);
            $request->delete();

            return response()->json([
              "message" => "Property Request deleted",
            ], 202);
          } else {
            return response()->json([
              "message" => "Property Request not found",
            ], 404);
          }
    }
    public function countRequest(){
      $requestCount = PropertyRequest::whereDate('created_at', Carbon::today())->count();
      return response()->json([
        "requestCount" => $requestCount
      ], 200);
    }
    public function notifyRequest(){
      $notifyRequest = PropertyRequest::whereDate('created_at', Carbon::today())->get();
      return response()->json([
        "notifyRequest" => $notifyRequest,
      ], 200);
    }
}
