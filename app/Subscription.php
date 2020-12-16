<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{


    protected $fillable = [
        'user_id','plan_id','reference','amount','payment_method','payment_status','completed_at'
    ];
    


}
