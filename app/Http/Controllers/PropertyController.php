<?php

namespace App\Http\Controllers;

use App\Property;
use App\Category;
use App\Location;
use App\ShortList;
use App\Type;
use App\User;
use DB;
use Auth;
use Image;
use Illuminate\Support\Facades\Storage;
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
        $property = Property::all();
        return response()->json(['property' => $property], 200);
    }

    public function paginate()
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
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'type_id' => 'required',
            'location' => 'required',
            'location_id' => 'nullable',
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
            'video_link' => 'nullable',
            'status' => 'required',
            'feature' => 'required',
        ]);


        DB::beginTransaction();
        if(Auth::check()) {
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $picture) {
                    $pictures[] = $fileName = time().'.'.$picture->getClientOriginalName();
                    $image_path = public_path('/FeaturedProperty_images');
                    $picture->move($image_path,$fileName);
                    // Storage::put('public/' . $fileName, file_get_contents($picture));
                }

                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $pin = mt_rand(1000000, 9999999)
                        . mt_rand(1000000, 9999999)
                        . $characters[rand(0, strlen($characters) - 1)];

                $property = Property::create([
                    'user_id' => auth('api')->user()->id,
                    'category_id' => $request->category_id,
                    'type_id' => $request->type_id,
                    'location_id' => $request->location_id,
                    'location' => $request->location,
                    'title' => $request->title,
                    'description' => $request->description,
                    'state' => $request->state,
                    'area' => $request->area,
                    'total_area' => $request->total_area,
                    'market_status' => $request->market_status,
                    'parking' => $request->parking,
                    'locality' => $request->locality,
                    'budget' => $request->budget,
                    'image' => implode(',', $pictures),
                    'bedroom' => $request->bedroom,
                    'bathroom' => $request->bathroom,
                    'toilet' => $request->toilet,
                    'video_link' => $request->video_link,
                    'status' => $request->status,
                    'feature' => $request->feature,
                    'ref_no' => str_shuffle($pin),
                ]);
                //$property =

                return response()->json([
                    'message' => 'Property Created!',
                    'property' => $property,
                    'image_path' => '/FeaturedProperty_images/'.implode(',', $pictures),
                ], 201);
            }
        } else {
            return response()->json([
                'message' => 'You are not logged in!'
            ], 201);
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
    public function update(Request $request, $id)
    {
        $property = Property::findorfail($id);
        if ($request->isMethod('post')) {
            $data = $request->all();
            try{

                $picture = $request->file('image');
                $image_filename = time().'.'.$picture->getClientOriginalExtension();
                $image_path = public_path('/FeaturedProperty_images');
                $picture->move($image_path,$image_filename);

                $data['image'] = $image_filename;

                $image_path1 = public_path('FeaturedProperty_images/'.$property->image);
                if(File::exists($image_path1)) {
                    File::delete($image_path1);
                }
            }
            catch(Exception $e){
                return response()->json([
                    'message' => 'An error occured',
                ], 400);
            }


            $property->update([
                'category_id' => $data['category_id'],
                'type_id' => $data['type_id'],
                'location_id' => $data['location_id'],
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
        $data = $request->has('data');

        $property = Property::where('title', 'like', "%{$data}%")
                        ->orWhere('bathroom', 'like', "%{$data}%")
                        ->orWhere('budget', 'like', "%{$data}%")
                        ->orWhere('state', 'like', "%{$data}%")
                        ->orWhere('locality', 'like', "%{$data}%")
                        ->orWhere('type_id', 'like', "%{$data}%")
                        ->orWhere('category_id', 'like', "%{$data}%");
                        // ->orWhere('location_id', 'like', "%{$data}%");


        return $property->get();
    }

    public function filter(Request $request)
    {
        $property = Property::where('status', 'Publish');
        if ($request->has('title','bathroom','budget', 'state', 'locality', 'type_id', 'category_id')) {
            $property->where('title', $request->title);
            $property->orWhere('bathroom', $request->bathroom);
            $property->orWhere('budget', $request->budget);
            $property->orWhere('state', $request->state);
            $property->orWhere('locality', $request->locality);
            $property->orWhere('type_id', $request->type_id);
            $property->orWhere('category_id', $request->category_id);
        }
        return $property->get();
    }

    public function propertyCount(){
        $propertyCount = Property::count();
        return response()-> json([
            'propertyCount' => $propertyCount
        ], 200);
    }

    public function user_property_count(){
        $user_id = auth('api')->user()->id;

        $user_property_Count = Property::where('user_id', $user_id)->count();
            return response()-> json([
            'user_property_listing_count' => $user_property_Count
        ], 200);
    }
}
