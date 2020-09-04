<?php

namespace App\Http\Controllers;

use App\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = Feature::all();
        return response()->json(['features' => $features], 200);
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
            'name' => 'required'
        ]);

        $feature = Feature::create($request->all());
        return response()->json([
            'message' => 'Feature Created',
            'feature' => $feature,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Feature::where('id', $id)->exists()) {
            $feature = Feature::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($feature, 200);
          } else {
            return response()->json([
              "message" => "Feature not found",
              'feature' => $feature,
            ], 404);
          }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $id)
    {
        if (Feature::where('id', $id)->exists()) {
            $feature = Feature::find($id);
            $feature->name = is_null($request->name) ? $feature->name : $request->name;
            $feature->save();

            return response()->json([
                "message" => "Feature updated successfully",
                'feature' => $feature,
            ], 200);
            } else {
            return response()->json([
                "message" => "Record not found",
                'feature' => $feature,
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        if(Feature::where('id', $id)->exists()) {
            $feature = Feature::find($id);
            $feature->delete();

            return response()->json([
              "message" => "record deleted",
              'feature' => $feature,
            ], 202);
          } else {
            return response()->json([
              "message" => "record not found",
              'feature' => $feature,
            ], 404);
          }
    }
}
