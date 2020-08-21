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
        $subscriptions = SubscriptionPlans::all();
        return response()->json(['subscriptions' => $subscriptions], 200);
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

        $subscription = SubscriptionPlans::create($request->all());
        return response()->json([
            'message' => 'Subscription Plan Created',
            'subscription' => $subscription,
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
            $subscriptionDetails = SubscriptionPlans::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($subscriptionDetails, 200);
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
            $subscription = SubscriptionPlans::find($id);
            $subscription->name = is_null($request->name) ? $subscription->name : $request->name;
            $subscription->price = is_null($request->price) ? $subscription->price : $request->price;
            $subscription->duration = is_null($request->duration) ? $subscription->duration : $request->duration;
            $subscription->maximum_listings = is_null($request->maximum_listings) ? $subscription->maximum_listings : $request->maximum_listings;
            $subscription->maximum_premium_listings = is_null($request->maximum_premium_listings) ? $subscription->maximum_premium_listings : $request->maximum_premium_listings;
            $subscription->max_featured_ad_listings = is_null($request->max_featured_ad_listings) ? $subscription->max_featured_ad_listings : $request->max_featured_ad_listings;
            $subscription->save();

            return response()->json([
                "message" => "Subscriptions Plan updated successfully"
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
            $subscription = SubscriptionPlans::find($id);
            $subscription->delete();

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
