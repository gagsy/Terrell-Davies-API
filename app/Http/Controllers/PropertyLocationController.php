<?php

namespace App\Http\Controllers;

use App\PropertyLocation;
use App\Location;
use App\Property;
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
        $property_locations = PropertyLocation::all();
        $properties = Property::get();
        $locations = Location::get();
        return response()->json(['property_locations' => $property_locations, 'properties' => $properties, 'locations' => $locations], 200);
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

        $property_locations = PropertyLocation::create($request->all());
        return response()->json([
            'message' => 'Record Created',
            'property_locations' => $property_locations,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PropertyLocation  $propertyLocation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (PropertyLocation::where('id', $id)->exists()) {
            $property_locations = PropertyLocation::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($property_locations, 200);
          } else {
            return response()->json([
              "message" => "record not found"
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PropertyLocation  $propertyLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyLocation $propertyLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PropertyLocation  $propertyLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyLocation $id)
    {
        if (PropertyLocation::where('id', $id)->exists()) {
            $property_locations = PropertyLocation::find($id);
            $property_locations->location_id = is_null($request->location_id) ? $property_locations->location_id : $request->location_id;
            $property_locations->property_id = is_null($request->property_id) ? $property_locations->property_id : $request->property_id;
            $property_locations->save();

            return response()->json([
                "message" => "record updated successfully",
                'property_locations' => $property_locations,
            ], 200);
            } else {
            return response()->json([
                "message" => "Record not found",
                'property_locations' => $property_locations,
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PropertyLocation  $propertyLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyLocation $id)
    {
        if(PropertyLocation::where('id', $id)->exists()) {
            $property_locations = PropertyLocation::find($id);
            $property_locations->delete();

            return response()->json([
              "message" => "record deleted",
              'property_locations' => $property_locations,
            ], 202);
          } else {
            return response()->json([
              "message" => "record not found",
              'property_locations' => $property_locations,
            ], 404);
        }
    }
}
