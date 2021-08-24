<?php

namespace App\Http\Controllers;

use App\Property;
use App\Category;
use App\Helpers\ApiConstants;
use App\Location;
use App\SavedProperty;
use App\ShortList;
use Illuminate\Support\Arr;
use App\Type;
use App\User;
use DB;
use Exception;
use Auth;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        $property = Property::orderBy('id', 'DESC')->where('status', 'Publish')->get();

        //extract the images

        return response()->json([
            'property' => $property,
        ], 200);

    }

    public function paginate()
    {
        $property = Property::orderBy('id', 'DESC')->paginate(5);
        return $property;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_saved_property(){
        $user_id = auth('api')->user()->id;

        $user_saved_property = SavedProperty::where('user_id', $user_id)->count();
            return response()-> json([
            'user_saved_property' => $user_saved_property
        ], 200);
    }

    public function createSavedProperty(Request $request)
    {
        //
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'property_id' => 'required'
            ]);

            if($validator->fails()){
                session()->flash('errors' , $validator->errors());
                throw new ValidationException($validator);
            } else {
                $users = auth('api')->user();
                $user = json_decode($users);

                $property = SavedProperty::create([
                    'user_id' => $user->id,
                    'property_id' => $request->property_id,
                ]);

                DB::commit();
                // return validResponse('Property Created!');
                return response()->json([
                    'message' => 'Property Saved!',
                    'property' => $property,
                ], 201);
            }   
        }

        catch(ValidationException $e){
            DB::rollback();
            $message = "" . (implode(' ', Arr::flatten($e->errors())));
            return problemResponse($message , ApiConstants::BAD_REQ_ERR_CODE , $request);
        }
        catch(Exception $e){
            session()->flash('error_msg' , $e->getMessage());
            dd($e->getMessage());
            DB::rollback();
            return problemResponse($e->getMessage() , ApiConstants::SERVER_ERR_CODE , $request);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromServer(Request $request)
    {
         if(!$this->planManager->canUserCreateProperty()){

            return response()->json([
                'message' => 'User does not have active subscription, or subscription has expired',
                'property' => [],
            ], 407);

         }
        $path2 = "";

        DB::beginTransaction();

        try{
            
            $validator = Validator::make($request->all(),[
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
                // 'other_images' => 'nullable',
                // 'other_images.*' => 'text|max:3048',
                'image' => 'required',
                'image.*' => 'text|max:3048',
                'bedroom' => 'required',
                'bathroom' => 'required',
                'toilet' => 'required',
                'video_link' => 'nullable',
                'status' => 'required',
                'feature' => 'required',
            ]);
            
            //TODO: Don't forget to remove the ! from this validation

            if($validator->fails()){
                session()->flash('errors' , $validator->errors());
                throw new ValidationException($validator);
            }       
        
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pin = mt_rand(1000000, 9999999)
                    . mt_rand(1000000, 9999999)
                    . $characters[rand(0, strlen($characters) - 1)];

            // $users = auth('api')->user();
            $user = json_decode($this->user);

            if ($request->hasFile('other_images')) {
                $path2 = array($request->other_images);
                print_r('The images when converted to array '.$path2);
                print_r('The images without array conversion '.$request->other_images);
            }

            $property = Property::create([
                'user_id' => $this->user->id,
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
                'other_images' => array($request->other_images),
                'image' => $request->image,
                'bedroom' => $request->bedroom,
                'bathroom' => $request->bathroom,
                'toilet' => $request->toilet,
                'video_link' => $request->video_link,
                'status' => $request->status,
                'feature' => $request->feature,
                'ref_no' => str_shuffle($pin),
                'user' => $user,
            ]);

            DB::commit();
            // return validResponse('Property Created!');
            return response()->json([
                'message' => 'Property Created!',
                'property' => $property,
            ], 201);
        }
        catch(Exception $e){
            session()->flash('error_msg' , $e->getMessage());
            // dd($e->getMessage());
            DB::rollback();
            return problemResponse($e->getMessage() , ApiConstants::SERVER_ERR_CODE , $request);
        }
        catch(ValidationException $e){
            DB::rollback();
            $message = "" . (implode(' ', Arr::flatten($e->errors())));
            return problemResponse($message , ApiConstants::BAD_REQ_ERR_CODE , $request);
        }
    }

    public function store(Request $request)
    {
        if(!$this->planManager->canUserCreateProperty()){

            return response()->json([
                'message' => 'User does not have active subscription, or subscription has expired',
                'property' => [],
            ], 407);

         }
        $path2 = "";

        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(),[
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
            'other_images' => 'nullable',
            'other_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
            'bedroom' => 'required',
            'bathroom' => 'required',
            'toilet' => 'required',
            'video_link' => 'nullable',
            'status' => 'required',
            'feature' => 'required',
        ]);

        if($validator->fails()){
            session()->flash('errors' , $validator->errors());
            throw new ValidationException($validator);
        }

        if ($request->hasFile('other_images')) {

            // break down the array

            foreach ($request->file('other_images') as $picture) {
                $pictures[] = $fileName = time().'.'.$picture->getClientOriginalName();
                $image_path = public_path('/FeaturedProperty_images');
                $picture->move($image_path,$fileName);

                // Storage::put('public/' . $fileName, file_get_contents($picture));
            }
            $path2 = '/FeaturedProperty_images/'.implode(',/FeaturedProperty_images/', $pictures);
            $path2 = array($path2);
            $featuredImage = $request->file('image');
            $image_filename = time().'.'.$featuredImage->getClientOriginalExtension();
            $image_path2 = public_path('/FeaturedProperty_images');
            $featuredImage->move($image_path2,$image_filename);
            $path = '/FeaturedProperty_images/'.$image_filename;

            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pin = mt_rand(1000000, 9999999)
                    . mt_rand(1000000, 9999999)
                    . $characters[rand(0, strlen($characters) - 1)];

            $users = auth('api')->user();
            $user = json_decode($users);

            $property = Property::create([
                'user_id' => $user->id,
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
                'other_images' => $path2,
                'image' => $path,
                'bedroom' => $request->bedroom,
                'bathroom' => $request->bathroom,
                'toilet' => $request->toilet,
                'video_link' => $request->video_link,
                'status' => $request->status,
                'feature' => $request->feature,
                'ref_no' => str_shuffle($pin),
                'user' => $user,
            ]);

            DB::commit();
            // return validResponse('Property Created!');
            return response()->json([
                'message' => 'Property Created!',
                'property' => $property,
            ], 201);
        }
        if (!$request->hasFile('other_images')) {
            $featuredImage = $request->file('image');
            $image_filename = time().'.'.$featuredImage->getClientOriginalExtension();
            $image_path = public_path('/FeaturedProperty_images');
            $featuredImage->move($image_path,$image_filename);
            $path = '/FeaturedProperty_images/'.$image_filename;

            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pin = mt_rand(1000000, 9999999)
                    . mt_rand(1000000, 9999999)
                    . $characters[rand(0, strlen($characters) - 1)];

            $users = auth('api')->user();
            $user = json_decode($users);

            $property = Property::create([
                'user_id' => $user->id,
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
                'other_images' => $request->other_images,
                'image' => $path,
                'bedroom' => $request->bedroom,
                'bathroom' => $request->bathroom,
                'toilet' => $request->toilet,
                'video_link' => $request->video_link,
                'status' => $request->status,
                'feature' => $request->feature,
                'ref_no' => str_shuffle($pin),
                'user' => $user,
            ]);

            DB::commit();
            // return validResponse('Property Created!');
            return response()->json([
                'message' => 'Property Created!',
                'property' => $property,
            ], 201);
            }
        }
        catch(ValidationException $e){
            DB::rollback();
            $message = "" . (implode(' ', Arr::flatten($e->errors())));
            return problemResponse($message , ApiConstants::BAD_REQ_ERR_CODE , $request);
        }
        catch(Exception $e){
            session()->flash('error_msg' , $e->getMessage());
            dd($e->getMessage());
            DB::rollback();
            return problemResponse($e->getMessage() , ApiConstants::SERVER_ERR_CODE , $request);
        }
    }

    public function user_property_list(){
        $user_id = auth('api')->user()->id;

        $user_property_get = Property::where('user_id', $user_id)->get();
        return response()-> json([
            'user_property_listing' => $user_property_get
        ], 200);
    }

    public function user_property_count(){
        $user_id = auth('api')->user()->id;

        $user_property_Count = Property::where('user_id', $user_id)->count();
            return response()-> json([
            'user_property_listing_count' => $user_property_Count
        ], 200);
    }

    public function shortlist(Request $request){
        $request->validate([
            'user_id' => 'required',
            'property_id' => 'required',
        ]);


        DB::beginTransaction();
        $shortlist = ShortList::create([
            'user_id' => auth('api')->user()->id,
            'property_id' => $request->property_id,
        ]);

        return response()->json([
            'message' => 'Property added to shortlist successfully!',
        ], 201);
    }

    public function user_shortlist_count(){
        $user_id = auth('api')->user()->id;

        $user_shortlist_count = Shortlist::where('user_id', $user_id)->count();
            return response()->json([
            'user_shortlist_count' => $user_shortlist_count
        ], 200);
    }

    public function searchByStateAreaCity(Request $request){
        $pro = Property::where('status', 'Publish');

        if ($request->has('state')) {
            $pro->where('state', $request->state);
        }



        return $pro->get();
    }

    public function addToShortlist($id)
    {
        $property = Property::find($id);
        if(!$property) {
            return response()->json([
                'message' => 'Property does not exist!'
            ], 404);
        }
        $shortlist = session()->get('shortlist');
        // if shortlist is empty then this the first pro$property
        if(!$shortlist) {
            $shortlist = [
                    $id => [
                        "name" => $property->name,
                        "quantity" => 1,
                        "budget" => $property->budget,
                        "image" => $property->image
                    ]
            ];
            session()->put('shortlist', $shortlist);
            return response()->json([
                'message' => 'Property added to shortlist successfully!',
            ], 201);
        }
        // if shortlist not empty then check if this pro$property exist then increment quantity
        if(isset($shortlist[$id])) {
            $shortlist[$id]['quantity']++;
            session()->put('shortlist', $shortlist);
            return response()->json([
                'message' => 'Property added to shortlist successfully!',
            ], 201);
        }
        // if item not exist in shortlist then add to shortlist with quantity = 1
        $shortlist[$id] = [
            "name" => $property->name,
            "quantity" => 1,
            "budget" => $property->budget,
            "image" => $property->image
        ];
        session()->put('shortlist', $shortlist);
        return response()->json([
            'message' => 'Property added to shortlist successfully!',
        ], 201);
    }

    public function updateShortlist(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function removeShortlist(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
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
                'image' => $data['image'],
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


    // api to count distinct property
    public function getUniquePropertyCount(Request $request)
    {
        // Property::where('type_id', 2);
        /**
         * Rent => 1
         * Sale => 2
         * Shortlet => 3
         * 
         * categories => 
         */
        // $property = DB::table('properties')->select('locality')->distinct()->get()->count();

        // $property = Property::distinct('locality')->get('type_id')->count();
        $property = Property::select('locality', DB::raw('count(locality) quantity'))->groupBy('locality')->get();

        // by type 
        $property = Property::where('type_id', 1)->select('locality', DB::raw('count(locality) quantity'))->groupBy('locality')->get();
        $property = Property::select('type_id', DB::raw('count(type_id) quantity'))->groupBy('type_id')->get();

        return response()-> json([
            'propertyDistinctCount' => $property
        ], 200);
    }

    public function rentByTownPropertyCount(Request $request)
    {

        $property = Property::where('type_id', 1)->select('locality', DB::raw('count(locality) quantity'))->groupBy('locality')->get();

        return response()-> json([
            'propertyCountForRentByTown' => $property
        ], 200);

    }

    public function saleByTownPropertyCount(Request $request)
    {

        $property = Property::where('type_id', 2)->select('locality', DB::raw('count(locality) quantity'))->groupBy('locality')->get();

        return response()-> json([
            'propertyCountForSaleByTown' => $property
        ], 200);

    }

    public function shortletByTownPropertyCount(Request $request)
    {

        $property = Property::where('type_id', 3)->select('locality', DB::raw('count(locality) quantity'))->groupBy('locality')->get();

        return response()-> json([
            'propertyCountForShortletByTown' => $property
        ], 200);

    }

    public function shortletByCategoryPropertyCount(Request $request)
    {

        $property = Property::where('type_id', 3)->where('category_id', 3)->select('locality', DB::raw('count(locality) quantity'))->groupBy('locality')->get();

        return response()-> json([
            'categoryCountForShortlet' => $property
        ], 200);

    }

    public function saleByCategoryPropertyCount(Request $request)
    {

        $property = Property::where('type_id', 2)->where('category_id', 3)->select('locality', DB::raw('count(locality) quantity'))->groupBy('locality')->get();

        return response()-> json([
            'categoryCountForSale' => $property
        ], 200);

    }

    public function rentByCategoryPropertyCount(Request $request)
    {

        $property = Property::where('type_id', 1)->where('category_id', 3)->select('locality', DB::raw('count(locality) quantity'))->groupBy('locality')->get();

        return response()-> json([
            'categoryCountForRent' => $property
        ], 200);

    }

    public function getCounts()
    {
        $user_count = User::where('userType', 'real_estate_agent')->count();
        $property_count = Property::all()->count();
        $areas_covered_count = Property::distinct('locality')->count();
        return response()-> json([
            'estateAgentCount' => $user_count,
            'propertyCount' => $property_count,
            'areasCovered' => $areas_covered_count
        ], 200);
    }

    public function getFlats(Request $request)
    {

        $flats = Property::where('category_id', 1)->paginate(5);

        return response()-> json([
            'flats' => $flats
        ], 200);

    }

    public function getHouses(Request $request)
    {

        $houses = Property::where('category_id', 2)->paginate(5);

        return response()-> json([
            'houses' => $houses
        ], 200);

    }

    public function getCommercialProjects(Request $request)
    {

        $commercialProjects = Property::where('category_id', 3)->paginate(5);

        return response()-> json([
            'commercialProjects' => $commercialProjects
        ], 200);

    }

    public function getLands(Request $request)
    {

        $lands = Property::where('category_id', 4)->paginate(5);

        return response()-> json([
            'lands' => $lands
        ], 200);
    }

    public function listAgentsData($id)
    {
		$estateAgent = User::where('id', $id)->where('userType', 'real_estate_agent')->with('properties')->get();
        if (count($estateAgent) > 0) {
            return response()->json([
                'agent_data' => $estateAgent
            ], 200);
        } else {
            return response()->json([
                'response' => 'User is not registered as an estate agent'
            ], 400);
        }
    }

    public function listPropertyOwnerData($id){
        $propertyOwner = User::where('id', $id)->where('userType', 'property_owner')->with('properties')->get();
        if (count($propertyOwner) > 0) {
            return response()->json([
                'property_owner_data' => $propertyOwner
            ], 200);
        } else {
            return response()->json([
                'response' => 'User is not registered as a Property Owner'
            ], 400);
        }
    }

    public function listAllAgents()
    {
        $estateAgents = User::where('userType', 'real_estate_agent')->with('properties')->paginate(5);
        if (count($estateAgents) > 0) {
            return response()->json([
                'agents_data' => $estateAgents
            ], 200);
        } else {
            return response()->json([
                'response' => '0 estate agent found'
            ], 400);
        }
    }
    
    public function listAllPropertyOwners()
    {
        $propertyOwners = User::where('userType', 'property_owner')->with('properties')->paginate(5);
        if (count($propertyOwners) > 0) {
            return response()->json([
                'property_owners_data' => $propertyOwners
            ], 200);
        } else {
            return response()->json([
                'response' => '0 Property Owner found'
            ], 400);
        }
    }
}
