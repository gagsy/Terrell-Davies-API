<?php

namespace App\Http\Controllers;

use App\PropertyType;
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
		//dd('check');
        $propertytypes = PropertyType::with('propertyType')->get();
        return response()->json(['propertytypes' => $propertytypes], 200);
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
            'property_id' => 'sometimes',
        ]);

        $propertytype = PropertyType::create($request->all());
        return response()->json([
            'message' => 'Property Type Created',
            'propertytype' => $propertytype,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyType $propertyType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (PropertyType::where('id', $id)->exists()) {
            $propertytypeDetails = PropertyType::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($propertytypeDetails, 200);
          } else {
            return response()->json([
              "message" => "Property Type not found"
            ], 404);
          }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (PropertyType::where('id', $id)->exists()) {
            $propertytype = PropertyType::findorFail($id);
            $propertytype->update($request->all());

            return response()->json([
                "message" => "Property Type updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Property Type not found"
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(PropertyType::where('id', $id)->exists()) {
            $propertytype = PropertyType::findorFail($id);
            $propertytype->delete();

            return response()->json([
              "message" => "Property Type deleted"
            ], 202);
          } else {
            return response()->json([
              "message" => "Property Type not found"
            ], 404);
        }
    }
}
