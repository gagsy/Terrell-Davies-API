<?php

namespace App\Http\Controllers;

use App\PropertyCategory;
use Illuminate\Http\Request;

class PropertyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $propertycats = PropertyCategory::all();
        return response()->json(['propertycats' => $propertycats], 200);
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
        ]);

        $propertycat = PropertyCategory::create($request->all());
        return response()->json([
            'message' => 'Property Category Created',
            'propertycat' => $propertycat,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PropertyCategory  $propertyCategory
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyCategory $propertyCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PropertyCategory  $propertyCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyCategory $id)
    {
        if (PropertyCategory::where('id', $id)->exists()) {
            $propertycatDetails = PropertyCategory::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($propertycatDetails, 200);
          } else {
            return response()->json([
              "message" => "Property Category not found"
            ], 404);
          }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PropertyCategory  $propertyCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyCategory $id)
    {
        if (PropertyCategory::where('id', $id)->exists()) {
            $propertycat = PropertyCategory::find($id);
            $propertycat->name = is_null($request->name) ? $propertycat->name : $request->name;
            $propertycat->save();

            return response()->json([
                "message" => "Property Category updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Property Category not found"
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PropertyCategory  $propertyCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyCategory $id)
    {
        if(PropertyCategory::where('id', $id)->exists()) {
            $propertycat = PropertyCategory::find($id);
            $propertycat->delete();

            return response()->json([
              "message" => "Property Category deleted"
            ], 202);
          } else {
            return response()->json([
              "message" => "Property Category not found"
            ], 404);
        }
    }
}
