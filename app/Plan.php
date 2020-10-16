<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
        'discount_month1',
        'discount_month2',
        'maximum_listings',
        'maximum_premium_listings',
        'max_featured_ad_listings'
    ];
}
