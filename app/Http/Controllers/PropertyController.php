<?php

namespace App\Http\Controllers;

use App\Property;
use App\PropertyType;
use App\PropertyCategory;
use App\User;

use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::all();
        // $propertytypes = PropertyType::get();
        // $propertycats = Propertycategory::get();
        return response()->json(['properties' => $properties], 200);
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
        $search = $request->validate([
            'prperty_cat_id' => 'required',
            'prperty_type_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'state' => 'required',
            'market-status' => 'required',
            'locality' => 'required',
            'budget' => 'required',
            'featuredImage' => 'required|image',
            'galleryImage' => 'required|image',
            'agent' => 'required',
            'feature' => 'required',
            'bedroom' => 'required',
            'bathroom' => 'required',
            'garage' => 'required',
            'toilet' => 'required',
            'totalarea' => 'required',
            'video-link' => 'required',
            'metaDescription' => 'required',
        ]);

        try{

            $featuredImage = $request->file('image');
            $image_filename = time().'.'.$featuredImage->getClientOriginalExtension();
            $image_path = public_path('/FeaturedProperty_images');
            $featuredImage->move($image_path,$image_filename);

            $search['featuredImage'] = $image_filename;

            $galleryImage = $request->file('image');
            $image_filename1 = time().'.'.$galleryImage->getClientOriginalExtension();
            $image_path = public_path('/Gallery_images');
            $galleryImage->move($image_path,$image_filename1);

            $search['galleryImage'] = $image_filename1;

            $property = Property::create($search);
            return response()->json([
                'message' => 'Type Created',
                'property' => $property,
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'An error occured',
                'property' => $property,
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Property::where('id', $id)->exists()) {
            $propertyDetails = Property::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($propertyDetails, 200);
          } else {
            return response()->json([
              "message" => "Property not found"
            ], 404);
          }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $id)
    {
        $properties = Property::findorfail($id);
        if ($request->isMethod('post')) {
            $search = $request->all();
            try{

                $featuredImage = $request->file('image');
                $image_filename = time().'.'.$featuredImage->getClientOriginalExtension();
                $image_path = public_path('/FeaturedProperty_images');
                $featuredImage->move($image_path,$image_filename);

                $search['featuredImage'] = $image_filename;

                $galleryImage = $request->file('image');
                $image_filename1 = time().'.'.$galleryImage->getClientOriginalExtension();
                $image_path = public_path('/Gallery_images');
                $galleryImage->move($image_path,$image_filename1);

                $search['galleryImage'] = $image_filename1;
            }
            catch(Exception $e){
                return response()->json([
                    'message' => 'An error occured',
                ], 400);
            }


            $properties->update([
                'prperty_cat_id' => $search['prperty_cat_id'],
                'prperty_type_id' => $search['prperty_type_id'],
                'title'=>$search['title'],
                'description'=>$search['description'],
                'state' => $search['state'],
                'market-status' => $search['market-status'],
                'locality' => $search['locality'],
                'budget' => $search['budget'],
                'featuredImage' => $image_filename,
                'galleryImage'=>$image_filename1,
                'agent' => $search['agent'],
                'feature' => $search['feature'],
                'bedroom' => $search['bedroom'],
                'bathroom' => $search['bathroom'],
                'garage' => $search['garage'],
                'toilet' => $search['toilet'],
                'totalarea' => $search['totalarea'],
                'video-link' => $search['video-link'],
                'metaDescription' => $search['metaDescription'],
            ]);

            return response()->json([
                "message" => "Property updated successfully",
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $id)
    {
        if(Property::where('id', $id)->exists()) {
            $properties = Property::find($id);
            $properties->delete();

            return response()->json([
              "message" => "record deleted",
              'properties' => $properties,
            ], 202);
          } else {
            return response()->json([
              "message" => "record not found",
              'properties' => $properties,
            ], 404);
        }
    }

    public function search(Request $request){
        // $searchTerm = $request->input('searchTerm');
        // $properties = Property::search($searchTerm)->get();
        // return response()->json(['properties' => $properties], 200);
    }

    public function getSearchResults(Request $request) {
        $data = $request->get('data');

        $properties = Property::where('title', 'like', "%{$data}%")->get();

        return response()->json([
            'search' => $properties
        ]);
    }
}