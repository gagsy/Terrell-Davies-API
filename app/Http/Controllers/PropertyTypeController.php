<?php

namespace App\Http\Controllers;

use App\PropertyType;
use App\Property;
use App\Type;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $property_types = PropertyType::all();
        $properties = Property::get();
        $types = Type::get();
        return response()->json(['property_types' => $property_types, 'properties' => $properties, 'types' => $types], 200);
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
            'type_id' => 'required',
            'property_id' => 'required',
        ]);

        $property_type = PropertyType::create($request->all());
        return response()->json([
            'message' => 'Record Created',
            'property_type' => $property_type,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (PropertyType::where('id', $id)->exists()) {
            $property_type = PropertyType::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($property_type, 200);
          } else {
            return response()->json([
              "message" => "record not found"
            ], 404);
          }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyType $propertyType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyType $id)
    {
        if (PropertyType::where('id', $id)->exists()) {
            $property_type = PropertyType::find($id);
            $property_type->type_id = is_null($request->type_id) ? $property_type->type_id : $request->type_id;
            $property_type->property_id = is_null($request->property_id) ? $property_type->property_id : $request->property_id;
            $property_type->save();

            return response()->json([
                "message" => "record updated successfully",
                'property_type' => $property_type,
            ], 200);
            } else {
            return response()->json([
                "message" => "Record not found",
                'property_type' => $property_type,
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyType $id)
    {
        if(PropertyType::where('id', $id)->exists()) {
            $property_type = PropertyType::find($id);
            $property_type->delete();

            return response()->json([
              "message" => "record deleted",
              'property_type' => $property_type,
            ], 202);
          } else {
            return response()->json([
              "message" => "record not found",
              'property_type' => $property_type,
            ], 404);
          }
    }
}