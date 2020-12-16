<?php namespace App\Services;

use App\Contracts\PaymentServiceContract;
use Illuminate\Support\Facades\Http;


class FlutterwavePaymentService extends PaymentServiceContract
{
    protected $__publicKey;
    protected $__secretKey;
    protected $__encryptionKey;
    protected $_baseurl;

    public function __construct()
    {
        //setup api key things here
        $this->__publicKey = env('APP_ENV') == 'local' ? env('FLUTTERWAVE_PUBLIC_TEST_KEY') : env('FLUTTERWAVE_PUBLIC_KEY');
        $this->__secretKey = env('APP_ENV') == 'local' ? env('FLUTTERWAVE_SECRET_TEST_KEY') : env('FLUTTERWAVE_SECRET_KEY');
        $this->__encryptionKey = env('APP_ENV') == 'local' ? env('FLUTTERWAVE_ENCRYPTION_TEST_KEY') : env('FLUTTERWAVE_ENCRYPTION_KEY');
        $this->_baseurl = env('FLUTTERWAVE_BASE_URL') == 'local' ? env('FLUTTERWAVE_BASE_URL') : env('FLUTTERWAVE_BASE_URL'); //this check is probably not needed!
        
    }

    public function createPlan(Array $data){
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
            'Authorization' => "Bearer " . $this->__secretKey,
            'Content-Type' => 'application/json'
        ])
        ->withOptions(['verify' => false]) //take this out in production
        ->post($this->_baseurl . "/payment-plans", $data);

        return $response;
    }

    public function fetchPlanDetails(){
        //return plan details

        $response = Http::withHeaders([
            'Authorization' => "Bearer " . $this->__secretKey,
            'Content-Type' => 'application/json'
        ])
        ->withOptions(['verify' => false]) //take this out in production
        ->get($this->_baseurl . "/payment-plans");

        return $response;

    }

    public function makePayment(Array $data){
        
        $response = Http::withHeaders([
            'Authorization' => "Bearer " . $this->__secretKey,
            'Content-Type' => 'application/json'
        ])
        ->withOptions(['verify' => false]) //take this out in production
        ->post($this->_baseurl . "/payments", $data);

        return $response;

    }

    public function registerCustomer(){
        //register customer in flutterwave
    }

    public function cancelPlan(){
        //cancel subscribed plan
    }

    public function 

    public function generateTransactionReference($length = 20){

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;

    }
    
}
