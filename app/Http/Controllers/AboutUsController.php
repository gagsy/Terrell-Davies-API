<?php

namespace App\Http\Controllers;

use App\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AboutUs::all();
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
            'content' => 'required',
            'description' => 'required',
            'image' => 'required|image',
        ]);

        DB::beginTransaction();
        $featuredImage = $request->file('image');
        $image_filename = time().'.'.$featuredImage->getClientOriginalExtension();
        $image_path = public_path('/About_images');
        $featuredImage->move($image_path,$image_filename);
        $path = '/About_images/'.$image_filename;

        $about = About::create([
            'content' => $request->content,
            'description' => $request->description,
            'image' => $path,
        ]);

        return response()->json([
            'message' => 'About Us Created!',
            'about' => $about,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function show(AboutUs $aboutUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (AboutUs::where('id', $id)->exists()) {
            $abouts = AboutUs::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($abouts, 200);
          } else {
            return response()->json([
              "message" => "About Us not found",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (AboutUs::where('id', $id)->exists()) {
            $about = AboutUs::findOrFail($id);
            $about->update($request->all());

            return response()->json([
                "message" => "About Us updated successfully",
            ], 200);
            } else {
            return response()->json([
                "message" => "About Us not found",
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(AboutUs::where('id', $id)->exists()) {
            $about = AboutUs::findOrFail($id);
            $about->delete();

            return response()->json([
              "message" => "About Us deleted",
            ], 202);
          } else {
            return response()->json([
              "message" => "About Us not found",
            ], 404);
        }
    }
}
