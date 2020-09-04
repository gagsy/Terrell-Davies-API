<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlans extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
        'maximum_listings',
        'maximum_premium_listings',
        'max_featured_ad_listings',
        'payment_method',
        'payment_status',
    ];
}
