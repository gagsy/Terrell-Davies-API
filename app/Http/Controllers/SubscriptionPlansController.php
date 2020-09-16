<?php

namespace App\Http\Controllers;

use App\SubscriptionPlans;
use Illuminate\Http\Request;

class SubscriptionPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = SubscriptionPlans::all();
        return response()->json(['plans' => $plans], 200);
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
            'name' => 'required',
            'price' => 'required',
            'duration' => 'required',
            'maximum_listings' => 'required',
            'maximum_premium_listings' => 'required',
            'max_featured_ad_listings' => 'required',
        ]);

        $plan = SubscriptionPlans::create($request->all());
        return response()->json([
            'message' => 'Subscription Plan Created',
            'plan' => $plan,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubscriptionPlans  $subscriptionPlans
     * @return \Illuminate\Http\Response
     */
    public function show(SubscriptionPlans $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubscriptionPlans  $subscriptionPlans
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (SubscriptionPlans::where('id', $id)->exists()) {
            $planDetails = SubscriptionPlans::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($planDetails, 200);
          } else {
            return response()->json([
              "message" => "Subscription Plan not found"
            ], 404);
          }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubscriptionPlans  $subscriptionPlans
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (SubscriptionPlans::where('id', $id)->exists()) {
            $plan = SubscriptionPlans::find($id);
            $plan->name = is_null($request->name) ? $plan->name : $request->name;
            $plan->price = is_null($request->price) ? $plan->price : $request->price;
            $plan->duration = is_null($request->duration) ? $plan->duration : $request->duration;
            $plan->maximum_listings = is_null($request->maximum_listings) ? $plan->maximum_listings : $request->maximum_listings;
            $plan->maximum_premium_listings = is_null($request->maximum_premium_listings) ? $plan->maximum_premium_listings : $request->maximum_premium_listings;
            $plan->max_featured_ad_listings = is_null($request->max_featured_ad_listings) ? $plan->max_featured_ad_listings : $request->max_featured_ad_listings;
            $plan->save();

            return response()->json([
                "message" => "plans Plan updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Subscription Plan not found"
            ], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubscriptionPlans  $subscriptionPlans
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(SubscriptionPlans::where('id', $id)->exists()) {
            $plan = SubscriptionPlans::find($id);
            $plan->delete();

            return response()->json([
              "message" => "Subscription Plan deleted"
            ], 202);
          } else {
            return response()->json([
              "message" => "Subscription Plans not found"
            ], 404);
        }
    }
}
