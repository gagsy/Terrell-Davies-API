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
        $data = $request->validate([
            'property_id' => '',
            'image' => 'required|image',
        ]);
        if ( ! is_dir(public_path('/Gallery_images'))) {
            mkdir(public_path('/Gallery_images'), 0777);
        }

        $images = Collection::wrap(request()->file('image'));

        $images->each(function($image   ){
            $basename = Str::random();
            $original = $basename . '.' . $image->getClientOriginalExtension();
            // $thumbnail = $basename . '_thumb.' . $image->getClientOriginalExtension();

            // Image::make($image)
            //     ->fit(250, 250)
            //     ->save(public_path('/Gallery_images'), $thumbnail);


            $image->move(public_path('/Gallery_images'), $original);

            $gallery = PropertyGallery::create([
                'property_id' => 1,
                'image' => '/Gallery_images/' . $original,
            ]);

            return response()->json([
                'message' => 'Property Gallery Created',
            ], 200);

        });
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
