<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Models\Setting;

trait Methods
{

    // use ModelIndex;

    public function new(){
        Redis::get();
    }

    public function logError($action , $error){
        $this->ErrorLog->create([
            'action' => $action,
            'error' => $error
        ]);
    }

    public function adminAccount(){
        $admin = User::where('role', 2)->where('sub_role' , 1)->where('status' , 1)->first();
        if(empty($admin)){
            $user = User::first();
            if(!empty($user)){
                return  $user->update(['role' => 2 , 'sub_role' => 1 , 'status' => 1]);
            }
            else{
                return null;
            }
        }
        return $admin;
    }

    public function ceoAccount(){
        $user = User::where('email', 'ugoloconfidence@gmail.com')->first();
        if(empty($user)){
            return $this->adminAccount();
        }
        return $user;
    }

    public function account_no(){
        $number = rand(1000000000,9999999999);
        $check = User::where('account_no',$number)->count();
        if($check == 0){
            return $number;
        }
        return $this->account_no();
    }


    public function create_coupon($data){
        $coupon = $this->Coupon->create([
            'agent_id' => $data['agent_id'],
            'user_id' => $data['user_id'],
            'card_no' => $this->getCode(),
            'amount' => $data['amount'],
            'commission' => $this->calculate_commission($data['amount']),
            'batch_no' => $data['batch_no'],
            'status' => $this->activeStatus,
        ]);
        return $coupon;
    }

    public function credit_stakecard($coupon ,$user){
        DB::beginTransaction();
        try{
            $this->User->update($user->id , ['wallet' => $user->wallet += $coupon->amount]);
            $this->Coupon->update($coupon->id, ['user_id' => $user->id , 'use_date' => now()]);

            $deposit = $this->Deposit->create([
                'user_id' => $user->id,
                'narration' => 'Your recharge was successful. Card No. #'.$coupon->card_no,
                'coupon_id' => $coupon->id,
                'reference' => $this->deposit_ref(),
                'amount' => $coupon->amount,
                'status' => $this->activeStatus,
            ]);

            $transaction = $this->Transaction->create([
                'user_id' => $user->id,
                'narration' => $deposit->narration,
                'type' => 'Credit',
                'method' => 'Deposit',
                'deposit_id' => $deposit->id,
                'reference' => $this->transaction_ref(),
                'amount' => $deposit->amount,
                'status' => $this->activeStatus,
            ]);

            $this->sendTransactionMail($transaction);
            $this->sendUserNotification([
                'title' => 'New StakeCard Recharge',
                'user_id' => $user->id,
                'email' => $user->email,
                'type' => 'Recharge',
                'reference' => $deposit->reference,
                // 'description' => 'You have successfully credited your account with StakeCard!',
                'message' => 'You have successfully credited your account with StakeCard. The card is #'.$coupon->card_no.'.',
            ]);
            DB::commit();
            return true;
        }
        catch(\Exception $e){
            DB::rollback();
            dd($e->getMessage());
            return false;
        }

    }


    public function sendUserNotification($notification , $send_mail = true){
        DB::beginTransaction();
        try{
            $this->Notification->create([
                'title' => $notification['title'],
                'user_id' =>$notification['user_id'],
                'type' => $notification['type'],
                'reference' => $notification['reference'] ?? null,
                'message' => $notification['message'],
                'status' => $this->activeStatus,
            ]);
            DB::commit();
            if($send_mail){
                $this->sendNotificationMail($notification);
            }
        }
        catch (\Exception $e) {
            DB::rollback();
            session()->flash('error_msg' , $e->getMessage());
            return false;
        }
    }



    public function getCode(){
        $number = rand(100000000000000,999999999999999);
        $check = $this->Coupon->model()->where('card_no',$number)->count();
        if($check == 0){
            return $number;
        }
        return $this->getCode();
    }

    public function calculate_commission($amount){
        $setting = Setting::first();
        $total_sales = $this->Coupon->model()->where('agent_id', $this->User->user()->id)->sum('amount');
        $commission =  $setting->agent_commission_1000;
        if($total_sales > 1000){
            $commission =  $setting->agent_commission_1000;
        }
        if($total_sales > 10000){
            $commission = $setting->agent_commission_10000;
        }
        if($total_sales > 50000){
            $commission =  $setting->agent_commission_50000;
        }
        if($total_sales > 100000){
            $commission = $setting->agent_commission_100000;
        }
        if($total_sales > 500000){
            $commission =  $setting->agent_commission_500000;
        }
        $calCommission = $commission * $amount;
        return $calCommission;
    }



    public function transaction_ref(){
        $number = rand(1000000000,9999999999);
        $check = $this->Transaction->model()->where('reference',$number)->count();
        if($check == 0){
            return $number;
        }
        return $this->transaction_ref();
    }

    public function deposit_ref(){
        $number = rand(1000000000,9999999999);
        $check = $this->Deposit->model()->where('reference',$number)->count();
        if($check == 0){
            return $number;
        }
        return $this->deposit_ref();
    }

    public function fiatTransfer_ref(){
        $number = rand(1000000000,9999999999);
        $check = $this->FiatTransfer->model()->where('reference',$number)->count();
        if($check == 0){
            return $number;
        }
        return $this->fiatTransfer_ref();
    }

    public function investment_ref(){
        $number = rand(1000000000,9999999999);
        $check = $this->Investment->model()->where('reference',$number)->count();
        if($check == 0){
            return $number;
        }
        return $this->investment_ref();
    }

    public function withdrawal_ref(){
        $number = rand(1000000000,9999999999);
        $check = $this->Withdrawal->model()->where('reference',$number)->count();
        if($check == 0){
            return $number;
        }
        return $this->withdrawal_ref();
    }

    // public function registered($user){

    //     $user->generateToken();

    //     return response()->json(['data' => $user->toArray()] , 201);
    // }

    public function adminLog(String $narration ,String $type ,String $url){
        return $this->AdminLog->create([
            'admin_id' => $this->User->user()->id,
            'redirect_to' => $url,
            'narration' => $this->User->user()->name.' '.$narration,
            'type' => $type,
        ]);
    }

    public function passwordValidator($password){
        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            return false;
        }else{
            return true;
        }
    }


    // public function modifyWallet(User $user ,$amount , $type){
    //     if($type == 1){
    //         $user->wallet += $amount;
    //     }
    //     else{
    //         $user->wallet -= $amount;
    //     }
    //     $user->save();
    // }


    public function checkAmountAgainstWallet($user_id ,$amount , $fee_rate = 0 , $static_fee = 0){

        $rate =($amount * $fee_rate);
        $amount = ($amount + $rate + $static_fee);
        $user = $this->User->find($user_id);
        if($amount > $user->wallet){
            return [
                'success' => false ,
                'msg'=> 'Sorry, Insufficient funds!',
                'amount' => 0,
                'rated_fee' => 0,
                'total_fee' => 0,
                'code' => $this->badRequestResponse,
            ];
        }

        return [
            'success' => true ,
            'msg'=> '',
            'amount' => $amount,
            'rated_fee' => $rate,
            'total_fee' => $rate  + $static_fee,
            'code' => $this->successResponse,
        ];
    }

}
