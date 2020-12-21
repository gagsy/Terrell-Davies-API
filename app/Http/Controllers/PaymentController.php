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
use App\Services\PlanManagerService;

class PaymentController extends Controller
{
    protected $paymentService;
    protected $planManger;
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

        $this->planManger = new PlanManagerService;

    }

    public function makePayment(Request $request){

        $transactionRef = $this->paymentService->generateTransactionReference(20);
        $amount = $request->amount;
        $planId = $request->plan_id;
        $duration = $request->duration;
        
        //check if this plan exists 

        $doesPlanExist = Plan::where('id',$planId)->count();

        if($doesPlanExist == 0){
            
            return response()->json([
                'message' => 'The selected plan does not exist',
                'data'=>[]
            ], 404);

        }

        $paymentData = [
            "tx_ref"=>$transactionRef,
            "amount"=>$amount,
            "payment_options"=>"card",
            "payment_plan"=>$planId,
            "redirect_url"=> env('APP_URL') . "/api/payment-response/?user=" . $this->user->id ."&plan=" . $planId . "&duration=" . $duration, 
            "currency"=>"NGN",
            "customer"=>[
                       "email" => $this->user->email,
                       "phonenumber" => $this->user->phone,
                       "name" => $this->user->name
                    ]
        ];

        $isPaymentDone = $this->paymentService->makePayment($paymentData);

        if($isPaymentDone->status == "success"){

            //send them to the URL
            return redirect()->away($isPaymentDone->data->link);

        }

        return response()->json([
            'message' => 'Connection to payment gateway failed!',
            'data'=>[]
        ], 500);


    }


    public function paymentResponse(Request $request){
        
       
        $user = $request['user'];

        $status = $request['status'];
        $transaction_ref = $request['tx_ref'];
        $duration = $request['duration'];
        $transaction_id = $request['transaction_id'];
        $plan_id = $request['plan_id'];

        $plan = Plan::where('id',$plan_id)->first();
    
        //check that the user is the same

        if($this->user->id != $user){

            return response()->json([
                'message' => 'Authentication Failed | The user who initiated this transaction must be the same',
                'data'=> []
            ], 403);

        }

        //verify that payment was successful

        if($status == "successful"){

            $attempt_activate_subscription = $this->planManger->activatePlan($this->user,$plan, ['ref'=>$transaction_ref,'status'=>$status,'duration'=>$duration]);
            
            if($attempt_activate_subscription){

                return response()->json([
                    'message' => 'Payment Completed, plan has been activated. You can close this window now.',
                    'data'=> []
                ], 200);
                
            }

            
            return response()->json([
                'message' => 'Something went wrong with activating the plan',
                'data'=> []
            ], 502);


        }

        return response()->json([
            'message' => 'Something went wrong with your payment',
            'data'=> []
        ], 500);

        

    }


}
