<?php

namespace App\Http\Controllers;

use App\PropertyStatus;
use App\Status;
use App\Property;
use Illuminate\Http\Request;

class PropertyStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $property_stasuses = PropertyStatus::all();
        $properties = Property::get();
        $stasuses = Status::get();
        return response()->json(['property_stasuses' => $property_stasuses, 'properties' => $properties, 'stasuses' => $stasuses], 200);
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
            'status_id' => 'required',
            'property_id' => 'required',
        ]);

        $property_status = PropertyStatus::create($request->all());
        return response()->json([
            'message' => 'Record Created',
            'property_status' => $property_status,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PropertyStatus  $propertyStatus
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyStatus $id)
    {
        if (PropertyStatus::where('id', $id)->exists()) {
            $property_status = PropertyStatus::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($property_status, 200);
          } else {
            return response()->json([
              "message" => "record not found"
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PropertyStatus  $propertyStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyStatus $propertyStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PropertyStatus  $propertyStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyStatus $id)
    {
        if (PropertyStatus::where('id', $id)->exists()) {
            $property_status = PropertyStatus::find($id);
            $property_status->status_id = is_null($request->status_id) ? $property_status->status_id : $request->status_id;
            $property_status->property_id = is_null($request->property_id) ? $property_status->property_id : $request->property_id;
            $property_status->save();

            return response()->json([
                "message" => "record updated successfully",
                'property_status' => $property_status,
            ], 200);
            } else {
            return response()->json([
                "message" => "Record not found",
                'property_status' => $property_status,
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PropertyStatus  $propertyStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyStatus $id)
    {
        if(PropertyStatus::where('id', $id)->exists()) {
            $property_status = PropertyStatus::find($id);
            $property_status->delete();

            return response()->json([
              "message" => "record deleted",
              'property_status' => $property_status,
            ], 202);
          } else {
            return response()->json([
              "message" => "record not found",
              'property_status' => $property_status,
            ], 404);
        }
    }
}
