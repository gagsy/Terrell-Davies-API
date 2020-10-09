<?php

namespace App\Http\Controllers;

use App\PropertyLocation;
use Illuminate\Http\Request;

class PropertyLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PropertyLocation::all();
        return response()->json(['data' => $data], 200);
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
            'location_id' => 'required',
            'property_id' => 'required',
        ]);

        $data = PropertyLocation::create($request->all());
        return response()->json([
            'message' => 'Property Location Created',
            'data' => $data,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PropertyLocation  $propertyLocation
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyLocation $propertyLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PropertyLocation  $propertyLocation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (PropertyLocation::where('id', $id)->exists()) {
            $data = PropertyLocation::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($data, 200);
          } else {
            return response()->json([
              "message" => "Property Location not found"
            ], 404);
          }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PropertyLocation  $propertyLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (PropertyLocation::where('id', $id)->exists()) {
            $data = PropertyLocation::findorFail($id);
            $data->update($request->all());

            return response()->json([
                "message" => "Property Location updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Property Location not found"
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PropertyLocation  $propertyLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(PropertyLocation::where('id', $id)->exists()) {
            $data = PropertyLocation::findorFail($id);
            $data->delete();

            return response()->json([
              "message" => "Property Location deleted"
            ], 202);
          } else {
            return response()->json([
              "message" => "Property Location not found"
            ], 404);
        }
    }
}
