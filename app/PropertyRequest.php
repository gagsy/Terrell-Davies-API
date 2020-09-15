<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyRequest extends Model
{
    protected $fillable = [
        'name',
        'user_type',
        'email',
        'phone',
        'category',
        'type',
        'state',
        'locality',
        'area',
        'bedrooms',
        'budget',
        'comment'
    ];
}
