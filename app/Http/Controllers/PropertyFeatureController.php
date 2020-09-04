<?php

namespace App\Http\Controllers;

use App\PropertyFeature;
use App\Property;
use App\Feature;
use Illuminate\Http\Request;

class PropertyFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $property_features = PropertyFeature::all();
        $properties = Property::get();
        $features = Feature::get();
        return response()->json(['property_features' => $property_features, 'properties' => $properties, 'features' => $features], 200);
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
            'feature_id' => 'required',
            'property_id' => 'required',
        ]);

        $property_features = PropertyFeature::create($request->all());
        return response()->json([
            'message' => 'Record Created',
            'property_features' => $property_features,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PropertyFeature  $propertyFeature
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (PropertyFeature::where('id', $id)->exists()) {
            $property_features = PropertyFeature::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($property_features, 200);
          } else {
            return response()->json([
              "message" => "record not found"
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PropertyFeature  $propertyFeature
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyFeature $propertyFeature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PropertyFeature  $propertyFeature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyFeature $id)
    {
        if (PropertyFeature::where('id', $id)->exists()) {
            $property_features = PropertyFeature::find($id);
            $property_features->feature_id = is_null($request->feature_id) ? $property_features->feature_id : $request->feature_id;
            $property_features->property_id = is_null($request->property_id) ? $property_features->property_id : $request->property_id;
            $property_features->save();

            return response()->json([
                "message" => "record updated successfully",
                'property_features' => $property_features,
            ], 200);
            } else {
            return response()->json([
                "message" => "Record not found",
                'property_features' => $property_features,
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PropertyFeature  $propertyFeature
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyFeature $id)
    {
        if(PropertyFeature::where('id', $id)->exists()) {
            $property_features = PropertyFeature::find($id);
            $property_features->delete();

            return response()->json([
              "message" => "record deleted",
              'property_features' => $property_features,
            ], 202);
          } else {
            return response()->json([
              "message" => "record not found",
              'property_features' => $property_features,
            ], 404);
        }
    }
}
