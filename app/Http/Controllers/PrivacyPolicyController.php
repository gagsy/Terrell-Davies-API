<?php

namespace App\Http\Controllers;

use App\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PrivacyPolicy::all();
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
            'description' => 'required'
        ]);

        $privacy = PrivacyPolicy::create($request->all());
        return response()->json([
            'message' => 'Privacy Policy Created',
            'privacy' => $privacy,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function show(PrivacyPolicy $privacyPolicy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (PrivacyPolicy::where('id', $id)->exists()) {
            $privacy = PrivacyPolicy::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($privacy, 200);
          } else {
            return response()->json([
              "message" => "Privacy Policy not found",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (PrivacyPolicy::where('id', $id)->exists()) {
            $privacy = PrivacyPolicy::findOrFail($id);
            $privacy->update($request->all());

            return response()->json([
                "message" => "Privacy Policy updated successfully",
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
     * @param  \App\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(PrivacyPolicy::where('id', $id)->exists()) {
            $privacy = PrivacyPolicy::findOrFail($id);
            $privacy->delete();

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
