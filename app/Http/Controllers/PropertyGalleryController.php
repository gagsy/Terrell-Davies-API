<?php

namespace App\Http\Controllers;

use App\PropertyGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PropertyGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = PropertyGallery::all();
        return response()->json(['galleries' => $galleries], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'property_id' => 'required',
            'image' => 'required|image|max:1999'
        ]);

        // Handle multiple file upload
        $images = $request->file('image');
        foreach($images as $key => $image) {
            if ($request->hasFile('image')[$key] && $request->file('image')[$key]->isValid()) {
                // store image to directory.
                $path = $request->image[$key]->store('public/Gallery_images/');
                $path = basename($path);

                // store image to database.
                $gallery = new PropertyGallery();
                $gallery->property_id = $request->input('property_id');
                $gallery->image = $path;
                $gallery->save();
                return response()->json([
                    'message' => 'Property Gallery Created',
                    'gallery' => $gallery,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'An error occured',
                ], 400);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PropertyGallery  $propertyGallery
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyGallery $propertyGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PropertyGallery  $propertyGallery
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyGallery $propertyGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PropertyGallery  $propertyGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyGallery $propertyGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PropertyGallery  $propertyGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyGallery $propertyGallery)
    {
        //
    }
}
