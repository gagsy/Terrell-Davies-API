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
    
}
