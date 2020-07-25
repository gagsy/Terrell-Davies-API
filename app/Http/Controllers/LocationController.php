<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();
        return response()->json(['locations' => $locations], 200);
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
            'locationName' => 'required'
        ]);

        $location = Location::create($request->all());
        return response()->json([
            'message' => 'Location Created',
            'location' => $location,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $id)
    {
        if (Location::where('id', $id)->exists()) {
            $location = Location::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($location, 200);
          } else {
            return response()->json([
              "message" => "Location not found",
              'location' => $location,
            ], 404);
          }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $id)
    {
        if (Location::where('id', $id)->exists()) {
            $location = Location::find($id);
            $location->locationName = is_null($request->locationName) ? $location->locationName : $request->locationName;
            $Location->save();

            return response()->json([
                "message" => "Location updated successfully",
                'location' => $location,
            ], 200);
            } else {
            return response()->json([
                "message" => "Record not found",
                'location' => $location,
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $id)
    {
        if(Location::where('id', $id)->exists()) {
            $location = Location::find($id);
            $location->delete();

            return response()->json([
              "message" => "record deleted",
              'location' => $location,
            ], 202);
          } else {
            return response()->json([
              "message" => "record not found",
              'location' => $location,
            ], 404);
          }
    }
}
