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
    protected $user;

    public function __construct()
    {
        //Select payment service here, only available option is flutterwave service, 
        //you can make other services by using the flutterwave service as a template 
        //and implementing the paymentservice contract

        $this->paymentService = new FlutterwavePaymentService();

        $this->user = auth('api')->user();

        
        if( !isset($this->user) || empty($this->user) ){

            return response()->json([
                'message' => 'Authentication Failed',
                'data'=>[]
            ], 403);

        }

    }

    public function makePayment(Request $request){

        // {
        //     "tx_ref":"hooli-tx-1920bbtytty",
        //     "amount":"100",
        //     "currency":"NGN",
        //     "redirect_url":"https://webhook.site/9d0b00ba-9a69-44fa-a43d-a82c33c36fdc",
        //     "payment_options":"card",
        //     "meta":{
        //        "consumer_id":23,
        //        "consumer_mac":"92a3-912ba-1192a"
        //     },
        //     "customer":{
        //        "email":"user@gmail.com",
        //        "phonenumber":"080****4528",
        //        "name":"Yemi Desola"
        //     },
        //     "customizations":{
        //        "title":"Pied Piper Payments",
        //        "description":"Middleout isn't free. Pay the price",
        //        "logo":"https://assets.piedpiper.com/logo.png"
        //     }
        //  }

        $transactionRef = $this->paymentService->generateTransactionReference(20);
        $amount = $request->amount;
        $planId = $request->plan;
        
        

        $paymentData = [
            "tx_ref"=>$transactionRef,
            "amount"=>$amount,
            "payment_options"=>"card",
            "payment_plan"=>$planId
            "redirect_url"=> Route:: 
        ]

    }






}
