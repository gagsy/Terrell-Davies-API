<?php namespace App\Services;

use Illuminate\Support\Facades\Http;

class FlutterwavePaymentService 
{
    protected $__publicKey;
    protected $__secretKey;
    protected $__encryptionKey;

    public function __construct()
    {
        //setup api key things here
        $this->__publicKey = env('APP_ENV') == 'local' ? env('FLUTTERWAVE_PUBLIC_TEST_KEY') : env('FLUTTERWAVE_PUBLIC_KEY');
        $this->__secretKey = env('APP_ENV') == 'local' ? env('FLUTTERWAVE_SECRET_TEST_KEY') : env('FLUTTERWAVE_SECRET_KEY');
        $this->__encryptionKey = env('APP_ENV') == 'local' ? env('FLUTTERWAVE_ENCRYPTION_TEST_KEY') : env('FLUTTERWAVE_ENCRYPTION_KEY');
        
    }

    public function createPlan($data){
        //create subscription plans
        /** Data sample to send
         * {
         *   "amount": 5000,
         *  "name": "Church collections plan",
         *   "interval": "monthly",
         *   "duration": 48
         *   }
         */

        $response = Http::withHeaders([
            'Authorization' => "Bearer " . $this->__publicKey,
            'Content-Type' => 'application/json'
        ])
        ->withOptions(['verify' => false]) //take this out in production
        ->post("https://api.goshippo.com/shipments/", $data);
    }

    public function fetchPlanDetails(){
        //return plan details
    }

    public function purchasePlan(){
        //make plan purchase
    }

    public function registerCustomer(){
        //register customer in flutterwave
    }
    
}
