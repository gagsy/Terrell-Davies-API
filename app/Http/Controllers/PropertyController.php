<?php

namespace App\Http\Controllers;

use App\Property;
use App\Category;
use App\Type;
use App\User;
use DB;
use Auth;
use Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     */

    public function index()
    {
        // $property = Property::all();
        // // $propertytype_ids = Propertytype_id::get();
        // // $propertycats = Propertycategory_id::get();
        // return response()->json(['property' => $property], 200);

        $property = Property::paginate(5);
        return $property;
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
    public function store(Request $request, $id = null)
    {


        $data = $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'type_id' => 'required',
            'location' => 'required',
            'title' => 'required',
            'description' => 'required',
            'state' => 'required',
            'area' => 'required',
            'total_area' => 'required',
            'market_status' => 'required',
            'parking' => 'required',
            'locality' => 'required',
            'budget' => 'required',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
            'bedroom' => 'required',
            'bathroom' => 'required',
            'toilet' => 'required',
            'video_link' => '',
            'status' => 'required',
            'feature' => 'required'
        ]);


        DB::beginTransaction();

        try{
            $user_id = Auth::user()->id;
            $data['user_id'] = $user_id;

            $featuredImage = $request->file('image');
            $image_filename = time().'.'.$featuredImage->getClientOriginalExtension();
            $image_path = public_path('/FeaturedProperty_images');
            $featuredImage->move($image_path,$image_filename);

            $data['image'] = $image_filename;


        }
        catch(\Exception $e){
            DB::rollback();
            dump($e->getMessage());
            return response()->json([
                'message' => 'An error occured',
            ], 400);
        }

        $property = Property::create($data);
            return response()->json([
                'message' => 'Property Created',
                'property' => $property,
            ], 200);
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
    public function update(Request $request, $id)
    {
        $property = Property::findorfail($id);
        if ($request->isMethod('post')) {
            $data = $request->all();
            try{

                $featuredImage = $request->file('image');
                $image_filename = time().'.'.$featuredImage->getClientOriginalExtension();
                $image_path = public_path('/FeaturedProperty_images');
                $featuredImage->move($image_path,$image_filename);

                $data['image'] = $image_filename;
            }
            catch(Exception $e){
                return response()->json([
                    'message' => 'An error occured',
                ], 400);
            }


            $property->update([
                'category_id' => $data['category_id'],
                'type_id' => $data['type_id'],
                'location' => $data['location'],
                'title'=>$data['title'],
                'description'=>$data['description'],
                'state' => $data['state'],
                'area' => $data['area'],
                'total_area' => $data['total_area'],
                'market_status' => $data['market-status'],
                'parking' => $data['parking'],
                'locality' => $data['locality'],
                'budget' => $data['budget'],
                'image' => $image_filename,
                'bedroom' => $data['bedroom'],
                'bathroom' => $data['bathroom'],
                'toilet' => $data['toilet'],
                'video_link' => $data['video_link'],
                'status' => $data['status'],
                'feature' => $data['feature'],
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
    public function destroy(Request $request, $id)
    {
        if(Property::where('id', $id)->exists()) {
            $property = Property::findorFail($id);
            $property->delete();

            return response()->json([
              "message" => "record deleted",
            ], 202);
          } else {
            return response()->json([
              "message" => "record not found",
            ], 404);
        }
    }

    public function search(Request $request){
        // $searchTerm = $request->input('searchTerm');
        // $property = Property::data($searchTerm)->get();
        // return response()->json(['property' => $property], 200);
    }

    public function getsearchResults(Request $request) {
        $data = $request->get('data');

        $property = Property::where('title', 'like', "%{$data}%")
                        ->orWhere('bathroom', 'like', "%{$data}%")
                        ->orWhere('budget', 'like', "%{$data}%")
                        ->orWhere('state', 'like', "%{$data}%")
                        ->orWhere('locality', 'like', "%{$data}%")
                        ->orWhere('type_id', 'like', "%{$data}%")
                        ->orWhere('category_id', 'like', "%{$data}%")
                        ->orWhere('location', 'like', "%{$data}%")
                        ->get();

        return response()->json([
            'data' => $property
        ]);
    }
    public function propertyCount(){
        $propertyCount = Property::count();
        return response()-> json([
            'propertyCount' => $propertyCount
        ], 200);
    }
}
