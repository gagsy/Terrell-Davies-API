<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Authenticatable;
use App\Notifications\VerifyApiEmail;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class User extends Model implements AuthenticatableContract,CanResetPasswordContract
{
    use Notifiable, HasApiTokens, Authenticatable,CanResetPassword;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'userType', 'isActivated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function properties(){

        return $this->hasMany(Property::class);
        
    }

    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new VerifyApiEmail); // my notification
    }

    public function notices(){
        return $this->hasMany(Notice::class,'receiver_id');
    }

    public function userSubscriptions(){
        //return the currently active plan for user.

        return $this->hasMany(Subscription::class);
    }

    public function fetchActiveSubscription(){
    
        return $this->userSubscriptions()->whereNull('completed_at')->where('payment_status','!=','Pending')->first();

    }

    public function currentPlan(){
// 

        if($this->fetchActiveSubscription()){

            return Plan::where('id',$this->fetchActiveSubscription()->plan_id)->first();

        }

        return false;
        
    }
}
