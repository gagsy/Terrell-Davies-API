<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Subscription;
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
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        // if($paymentDetails['data']['status'] == 'success')
        // {
        //     dd($paymentDetails);
        //     //return redirect()-back()->with('flash_message_success','Subscription Done Successfully');
        // }else{
        //     //return redirect()-back()->with('flash_message_success','Subcription not Successful');
        // }

        $getID = Subscription::orderBy('id', 'desc')->first();
        if ($getID === NULL) {
            $lastID = 0;
        } else {
            $lastID = $getID->id;
        }
        $newID = $lastID + 1;
        $date = date('ymds');
        $subscripionID = 'WG' . $date . $newID;
        Session::forget('subscription');
        Subscription::create([
            'name' => \Auth::User()->first_name . ' ' . \Auth::User()->last_name,
            'subscription_plan_id' => $paymentDetails['data']['subscription_plan_id'],
            'user_id' => \Auth::User()->id,
            'amount' => $paymentDetails['data']['metadata']['amount'],
            'reference_code' => $paymentDetails['data']['reference']
        ]);

        $subscription= new Subscription();
        $subscription->user_id = 1;
        $subscription->subscription_plan_id = $paymentDetails['data']['subscription_plan_id'];
        //$subscription->reference= $paymentDetails['data']['reference'];
        //$subscription->email= Auth::user()->email;
        //$subscription->amount= $paymentDetails['data']['amount'];
        $subscription->payment_status= $paymentDetails['data']['payment_status'];
        //$subscription->payment_date=$paymentDetails['data']['transaction_date'];
        $subscription->save();
        return redirect()-back();

        //dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
