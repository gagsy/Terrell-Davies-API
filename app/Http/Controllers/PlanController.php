<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;
use App\Services\FlutterwavePaymentService;


class PlanController extends Controller
{

    protected $paymentService;
    protected $user;

    public function __construct()
    {

        $this->user = auth('api')->user();

        if( !isset($this->user) || empty($this->user) ){

            return response()->json([
                'message' => 'Authentication Failed',
                'data'=>[]
            ], 403);

        }

        $this->paymentService = new FlutterwavePaymentService();


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::all();
        return response()->json([ 'plans' => $plans], 200);
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
        // return $this->user;
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'duration' => 'required'            
        ]);

        $availablePaymentPlans = $this->getPlans();

        foreach($availablePaymentPlans['data'] as $option){

            $singlePlanName = $option['name'];
 
            if($request->name == $singlePlanName){
 
                 return response()->json([
                     'message' => 'The plan name already exists',
                     'data'=>[]
                 ], 405);
 
            }
 
         }

        $paymentPlan = $this->paymentService->createPlan([
            "amount"=> $request->price,
            "name"=> $request->name,
            "interval"=> 'monthly',
            "duration"=> $request->duration
        ]);

        if($paymentPlan->json()['status'] == 'success'){

            $plan = Plan::create([

                'name' => $request->name,
                'price' => $request->amount,
                'duration' => $request->duration,
                'discount_month1' => $request->discount_month1 ?? '',
                'discount_month2' =>  $request->discount_month2 ?? '',
                'maximum_listings' => $request->maximum_listings,
                'maximum_premium_listings' => $request->maximum_premium_listings,
                'max_featured_ad_listings' => $request->max_featured_ad_listings
                'gateway_id'=> $paymentPlan->json()['data']['id']
            ]);
             
    
            return response()->json([
                'message' => 'Subscription Plan Created',
                'plan' => $plan,
            ], 200);
        }

        return response()->json([
            'message' => 'Something went wrong during plan creation',
            'plan' => [],
        ], 503);

     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan=Plans::where('id', $id)->first();
        return response()->json(['plan' => $plan], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Plan::where('id', $id)->exists()) {
            $planDetails = Plan::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($planDetails, 200);
          } else {
            return response()->json([
              "message" => "Plan not found"
            ], 404);
          }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Plan::where('id', $id)->exists()) {
            $plan = Plan::find($id);
            $plan->name = is_null($request->name) ? $plan->name : $request->name;
            $plan->price = is_null($request->price) ? $plan->price : $request->price;
            $plan->duration = is_null($request->duration) ? $plan->duration : $request->duration;
            $plan->maximum_listings = is_null($request->maximum_listings) ? $plan->maximum_listings : $request->maximum_listings;
            $plan->maximum_premium_listings = is_null($request->maximum_premium_listings) ? $plan->maximum_premium_listings : $request->maximum_premium_listings;
            $plan->max_featured_ad_listings = is_null($request->max_featured_ad_listings) ? $plan->max_featured_ad_listings : $request->max_featured_ad_listings;
            $plan->save();

            return response()->json([
                "message" => "Plan updated successfully"
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Plan::where('id', $id)->exists()) {
        $plan = Plan::find($id);
        $plan->delete();

        return response()->json([
          "message" => "Plan deleted"
        ], 202);
      } else {
        return response()->json([
          "message" => "Plan not found"
        ], 404);
    }
    }


    public function getPlans(){

        $paymentPlans = $this->paymentService->fetchPlanDetails();

        return $paymentPlans->json();

     
    }


    public function activePlan(Array $data){
        //active plan for user, needs user_plan.
        // add user id to plan 

    }

    public function cancelPlan(){
        //allow user to cancel plan before being billed again

        $cancelPlan = $this->paymentService->cancelPlan();
        return $cancelPlan->json();
    }
}
