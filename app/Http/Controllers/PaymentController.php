<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Subscription;
use App\Plan;
use App\Payment;
use App\Http\Controllers\Controller;
use Paystack;
use Session;

use App\Services\FlutterwavePaymentService;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct()
    {
        //Select payment service here, only available option is flutterwave service, 
        //you can make other services by using the flutterwave service as a template 
        //and implementing the paymentservice contract

        $this->paymentService = new FlutterwavePaymentService();
    }

    public function createPaymentPlan(Request $request){

             //check that plan with that name does not exist

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
            "amount"=> $request->amount,
            "name"=> $request->name,
            "interval"=> $request->interval,
            "duration"=> $request->duration
        ]);

      return $paymentPlan;


    }

    public function getPlans(){

        $paymentPlans = $this->paymentService->fetchPlanDetails();

        return $paymentPlans->json();

     
    }

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        try{

            return Paystack::getAuthorizationUrl()->redirectNow();

        }catch(\Exception $e) {

            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
            
        }
    }



    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        $subscription= new Subscription();
        $subscription->user_id = 1;
        $subscription->plan_id = $paymentDetails['data']['plan_id'];
        //dd($paymentDetails['data']['plan_id']);
        $subscription->payment_method = 'Paystack';
        $subscription->reference= $paymentDetails['data']['reference'];
        $subscription->amount= $paymentDetails['data']['amount'];
        $subscription->save();

        return redirect()-back();

        //dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
