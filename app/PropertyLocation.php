<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyLocation extends Model
{
    protected $fillable = [
        'location_id',
        'property_id'
    ];
}
