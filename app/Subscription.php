<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'payment_method'
    ];

    public function user()
	{
		return $this->belongsTo(User::class);
    }

    public function plan()
	{
		return $this->belongsTo(SubscriptionPlan::class);
    }
}
