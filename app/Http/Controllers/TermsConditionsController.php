<?php

namespace App\Http\Controllers;

use App\TermsConditions;
use Illuminate\Http\Request;

class TermsConditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = TermsConditions::all();
        return response()->json(['terms' => $terms], 200);
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
            'description' => 'required'
        ]);

        $term = TermsConditions::create($request->all());
        return response()->json([
            'message' => 'Terms and Conditions Created',
            'term' => $term,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TermsConditions  $termsConditions
     * @return \Illuminate\Http\Response
     */
    public function show(TermsConditions $termsConditions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TermsConditions  $termsConditions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (TermsConditions::where('id', $id)->exists()) {
            $term = TermsConditions::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($term, 200);
          } else {
            return response()->json([
              "message" => "Terms and Conditions not found",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TermsConditions  $termsConditions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (TermsConditions::where('id', $id)->exists()) {
            $term = TermsConditions::findOrFail($id);
            $term->update($request->all());

            return response()->json([
                "message" => "Terms and Conditions updated successfully",
            ], 200);
            } else {
            return response()->json([
                "message" => "Record not found",
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TermsConditions  $termsConditions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(TermsConditions::where('id', $id)->exists()) {
            $term = TermsConditions::findOrFail($id);
            $term->delete();

            return response()->json([
              "message" => "record deleted",
            ], 202);
          } else {
            return response()->json([
              "message" => "record not found",
            ], 404);
          }
    }
}
