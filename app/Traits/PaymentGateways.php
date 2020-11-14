<?php

namespace App\Traits;

use App\Helpers\ApiConstants;
use App\Mail\NewInvestment;
use App\Mail\NewNotification;
use App\Mail\NewStakeCard;
use App\Mail\NewTransaction;
use App\Mail\NewWithdrawal;
use App\Models\Payment;
use App\Models\UserTransaction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;

trait PaymentGateWays
{
    public function processStripe(Request $request , $user_id = null){
        try{
            if ($request->input('stripeToken')) {

                $gateway = Omnipay::create('Stripe');
                $gateway->setApiKey(env("STRIPE_LIVE_KEY"));

                $token = $request->input('stripeToken');

                $response = $gateway->purchase([
                    'amount' => $request->input('amount'),
                    'currency' => 'USD',
                    'token' => $token,
                ])->send();

                if ($response->isSuccessful()) {
                    // payment was successful: insert transaction data into the database
                    $data = $response->getData();
                    //dd($data);
                    $payment = Payment::create([
                        "user_id" => $user_id ?? auth()->id(),
                        "reference" =>  $data['id'],
                        "amount" => $data['amount']/100,
                        "currency" => "USD",
                        "method" => "Stripe",
                        "status" => 1,
                    ]);

                    return [
                        'success' => true,
                        'msg' => "Payment successful",
                        "payment" => $payment,
                    ];
                }
                else{
                    return [
                        'success' => false,
                        'msg' => $response->getMessage(),
                    ];
                }
            }
            return [
                'success' => false,
                'msg' => "Couldn`t verify payment!",
            ];
        }
        catch(Exception $e){
            dd($e);
            return [
                'success' => false,
                'msg' => "Couldn`t verify payment!",
            ];
        } 
    }
    
}