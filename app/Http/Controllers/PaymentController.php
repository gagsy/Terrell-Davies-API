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

class PaymentController extends Controller
{

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
        // $paymentDetails = Paystack::getPaymentData();

        // $subscription= new Subscription();
        // $subscription->user_id = 1;
        // $subscription->plan_id = $paymentDetails['data']['plan_id'];
        // //dd($paymentDetails['data']['plan_id']);
        // $subscription->payment_method = 'Paystack';
        // $subscription->reference= $paymentDetails['data']['reference'];
        // $subscription->amount= $paymentDetails['data']['amount'];
        // $subscription->save();

        // return redirect()-back();

        //dd($paymentDetails);

        // Implementing Flutterwave's callback
        $subscription= new Subscription();
        $subscription->user_id = 1;
        $subscription->plan_id = $paymentDetails['data']['plan_id'];
        //dd($paymentDetails['data']['plan_id']);
        $subscription->payment_method = 'Paystack';
        $subscription->reference= $paymentDetails['data']['reference'];
        $subscription->amount= $paymentDetails['data']['amount'];
        $subscription->save();

        return redirect()-back();
    }


}
