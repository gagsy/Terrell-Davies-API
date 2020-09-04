<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Subscription;
use App\Http\Controllers\Controller;
use Paystack;

class PaymentController extends Controller
{

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        //$paymentDetails = Paystack::getPaymentData();
        $subscriptionDetails = Paystack::getAllPlans();

        if($subscription['data']['status'] == 'success')
        {
            flash('Subscription Done Successfully');
        }else{
            flash('Subcription not Successful');
        }

        $subscription= new Subscription;
        $subscription->user_id = Auth::user()->id;
        $subscription->subscription_plan_id = $subscriptionDetails['data']['subscription_plan_id'];
        $subscription->reference= $subscriptionDetails['data']['reference'];
        $subscription->email= Auth::user()->email;
        $subscription->amount= $subscriptionDetails['data']['amount'];
        $subscription->status= $subscriptionDetails['data']['status'];
        $subscription->payment_date=$subscriptionDetails['data']['transaction_date'];
        $subscription->save();
        return redirect()-back();

        //dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
